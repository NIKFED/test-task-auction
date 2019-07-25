<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Author</th>
                <th scope="col">Start price</th>
                <th scope="col">Release</th>
                <th scope="col">In auction</th>
                <th scope="col">Buy Price</th>
                <th scope="col">Owner</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="picture in pictures">
                <th>{{picture.name}}</th>
                <td>{{picture.author}}</td>
                <td>{{picture.start_price}}</td>
                <td>{{picture.release}}</td>
                <td>{{picture.inAuction === 1 ? "yes" : "no"}}</td>
                <td>{{picture.buy_price}}</td>
                <td>{{picture.owner}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data: function() {
            return {
                pictures: []
            }
        },
        methods: {
            fetch()
            {
                axios.get('/pictures/all')
                    .then(response => {
                        this.pictures = response.data
                    })
            }
        },
        mounted() {
            this.fetch();
        },
    }
</script>
