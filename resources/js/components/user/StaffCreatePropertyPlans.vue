<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card light raised elevation="4" min-height="200" class="mx-auto">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New Plan</v-card-title>
                    <v-card-text class="mt-5 px-3">
                        <v-text-field label="Title" hint="The title of the plan(e.g 6 months price)" v-model="plan.name" required v-validate="'required|min:3|max:100'" :error-messages="errors.collect('name')" name="name"></v-text-field>
                        <v-text-field label="Unit" hint="The unit/size of the plan" v-model="plan.unit" required v-validate="'required|min:3|max:50'" :error-messages="errors.collect('unit')" name="unit"></v-text-field>
                        <v-text-field label="Price(NGN)" hint="Price of a unit/size of the plan in Naira. Please do not add commas" v-model="plan.price" v-validate="'required|decimal'" :error-messages="errors.collect('price')" name="price"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6">
                        <v-btn large text width="40%" color="red darken-2" @click="clear">Cancel</v-btn>
                        <v-btn large dark width="40%" color="primary" :loading="isBusy" @click="submit">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="submitFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to submit the plan. Please ensure all fields are validly filled before trying again.
            <v-btn text color="white--text" @click="submitFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            plan: {
                name: '',
                unit: '',
                price: null
            },
            isBusy: false,
            submitFailed: false
        }
    },
    computed: {
        authUser(){
            return this.$store.getters.authUser
        },
        api(){
            return this.$store.getters.api
        },
        authHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authUser.token}`
                }
            }
            return headers
        },
    },
    methods: {
        clear(){
            this.plan.name = ''
            this.plan.unit = ''
            this.plan.price = ''
            // this.$validator.pause()
            this.$validator.errors.clear()
        },
        submit(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    let id = this.$route.params.listing
                    axios.post(this.api + `/auth/create_new_listing_plan/${id}`, {
                        plan: this.plan
                    }, this.authHeaders).then((res) => {
                        this.isBusy = true
                        this.$store.commit('listingPlanCreated')
                        this.$router.push({name: 'StaffPropertyDetail', params: {id: id}})
                        // console.log(res.data)
                    }).catch((err) => {
                        this.isBusy = true
                        this.submitFailed = true
                    })
                }
            })
        }
    }
}
</script>
