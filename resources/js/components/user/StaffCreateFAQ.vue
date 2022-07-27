<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New FAQ</v-card-title>
                    <v-card-text class="mt-5">
                        <v-text-field label="FAQ question" v-model="faq.qstn" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('question')" name="question" counter="250"></v-text-field>
                        <v-textarea label="FAQ Answer" rows="2" auto-grow v-model="faq.ans" v-validate="'required|min:5|max:600'" :error-messages="errors.collect('answer')" name="answer" counter="600"></v-textarea>
                        <v-textarea label="Other Details (extra)" rows="1" auto-grow v-model="faq.extra" v-validate="'max:600'" :error-messages="errors.collect('extra')" name="extra"></v-textarea>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn large width="40%" color="red darken-2" text>Cancel</v-btn>
                        <v-btn large width="40%" color="primary" dark :loading="isBusy" @click="submit">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="createFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to post a faq. Please ensure all fields are validly filled before trying again.
            <v-btn text color="white--text" @click="createFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            faq: {
                qstn: '',
                ans: '',
                extra: '',
            },
            isBusy: false,
            createFailed: false,
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
        submit(){
             this.$validator.validateAll().then((isValid) => {
                if (isValid) {
                    this.isBusy = true
                    axios.post(this.api + '/auth/post_faq', {
                        faq: this.faq
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$router.push({name: 'StaffFaqList'})
                        this.$store.commit('faqAdded')
                    }).catch(() => {
                        this.isBusy = false
                        this.createFailed = true
                    })
                }
             })
        },
        cancel(){
            this.faq.qstn = ''
            this.faq.ans = ''
            this.faq.extra = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
        }
    }
}
</script>
