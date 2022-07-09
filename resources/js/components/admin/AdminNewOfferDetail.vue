<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminNewOffersList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="6">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else elevation="4" raised min-height="200" class="mx-auto">
                    <template v-if="offer">
                        <!-- <v-img :src="`/images/offers/${offer.flier}`" :alt="offer.title"></v-img> -->
                        <v-img :src="offerFlier" :alt="offer.title"></v-img>
                        <v-card-text>
                            <div class="tit">
                                <table class="table">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <td>{{ offer.title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created On</th>
                                            <td>{{ offer.created_at | moment('Do MMM, YYYY') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            <td>{{ offer.user && offer.user.fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approved By</th>
                                            <td>{{ offer.admin && offer.admin.fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ offer.status ? 'Active' : 'Not-Active' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval Status</th>
                                            <td>{{ offer.is_approved ? 'Approved' : 'Not-Approved' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Feature Status</th>
                                            <td>{{ offer.is_featured ? 'Featured' : 'Not-Featured' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-6">
                            <v-btn color="secondary" class="mx-4" @click="changeFeatureStatus" :loading="isUpdating">{{ offer.is_featured ? 'Un-Feature' : 'Feature' }}</v-btn>
                            <v-btn color="primary" class="mx-4" @click="confirmApprovalDial = true">{{ offer.is_approved ? 'Dis-Approve' : 'Approve' }}</v-btn>
                            <v-btn icon color="red darken-1" class="mx-4" @click="confirmDelDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                        </v-card-actions>
                    </template>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this offer?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the offer cannot be recovered.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delNewOffer">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmApprovalDial" max-width="450" v-if="offer">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Do you want to {{ offer.is_approved ? 'Dis-Approve' : 'Approve' }} this offer?</v-card-title>
                <v-card-actions class="pb-8 justify-center mt-5">
                    <v-btn text width="40%" color="red darken--2" @click="confirmApprovalDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeApprovalStatus">Yes, {{ offer.is_approved ? 'Dis-Approve' : 'Approve' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="approvalChanged" :timeout="4000" top dark color="green darken-2">
            The new offer approval status was updated successfully.
            <v-btn text color="white--text" @click="approvalChanged">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="featureChanged" :timeout="4000" top dark color="green darken-2">
            The new offer feature status was updated successfully.
            <v-btn text color="white--text" @click="featureChanged">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            offer: null,
            isLoading: false,
            confirmDelDial: false,
            isBusy: false,
            isUpdating: false,
            confirmApprovalDial: false,
            approvalChanged: false,
            featureChanged: false,
            offerFlier: ''
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
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
    methods: {
        getOffer(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_new_offer/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.offer = res.data
                this.getFlierFromS3()
            })
        },
        getFlierFromS3(){
            axios.get(this.api + `/auth-admin/get_new_offer_flier/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.offerFlier = res.data
            })
        },
        delNewOffer(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/delete_offer/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.$router.push({name:'AdminNewOffersList'})
                this.$store.commit('adminDeletedNewOffer')
            })
        },
        changeApprovalStatus(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_new_offer_apprv_status/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.offer.is_approved = res.data
                this.approvalChanged = true
                this.confirmApprovalDial = false
            })
        },
        changeFeatureStatus(){
            this.isUpdating = true
            axios.post(this.api + `/auth-admin/change_new_offer_feat_status/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isUpdating = false
                this.offer.is_featured = res.data
                this.featureChanged = true
            })
        }
    },
    mounted() {
        this.getOffer()
    },
}
</script>


<style lang="scss" scoped>
.v-card{
    .v-image{
        height: 80%;
        width: 100%;
    }
    .table tr td{
        vertical-align: middle !important;
    }
    .v-card__actions{
        .v-btn{
            i{
                font-size: 1rem !important;
            }
        }
    }
}
</style>
