<template>
<v-container>
    <v-row justify="center" >
            <v-col cols="10" md="5">
                <v-text-field placeholder="Search for Super User" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="filter" @abort="clear"></v-text-field>
            </v-col>
            <v-col cols="2" md="1" v-if="filterView">
                <v-btn small text color="red" @click="clear" class="mt-1"><v-icon color="red">clear</v-icon></v-btn>
            </v-col>
            <v-col cols="12" md="4" offset-md="2" >
                <v-btn dark color="primary" :to="{name: 'AdminCreateSuperUser'}"><v-icon left>add</v-icon>New Admin</v-btn>
            </v-col>
        </v-row>
        <v-row v-if="filterView" justify="center" class="mt-n5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n10':''">
            <v-col cols="12">
                <div class="text-center subtitle-1">Search for admin <strong>{{ q }}</strong> returns {{ filtered.length | pluralize('user') }}</div>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" :class="$vuetify.breakpoint.smAndDown ? 'ml-n8':''">
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                        <v-card-title class="primary white--text subtitle-1 justify-center">Super Users List</v-card-title>
                        <v-card-text>
                        <table class="table table-hover table-striped" v-if="admins.length > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="admin_list">
                                <template v-if="!filterView">
                                    <tr v-for="(user) in admins" :key="user.id" :class="!user.is_verified ? 'warning--text' : ''">
                                        <td @click="showUser(user)">{{ user.id }}</td>
                                        <td @click="showUser(user)">{{ user.fullname }}</td>
                                        <td @click="showUser(user)">{{ user.email }}</td>
                                        <td>{{ user.status ? 'Enabled' : 'Disabled'}} &nbsp; <v-btn v-if="user.id !== authAdmin.id && user.authorized_by" dark small :class="user.status == 1 ? 'primary' : 'green darken-2'" @click.prevent="toggleUserStatus(user)">{{ user.status ? 'Disable' : 'Enable'}}</v-btn> </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="(user) in filtered" :key="user.id">
                                        <td @click="showUser(user)">{{ user.id }}</td>
                                        <td @click="showUser(user)">{{ user.fullname }}</td>
                                        <td @click="showUser(user)">{{ user.email }} </td>
                                        <td>{{ user.status ? 'Enabled' : 'Disabled'}} &nbsp; <v-btn v-if="user.id !== authAdmin.id" dark small :class="user.status == 1 ? 'primary' :'green darken-2'" @click.prevent="toggleUserStatus(user)">{{ user.status ? 'Disable' : 'Enable'}}</v-btn> </td>
                                        <!-- <td><v-btn v-if="user.id !== authAdmin.id" small icon color="red darken-2" @click="confirmDel(user, i)"><i class="uil uil-trash-alt"></i></v-btn></td> -->
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no super users(admin) at the moment.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar :value="adminUpdatedSuperUser" :timeout="4000" top dark color="green darken-2">
            Admin update successful.
            <v-btn text color="white--text" @click="adminUpdatedSuperUser = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminCreated" :timeout="6000" top dark color="green darken-2">
            A new admin has been created successfully. An Email to verify his/her email has been sent to him.
            <v-btn text color="white--text" @click="adminCreated = false">Close</v-btn>
        </v-snackbar>
</v-container>
</template>

<script>
export default {
    data() {
        return {
            admins: [],
            isLoading:false,
            filterView: false,
            q: '',
            filtered: [],
            isToggling: false,
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
        adminUpdatedSuperUser(){
            return this.$store.getters.adminUpdatedSuperUser
        },
        adminUserDeleted(){
            return this.$store.getters.adminUserDeleted
        },
        adminCreated(){
            return this.$store.getters.newAdminCreated
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods: {
        getAdmins(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/all_admins`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.admins = res.data
            }).catch(() => {
                this.isLoading = false
            })
        },
        showUser(user){
            this.$router.push({name: 'AdminDetail', params:{id: user.id}})
        },
        toggleUserStatus(user){
            this.isToggling = true
            axios.post(this.api + `/auth-admin/change_superuser_status/${user.id}`, {}, this.adminHeaders)
            .then((res)=>{
                this.isToggling = false
                this.$store.commit('adminUpdatedSuperUser')
                user.status = res.data
            })
        },
        filter(){
            this.filterView = true
            let query = this.q.toLowerCase()
            let rez = this.admins.filter((el) => el.first_name.toLowerCase().includes(query) || el.last_name.toLowerCase().includes(query) || el.email.toLowerCase().includes(query))
            this.filtered = rez
        },
        clear(){
            this.filterView = false
            this.q = ''
            this.getAdmins()
        }
    },
    mounted() {
        this.getAdmins()
    },
}
</script>

<style lang="css" scoped>
.v-btn{
    text-decoration: none;
}
    table .admin_list tr td{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    .v-btn i{
        font-size: 1rem !important;
    }
    .table .users_list tr td{
        vertical-align: middle !important;
    }
</style>
