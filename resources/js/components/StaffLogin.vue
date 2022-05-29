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
                            <v-btn large width="80%" color="primary" @click="login">Login</v-btn>
                        </v-card-actions>
                        <v-card-actions class="justify-center flex-column mt-2">
                            <p class="mr-2"><router-link to="/staff-register">Register as a user (staff) </router-link></p>
                            <p class="ml-2 secondary--text"><router-link to="/admin-login" class="secondary--text">Login as an Admin </router-link></p>
                        </v-card-actions>
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
            }
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        login(){
            console.log(this.cred)
        }
    },
}
</script>

<style lang="scss" scoped>
a{
    text-decoration: none !important;
}

</style>
