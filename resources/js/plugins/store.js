import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        modalTitle: '',
        products: [],
        product: [],
    },
    mutations: { 
        changeModalTitle(state, newVal) {
            state.modalTitle = newVal;
        },
        changeProducts(state, newVal) {
            state.products = newVal;
        },
        changeProduct(state, newVal) {
            state.product = newVal;
        }
    },
    actions: {
        getProducts(context) {
            let headers = { headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }};
            axios.get('/products-resource', headers).then((response) => {
                context.commit('changeProducts', response.data);
            }).catch((error) => {
                console.log(error);
            });
        },
        searchProducByDates(context, payload) {
            let headers = { headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }};
            axios.get('/searchProducByDates/'+payload.initDate+'/'+payload.endDate, headers).then((response) => {
                context.commit('changeProducts', response.data);
            }).catch((error) => {
                console.log(error);
            });
        }
    }
})