<template>
    <v-container>
        <v-row class="mt-4">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon> Back</v-btn>
            </v-col>
        </v-row>
        <v-row class="mt-3" justify="center" :class="$vuetify.breakpoint.smAndDown ? 'ml-n4 mr-n5': ''">
            <v-col cols="12" md="8">
                <v-card light raised elevation="8" min-height="200">
                    <v-card-title class="subtitle-1 primary white--text justify-center">Create Newsletter</v-card-title>
                    <v-card-text class="body-1 mt-5 px-8">
                        <v-text-field label="Subject" v-model="newsletter.subject" required placeholder="Subject" v-validate="'required|min:3|max:150'" :error-messages="errors.collect('subject')" name="subject"></v-text-field>
                        <v-textarea label="Body" rows="2" auto-grow v-model="newsletter.body" required placeholder="Body" v-validate="'required|min:10|max:600'" :error-messages="errors.collect('body')" name="body"></v-textarea>
                        <v-text-field label="Closing" v-model="newsletter.closing" required v-validate="'max:150'" :error-messages="errors.collect('closing')" name="closing"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn large text color="red darken-2" width="40%">Cancel</v-btn>
                        <v-btn large color="primary" width="40%" @click="postNewsletter" :loading="isBusy">Post Newsletter</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="newsletterSent" :timeout="3000" top color="green darken-1 white--text">
            Newsletter has been sent to subscribers successfully.
            <v-btn text color="white--text" @click="newsletterSent = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="newsletterFailed" :timeout="6000" top color="red darken-1 white--text">
            There was an error while trying to send the newsletter to subscribers. Please ensure the email addresses are correct before trying again.
            <v-btn text color="white--text" @click="newsletterFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            newsletter:{
                subject: '',
                body: '',
                closing: ''
            },
            isBusy: false,
            newsletterSent: false,
            newsletterFailed: false,
        }
    },
    computed: {
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
    },
    methods:{
        postNewsletter(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    axios.post(this.api + '/auth-admin/post_newsletter', {
                        newsletter: this.newsletter
                    }, this.adminHeaders).then((res) =>{
                        this.isBusy = false
                        this.newsletter.subject = ''
                        this.newsletter.body = ''
                        this.newsletter.closing = ''
                        this.$validator.pause()
                        this.$validator.fields.items.forEach(field => field.reset())
                        this.$validator.errors.clear()
                        this.newsletterSent = true
                        console.log(res.data)
                    }).catch(() => {
                        this.isBusy = false
                        this.newsletterFailed = true
                    })
                }
            })
        }
    }
}
</script>
