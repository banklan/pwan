<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="9">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card light raised outlined elevation="4" min-height="400" class="mx-auto">
                    <v-card-title class="justify-center subtile-1 primary white--text">Update Admin Details</v-card-title>
                    <v-card-text class="mt-5">
                        <v-text-field label="First Name" v-model="user.first_name" required v-validate="'required'" :error-messages="errors.collect('first_name')" name="first_name"></v-text-field>
                        <v-text-field label="Last Name" v-model="user.last_name" required v-validate="'required'" :error-messages="errors.collect('last_name')" name="last_name"></v-text-field>
                        <v-text-field label="Phone Number" v-model="user.phone" v-validate="'required'" :error-messages="errors.collect('phone')" name="phone"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-4">
                        <v-btn width="40%" text large color="red darken-2" @click.prevent="$router.go(-1)">Cancel</v-btn>
                        <v-btn width="40%" dark large color="primary" @click="updateUser" :loading="isUpdating">Update</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="updateFailed" :timeout="4000" top dark color="red darken-1">
            Update of the admin failed. Please ensure all fields are validly filled.
            <v-btn text color="white--text" @click="updateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>


<script>
export default {
    data() {
        return {
            user: {
                first_name: '',
                last_name: '',
                phone: '',
            },
            isLoading: false,
            isUpdating: false,
            id: this.$route.params.id,
            updateFailed: false
        }
    },
    computed: {
        authAdmin(){
            return this.$store.getters.authAdmin
        },
        api(){
            return this.$store.getters.api
        },
        headers(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authAdmin.token}`
                }
            }
            return headers
        }
    },
    methods: {
        getUser(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_super_user/${this.id}`, this.headers).then((res) => {
                this.isLoading = false
                this.user = res.data
            })
        },
        updateUser(){
            this.isUpdating = true
            axios.post(this.api + `/auth-admin/super_user/${this.id}/update`, {
                user: this.user
            }, this.headers).then((res) => {
                this.isUpdating = false
                this.$store.commit('adminUpdatedSuperUser')
                this.$router.push({name: 'AdminDetail', params: {id: res.data.id}})
            }).catch(() => {
                this.isUpdating = false
                this.updateFailed = true
            })
        }
    },
    created() {
        this.getUser()
    },
}
</script>
