
require('./bootstrap');

window.Vue = require('vue');



Vue.component('picture-component', require('./components/PictureComponent.vue').default);
Vue.component('view-component', require('./components/ViewComponent.vue').default);
Vue.component('chat-component', require('./components/ChatComponent.vue').default);
Vue.component('auction-component', require('./components/AuctionComponent.vue').default);
Vue.component('buys-component', require('./components/BuysComponent.vue').default);

const app = new Vue({
    el: '#app'
});
