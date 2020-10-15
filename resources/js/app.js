require('./bootstrap');
import store from './plugins/store'

window.Vue = require('vue');

Vue.component('product', require('./components/Product.vue').default);

const app = new Vue({
    el: '#app',
    store
});
