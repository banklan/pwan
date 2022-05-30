import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { totalmem } from 'os';
import router from './routes';

Vue.use(Vuex, axios);

const auth_admin = window.localStorage.getItem('authAdmin')
const authAdmin = auth_admin ? JSON.parse(auth_admin) : null;

const adminlogged_in = window.localStorage.getItem('adminIsLoggedIn')
const adminIsLoggedIn = adminlogged_in ? true : false

const subForm1 = window.localStorage.getItem('subscriptionForm1')
const subscriptionForm1 = subForm1 ? JSON.parse(subForm1) : null

const subForm2 = window.localStorage.getItem('subscriptionForm2')
const subscriptionForm2 = subForm2 ? JSON.parse(subForm2) : null

const subFm = window.localStorage.getItem('subscrForm')
const subscrForm = subFm ? JSON.parse(subFm) : null



export const store = new Vuex.Store({
    state: {
        api: 'http://localhost:8000/api',
        adminIsLoggedIn: adminIsLoggedIn,
        authAdmin: authAdmin,
        userIsLoggedIn: false,
        adminUpdatedSuperUser: false,
        newAdminCreated: false,
        adminUpdatedUser: false,
        adminDeletedUser: false,
        AdminUpdatedProperty: false,
        subscriptionForm1: subscriptionForm1,
        subscriptionForm2: subscriptionForm2,
        subscrForm: subscrForm,
        adminDeletedEvent: false,
        adminUpdatedEvent: false,
        adminDeletedTestimonial: false,
        adminUpdatedTestimonial: false,
        adminDeletedNewsPost: false,
        adminUpdatedNewsPost: false,
        // userIsLoggedIn: false,
    },
    getters: {
        api(state)
        {
            return state.api
        },
        adminIsLoggedIn(state)
        {
            return state.adminIsLoggedIn
        },
        authAdmin(state)
        {
            return state.authAdmin;
        },
        adminUpdatedSuperUser(state)
        {
            return state.adminUpdatedSuperUser
        },
        newAdminCreated(state)
        {
            return state.newAdminCreated
        },
        adminUpdatedUser(state){
            return state.adminUpdatedUser
        },
        adminDeletedUser(state){
            return state.adminDeletedUser
        },
        AdminUpdatedProperty(state){
            return state.AdminUpdatedProperty
        },
        subscriptionForm1(state)
        {
            return state.subscriptionForm1
        },
        subscriptionForm2(state)
        {
            return state.subscriptionForm2
        },
        subscrForm(state)
        {
            return state.subscrForm
        },
        adminDeletedEvent(state)
        {
            return state.adminDeletedEvent
        },
        adminUpdatedEvent(state)
        {
            return state.adminUpdatedEvent
        },
        adminDeletedTestimonial(state)
        {
            return state.adminDeletedTestimonial
        },
        adminUpdatedTestimonial(state)
        {
            return state.adminUpdatedTestimonial
        },
        adminDeletedNewsPost(state)
        {
            return state.adminDeletedNewsPost
        },
        adminUpdatedNewsPost(state)
        {
            return state.adminUpdatedNewsPost
        },
    },
    actions: {

    },
    mutations: {
        adminLoginSuccess(state, payload)
        {
            state.adminIsLoggedIn = true
            state.authAdmin = Object.assign({}, payload.user, {token: payload.access_token})
            window.localStorage.setItem('authAdmin', JSON.stringify(state.authAdmin))
            window.localStorage.setItem('adminIsLoggedIn', true)
        },
        logOutAdmin(state)
        {
            localStorage.removeItem('authAdmin')
            localStorage.removeItem('adminIsLoggedIn')
            state.adminIsLoggedIn = false
            state.authAdmin = null
        },
        logOutAuthUser(state)
        {
            localStorage.removeItem('authUser')
            localStorage.removeItem('userIsLoggedIn')
            localStorage.removeItem('authService')
            localStorage.removeItem('authUserService')
            state.userIsLoggedIn = false
            state.authUser = null
        },
        resetAdminFlashMsg(state)
        {
            state.newAdminCreated = false;
            state.adminUpdatedUser = false
            state.adminDeletedUser = false
            state.adminUpdatedSuperUser = false
            state.adminUpdatedEvent = false
            state.adminDeletedEvent = false
            state.adminDeletedTestimonial = false
            state.adminUpdatedTestimonial = false
            state.adminDeletedNewsPost = false
        },
        adminUpdatedSuperUser(state)
        {
            state.adminUpdatedSuperUser = true
        },
        newAdminCreated(state)
        {
            state.newAdminCreated = true
        },
        adminUpdatedUser(state)
        {
            state.adminUpdatedUser = true
        },
        adminDeletedUser(state)
        {
            state.adminDeletedUser = true
        },
        AdminUpdatedProperty(state)
        {
            state.AdminUpdatedProperty = true
        },
        saveSubscriptionForm1(state, payload)
        {
            localStorage.setItem('subscriptionForm1', JSON.stringify(payload))
            state.subscriptionForm1 = payload
            // localStorage.setItem('subscrForm', JSON.stringify(payload))
            // state.subscrForm = payload
        },
        saveSubscriptionForm2(state, payload)
        {
            localStorage.setItem('subscriptionForm2', JSON.stringify(payload))
            state.subscriptionForm2 = payload
            let fm1 = localStorage.getItem('subscriptionForm1')
            fm1 = JSON.parse(fm1)
            let subFms = { ...fm1, ...payload }
            state.subscrForm = subFms
            localStorage.setItem('subscrForm', JSON.stringify(subFms))
        },
        resetSubscriptionForm(state){
            state.subscrForm = null
            state.subscriptionForm1 = null
            state.subscriptionForm2 = null
            localStorage.removeItem('subscrForm')
            localStorage.removeItem('subscriptionForm1')
            localStorage.removeItem('subscriptionForm2')
        },
        adminDeletedEvent(state)
        {
            state.adminDeletedEvent = true
        },
        adminUpdatedEvent(state)
        {
            state.adminUpdatedEvent = true
        },
        adminDeletedTestimonial(state)
        {
            state.adminDeletedTestimonial = true
        },
        adminUpdatedTestimonial(state)
        {
            state.adminUpdatedTestimonial = true
        },
        adminDeletedNewsPost(state)
        {
            state.adminDeletedNewsPost = true
        },
        adminUpdatedNewsPost(state){
            state.adminUpdatedNewsPost = true
        }
    }
})
