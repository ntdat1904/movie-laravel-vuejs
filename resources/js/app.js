
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'
import router from './router'
import BootstrapVue from 'bootstrap-vue'
// import 'bootstrap/dist/css/bootstrap.css'
import "../../public/css/style.css"
import Vuelidate from "vuelidate"
// sweetalert //
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
//Ckeditor
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueGlide from 'vue-glide-js'
import 'vue-glide-js/dist/vue-glide.css';
Vue.use(VueGlide);

// import 'vue-video-player/src/custom-theme.css'
import jQuery from 'jquery';
window.jQuery = jQuery;
// Set Vue globally
window.Vue = Vue;

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(BootstrapVue);

// Set Vue authentication
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `/api`;
Vue.use(VueAuth, auth);
Vue.use(Vuelidate);
//Ckeditor
Vue.use( CKEditor );

Vue.use(VueSweetalert2);
// Load Index
Vue.component('index', Index);
export const HTTP = axios.create({
    baseURL: `/api`,
    headers: {
        Authorization: 'Bearer {token}'
    }
});

import Echo from 'laravel-echo'

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

const app = new Vue({
    el: '#app',
    router
});

