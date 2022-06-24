<template>
    <v-container>
        <v-row class="pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-alert type="info">
                    Please note that this is a log of the successful password resets made by staff's accounts. This log serves only for record purposes, to help the admin keep tracks of staff accounts whose passwords were reset,
                    so actions can be taken if resets were done illegaly.
                </v-alert>
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Password Resets Log </v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="resets.length > 0">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Req Date</th>
                                    <th>Reset Date</th>
                                    <th>IP Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="resets_list">
                                <tr v-for="(res, i) in resets" :key="res.id">
                                    <td class="text-truncate">{{ res.user && res.user.fullname }}</td>
                                    <td>{{ res.request_date | moment('DD/MM/YYYY - HH:mma') }}</td>
                                    <td>{{ res.reset_date | moment('DD/MM/YYYY - HH:mma') }}</td>
                                    <td>{{ res.request_ip }} </td>
                                    <td> <v-btn icon color="red darken-2" @click="confirmDel(res.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no reset requests to display at the moment.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="delConfDial" max-width="450">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this password request log?</v-card-title>
                <v-card-text class="mt-4 grey_text--text">
                    Once deleted, this can't be recovered!
                </v-card-text>
                <v-card-actions class="pb-8 mt-3 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="delConfDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteReq">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="reqDeleted" :timeout="4000" top dark color="green darken-1">
            A password reset request was deleted.
            <v-btn text color="white--text" @click="reqDeleted = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data(){
        return{
            resets: [],
            isLoading: false,
            resToDelInd: null,
            resToDel: null,
            delConfDial: false,
            isDeleting: false,
            reqDeleted: false
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
    },
    methods: {
        getReqs(){
            this.isLoading = true
            axios.get(this.api + '/auth-admin/get_pswd_req_resets', this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.resets = res.data
            })
        },
        confirmDel(res, i){
            this.resToDel = res
            this.resToDelInd = i
            this.delConfDial = true
        },
        deleteReq(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/del_pswd_req/${this.resToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.delConfDial = false
                this.reqDeleted = true
                this.resets.splice(this.resToDelInd, 1)
            })
        }
    },
    created() {
        this.getReqs()
    }
}
</script>

<style lang="css" scoped>
    .table .resets_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .news_list tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>


