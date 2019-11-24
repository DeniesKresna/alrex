require('./bootstrap');

import store from './store.js';
import VueRouter from 'vue-router';
import routes from './routes.js';
import filters from './filters'; 
import Vuetify from 'vuetify';
import VueSwal from 'vue-swal';
import VeeValidate from 'vee-validate';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import vuetify from './vuetify'
import DatetimePicker from 'vuetify-datetime-picker'
    
window.Vue = require('vue');
//require('vue-axios-interceptors');

filters.forEach(f => {
   Vue.filter(f.name, f.execute)
})

Vue.use(VueSwal);
Vue.use(VeeValidate);
Vue.use(DatetimePicker)

/*
Vue.use(Loading, {
	color: 'red',
});*/
//=========================vue router========================================
Vue.use(VueRouter)
const router = new VueRouter({
  routes: routes
})

Vue.component('pagination', require('laravel-vue-pagination'));

import interceptorsSetup from './interceptors'
interceptorsSetup();

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('app-component', require('./components/AppComponent.vue').default);

const app = new Vue({
	router,
	store,
    vuetify,
    el: '#app',
    mounted(){
    }
});
