require('./bootstrap');

window.Vue = require('vue');
 
import App from './app.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import moment from 'moment';
import {routes} from './routes';


Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.component('pagination', require('laravel-vue-pagination'));
 
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
 
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});


Vue.filter('date', function(value) {
    if (value) {
        return moment(String(value)).format('DD-MM-YYYY hh:mm')
    }
});