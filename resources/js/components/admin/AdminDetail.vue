<template>
    <v-container>
        <v-row justify="center" class="justify-center mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="start" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n8': ''">
            <v-col cols="12" md="6">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <!-- <v-img v-if="user.picture" :src="`/images/profiles/${user.picture}`" height="100%" transition="scale-transition"></v-img> -->
                    <v-img v-if="user.picture" :src="`https://pwanplatinum.s3.amazonaws.com/profiles/${user.picture}`" height="100%" transition="scale-transition"></v-img>
                    <v-img v-else src="/images/assets/user7.jpg" aspect-ratio="1" height="300" transition="scale-transition"></v-img>
                    <v-card-text>
                        <div class="subtitle-2 my-3 text-center">Admin Profile</div>
                        <v-simple-table light>
                            <template v-slot:default>
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="30%">First Name:</th>
                                        <td>{{ user.first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name:</th>
                                        <td>{{ user.last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ user.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role:</th>
                                        <td>{{ user.role }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>{{ user.status ? 'Active' : 'Inactive' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone No:</th>
                                        <td>{{ user.phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ creator && user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Authorized By</th>
                                        <td>{{ authorizer && authorizer.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ user.created }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated:</th>
                                        <td>{{ user.updated_at | moment('DD/MM/YYYY - H:mma') }}</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="justify-space-around pb-5">
                        <v-btn v-if="user.authorized_by" dark icon color="primary" :to="{name: 'AdminUpdateSuperUser', params: {id: user.id}}"><i class="uil uil-edit"></i></v-btn>
                        <!-- check if user is authorized/check if auth admin created ---if not, display authorize button -->
                        <span v-if="user.is_verified"><v-btn v-if="!user.authorized_by && authAdmin.id !== user.created_by" color="admin_b" dark small @click="confirmAuthDial = true">Authorize</v-btn></span>
                        <v-btn v-if="user.authorized_by" dark small text color="admin_a" @click="statusDialog = true">{{ user.status == 1 ? 'Disable' : 'Enable' }}</v-btn>
                        <v-alert v-if="!user.is_verified" type="warning" border="left">
                            This user has to verify his/her email address before they can be authorized, by an admin <span class="font-weight-bold">different from the one who created them</span>.
                        </v-alert>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" md="5">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="150">
                    <v-card-title class="primary white--text justify-center">Reset Password</v-card-title>
                    <v-card-text class="mt-4">
                        <v-alert v-if="!user.is_verified" type="warning">
                            This user has to verify his/her email address before they can be authorized, by an admin <span class="font-weight-bold">different from the one who created them</span>.
                        </v-alert>
                        <template v-else>
                            <v-btn text dark color="admin_c" @click="resetPassword = !resetPassword">Reset Password</v-btn>
                            <template v-if="resetPassword">
                                <v-text-field label="New Password" type="password" v-model="password.password" required ref="new_pswd" v-validate="'required|min:5|max:20'" :error-messages="errors.collect('password')"  name="password" data-vv-as="new password"></v-text-field>
                                <v-text-field label="Confirm Password" type="password" v-model="password.password_confirmation" v-validate="'required|confirmed:new_pswd'" :error-messages="errors.collect('confirm')"  name="confirm" data-vv-as="confirm password"></v-text-field>
                            </template>
                        </template>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8" v-if="resetPassword">
                        <v-btn width="40%" text dark color="red darken-2" @click="resetPassword = false">Cancel</v-btn>
                        <v-btn width="40%" dark class="primary" :loading="isUpdating" @click="update">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="statusDialog" max-width="450">
            <v-card min-height="150">
                <v-card-title class="subtitle-1 white--text primary justify-center">{{ user && user.status == 0 ? 'Enable' : 'Disable'}} this super-user?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="statusDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isToggling" @click="toggleUserStatus">Yes, {{ user && user.status == 0 ? 'enable' : 'disable' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmAuthDial" max-width="450">
            <v-card min-height="150">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to authorize the creation of this admin?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmAuthDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isConfirmingAuth" @click="authorizeAdmin">Yes, Authorize</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="adminUpdatedSuperUser" :timeout="4000" top dark color="green darken-1">
            Super-user successfully updated.
            <v-btn text color="white--text" @click="adminUpdatedSuperUser = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="statusChanged" :timeout="4000" top color="green darken-1 white--text">
            User was {{ user && user.status == 0 ? 'disabled' : 'enabled' }} successfully.
            <v-btn text color="white--text" @click="statusChanged = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="passwordResetSuccessfull" :timeout="4000" top color="green darken-1 white--text">
            Password was reset successfully.
            <v-btn text color="white--text" @click="passwordResetSuccessfull = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="passwordResetFailed" :timeout="6000" top color="red darken-1 white--text">
            Password reset failed. Please ensure that the new password is between 5 & 20 characters.
            <v-btn text color="white--text" @click="passwordResetFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="adminWasAuthorized" :timeout="4000" top color="green darken-1 white--text">
            The admin account has been authorized. He/She can now login.
            <v-btn text color="white--text" @click="adminWasAuthorized = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>


<script>
export default {
    data() {
        return {
            user: null,
            isLoading: false,
            id: this.$route.params.id,
            confirmDelDialog: false,
            statusDialog: false,
            statusChanged: false,
            resetPassword: false,
            password: {
                password: '',
                password_confirmation: ''
            },
            isUpdating: false,
            passwordResetSuccessfull: false,
            passwordResetFailed: false,
            isToggling: false,
            creator: null,
            authorizer: null,
            adminWasAuthorized: false,
            confirmAuthDial: false,
            isConfirmingAuth: false,
        }
    },
    computed: {
        authAdmin(){
            return this.$store.getters.authAdmin
        },
        api(){
            return this.$store.getters.api
        },
        adminUpdatedSuperUser(){
            return this.$store.getters.adminUpdatedSuperUser
        },
        adminHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authAdmin.token}`
                }
            }
            return headers
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods: {
        getUser(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_super_user/${this.id}`, this.adminHeaders).then((res) => {
                this.isLoading = false
                this.user = res.data
                console.log(res.data)
                this.getCreator(res.data.created_by);
                this.getAuthorizer(res.data.authorized_by)
            })
        },
        getCreator(id){
            axios.get(this.api + `/auth-admin/get_admin_creator/${id}`, this.adminHeaders)
            .then((res) => {
                this.creator = res.data
                console.log(res.data)
            })
        },
        getAuthorizer(id){
            axios.get(this.api + `/auth-admin/get_admin_authorizer/${id}`, this.adminHeaders)
            .then((res) => {
                this.authorizer = res.data
            })
        },
        toggleUserStatus(){
            this.isToggling = true
            axios.post(this.api + `/auth-admin/change_superuser_status/${this.user.id}`, {}, this.adminHeaders)
            .then((res)=>{
                this.isToggling = false
                this.$store.commit('adminUpdatedSuperUser')
                this.user.status = res.data
                this.statusDialog = false
            })
        },
        update(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isUpdating = true
                    axios.post(this.api + `/auth-admin/change_superuser_password/${this.id}`, {
                        password: this.password
                    }, this.adminHeaders).then((res) => {
                        this.isUpdating = false
                        this.passwordResetSuccessfull = true
                        this.resetPassword = false
                        this.password.password = ''
                        this.password.password_confirmation = ''
                        this.$validator.pause()
                        this.$validator.fields.items.forEach(field => field.reset())
                        this.$validator.errors.clear()
                    }).catch(()=>{
                        this.isUpdating = false
                        this.passwordResetFailed = true
                    })
                }
            })
        },
        authorizeAdmin(){
            this.isConfirmingAuth = true
            // console.log(this.$route.params.id)
            axios.post(this.api + `/auth-admin/authorize_admin/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                console.log(res.data)
                this.isConfirmingAuth = false
                this.confirmAuthDial = false
                this.user = res.data
                this.adminWasAuthorized = true
            })
        }
    },
    created() {
        this.getUser()
    },
}
</script>

<style lang="css" scoped>
    a, .v-btn{
        text-decoration: none !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    table tbody tr th,table tbody tr td {
        white-space: nowrap !important;
    }

</style>
