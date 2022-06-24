<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminPropertyList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n3 mr-n5': ''">
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Listing ID <span v-if="prop">&nbsp;{{ prop.id}}</span></v-card-title>
                    <v-card-text class="mt-5" v-if="prop">
                        <v-simple-table light>
                            <template v-slot:default>
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%">Name:</th>
                                        <td>{{ prop.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title:</th>
                                        <td>{{ prop.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>{{ prop.location }}</td>
                                    </tr>
                                    <tr>
                                        <th>Landmark:</th>
                                        <td>{{ prop.landmark }}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail:</th>
                                        <td>{{ prop.detail }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td :class="prop.status ? 'green_text--text' : 'red--text lighten-1'">{{ prop.status ? 'Active' : 'Closed' }} <span class="float-right mr-7"><v-btn small dark text :class="prop.status ? 'secondary--text' : 'primary--text'" @click="confirmStatusDial = true">{{ prop.status ?  'Deactivate' : 'Activate' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th>Approval:</th>
                                        <td :class="prop.is_approved ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_approved ? 'Approved' : 'Not Approved' }} <span class="float-right mr-7"><v-btn small dark text :class="prop.is_approved ? 'secondary--text' : 'primary--text'" @click="confirmApprovalDial = true">{{ prop.is_approved ?  'DisApprove' : 'Approve' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th>Feature:</th>
                                        <td :class="prop.is_featured ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_featured ? 'Featured' : 'Not Featured' }} <span class="float-right mr-7"><v-btn small dark text :class="prop.is_featured ? 'secondary--text' : 'primary--text'" @click="confirmFeatureDial = true">{{ prop.is_featured ?  'Unfeature' : 'Feature' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ prop.user && prop.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Authorized By:</th>
                                        <td>{{ prop.admin && prop.admin.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Published:</th>
                                        <td>{{ prop.published }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated:</th>
                                        <td>{{ prop.updated }}</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6" v-if="prop">
                        <v-btn large icon color="primary darken-2" class="mr-5" :to="{name: 'AdminPropertyUpdate', params: {id: prop.id}}"><i class="uil uil-edit"></i></v-btn>
                        <v-btn large icon color="red darken-2" class="ml-5" @click="confirmDelListingDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
            <template v-else>
                <v-col cols="12" md="8">
                    <v-card light raised outlined elevation="3" min-height="100" class="mt-5">
                        <v-card-title class="primary white--text justify-center subtitle-1">Listing Plans <span v-if="prop && plans.length > 0">&nbsp;<v-chip color="primary lighten-2 white--text">{{ plans.length }}</v-chip></span></v-card-title>
                        <v-card-text class="mt-5">
                            <template v-if="plans.length > 0">
                                <table class="table plans">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Unit</th>
                                            <th>Price(&#8358;)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(plan, i) in plans" :key="plan.id">
                                            <td>{{ plan.created_at | moment('DD/MM/YYYY') }}</td>
                                            <td class="text-truncate">{{ plan.name }}</td>
                                            <td>{{ plan.unit }}</td>
                                            <td>{{ plan.price / 100 | price }}</td>
                                            <td><v-btn small icon color="primary darken-2" :to="{name: 'AdminPropertyPlanUpdate', params:{id: plan.id}}"><i class="uil uil-edit"></i></v-btn><v-btn small class="ml-3" icon color="red darken-2" @click="confirmPlanDel(plan.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <v-alert type="warning" border="left">
                                    There are no listing plans set for this listing.
                                </v-alert>
                            </template>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="8">
                    <v-card min-height="500" class="mt-5" v-if="files.length > 0">
                        <v-carousel height="500" cycle hide-delimiter-background>
                            <v-carousel-item contain v-for="(file, i) in files" :key="i" :src="`/images/properties/${file.image}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                        </v-carousel>
                        <v-card-actions class="justify-center px-3 mt-5" v-if="files">
                            <v-btn large icon color="red darken-2 mx-5" @click="confirmDelFile">
                                <i class="uil uil-trash-alt"></i>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                    <v-alert type="info" class="mt-5" v-else>
                        This listing has no files.
                    </v-alert>
                </v-col>
            </template>
        </v-row>
        <v-dialog v-model="confirmStatusDial" max-width="450" v-if="prop">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to {{ prop.status ? 'De-activate': 'Activate' }} this listing?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmStatusDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeStatus">Yes, {{ prop.status ? 'De-activate': 'Activate' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmDelListingDial" max-width="450" v-if="prop">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this listing?</v-card-title>
                <v-card-text class="mt-4 grey_text--text">
                    Once deleted, this listing cannot be recovered!
                </v-card-text>
                <v-card-actions class="pb-8 mt-3 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelListingDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteListing">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmApprovalDial" max-width="450" v-if="prop">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to {{ prop.is_approved ? 'Dis-approve': 'Approve' }} this listing?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmApprovalDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeApproval">Yes, {{ prop.is_approved ? 'Dis-approve': 'Approve' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmFeatureDial" max-width="450" v-if="prop">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to {{ prop.is_featured ? 'Un-feature': 'Feature' }} this listing?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmFeatureDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeFeature">Yes, {{ prop.is_featured ? 'Un-feature': 'Feature' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmDelFileDial" max-width="450">
            <v-card min-height="150" class="mx-auto">
                <v-card-title class="subtitle-1 justify-center primary white--text">Delete listing file(s)?</v-card-title>
                <v-card-text class="mt-3" v-if="delDialFiles.length > 0">
                    <v-alert type="warning">
                        Files deleted are not recoverable.
                    </v-alert>
                </v-card-text>
                <v-card-text class="img_wrap mt-n3" v-if="delDialFiles.length > 0">
                    <v-list>
                        <v-list-item v-for="(file, i) in delDialFiles" :key="i">
                            <v-list-item-content>
                                <v-img :alt="file.file" :src="`/images/properties/${file.image}`" width="80" height="80" ></v-img>
                            </v-list-item-content>
                            <v-list-item-icon class="mt-5">
                                <v-btn large icon @click="removeFile(file, i)" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-text v-else>
                    <v-alert type="info" class="mt-5">
                        There are no files.
                    </v-alert>
                </v-card-text>
                <v-card-actions class="justify-space-around pb-8" v-if="files.length > 0">
                    <v-btn text color="red darken-2" width="40%" @click="confirmDelFileDial = false">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmPlanDelDial" max-width="450">
            <v-card min-height="100" class="mx-auto">
                <v-card-title class="subtitle-1 justify-center primary white--text">Delete this listing plan?</v-card-title>
                <v-card-text class="mt-4 grey_text--text">
                    If you proceed to delete, you will not be able to recover this listing plan.
                </v-card-text>
                <v-card-actions class="justify-space-around mt-4 pb-6">
                    <v-btn outlined color="red darken-2" width="40%" @click="confirmPlanDelDial = false">Cancel</v-btn>
                    <v-btn dark color="primary" width="40%" @click="deleteListingPlan" :loading="isDeleting">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="statusChanged" :timeout="4000" top dark color="green darken-1">
            The listing was successfully updated.
            <v-btn text color="white--text" @click="statusChanged = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="AdminUpdatedProperty" :timeout="4000" top dark color="green darken-1">
            The listing was successfully updated.
            <v-btn text color="white--text" @click="AdminUpdatedProperty = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="delPlanFailed" :timeout="4000" top dark color="red darken-1">
           There was an error while trying to delete the listing plan. Please try again.
            <v-btn text color="white--text" @click="delPlanFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="planDeleted" :timeout="4000" top dark color="green darken-1">
           Listing plan deleted successfully.
            <v-btn text color="white--text" @click="planDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminUpdatedListingPlan" :timeout="4000" top dark color="green darken-1">
           Listing plan has been updated successfully.
            <v-btn text color="white--text" @click="adminUpdatedListingPlan = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            prop: null,
            isLoading: false,
            confirmStatusDial: false,
            isBusy: false,
            confirmApprovalDial: false,
            confirmFeatureDial: false,
            statusChanged: false,
            files: [],
            plans: [],
            confirmDelFileDial: false,
            delDialFiles: [],
            isDeleting: false,
            confirmDelListingDial: false,
            confirmPlanDelDial: false,
            planToDel: null,
            planToDelInd: null,
            delPlanFailed: false,
            planDeleted: false,
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
        AdminUpdatedProperty(){
            return this.$store.getters.AdminUpdatedProperty
        },
        adminUpdatedListingPlan(){
            return this.$store.getters.adminUpdatedListingPlan
        },
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods: {
        getprop(){
            axios.get(this.api + `/auth-admin/get_property/${this.$route.params.id}`, this.adminHeaders).then((res) => {
                this.prop = res.data
                this.prop.price = parseFloat(res.data.price / 100)
                this.files = res.data.files
                this.plans = res.data.property_listing_plans
                // console.log(res.data)
            })
        },
        confirmDelFile(){
            this.confirmDelFileDial = true
            this.delDialFiles = this.files
        },
        removeFile(file){
            axios.post(this.api + `/auth-admin/admin_del_property_file/${file.id}`, {}, this.adminHeaders).then((res) =>{
            })
            this.delDialFiles.splice(file, 1)
        },
        changeStatus(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_prop_status/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.confirmStatusDial = false
                this.prop.status = res.data
                this.statusChanged = true
            })
        },
        changeApproval(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_prop_approval/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.confirmApprovalDial = false
                this.prop.is_approved = res.data
                this.statusChanged = true
            })
        },
        changeFeature(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_prop_feature/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.confirmFeatureDial = false
                this.prop.is_featured = res.data
                this.statusChanged = true
            })
        },
        deleteListing(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/del_listing/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.confirmDelListingDial = false
                this.$store.commit('adminDeletedListing')
                this.$router.push({name: 'AdminPropertyList'})
            })
        },
        confirmPlanDel(id, i){
            this.confirmPlanDelDial = true
            this.planToDel = id
            this.planToDelInd = i
        },
        deleteListingPlan(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/del_listing_plan/${this.planToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.confirmPlanDelDial = false
                this.plans.splice(this.planToDelInd, 1)
                this.planDeleted = true
            }).catch(() => {
                this.isDeleting = false
                this.delPlanFailed = true
            })
        }
    },
    mounted(){
        this.getprop()
    }
}
</script>

<style lang="scss" scoped>
    .v-btn i{
        font-size: 1.1rem !important;
    }
</style>
