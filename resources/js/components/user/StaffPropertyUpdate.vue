<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card light raised outlined elevation="4" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Update Property Detail</v-card-title>
                    <v-card-text class="mt-7 mb-n5">
                        <div class="intro">Property: <span class="ml-2">{{ prop.name }}</span></div>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-text class="pl-5">
                        <v-text-field label="Name" v-model="prop.name" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('name')" name="name"></v-text-field>
                        <v-text-field label="Location" v-model="prop.location" required v-validate="'required|min:5|max:600'" :error-messages="errors.collect('location')" name="location"></v-text-field>
                        <v-text-field label="Landmark" v-model="prop.landmark" v-validate="'min:5|max:600'" :error-messages="errors.collect('landmark')" name="landmark"></v-text-field>
                        <v-text-field label="Title" v-model="prop.title" v-validate="'max:500'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <v-textarea label="Detail" v-model="prop.detail" v-validate="'required|min:5|max:1000'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                        <v-text-field label="Price(NGN)" v-model="prop.price" v-validate="'required|decimal'" :error-messages="errors.collect('price')" name="price"></v-text-field>
                        <v-text-field label="Size" v-model="prop.size" v-validate="'max:20'" :error-messages="errors.collect('size')" name="size"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn dark large text color="red darken-1" width="40%" :to="{name: 'AdminPropertyDetail', params: {id: prop.id}}">Cancel</v-btn>
                        <v-btn dark large color="primary" width="40%" @click="updateProp" :loading="isBusy">Submit</v-btn>
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
            isLoading: false,
            prop: {
                name: '',
                title: '',
                location: '',
                landmark: '',
                detail: '',
                price: '',
                size: ''
            },
            isBusy: false
        }
    },
    computed:{
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
        getProp(){
            axios.get(this.api + `/auth/get_property/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.prop = res.data
                this.prop.price = res.data.price / 100
            })
        },
        updateProp(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    axios.post(this.api + `/auth/staff_update_property/${this.$route.params.id}`, {
                        property: this.prop
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('StaffUpdatedProperty')
                        this.$router.push({name: 'StaffPropertyDetail', params: {id: this.$route.params.id}})
                    })
                }
            })
        }
    },
    mounted() {
        this.getProp()
    },
}
</script>

<style lang="scss" scoped>
    .intro{
        color: rgb(3, 3, 26) !important;
        padding: 0 10px;
        font-size: 1.1rem !important;
        color: rgb(3, 3, 26) !important;
    }
    a{
        text-decoration: none !important;
    }
</style>
