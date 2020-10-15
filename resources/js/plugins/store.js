import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        modalTitle: '',
    },
    mutations: { 
        changeModalTitle(state, newVal) {
            state.modalTitle = newVal;
        }
    },
})