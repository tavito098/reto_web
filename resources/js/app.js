require('./bootstrap');

import store from './plugins/store'
import Axios from 'axios'
import VueResource from 'vue-resource'
import swal from 'sweetalert';

window.Vue = require('vue');

Vue.prototype.$http = Axios;
Vue.component('product', require('./components/Product.vue').default);
Vue.component('folder-tree', require('./components/FolderTree.vue').default);
Vue.use(VueResource);

const app = new Vue({
    el: '#app',
    store,
});
