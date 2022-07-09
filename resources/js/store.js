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

const auth_user = window.localStorage.getItem('authUser')
const authUser = auth_user ? JSON.parse(auth_user) : null

const user_loggedin = window.localStorage.getItem('userIsLoggedIn')
const userIsLoggedIn = user_loggedin ? true : false

const redirect = window.localStorage.getItem('redirOnlogin')
const redirectOnLogin = redirect ? redirect : null

const new_prop = window.localStorage.getItem('new_prop')
const newPropListing = new_prop ? JSON.parse(new_prop) : null

const new_evnt = window.localStorage.getItem('newEvent')
const newEvent = new_evnt ? JSON.parse(new_evnt) : null



export const store = new Vuex.Store({
    state: {
        api: 'http://localhost:8000/api',
        // api: 'https://www.pwan-platinum.com.ng/api',
        adminIsLoggedIn: adminIsLoggedIn,
        authAdmin: authAdmin,
        userIsLoggedIn: userIsLoggedIn,
        authUser: authUser,
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
        updatedAdminProfile: false,
        redirectOnLogin: redirectOnLogin,
        StaffUpdatedProperty: false,
        newPropListing: newPropListing,
        listingFilesUploaded: false,
        listingDeleted: false,
        adminDeletedListing: false,
        listingPlanCreated: false,
        listingPlanUpdated: false,
        eventDeleted: false,
        eventUpdated: false,
        newsPostDeleted: false,
        updateNewsNotAllowed: false,
        newsPostUpdated: false,
        canUpdateNewsPost: false,
        checkAuthor: null,
        cannotUpdatePost: false,
        newPostCreated: false,
        testimonialSent: false,
        newEvent: newEvent,
        eventCreated: false,
        updatedUserProfile: false,
        adminUpdatedListingPlan: false,
        passwordReset: false,
        adminDeleteEnquiry: false,
        newOfferCreated: false,
        newOfferUpdated: false,
        newOfferDeleted: false,
        adminDeletedNewOffer: false,
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
        updatedAdminProfile(state)
        {
            return state.updatedAdminProfile
        },
        authUser(state)
        {
            return state.authUser
        },
        userIsLoggedIn(state){
            return state.userIsLoggedIn
        },
        redirectOnLogin(state){
            return state.redirectOnLogin
        },
        StaffUpdatedProperty(state)
        {
            return state.StaffUpdatedProperty
        },
        newPropListing(state)
        {
            return state.newPropListing
        },
        listingFilesUploaded(state)
        {
            return state.listingFilesUploaded
        },
        listingDeleted(state)
        {
            return state.listingDeleted
        },
        adminDeletedListing(state)
        {
            return state.adminDeletedListing
        },
        listingPlanCreated(state)
        {
            return state.listingPlanCreated
        },
        listingPlanUpdated(state)
        {
            return state.listingPlanUpdated
        },
        eventDeleted(state)
        {
            return state.eventDeleted
        },
        eventUpdated(state)
        {
            return state.eventUpdated
        },
        newsPostDeleted(state)
        {
            return state.newsPostDeleted
        },
        updateNewsNotAllowed(state)
        {
            return state.updateNewsNotAllowed
        },
        newsPostUpdated(state)
        {
            return state.newsPostUpdated
        },
        canUpdateNewsPost(state)
        {
            return state.canUpdateNewsPost
        },
        checkAuthor(state){
            return state.checkAuthor
        },
        cannotUpdatePost(state)
        {
            return state.cannotUpdatePost
        },
        newPostCreated(state)
        {
            return state.newPostCreated
        },
        testimonialSent(state)
        {
            return state.testimonialSent
        },
        newEvent(state)
        {
            return state.newEvent
        },
        eventCreated(state)
        {
            return state.eventCreated
        },
        updatedUserProfile(state)
        {
            return state.updatedUserProfile
        },
        adminUpdatedListingPlan(state)
        {
            return state.adminUpdatedListingPlan
        },
        passwordReset(state)
        {
            return state.passwordReset
        },
        adminDeleteEnquiry(state)
        {
            return state.adminDeleteEnquiry
        },
        newOfferCreated(state)
        {
            return state.newOfferCreated
        },
        newOfferUpdated(state)
        {
            return state.newOfferUpdated
        },
        newOfferDeleted(state)
        {
            return state.newOfferDeleted
        },
        adminDeletedNewOffer(state)
        {
            return state.adminDeletedNewOffer
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
            state.adminUpdatedNewsPost = false
            state.AdminUpdatedProperty = false
            state.adminDeletedListing = false
            state.adminUpdatedListingPlan = false
            state.adminDeleteEnquiry = false
            state.adminDeletedNewOffer = false
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
        },
        updatedAdminProfile(state, payload){
            state.authAdmin.first_name = payload.first_name
            state.authAdmin.last_name = payload.last_name
            state.authAdmin.phone = payload.phone
            state.authAdmin.picture = payload.picture
            state.authAdmin.updated_at = payload.updated_at
            state.authAdmin.fullname = payload.first_name + ' '+ payload.last_name
            window.localStorage.setItem('authAdmin', JSON.stringify(state.authAdmin))
            state.updatedAdminProfile = true
        },
        redirectOnLogin(state, payload)
        {
            window.localStorage.setItem('redirOnLogin', payload)
            state.redirectOnLogin = payload
        },
        userLoginSuccess(state, payload)
        {
            localStorage.removeItem('authAdmin')
            localStorage.removeItem('adminIsLoggedIn')
            state.adminIsLoggedIn = false
            state.authadmin = null
            state.userIsLoggedIn = true
            state.authUser = Object.assign({}, payload.user, {token: payload.access_token})
            window.localStorage.setItem('authUser', JSON.stringify(state.authUser))
            window.localStorage.setItem('userIsLoggedIn', true)
        },
        logOutAuthUser(state)
        {
            localStorage.removeItem('authUser')
            localStorage.removeItem('userIsLoggedIn')
            state.userIsLoggedIn = false
            state.authUser = null
        },
        StaffUpdatedProperty(state)
        {
            state.StaffUpdatedProperty = true
        },
        resetStaffFlashMsg(state)
        {
            state.StaffUpdatedProperty = false
            state.listingCreated = false
            state.listingDeleted = false
            state.listingFilesUploaded = false
            state.listingPlanCreated = false
            state.listingPlanUpdated = false
            state.eventDeleted = false
            state.eventUpdated = false
            state.newsPostDeleted = false
            state.cannotUpdatePost = false
            state.newPostCreated = false
            state.newsPostUpdated = false
            state.testimonialSent = false
            state.eventCreated = false
            state.newOfferCreated = false
            state.newOfferUpdated = false
            state.newOfferDeleted = false
        },
        CreatePropListing(state, payload)
        {
            window.localStorage.setItem('new_prop', JSON.stringify(payload))
            state.newPropListing = payload
        },
        listingFilesUploaded(state)
        {
            state.listingFilesUploaded = true
        },
        newListingCleared(state)
        {
            window.localStorage.removeItem('new_prop')
            state.newPropListing = null
        },
        listingDeleted(state)
        {
            state.listingDeleted = true
        },
        adminDeletedListing(state)
        {
            state.adminDeletedListing = true
        },
        listingPlanCreated(state)
        {
            state.listingPlanCreated = true
        },
        listingPlanUpdated(state)
        {
            state.listingPlanUpdated = true
        },
        eventDeleted(state){
            state.eventDeleted = true
        },
        eventUpdated(state)
        {
            state.eventUpdated = true
        },
        newsPostDeleted(state)
        {
            state.newsPostDeleted = true
        },
        updateNewsNotAllowed(state)
        {
            state.updateNewsNotAllowed = true
        },
        newsPostUpdated(state)
        {
            state.newsPostUpdated = true
        },
        canUpdateNewsPost(state, payload){
            if(payload == state.authUser.id){
                state.canUpdateNewsPost = true
            }else{
                state.canUpdateNewsPost = false
            }
            // console.log(state.canUpdateNewsPost)
        },
        checkAuthor(state, payload)
        {
            state.checkAuthor = payload
        },
        cannotUpdatePost(state){
            state.cannotUpdatePost = true
        },
        newPostCreated(state)
        {
            state.newPostCreated = true
        },
        testimonialSent(state)
        {
            state.testimonialSent = true
        },
        storeCreatedEvent(state, payload)
        {
            localStorage.setItem('newEvent', JSON.stringify(payload))
            state.newEvent = payload
        },
        eventCreated(state)
        {
            localStorage.removeItem('newEvent')
            state.newEvent = null
            state.eventCreated = true
        },
        updatedUserProfile(state, payload){
            state.authUser.first_name = payload.first_name
            state.authUser.last_name = payload.last_name
            state.authUser.phone = payload.phone
            state.authUser.picture = payload.picture
            state.authUser.updated_at = payload.updated_at
            state.authUser.fullname = payload.first_name + ' '+ payload.last_name
            window.localStorage.setItem('authUser', JSON.stringify(state.authUser))
            state.updatedUserProfile = true
        },
        adminUpdatedListingPlan(state)
        {
            state.adminUpdatedListingPlan = true
        },
        passwordReset(state)
        {
            state.passwordReset = true
        },
        adminDeleteEnquiry(state)
        {
            state.adminDeleteEnquiry = true
        },
        newOfferCreated(state)
        {
            state.newOfferCreated = true
        },
        newOfferUpdated(state)
        {
            state.newOfferUpdated = true
        },
        newOfferDeleted(state)
        {
            state.newOfferDeleted = true
        },
        adminDeletedNewOffer(state)
        {
            state.adminDeletedNewOffer = true
        },
    }
})
