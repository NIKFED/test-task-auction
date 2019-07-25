<template>
    <div class="container">
        <div class="lead">
            Balance: {{balance}} $
            <input type="text" class="form-control" v-model="replenishment">
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
            <div class="col-md-4" v-for="picture in pictures">
                <div class="card mb-4 box-shadow">
                    <div class="card-body">
                        <p class="card-text">{{picture.name}}</p>
                        <img :src="'images/' + picture.image" width="50%">
                        <p class="card-text">Author: {{picture.author}}</p>
                        <div v-if="show_rate">
                            <input v-if="start_auction" type="text" class="form-control" v-model="rate[picture.id]">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button v-if="start_auction" class="btn btn-sm btn-outline-secondary" @click.prevent="OfferBid(picture.id)">Offer bid</button>
                                </div>
                                <small v-if="start_auction" class="text-muted">Current price: {{picture.buy_price}} $</small>
                            </div>
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
                rate: [],
                balance: 0,
                user_name: '',
                now: 0,
                start_auction: false,
                show_start: true,
                date: 0,
                finish: false,
                is_admin: false,
                function_once: true,
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
                    });
                window.Echo.channel('laravel_database_auction_data')
                    .listen('AuctionInformation', ({picture_data}) => {
                        this.pictures[picture_data.id - 1] = picture_data;
                        this.set_timer();
                    });
                window.Echo.channel('laravel_database_auction_start')
                    .listen('AuctionStart', ({start_auction}) => {
                        this.StartAuction();
                    });
                axios.post('../users/balance', { id: this.user_id} )
                    .then(response => {
                        this.balance = response.data
                    });
                axios.post('../users/name', { id: this.user_id} )
                    .then(response => {
                        this.user_name = response.data
                    });
            },
            OfferBid(id)
            {
                if(parseFloat(this.balance) >= parseFloat(this.rate[id]) + parseFloat(this.pictures[id - 1].buy_price))
                {
                    this.pictures[id - 1].buy_price = parseFloat(this.pictures[id - 1].buy_price) + parseFloat(this.rate[id]);
                    this.pictures[id - 1].owner = this.user_name;
                    axios.post('/auction/picture', { picture_data: (this.pictures[id - 1]) });
                    this.balance = this.balance - this.pictures[id - 1].buy_price;
                    axios.post('/users/balancewriting', { user_id: (this.user_id), balance: this.balance });

                    this.set_timer();
                }
                else
                {
                    alert('Недостаточно средств! Или неправильно введена ставка');
                }
            },
            StartAuction()
            {
                if ((this.is_admin) && (this.function_once)) {
                    this.function_once = false;
                    axios.post('/auction/start', { start_auction: (true) });
                }
                this.pictures.forEach(function(picture) {
                    picture.buy_price = picture.start_price;
                });
                this.start_auction = true;
                this.show_start = false;
                this.set_timer();
            },
            EndAuction()
            {
                this.finish = true;
                this.show_rate = false;
                axios.post('/auction/end', { picture_data: this.pictures });
            },
            timer_loop()
            {
                if (!this.finish) {
                    this.now = Math.trunc(new Date().getTime() / 1000);
                    if ((this.date - this.now) == 0) {
                        this.EndAuction();
                    }
                    setTimeout(this.timer_loop, 1000);
                }
            },
            set_timer()
            {
                axios.get('/auction/settings')
                    .then(response => {
                        this.date = Math.trunc(new Date().getTime() / 1000) + (response.data * 10);
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
