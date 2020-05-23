/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../base');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 */
Vue.component('app-notification', require('../components/AppNotification.vue').default);
Vue.component('app-notifications', require('../components/AppNotifications.vue').default);
Vue.component('app-ride-points', require('../components/AppRidePoints.vue').default);
Vue.component('app-ride-point', require('../components/AppRidePoint.vue').default);



/**
* Import our store app
*/
import store from '../notification/index'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});