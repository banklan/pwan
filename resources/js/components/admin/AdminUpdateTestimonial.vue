<template>
    <v-container>
        <v-row justify="center" class="justify-center mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Testimonial Update</v-card-title>
                    <v-card-text class="mt-8 ml-5" v-if="testimonial">
                        <v-text-field label="Fullname of Client" v-model="testimonial.fullname" required v-validate="'required|min:5|max:100'" :error-messages="errors.collect('fullname')"  name="fullname"></v-text-field>
                        <v-text-field label="Occupation" v-model="testimonial.occupation" required v-validate="'required|min:3|max:100'" :error-messages="errors.collect('occupation')"  name="occupation"></v-text-field>
                        <v-text-field label="Organization" v-model="testimonial.organization" required v-validate="'required|min:3|max:100'" :error-messages="errors.collect('organization')"  name="organization"></v-text-field>
                        <v-textarea label="Title" v-model="testimonial.title" rows="1" auto-grow required v-validate="'required|min:5|max:200'" :error-messages="errors.collect('title')"  name="title" data-vv-as="title"></v-textarea>
                        <v-textarea label="Detail" v-model="testimonial.detail" rows="2" auto-grow required v-validate="'required|min:10|max:600'" :error-messages="errors.collect('detail')"  name="detail" data-vv-as="detail"></v-textarea>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn text large color="red darken-2" @click="$router.go(-1)" width="40%">Cancel</v-btn>
                        <v-btn dark color="primary" large :loading="isBusy" @click="updateTestimonial" width="40%">Update</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="updatefailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the testimonial. Ensure all fields are filled validly while trying again.
            <v-btn text color="white--text" @click="updatefailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            testimonial: {
                fullname: '',
                occupation: '',
                organization: '',
                title: '',
                detail: ''
            },
            isLoading: false,
            isBusy: false,
            updatefailed: false
        }
    },
    computed:{
         authAdmin(){
            return this.$store.getters.authAdmin
        },
        api(){
            return this.$store.getters.api
        },
        adminHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authAdmin.token}`
                }
            }
            return headers
        },
        adminUpdatedUser(){
            return this.$store.getters.adminUpdatedUser
        },
    },
    methods: {
        getTestimonial(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_testimonial/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.testimonial.fullname = res.data.fullname
                this.testimonial.occupation = res.data.fullname
                this.testimonial.organization = res.data.organization
                this.testimonial.title = res.data.title
                this.testimonial.detail = res.data.detail
            })
        },
        updateTestimonial(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    axios.post(this.api + `/auth-admin/update_testimonial/${this.$route.params.id}`, {
                        testimonial: this.testimonial
                    }, this.adminHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('adminUpdatedTestimonial')
                        this.$router.push({name: 'AdminTestimonialDetail', params: {id: res.data.id}})
                        // console.log(res.data)s
                    }).catch(()=>{
                        this.isBusy = false
                        this.updatefailed = true
                    })
                }
            })
        }
    },
    mounted() {
        this.getTestimonial()
    },
}
</script>
