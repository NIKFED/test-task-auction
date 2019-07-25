<template>
    <div class="container">
        <div class="card" style="width: 30rem;">
            <img :src="'../../images/' + picture.image" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">{{picture.name}}</h5>
                <p class="card-text">Author: {{picture.author}}</p>
                <p class="card-text">Description: {{picture.description}}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Price: {{picture.price}} $</li>
                <li class="list-group-item">Release: {{picture.release}} year</li>
                <li class="list-group-item">In action: {{picture.inAuction === 1 ? "yes" : "no"}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'picture'
        ]
    }
</script>