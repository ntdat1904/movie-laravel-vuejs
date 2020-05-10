
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAxios from 'vue-axios'
import jQuery from 'jquery'
import Comments from './components/Comments'
import ListComments from './components/ListComments'
// sweetalert //
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.jQuery = jQuery;
// Set Vue globally
window.Vue = Vue;
// // Set Vue router
// Vue.router = router
// Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `/api`;
Vue.use(VueSweetalert2);

Vue.component('comments', Comments);

Vue.component('listcomments', ListComments);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Echo from 'laravel-echo'

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

const app = new Vue({
    el: '#comments',
});

