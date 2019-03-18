import './bootstrap';
import { store } from './store'


Vue.component(
    'auth-component',
    require('./components/AuthComponent.vue').default
);

Vue.component(
    'create-proforma',
    require('./components/CreateProforma.vue').default
);

Vue.component('vue-input-number', require('vue-input-number').default);

Vue.component('loader', require('./components/Loader').default);

Vue.component('SelectEdit', require('./components/SelectEdit').default);

Vue.component('list-proformas', require('./components/ListProformas').default);

Vue.component('list-products', require('./components/ListProducts').default);

Vue.component(
    'edit-proforma',
    require('./components/EditProforma.vue').default
);

Vue.component('client', require('./components/Client').default);

//Vue
new Vue({
    store,
}).$mount('#app')
