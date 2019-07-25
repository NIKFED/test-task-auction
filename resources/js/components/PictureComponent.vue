<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4" v-for="picture in pictures">
                <div class="card mb-4 box-shadow">
                    <div class="card-body">
                        <p class="card-text">{{picture.name}}</p>
                        <img :src="'images/' + picture.image" width="50%">
                        <p class="card-text">Author: {{picture.author}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <p>
                                    <a :href="'/pictures/view/' + picture.id" class="btn btn-sm btn-outline-secondary">View</a>
                                </p>
                            </div>
                            <small class="text-muted">Start price: {{picture.start_price}} $</small>
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
                is_admin: false,
            }
        },
       methods: {
            fetch()
            {
                axios.get('/pictures/all')
                    .then(response => {
                        this.pictures = response.data
                    })
            },
           checkAdmin()
           {
               axios.post('/users/checkadmin', { id: this.user_id} )
                   .then(response => {
                       console.log(response.data);
                       this.is_admin = response.data
                   })
           }
       },
       mounted() {
            this.fetch();
            this.checkAdmin();
       }
    }
</script>
