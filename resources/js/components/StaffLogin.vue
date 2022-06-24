<template>
    <v-container>
        <v-row justify="center" class="mt-8">
            <v-col cols="12" md="5">
                <v-card elevation="12" raised min-height="250">
                    <v-card-title class="justify-center title primary white--text">Staff Login</v-card-title>
                    <v-card-text class="mt-5 text-center">
                        <v-text-field label="Email" v-model="cred.email"></v-text-field>
                        <v-text-field label="Password" type="password" v-model="cred.password"></v-text-field>
                        <v-card-actions class="justify-center pb-5 mt-4">
                            <v-btn large width="80%" color="primary" @click="login" :loading="isLoading">Login</v-btn>
                        </v-card-actions>
                        <div class="user_class">
                            <p class="mr-2"><router-link to="/staff-register">Register as a user (staff) </router-link></p>
                            <span class="primary--text">|</span>
                            <p class="ml-2"><router-link to="/admin-login" class="secondary--text">Login as an Admin </router-link></p>
                        </div>
                        <div class="text-center pb-5"><router-link to="/forgot-password"> Forgot Password?</router-link></div>
                        <div v-if="authError" class="pb-5">
                            <div class="error white--text pa-4 mx-3">
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
            isLoading: false,
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
        },
        redirectOnLogin(){
            return this.$store.getters.redirectOnLogin
        },
        authUser(){
            return this.$store.getters.authUser
        },
    },
    methods: {
        login(){
            this.$validator.validateAll().then((isValid) => {
                if (isValid) {
                    this.isLoading = true
                    axios.post(this.api + '/login', {
                        email: this.cred.email,
                        password: this.cred.password,
                    }).then((res) => {
                        this.isLoading = false
                        this.authError = false
                        this.$store.commit('userLoginSuccess', res.data)

                        // check if there is redirect on login
                        if(this.redirectOnLogin){
                            this.$router.push(this.redirectOnLogin)
                            localStorage.removeItem('redirOnLogin')
                        }else{
                            this.$router.push({name: 'StaffDashboard'})
                        }
                    }).catch((err) => {
                        this.isLoading = false
                        this.authError = true
                        if(err.response.status === 441){
                            this.errorMsg = 'Error! Invalid credentials.'
                        }else if(err.response.status === 551){
                            this.errorMsg = 'You cannot login into your account now. Kindly contact the admin.'
                        }else{
                            this.errorMsg = 'Error! Invalid credentials.'
                        }
                    })
                }
            })
        }
    },
}
</script>

<style lang="scss" scoped>
a{
    text-decoration: none !important;
}
.user_class{
    display: flex;
    justify-content: center;
    gap: 1rem;
    // grid-template-columns: 1fr 1fr;
}

</style>
