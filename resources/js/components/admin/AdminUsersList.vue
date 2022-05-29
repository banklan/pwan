<template>
<v-container>
    <v-row justify="center" >
            <v-col cols="10" md="6">
                <v-text-field placeholder="Search for Staff" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="filter"></v-text-field>
            </v-col>
            <v-col cols="2" md="1" v-if="filterView">
                <v-btn small text color="red" @click="clear" class="mt-1"><v-icon color="red">clear</v-icon></v-btn>
            </v-col>
        </v-row>
        <v-row v-if="filterView" justify="center" class="mt-n5" >
            <v-col cols="12">
                <div class="text-center subtitle-1">Search for staff <strong>{{ q }}</strong> returns {{ filtered.length | pluralize('user') }}</div>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                        <v-card-title class="primary white--text subtitle-1 justify-center">Staff Users List <span v-if="users.length > 0 && !filterView"><v-chip color="primary lighten-2 ml-2">{{ users.length }}</v-chip></span></v-card-title>
                        <v-card-text>
                        <table class="table table-hover table-striped" v-if="users.length > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="users_list">
                                <template v-if="!filterView">
                                    <tr v-for="(user, i) in users" :key="user.id" :class="!user.authorized_by ? 'warning--text' : ''">
                                        <template v-if="user.is_verified">
                                            <td @click="showUser(user)">{{ user.user_id }}</td>
                                            <td @click="showUser(user)">{{ user.fullname }}</td>
                                            <td @click="showUser(user)">{{ user.email }}</td>
                                            <td>{{ user.status ? 'Active' : 'Inactive'}} </td>
                                            <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateUser', params:{id: user.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(user.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                        </template>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="(user, i) in filtered" :key="user.id" :class="!user.authorized_by ? 'warning--text' : ''">
                                        <template v-if="user.is_verified">
                                            <td @click="showUser(user)">{{ user.id }}</td>
                                            <td @click="showUser(user)">{{ user.fullname }}</td>
                                            <td @click="showUser(user)">{{ user.email }} </td>
                                            <td>{{ user.status ? 'Active' : 'Inactive'}} </td>
                                            <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateUser', params:{id: user.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(user.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no registered users(staff) at the moment.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDialog" max-width="450">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this user profile?</v-card-title>
                <v-card-text class="mt-5 subtitle-1">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteUser">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="adminUpdatedUser" :timeout="4000" top dark color="green darken-2">
            A user profile has been updated successfully.
            <v-btn text color="white--text" @click="adminUpdatedUser = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminDeletedUser" :timeout="4000" top dark color="green darken-2">
            A user profile has been deleted successfully.
            <v-btn text color="white--text" @click="adminDeletedUser = false">Close</v-btn>
        </v-snackbar>
</v-container>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            isLoading:false,
            filterView: false,
            q: '',
            filtered: [],
            isToggling: false,
            confirmDelDialog: false,
            isDeleting: false,
            userToDel: null,
            userIndex: null
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
        adminDeletedUser(){
            return this.$store.getters.adminDeletedUser
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods: {
        getUsers(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/all_users`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.users = res.data
            }).catch(() => {
                this.isLoading = false
            })
        },
        showUser(user){
            this.$router.push({name: 'AdminUserDetail', params:{id: user.id, user_id: user.user_id}})
        },
        toggleUserStatus(user){
            this.isToggling = true
            axios.post(this.api + `/auth-admin/change_user_status/${user.id}`, {}, this.adminHeaders)
            .then((res)=>{
                this.isToggling = false
                this.$store.commit('adminUpdatedUser')
                user.status = res.data
            })
        },
        filter(){
            this.filterView = true
            let query = this.q.toLowerCase()
            let rez = this.users.filter((el) => el.first_name.toLowerCase().includes(query) || el.last_name.toLowerCase().includes(query) || el.email.toLowerCase().includes(query) || el.user_id.toLowerCase().includes(query))
            this.filtered = rez
        },
        clear(){
            this.filterView = false
            this.q = ''
            this.getUsers()
        },
        confirmDel(user, i){
            this.confirmDelDialog = true
            this.userToDel = user
            this.userIndex = i
        },
        deleteUser(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_user/${this.userToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.confirmDelDialog = false
                this.$store.commit('adminDeletedUser')
                this.users.splice(this.userIndex, 1)
            })
        }
    },
    mounted() {
        this.getUsers()
    },
}
</script>

<style lang="css" scoped>
.v-btn{
    text-decoration: none;
}
    table .users_list tr td{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    .table .users_list tr td{
        vertical-align: middle !important;
    }
</style>
