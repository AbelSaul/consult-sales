import VueRouter from 'vue-router';
import ConsultSale from './components/ConsultSaleComponent';
import Login from './components/LoginComponent';
import NewOrder from './components/NewOrderComponent';

let routes = [
    {
        path: '/',
        name: 'home',
        component: NewOrder
    },
    {
        path: '/ruc',
        name: 'ruc',
        component: ConsultSale
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    }
];

export default new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'is-active'
});
