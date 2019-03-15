
import Vue from 'vue'
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        selected: [],
    },
    getters: {
        countSelected: state => {
          return state.selected.length
        }
      },
    mutations: {
        MODIFY_SELECTED: (state, selected) => {
            state.selected = selected
        },
        REMOVE_ITEM_SELECTED: (state,product) => {
            state.selected.splice(product, 1)
        },
        REMOVE_ALL: (state,selected) => {
            state.selected = []
        }
    },

    actions: {
        modifySelected: (context, selected) => {
          context.commit("MODIFY_SELECTED", selected)
        },

        removeAll({ commit }) {
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            commit('REMOVE_ALL')
            resolve()
          },500)
        })
        },
        removeProduct: (context, product) => {
            context.commit("REMOVE_ITEM_SELECTED", product)
        },

    }

});