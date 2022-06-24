<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="6">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <template v-if="resetPasswordForm">
                        <v-card elevation="6" light raised min-height="250" class="my-10">
                            <v-card-title class="justify-center primary white--text">Reset Password</v-card-title>
                            <v-card-text class="text-center mt-5">
                                <v-text-field label="New Password" type="password" v-model="pswd.password" ref="new_pswd" required v-validate="'required|min:5|max:20'" :error-messages="errors.collect('password')" name="password"></v-text-field>
                                <v-text-field label="Confirm Password" type="password" v-model="pswd.password_confirmation" required v-validate="'required|confirmed:new_pswd'" :error-messages="errors.collect('password_confirmation')" name="password_confirmation" data-vv-as="password confirmation"></v-text-field>
                            </v-card-text>
                            <v-card-actions class="pb-8 justify-center">
                                <v-btn dark class="justify-center primary" large width="60%" @click="resetPswd" :loading="isSaving">Reset Password</v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                    <template v-else>
                        <template v-if="resetRequestFailed">
                            <v-alert type="error" border="left" class="my-8">{{ resetError }}</v-alert>
                        </template>
                    </template>
                </template>
            </v-col>
        </v-row>
        <v-snackbar v-model="resetFailed" :timeout="4000" top dark color="red darken-2">
            There was an error while trying to reset your password. Please try again.
            <v-btn text color="white--text" @click="resetFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: true,
            resetPasswordForm: false,
            pswd: {
                password: '',
                password_confirmation: ''
            },
            isSaving: false,
            resetRequestFailed: false,
            // resetSuccess: false,
             token: this.$route.query.token,
             resetError: '',
             resetFailed: false,
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        },
    },
    methods: {
        getToken(){
            this.isLoading = true
            axios.post(this.api + '/confirm_pswd_reset_req', {
                token: this.token
            }).then((res) =>{
                this.isLoading = false
                if(res.data.message === 'confirmed'){
                    this.resetPasswordForm = true
                }else if(res.data.message === 'expired'){
                    this.resetRequestFailed = true
                    this.resetError = 'Reset request failed. Kindly initiate a fresh reset request.'
                }else if(res.data.message === 'invalid'){
                    this.resetRequestFailed = true
                    this.resetError = 'Reset request failed. Invalid token!'
                }
                console.log(res.data)
            }).catch((err) => {
                this.isLoading = false
            })
        },
        resetPswd(){
            this.$validator.validateAll().then((isValid) => {
                if (isValid) {
                    this.isSaving = true
                    axios.post(this.api + '/reset_user_password', {
                        pswd: this.pswd,
                        token: this.token
                    }).then((res) => {
                        this.isSaving = false
                        this.$store.commit('passwordReset')
                        this.$router.push({name: 'PasswordHasBeenReset'})
                    }).catch((err) => {
                        this.isSaving = false
                        this.resetFailed = true
                    })
                }
            })
        }
    },
    mounted() {
        this.getToken()
    },
}
</script>
