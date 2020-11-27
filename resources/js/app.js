/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('enter-cast', require('./components/casting/enterCast.vue').default);
Vue.component('list-cast', require('./components/casting/listCast.vue').default);
Vue.component('enter-role', require('./components/casting/addRole.vue').default);
Vue.component('list-people', require('./components/admin/listPeople.vue').default);
Vue.component('add-play', require('./components/admin/addPlay.vue').default);
Vue.component('view-productions', require('./components/admin/viewProductions.vue').default);
Vue.component('view-casted', require('./components/admin/viewCasted.vue').default);
Vue.component('view-remaining-cast', require('./components/admin/viewRemainingCast.vue').default);
Vue.component('free-to-cast', require('./components/admin/freeToCast.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
