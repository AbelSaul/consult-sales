import Vue from "vue";
import axios from "axios";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import vuetifyToast from "vuetify-toast";
import vueInputNumber from "vue-input-number";
import "es6-promise/auto";
// import component and stylesheet
import AirbnbStyleDatepicker from "vue-airbnb-style-datepicker";
import "vue-airbnb-style-datepicker/dist/vue-airbnb-style-datepicker.min.css";
// Import component vue-datetime and stylesheet
import { Settings } from "luxon";
import Datetime from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";

import { datepickerOptions, localeFormat } from "./date";

window.Vue = Vue;

Vue.use(Vuetify);
Vue.use(vueInputNumber);
// see docs for available options vue-airbnb-style-datepicker

Vue.use(AirbnbStyleDatepicker, datepickerOptions);
Vue.use(Datetime);
Settings.defaultLocale = "pe";

window.localeFormat = localeFormat;
window.notify = vuetifyToast;
window.notify.showCool = text => notify.show({ text, color: "" });
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.defaults.baseURL = document.head.querySelector(
    'meta[name="api-base-url"]'
).content;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
