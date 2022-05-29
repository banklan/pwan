<template>
    <v-container fluid>
        <v-row class="mt-3">
            <v-col cols="12" md="1">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'SubscriptionForm'}"><i class="uil uil-arrow-left"></i>Section 1</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-6">
            <v-col cols="12" md="8">
                <v-card elevation="6" light raised>
                    <v-card-title class="justify-center primary white--text subtitle-1">Subscription Form - Section 2 (Next Of Kin)</v-card-title>
                    <v-alert type="info" class="mt-2 mx-2">All Fields must be filled</v-alert>
                    <v-card-text class="mt-2 pl-6">
                        <v-text-field label="Next Of Kin Name" v-model="client.kin_name" v-validate="'required|min:3|max:200'" :error-messages="errors.collect('kin_name')"  name="kin_name" data-vv-as="next of kin name"></v-text-field>
                        <v-text-field label="Phone Number" v-model="client.kin_phone" v-validate="'required|numeric|max:16'" :error-messages="errors.collect('kin_phone')"  name="kin_phone" data-vv-as="next of kin phone number"></v-text-field>
                        <v-text-field label="Email Address" v-model="client.kin_email" v-validate="'required|email'" :error-messages="errors.collect('kin_email')"  name="kin_email" data-vv-as="next of kin email address"></v-text-field>
                        <v-textarea rows="2" auto-grow label="Address" v-model="client.kin_address" v-validate="'required|min:5|max:200'" :error-messages="errors.collect('kin_address')"  name="kin_address" data-vv-as="next of kin address"></v-textarea>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6">
                        <v-btn x-large dark elevation="12" color="primary" width="50%" @click="saveKin">NEXT</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { store } from './../store'

export default {
    data() {
        return {
            radioGroup: 1,
            client:{
                kin_name: '',
                kin_phone: '',
                kin_email: '',
                kin_address: ''
            },
        }
    },
    computed: {
        subscriptionForm2(){
            return this.$store.getters.subscriptionForm2
        },
        subscriptionForm1(){
            return $this.store.getters.subscriptionForm1
        }
    },
    beforeRouteEnter (to, from, next) {
        if(store.getters.subscriptionForm1){
            next()
        }else{
            // this.$router.push({name: 'SubscriptionForm1'})
            next('/subscription-form')
        }
    },
    watch:{
        // go to form3 when saved
        // saveKin(){
        //     this.$router.push({name: 'SubscriptionForm3'})
        // }
    },
    methods: {
        saveKin(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.$store.commit('saveSubscriptionForm2', this.client)
                    this.$router.push({name: 'SubscriptionForm3'})
                }
            })
        },
        checkIfFormExist(){
            if(this.subscriptionForm2){
                this.client = this.subscriptionForm2
            }
        }
    },
    mounted() {
        this.checkIfFormExist()
    },
}
</script>

<style lang="scss" scoped>
    .subgroup-head{
        width: 100%;
        background: #001659;
        color: white;
        text-align: center;
        padding: .8rem 0;
    }
    .form_info{
        padding: 1.2rem 1rem;
        p{
            font-size: 1rem;
            color: #001659;
            font-weight: 400;
        }
    }
     a{
        text-decoration: none !important;
    }
</style>
