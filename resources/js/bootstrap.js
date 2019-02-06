import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import vuetifyToast from 'vuetify-toast';
import vueInputNumber from 'vue-input-number';

window.Vue = Vue;

Vue.use(Vuetify);
Vue.use(vueInputNumber);

window.notify = vuetifyToast;
window.notify.showCool = (text) => notify.show({ text, color: '' });
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.baseURL = document.head.querySelector(
    'meta[name="api-base-url"]'
).content;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error(
        'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'
    );
}
