<template>
    <v-container fluid>
        <v-row justify="center" class="mt-6">
            <v-col cols="12" md="8">
                <v-card elevation="6" light raised>
                    <v-card-title class="justify-center primary white--text subtitle-1">Subscription Form - Section 1 (Subscriber's details)</v-card-title>
                    <v-alert type="info" class="mt-2 mx-2">All Fields must be filled</v-alert>
                    <v-card-text class="mt-6 pl-6">
                        <v-text-field label="Surname" v-model="client.surname" required v-validate="'required|min:2|max:50'" :error-messages="errors.collect('surname')"  name="surname"></v-text-field>
                        <v-text-field label="Other Names" v-model="client.other_names" required v-validate="'required|min:2|max:80'" :error-messages="errors.collect('other_names')"  name="other_names" data-vv-as="other names"></v-text-field>
                        <v-text-field label="Spouse Surname (If applicable)" v-model="client.spouse_surname" v-validate="'max:50'" :error-messages="errors.collect('spouse_surname')"  name="spouse_surname" data-vv-as="spouse surname"></v-text-field>
                        <v-text-field label="Spouse Other Names (If applicable)" v-model="client.spouse_names" v-validate="'max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-textarea rows="2" auto-grow label="Address" v-model="client.address" required v-validate="'required|min:5|max:500'" :error-messages="errors.collect('address')"  name="address"></v-textarea>
                        <!-- <v-text-field type="date" label="Date Of Birth" v-model="client.dob" required v-validate="'required'" :error-messages="errors.collect('dob')"  name="dob" data-vv-as="date of birth"></v-text-field> -->
                        <v-menu ref="datePicker" v-model="datePicker" :close-on-content-click="false" :return-value.sync="client.dob" transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="client.dob" label="Date of Birth" prepend-icon="event" readonly v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="client.dob" color="primary" elevation="4" scrollable>
                                <div class="flex-grow-1"></div>
                                <v-btn text color="red darken-2" @click="datePicker = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.datePicker.save(client.dob)">Ok</v-btn>
                            </v-date-picker>
                        </v-menu>
                        <v-radio-group v-model="client.gender" row>
                            <v-radio value="M">
                                <template v-slot:label>Male</template>
                            </v-radio>
                            <v-radio value="F">
                                <template v-slot:label>Female</template>
                            </v-radio>
                        </v-radio-group>
                        <v-select label="Marital Status" v-model="client.mar_status" :items="maritalStatus" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('marital')" data-vv-as="marital status" name="marital"></v-select>
                        <v-text-field label="Nationality" v-model="client.nationality" v-validate="'required|min:3|max:60'" :error-messages="errors.collect('nationality')"  name="nationality"></v-text-field>
                        <v-text-field label="Occupation" v-model="client.occupation" v-validate="'required|min:3|max:200'" :error-messages="errors.collect('occupation')"  name="occupation"></v-text-field>
                        <v-text-field label="Employer" v-model="client.employer" v-validate="'required|min:3|max:200'" :error-messages="errors.collect('employer')"  name="employer"></v-text-field>
                        <v-text-field label="Country Of Residence" v-model="client.count_res" v-validate="'required|min:3|max:60'" :error-messages="errors.collect('count_res')"  name="count_res" data-vv-as="country of residence"></v-text-field>
                        <v-text-field label="Email Address" type="email" v-model="client.email" v-validate="'required|email'" :error-messages="errors.collect('email')"  name="email" data-vv-as="email address"></v-text-field>
                        <v-text-field label="Telephone Number" v-model="client.phone" v-validate="'required|max:14|numeric'" :error-messages="errors.collect('phone')"  name="phone"></v-text-field>
                        <!-- <v-text-field label="Telephone Number" v-model="client.phone" :rules="[^[0-9\+\]+$]" :error-messages="errors.collect('phone')"  name="phone"></v-text-field> -->
                        <v-text-field label="Mobile Number" v-model="client.mobile" v-validate="'max:14|numeric'" :error-messages="errors.collect('mobile')"  name="mobile"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn x-large dark elevation="12" color="primary" width="50%" @click="saveClientDetails">NEXT </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            radioGroup: 1,
            client:{
                surname: '',
                other_names: '',
                spouse_surname: '',
                spouse_names: '',
                address: '',
                gender: '',
                dob: new Date().toISOString().substr(0, 10),
                mar_status: '',
                nationality: '',
                occupation: '',
                employer: '',
                count_res: '',
                email: '',
                phone: '',
                mobile: ''

            },
            maritalStatus:[
                {type: 'Single'}, {type: 'Married'}, {type: 'Divorced'}, {type: 'Widowed'}
            ],
            typeOfPlot: [
                {type: 'Residential'}, {type: 'Commercial Plots'}
            ],
            paymentPlans: [
                {type: '3'}, {type: '12'}
            ],
            plotSizes:[
                {type: '460sqm'}
            ],
            date: new Date().toISOString().substr(0, 10),
            datePicker: false,
        }
    },
    computed: {
        subscriptionForm1(){
            return this.$store.getters.subscriptionForm1
        }
    },
    methods: {
        saveClientDetails(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    console.log(this.client)
                    this.$store.commit('saveSubscriptionForm1', this.client)
                    this.$router.push({name: 'SubscriptionForm2'})
                }
            })
        }
    },
    mounted(){
        if(this.subscriptionForm1){
            this.client =  this.subscriptionForm1
        }
    }
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
</style>
