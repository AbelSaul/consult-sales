
import Vue from 'vue'
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        selected: [],
    },
    mutations: {
        ADD_PRODUCT: (state, selected) => {
            state.selected = selected
        },
        REMOVE_PRODUCT: (state, product) => {
            state.selected.splice(product, 1)
        }
    },

});