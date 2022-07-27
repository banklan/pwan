<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <template v-if="faq">
                        <v-card-title class="primary white--text justify-center subtile-1">Faq Update</v-card-title>
                        <v-card-text class="mt-8">
                            <v-text-field label="Question" v-model="faq.qstn" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('question')" name="question"></v-text-field>
                            <v-textarea label="Answer" rows="2" auto-grow v-model="faq.ans" v-validate="'required|min:5|max:600'" :error-messages="errors.collect('answer')" name="answer"></v-textarea>
                            <v-textarea label="Other Details (extra)" rows="1" auto-grow v-model="faq.extra" v-validate="'max:600'" :error-messages="errors.collect('extra')" name="extra"></v-textarea>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-8" v-if="authUser.id === faq.user_id">
                            <v-btn large dark color="primary" :loading="isUpdating" @click="updateFaq" width="50%">Update</v-btn>
                        </v-card-actions>
                    </template>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="updateFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the faq. Please enure all fields are validly filled while trying again.
            <v-btn text color="white--text" @click="updateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            faq: null,
            isLoading: false,
            isUpdating: false,
            updateFailed: false,
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
        faqAdded(){
            return this.$store.getters.faqAdded
        }
    },
    methods: {
        getFaq(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_faq/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.faq = res.data
            })
        },
        updateFaq(){
            this.$validator.validateAll().then((isValid) => {
                if (isValid) {
                    this.isUpdating = true
                    axios.post(this.api + `/auth/update_faq/${this.$route.params.id}`, {
                        faq: this.faq
                    }, this.authHeaders).then((res) => {
                        this.isUpdating = false
                        this.$router.push({name: 'StaffFaqDetail', params: {id: res.data.id}})
                        this.$store.commit('faqUpdated')
                    }).catch(() => {
                        this.isUpdating = false
                        this.updateFailed = true
                    })
                }
            })
        }
    },
    mounted() {
        this.getFaq()
    },
}
</script>

<style lang="scss" scoped>
    .table tr{
        cursor: pointer;
    }
    .table tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
    table tbody tr th{
        white-space: nowrap !important;
    }

    .v-card__actions button{
        margin: 0 20px !important;
    }

</style>

