<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="1">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="start" class="mt-3">
            <v-progress-circular v-if="isLoading" indeterminate color="primary" :width="4" :size="40" justify="center" class="mx-auto"></v-progress-circular>
            <template v-else>
                <v-col cols="12" md="10">
                    <v-card light raised elevation="12" min-height="300" class="scroll mx-auto">
                        <v-card-title class="justify-center subtitle-1 primary white--text">Enquiry Detail</v-card-title>
                        <v-card-text class="mt-5 ml-3">
                            <template v-if="enquiry">
                                <table class="table table-striped">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th width="20%" style="border-top: none">Sent:</th>
                                            <td style="border-top: none">{{ enquiry.sent }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ enquiry.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fullname:</th>
                                            <td>{{ enquiry.fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Organization:</th>
                                            <td>{{ enquiry.organization }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position:</th>
                                            <td>{{ enquiry.position }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone No:</th>
                                            <td>{{ enquiry.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subject</th>
                                            <td>{{ enquiry.subject }}</td>
                                        </tr>
                                        <tr>
                                            <th>Message</th>
                                            <td>{{ enquiry.message }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <v-alert type="warning" border="left" class="mt-5">
                                    The enquiry you are trying to view does not exist.
                                </v-alert>
                            </template>
                        </v-card-text>
                        <v-card-actions class="justify-center action_btn">
                            <v-btn icon color="red darken-2" @click="confirmDelDial = true">
                                <i class="uil uil-trash-alt"></i>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </template>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="150">
                <v-card-title class="subtitle-1 primary darken-2 white--text justify-center">Are you sure you want to delete this enquiry?</v-card-title>
                <v-card-text class="justify-center mt-5 subtitle-1 black--text lighten-2">
                    If you proceed, the enquiry cannot be recovered.
                </v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text color="red darken-2" @click="confirmDelDial = false" width="40%">Cancel</v-btn>
                    <v-btn dark color="primary" :loading="isDeleting" width="40%" @click="delEnquiry">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            enquiry: null,
            isLoading: false,
            confirmDelDial: false,
            isDeleting: false
        }
    },
    computed: {
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
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods: {
        getEnquiry(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_enquiry/${this.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.enquiry = res.data
                this.enquiryHasBeenread()
            }).catch(() =>{
                this.isLoading = false
            })
        },
        delEnquiry(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/admin_del_enquiry/${this.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.$router.push({name: 'AdminEnquiries'})
                this.$store.commit('adminDeleteEnquiry')
            })
        },
        enquiryHasBeenread(){
            axios.post(this.api + `/auth-admin/enquiry_was_read/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {})
        }
    },
    created(){
        this.getEnquiry()
    }
}
</script>

<style lang="scss" scoped>
    .v-btn, a{
        text-decoration: none !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    table tbody tr th{
        white-space: nowrap !important;
    }
     table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
    .action_btn {
        padding: 1.5rem .6rem;

        .v-btn i{
            font-size: 1.1rem !important;
        }
    }
</style>
