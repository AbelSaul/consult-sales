import './bootstrap';

Vue.component(
    'auth-component',
    require('./components/AuthComponent.vue').default
);

Vue.component(
    'neworder-component',
    require('./components/NewOrderComponent.vue').default
);

Vue.component('vue-input-number', require('vue-input-number').default);

new Vue({
    el: '#app'
});
