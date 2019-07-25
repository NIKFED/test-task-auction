<template>
    <div class="container">
        <p>Chat</p>
        <div class="row">
            <div class="col-sm-12">
                <textarea class="form-control" rows="10" readonly="">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
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
        data() {
            return {
                user_name: '',
                messages: [],
                textMessage: ''
            }
        },
        methods: {
            sendMessage() {
                axios.post('/auction/chat', { body: (this.user_name + ': ' + this.textMessage) });

                this.messages.push((this.user_name + ': ' + this.textMessage));

                this.textMessage = '';
            },
            fetch()
            {
                axios.post('../users/name', { id: this.user_id} )
                    .then(response => {
                        this.user_name = response.data
                    })
            }
        },
        mounted() {
            this.fetch();
            window.Echo.channel('laravel_database_chat')
                .listen('Message', ({message}) => {
                    this.messages.push(message)
                });
        }
    }
</script>
