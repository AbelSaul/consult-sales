import './bootstrap';

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

Vue.component(
    'edit-proforma',
    require('./components/EditProforma.vue').default
);


//Vue
new Vue({
    el: '#app'
});
