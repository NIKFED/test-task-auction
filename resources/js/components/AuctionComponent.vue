<template>
    <div class="container">
        <div class="lead">
            <p class="float-right">Balance: {{balance}} $</p>
            <input type="text" class="text-muted" v-model="replenishment">
            <button class="btn btn-sm btn-outline-secondary" @click.prevent="PuyBalance">To replenish the balance.</button>
        </div>
        <br>
        <div v-if="finish">
            <p class="lead" v-if="finish"> Auction end. Sold  pictures can see in buys.</p>
            <p class="lead" v-if="start_auction">Timer:  00: 00</p>
        </div>
        <div v-else="">
            <p v-if="start_auction">Timer:  {{minutes}}: {{seconds}}</p>
        </div>
        <div v-if="is_admin" class="container">
            <button v-if="show_start" class="btn btn-sm btn-outline-secondary" @click.prevent="StartAuction">Start auction</button>
        </div>
        <br>
        <div class="row">
            <div class="card mb-4 box-shadow">
                <div class="card-body" v-if="render">
                    <p class="card-text" >{{pictures[id_curr_picture].name}}</p>
                    <img :src="'images/' + pictures[id_curr_picture].image" width="50%">
                    <p class="card-text">Author: {{pictures[id_curr_picture].author}}</p>
                    <div v-if="start_auction">
                        <div v-if="show_rate">
                            <input type="text" class="text-muted" v-model="rate">
                            <br>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary" @click.prevent="OfferBid">Offer bid</button>
                            </div>
                        </div>
                        <div v-else="show_rate">
                            <p>Ставка сделана ожидайте...</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small class="text-muted">Current price: </small>
                                <small class="text-muted"> {{current_price}}</small>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary" @click.prevent="SkipTime">Skip Time</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        props: [
            'user_id'
        ],
        data: function() {
            return {
                pictures: [],
                id_curr_picture: 0,
                rate: 0,
                current_price: 0,
                first_bid: true,
                balance: 0,
                user_name: '',
                now: 0,
                start_auction: false,
                show_start: true,
                date: 0,
                finish: false,
                is_admin: false,
                function_once: true,
                function_once_2: true,
                render: false,
                show_rate: true,
                replenishment: 0
            }
        },
        methods: {
            fetch()
            {
                axios.get('/auction')
                    .then(response => {
                        this.pictures = response.data;
                        this.render = true;
                    });
                window.Echo.channel('laravel_database_auction_start')
                    .listen('AuctionStart', ({ }) => {
                        this.StartAuction();
                    });
                window.Echo.channel('laravel_database_auction_next')
                    .listen('AuctionNextPicture', ({ }) => {
                        this.NextPicture();
                    });
                window.Echo.channel('laravel_database_auction_data')
                    .listen('AuctionInformation', ({picture_data}) => {
                        this.pictures[this.id_curr_picture] = picture_data;
                    });
                window.Echo.channel('laravel_database_price_update')
                    .listen('UpdatePrice', ({price_data}) => {
                        this.set_timer();
                        this.show_rate = true;
                        if (this.first_bid)
                        {
                            this.first_bid = false;
                        }
                        else
                        {
                            this.balance = this.balance + this.current_price;
                        }
                        this.current_price = parseFloat(price_data);
                    });
                axios.post('../users/balance', { id: this.user_id} )
                    .then(response => {
                        this.balance = parseFloat(response.data);
                    });
                axios.post('../users/name', { id: this.user_id} )
                    .then(response => {
                        this.user_name = response.data
                    });
            },
            OfferBid()
            {
                if (this.balance >= this.current_price + parseFloat(this.rate))
                {
                    alert('Ставка была предложена!');
                    this.current_price = this.current_price + parseFloat(this.rate);
                    this.first_bid = false;
                    this.rate = 0;
                    axios.post('/auction/update', { price: (this.current_price) });
                    this.balance = this.balance - this.current_price;
                    this.show_rate = false;
                    this.pictures[this.id_curr_picture].buy_price = this.current_price;
                    this.pictures[this.id_curr_picture].owner = this.user_name;
                    axios.post('/auction/picture', { picture_data: (this.pictures[this.id_curr_picture]) });

                    this.set_timer();
                }
                else {
                    alert('Недостаточно средств или неправильно введена ставка!');
                }
            },
            StartAuction()
            {
                if ((this.is_admin) && (this.function_once)) {
                    this.function_once = false;
                    axios.get('/auction/start');
                }
                this.current_price = parseFloat(this.pictures[this.id_curr_picture].start_price);
                this.start_auction = true;
                this.first_bid = true;
                this.show_start = false;
                this.set_timer();
            },
            EndAuction()
            {
                if (this.id_curr_picture < (this.pictures.length - 1))
                {
                    axios.get('/auction/picture', { });
                    this.NextPicture();
                }
                else
                {
                    this.start_auction = false;
                    this.show_rate = false;
                    this.finish = true;
                    this.show_rate = false;
                    axios.post('/auction/end', { picture_data: this.pictures });
                }
            },
            NextPicture()
            {
                axios.post('/users/balancewriting', { user_id: (this.user_id), balance: (this.balance)} );
                this.id_curr_picture++;
                this.show_rate = true;
                this.first_bid = true;
                this.function_once = true;
                this.StartAuction();
            },
            SkipTime()
            {
                this.function_once_2 = false;
                this.EndAuction();
            },
            timer_loop()
            {
                if (!this.finish) {
                    this.now = Math.trunc(new Date().getTime() / 1000);
                    if (((this.date - this.now) == 0) && (this.function_once_2)){
                        this.SkipTime();
                    }
                    else {
                        setTimeout(this.timer_loop, 1000);
                        if ((this.date - this.now) != 0)    this.function_once_2 = true;
                    }
                }
            },
            set_timer()
            {
                // this.function_once_2 = true;
                axios.get('/auction/settings')
                    .then(response => {
                        this.date = Math.trunc(new Date().getTime() / 1000) + (response.data * 60);
                    });

                this.timer_loop();
            },
            checkAdmin()
            {
                axios.post('/users/checkadmin', { id: this.user_id} )
                    .then(response => {
                        this.is_admin = response.data
                    })
            },
            PuyBalance()
            {
                alert('Баланс был пополнен!');
                this.balance = parseFloat(this.balance) + parseFloat(this.replenishment);
                axios.post('/users/balancewriting', { user_id: (this.user_id), balance: (this.balance)} );
            }
        },
        mounted() {
            this.fetch();
            this.checkAdmin();
        },
        computed: {
            seconds() {
                let second = ((this.date - this.now) % 60);
                return (second < 10) ? '0' + second : second;
            },
            minutes() {
                let minute = (Math.trunc((this.date - this.now) / 60) % 60);
                return (minute < 10) ? '0' + minute : minute;
            }
        }
    }
</script>
