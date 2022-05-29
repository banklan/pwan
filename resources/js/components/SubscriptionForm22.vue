<template>
    <v-container fluid>
        <v-row justify="center" class="mt-6">
            <v-col cols="12" md="8">
                <v-card elevation="6" light raised>
                    <v-card-title class="justify-center primary white--text subtitle-1">Subscription Form</v-card-title>
                    <v-card-text class="mt-6 pl-6">
                        <div class="subgroup-head">
                            <div class="subtitle-1 justify-center">Section 1: Subscriber's Details</div>
                        </div>
                        <v-text-field label="Surname" v-model="client.surname" required v-validate="'required|min:2|max:50'" :error-messages="errors.collect('surname')"  name="surname"></v-text-field>
                        <v-text-field label="Other Names" v-model="client.other_names" required v-validate="'required|min:2|max:80'" :error-messages="errors.collect('other_names')"  name="other_names" data-vv-as="other names"></v-text-field>
                        <v-text-field label="Spouse Surname (If applicable)" v-model="client.spouse_surname" v-validate="'required|min:2|max:50'" :error-messages="errors.collect('spouse_surname')"  name="spouse_surname" data-vv-as="spouse surname"></v-text-field>
                        <v-text-field label="Spouse Other Names (If applicable)" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-textarea rows="2" auto-grow label="Address" v-model="client.address" required v-validate="'required|min:3|max:500'" :error-messages="errors.collect('address')"  name="address"></v-textarea>
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
                        <v-radio-group v-model="radioGroup" row>
                            <v-radio value="M">
                                <template v-slot:label>Male</template>
                            </v-radio>
                            <v-radio value="F">
                                <template v-slot:label>Female</template>
                            </v-radio>
                        </v-radio-group>
                        <v-select label="Marital Status" v-model="client.mar_status" :items="maritalStatus" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('marital')" data-vv-as="marital status" name="marital"></v-select>
                        <v-text-field label="Nationality" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Occupation" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Employer" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Country Of Residence" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Email Address" type="email" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Telephone Number" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-text-field label="Mobile Number" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                        <v-divider></v-divider>
                        <div class="subgroup-head">
                            <div class="subtitle-1 justify-center">Section 2: Next Of Kin</div>
                        </div>
                            <v-text-field label="Name" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                            <v-text-field label="Phone Number" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                            <v-text-field label="Email Address" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-text-field>
                            <v-textarea rows="2" auto-grow label="Address" v-model="client.spouse_names" v-validate="'required|min:2|max:80'" :error-messages="errors.collect('spouse_names')"  name="spouse_names" data-vv-as="spouse other names"></v-textarea>
                         <div class="subgroup-head">
                            <div class="subtitle-1 justify-center">Section 3: Subscriber's Declaration</div>
                        </div>
                        <div class="mt-5 form_info">
                            <p>I <strong>{{ client.fullname }} </strong> do hereby affirm that all information provided as a requirement for the land
                            in Platinum view at Adagbrassa, Warri, is true. Any false or inaccurate information given by me may result in the decline of my application.</p>
                        </div>
                        <div class="mt-3 px-5">
                            <v-row justify="center">
                                <v-col cols="12" md="6">
                                    <v-select label="Type of plot" v-model="client.mar_status" :items="typeOfPlot" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('plot_type')" data-vv-as="type of plot" name="plot_type"></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-select label="Payment plans (months)" v-model="client.mar_status" :items="paymentPlans" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('plot_type')" data-vv-as="type of plot" name="plot_type"></v-select>
                                </v-col>
                                <v-alert type="info">Please note that Commercial plots attract 10%</v-alert>
                            </v-row>
                            <v-row justify="center">
                                <v-col cols="12" md="6">
                                    <v-text-field label="Number of Plots" type="number"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-select label="Plots Size" v-model="client.mar_status" :items="plotSizes" item-text="type" item-value="type" required v-validate="'required'" :error-messages="errors.collect('plot_size')" data-vv-as="plot size" name="plot_size"></v-select>
                                </v-col>
                                <v-alert type="info">
                                    Please note that corner plot(s) attract 10% of total land cost.
                                </v-alert>
                            </v-row>
                        </div>
                    </v-card-text>
                    <div class="form_info">
                        <p>By clicking on the button below, you have agreed to all our terms, given your consent and signed this declation form electronically.</p>
                    </div>
                    <v-card-actions class="justify-center pb-6">
                        <v-btn x-large dark elevation="12" color="primary" width="50%">Submit</v-btn>
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
                dob: ''
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