<template>
    <v-container>
        <template v-if="!submitSuccess">
            <v-row class="mt-3">
                <v-col cols="12" md="1">
                    <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'SubscriptionForm2'}"><i class="uil uil-arrow-left"></i>Section 2</v-btn>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-6">
                <v-col cols="12" md="8">
                    <v-card elevation="6" light raised class="mx-auto">
                        <v-card-title class="justify-center primary white--text subtitle-1">Subscription Form - Section 3 (Subscriber's passport)</v-card-title>
                        <div class="text-center mt-7 mx-5">
                            <v-alert type="info">Kindly upload a passport of yourself. Passport must not have face covered, and on a plain background.</v-alert>
                        </div>
                        <v-card-text class="mt-5 text-center">
                            <template v-if="!prvImg">
                                <v-btn outlined color="primary lighten--2" class="mb-5" @click="openUpload">Choose Picture</v-btn>
                                <input type="file" ref="image" style="display:none" @change.prevent="pickImg" accept="image/*">
                            </template>
                            <template v-else>
                                <v-img :src="prvImgUrl" height="150" contain alt="subscriber's passport photo" aspect-ratio="1"></v-img>
                                <v-card-actions class="justify-center mt-5">
                                    <v-btn text color="red darken-2" small @click="removeImg"><i class="uil uil-trash-alt"></i></v-btn>
                                </v-card-actions>
                            </template>
                        </v-card-text>
                    </v-card>
                    <v-card elevation="6" light raised class="mt-8">
                        <v-card-title class="justify-center primary white--text subtitle-1">Section 4 - Subscriber's Declaration</v-card-title>
                        <v-card-text class="mt-6 pl-6">
                            <div class="mt-5 form_info">
                                <p>I do hereby affirm that all information provided as a requirement for the land
                                in Platinum view at Adagbrassa, Warri, is true. Any false or inaccurate information given by me may result in the decline of my application.</p>
                            </div>
                            <div class="mt-3 px-5">
                                <v-row justify="center">
                                    <v-col cols="12" md="6">
                                        <v-select label="Type of plot" v-model="client.plot_type" hint="What are you using the land/property for?" v-validate="'required'" :items="typeOfPlot" item-text="type" item-value="type" required :error-messages="errors.collect('plot_type')" data-vv-as="type of plot" name="plot_type"></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <!-- <v-select label="Payment Plans (months)" v-model="client.pay_plans" v-validate="'required'" :items="paymentPlans" item-text="type" item-value="type" required :error-messages="errors.collect('pay_plans')" data-vv-as="payment plans" name="pay_plans"></v-select> -->
                                        <v-select label="Payment Plans (months)" hint="Payment plans you wish to subscribe to" v-model="client.plan" v-validate="'required'" :items="plans" item-text="plan" item-value="id" required :error-messages="errors.collect('plan')" data-vv-as="payment plans" name="plan"></v-select>
                                    </v-col>
                                    <v-alert type="info">
                                        <p>Please note that Commercial plots attract 10% of land cost.</p>
                                        <p>Corner plot(s) also attracts 10% of total land cost. </p>
                                    </v-alert>
                                </v-row>
                                <v-row justify="center">
                                    <v-col cols="12" md="6">
                                        <v-text-field label="Number of Plots" type="number" v-model="client.no_plot" v-validate="'required|between:1,20'" required :error-messages="errors.collect('no_plot')" data-vv-as="number of plot(s) plans" name="no_plot"></v-text-field>
                                    </v-col>
                                    <!-- <v-col cols="12" md="6">
                                        <v-select label="Plot Size" v-model="client.plot_size" :items="plotSizes" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('plot_size')" data-vv-as="plot size" name="plot_size"></v-select>
                                    </v-col> -->
                                </v-row>
                            </div>
                            <v-alert type="warning" class="mt-5">
                                By clicking on the button below, you have agreed to all our terms, given your consent and signed this declation form electronically.
                            </v-alert>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-6">
                            <v-btn x-large dark elevation="12" color="primary" width="50%" @click="submitForm" :loading="isBusy">Submit</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-snackbar v-model="submitFailed" :timeout="6000" top dark color="red darken-1">
                {{ formError }}
                <v-btn text color="white--text" @click="submitFailed = false">Close</v-btn>
            </v-snackbar>
        </template>
        <template v-else>
            <v-row justify="center" class="mt-8">
                <v-col cols="12" md="8">
                    <v-alert type="success" border="left">
                        Thank you for filling our subscription form. One of our executives will contact you soon.
                    </v-alert>
                    <div class="text-center mt-8">
                        <v-btn text color="primary" to="/">Back To Home</v-btn>
                    </div>
                </v-col>
            </v-row>
        </template>
    </v-container>
</template>

<script>
import { store } from './../store'
export default {
    data() {
        return {
            radioGroup: 1,
            client:{
                plot_type: '',
                no_plot: null,
                plot_size: '',
                plan: null,
            },
            image: '',
            prvImg: false,
            prvImgUrl: '',
            isBusy: false,
            typeOfPlot: [
                {id: 1, type: 'Residential'}, {id: 2, type: 'Commercial'}
            ],
            paymentPlans: [
                {id: 1, type: '3'}, {id:2, type: '12'}
            ],
            plotSizes:[
                {id: 1, type: '460sqm'}
            ],
            submitFailed: false,
            formError: '',
            submitSuccess: false,
            property: null,
            plans: [],
            gettingProperty: false,
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        },
        form1(){
            return this.$store.getters.subscriptionForm1
        },
        form2(){
            return this.$store.getters.subscriptionForm2
        },
        subscrForm(){
            return this.$store.getters.subscrForm
        }
    },
    beforeRouteEnter (to, from, next) {
        if(store.getters.subscrForm){
            next()
        }else{
            // this.$router.push({name: 'SubscriptionForm1'})
            next('/subscription-form2')
        }
    },
    methods: {
        openUpload(){
            this.$refs.image.click()
        },
        pickImg(e){
            const file = e.target.files[0]
            this.image = file
            this.prvImg = true
            this.prvImgUrl = URL.createObjectURL(file)
        },
        removeImg(){
            this.image = null
            this.prvImg = false
            this.prvImgUrl = ''
        },
        testform(){
            const clnt = this.client
            let form = JSON.parse(localStorage.getItem('subscrForm'))
            console.log(typeof(form))
            axios.post(this.api + '/test_sub_form', {
                form: clnt
            }).then((res) => {
                console.log(res.data)
            })
        },
        submitForm(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    if(this.image !== ''){
                        this.isBusy = true
                        let form1 = this.form1
                        let form2 = this.form2
                        let form3 = this.client
                        const allForm = {...this.form1, ...this.form2, ...this.client}

                        axios.post(this.api + '/post_subscription_form', {
                            client: allForm
                        }).then((res) => {
                            this.isBusy = false
                            console.log(res.data)
                            this.uploadPassport(res.data.id)
                            this.clearStorage()
                            this.submitSuccess = true
                        }).catch(() => {
                            this.isBusy = false
                            this.submitFailed = true
                            this.formError = "There was an error while trying to submit the form. Please ensure all fields are validly filled while trying again."
                        })
                    }else{
                        this.submitFailed = true
                        this.formError = "Subscribers are required to upload a passpot picture of themselves."
                    }
                }
            })
        },
        uploadPassport(id){
             let form = new FormData();
             form.append('image', this.image)

             axios.post(this.api + `/upload_subscription_passport/${id}`, form).then((res) => {
                 this.image = ''
             })
        },
        clearStorage(){
            this.$store.commit('resetSubscriptionForm')
        },
        getProperty(){
            this.gettingProperty = true
            axios.get(this.api + `/get_subscription_listing/${this.form1.property}`)
            .then((res) => {
                this.gettingProperty = false
                this.property = res.data
                this.plans = res.data.property_listing_plans
                console.log(this.plans)
            }).catch((e) => {
                console.log(e)
            })
        }
    },
    mounted() {
        this.getProperty()
    },
}
</script>

<style lang="scss" scoped>
    .v-btn i{
        font-size: 1.2rem !important;
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
