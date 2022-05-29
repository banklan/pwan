<template>
    <v-container>
        <v-row justify="center" >
            <!-- <v-col cols="10" md="6">
                <v-text-field placeholder="Search for Subscriptions" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="filter"></v-text-field>
            </v-col> -->
            <!-- <v-col cols="2" md="1" v-if="filterView">
                <v-btn small text color="red" @click="clear" class="mt-1"><v-icon color="red">clear</v-icon></v-btn>
            </v-col> -->
        </v-row>
        <v-row class="mt-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Subscriptions List <span v-if="total > 0"><v-chip color="primary lighten-2 ml-2">{{ total }}</v-chip></span></v-card-title>
                    <v-card-text class="mt-3">
                        <table class="table table-hover table-striped" v-if="total > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="sub_list">
                                <tr v-for="(sub, i) in subscriptions" :key="sub.id">
                                    <td @click="showSub(sub.id)">{{ sub.id }}</td>
                                    <td @click="showSub(sub.id)">{{ sub.created }}</td>
                                    <td @click="showSub(sub.id)">{{ sub.surname }}</td>
                                    <td @click="showSub(sub.id)">{{ sub.other_names }}</td>
                                    <td><v-btn small icon color="primary" class="mr-3"><i class="uil uil-eye" @click="showSub(sub.id)"></i></v-btn><v-btn small color="red darken-2" icon @click="confirmDel(sub, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert type="info" class="mt-5" v-else>
                            There are no subscriptions to view yet.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5 pb-8" v-if="subscriptions.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getSubs(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this subscription?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 text-dark">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 mt-3 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteSub">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="delFailed" :timeout="6000" top dark color="red darken-2">
            There was a problem while trying to delete the subscription. Please try again.
            <v-btn text color="white--text" @click="delFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="deleteSuccess" :timeout="4000" top dark color="green darken-2">
            Subscription deleted successfully.
            <v-btn text color="white--text" @click="deleteSuccess = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            subscriptions: [],
            pagination: null,
            total: null,
            subToDelIndex: null,
            subToDel: null,
            confirmDelDial: false,
            isDeleting: false,
            deleteSuccess: false,
            delFailed: false
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
    },
    methods: {
        getSubs(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_paginated_subscriptions`
            axios.get(pag, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.subscriptions = res.data.data
                this.total = res.data.total
                this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
            }).catch(() => {
                this.isLoading = false
            })
        },
        showSub(sub){
            this.$router.push({name: 'AdminSubscriptionDetail', params:{id: sub}})
        },
        confirmDel(sub, i){
            this.subToDel = sub
            this.subToDelIndex = i
            this.confirmDelDial = true
        },
        deleteSub(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_subscription/${this.subToDel.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.confirmDelDial = false
                this.deleteSuccess = true
                this.subscriptions.splice(this.subToDelIndex, 1)
                this.total--;
                this.subscriptions.length--;
                console.log(res.data)
            }).catch(() => {
                this.isDeleting = false
                this.delFailed = true
            })
        }
    },
    mounted() {
        this.getSubs()
    },
}
</script>

<style lang="css" scoped>
.v-btn{
    text-decoration: none;
}
    table .sub_list tr td{
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
    .table .sub_list tr td{
        vertical-align: middle !important;
    }
</style>

