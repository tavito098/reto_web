import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        modalTitle: '',
        products: [],
    },
    mutations: { 
        changeModalTitle(state, newVal) {
            state.modalTitle = newVal;
        },
        changeProducts(state, newVal) {
            state.products = newVal;
        }
    },
    actions: {
        getProducts(context) {
            axios.get('/products-resource').then((response) => {
                console.log(response.data);
                context.commit('changeProducts', response.data);
            }).catch((error) => {
                console.log(error);
            });
        }
    }
})