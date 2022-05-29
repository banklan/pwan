<template>
    <v-container>
        <v-row justify="center" align="center" class="mt-7">
            <v-col cols="12" md="4">
                <v-card elevation="12" raised min-height="250">
                    <v-card-title class="justify-center primary title white--text">Admin Login</v-card-title>
                    <v-card-text class="mt-5 text-center">
                        <v-text-field label="Email" v-model="cred.email" required v-validate="'required|email'" :error-messages="errors.collect('email')" name="email"></v-text-field>
                        <v-text-field label="Password" type="password" v-model="cred.password" required v-validate="'required|min:3'" :error-messages="errors.collect('password')" name="password"></v-text-field>
                        <v-card-actions class="justify-center pb-6 mt-4">
                            <v-btn large block color="primary" @click="login" :loading="isBusy">Login</v-btn>
                        </v-card-actions>
                        <v-card-actions class="justify-center pb-3 mx-1 mt-n2">
                            Not an Admin? <router-link to="/login">&nbsp; Login as a staff </router-link>
                        </v-card-actions>
                        <div v-if="authError" class="pb-5">
                            <div class="error white--text pa-3 mx-3">
                                {{ errorMsg }}
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isBusy: false,
            cred: {
                email: '',
                password: ''
            },
            authError: false,
            errorMsg: ''
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        login(){
            this.$validator.validateAll().then((isValid) => {
                if (isValid) {
                    this.isBusy = true
                    axios.post(this.api + '/auth-admin/login', this.cred)
                        .then((res) => {
                            this.isLoading = false
                            this.$store.commit('adminLoginSuccess', res.data)
                            this.$router.push({name: 'AdminDashboard'})
                        }).catch((err) => {
                            this.isBusy = false
                            this.authError = true
                            if(err.response.status === 441){
                                this.errorMsg = 'Error! Invalid login credentials.'
                            }else if(err.response.status === 501){
                                this.errorMsg = 'You cannot login into your account now. Kindly contact the admin.'
                            }else{
                                this.errorMsg = 'Error! Invalid login credentials.'
                            }
                        })
                }
            })
        }
    },
}
</script>

