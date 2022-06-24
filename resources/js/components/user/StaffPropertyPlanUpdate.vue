<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="4" min-height="200" class="mx-auto">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Update Plan</v-card-title>
                    <v-card-text class="mt-5 ml-3" v-if="plan">
                        <v-text-field label="Title" hint="The title of the plan(e.g 6 months price)" v-model="plan.name" required v-validate="'required|min:3|max:100'" :error-messages="errors.collect('name')" name="name"></v-text-field>
                        <v-text-field label="Unit" hint="The unit/size of the plan" v-model="plan.unit" required v-validate="'required|min:3|max:50'" :error-messages="errors.collect('unit')" name="unit"></v-text-field>
                        <v-text-field label="Price(NGN)" hint="Price of a unit/size of the plan in Naira. Please do not add commas" v-model="plan.price" v-validate="'required|decimal'" :error-messages="errors.collect('price')" name="price"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn large dark width="50%" color="primary" :loading="isBusy" @click="update">Update</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="updateFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the plan. Please ensure all fields are validly filled before trying again.
            <v-btn text color="white--text" @click="updateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            plan: {},
            isBusy: false,
            updateFailed: false
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
        getPlan(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_listing_plan/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.plan = res.data
                this.plan.price = res.data.price / 100
                // console.log(res.data)
            })
        },
        update(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    axios.post(this.api + `/auth/update_listing_plan/${this.plan.id}`, {
                        plan: this.plan
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('listingPlanUpdated')
                        this.$router.push({name: 'StaffPropertyDetail', params: {id: this.plan.property_listing_id}})
                        // console.log(res.data)
                    }).catch(() => {
                        this.isBusy = false
                        this.updateFailed = true
                    })
                }
            })
        }
    },
    mounted() {
        this.getPlan()
    },
}
</script>
