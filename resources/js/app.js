/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import 'animate.css'
import VueCarousel from 'vue-carousel';
// import Icon from 'vue-awesome/components/Icon'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret, faSpinner, faBinoculars, faSpaceShuttle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faUserSecret, faSpinner, faBinoculars, faSpaceShuttle)
Vue.component('fas', FontAwesomeIcon)

import vuetify from './plugins/vuetify';
import Routes from './routes';
import { store } from './store';
import App from './components/App'
import Moment from 'vue-moment'
import './filters';

Vue.use(VueRouter)
Vue.use(VeeValidate)
Vue.use(Moment)

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    linkActiveClass: 'font-semibold'
})


router.beforeEach((to, from, next) => {
    const requireAdminsAuth = to.matched.some(rec => rec.meta.requireAdminsAuth);
    const authAdmin = store.state.authAdmin
    if (requireAdminsAuth && authAdmin == null) {
        next('/admin-login')
    }else if(to.path == '/admin-login' && authAdmin){
        next('/admin')
    }else if(to.path == '/login' && authAdmin){
        next('/')
    }else if(to.path == '/register' && authAdmin){
        next('/')
    }else {
        next()
    }
});


router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(rec => rec.meta.requiresAuth);
    const authUser = store.state.authUser
    if (requiresAuth && authUser == null) {
        store.commit('redirectOnLogin', to.path)
        next('/login')
    }else if(to.path == '/login' && authUser){
        next('/staff-dashboard')
    }else if(to.path == '/register' && authUser){
        next('/staff-dashboard')
    }else if(to.path.substring(0, 6) == '/admin' && authUser){
        next('/staff-dashboard')
    }else {
        next()
    }
});


//axios interceptor for expired token
axios.interceptors.response.use(null, (err) =>
{
    if (err.response.status == 401) {
        store.commit('logOutAuthUser')
        store.commit('logOutAdmin')
        if (router.currentRoute.name !== ('AdminLogin' || 'Login')) {
            router.push('/')
        }
        router.push('/')
    }
    return Promise.reject(err)
})



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('welcome-banner', require('./components/Children/WelcomeBanner.vue').default);
Vue.component('our-mission', require('./components/Children/OurMission.vue').default);
Vue.component('our-services', require('./components/Children/OurServices.vue').default);
Vue.component('our-core-values', require('./components/Children/OurCoreValues.vue').default);
Vue.component('news-brief', require('./components/Children/NewsBrief.vue').default);
Vue.component('events-brief', require('./components/Children/EventsBrief.vue').default);
Vue.component('our-directors', require('./components/Children/OurDirectors.vue').default);
Vue.component('latest-events', require('./components/Children/LatestEvents.vue').default);
Vue.component('testimonials', require('./components/Children/Testimonials.vue').default);
Vue.component('featured-properties', require('./components/Children/FeaturedProperties.vue').default);
Vue.component('latest-properties', require('./components/Children/LatestProperties.vue').default);
Vue.component('news-post', require('./components/Children/LatestNewsPosts.vue').default);
Vue.component('listing-card', require('./components/Children/ListingCard.vue').default);
Vue.component('new-offers', require('./components/Children/NewOffers.vue').default);
Vue.component('admin-search', require('./components/Children/AdminSearch.vue').default);
Vue.component('staff-search', require('./components/Children/StaffSearch.vue').default);
Vue.component('admin-dash-brief-cards', require('./components/Children/AdminDashBriefCards.vue').default);
Vue.component('video-rolls', require('./components/Children/VideoRolls.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    components: { App },
    router,
    vuetify,
    store
});
