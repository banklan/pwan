<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffPropertyList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n3 mr-n5': ''">
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtitle-1">Listing ID <span v-if="prop">&nbsp;{{ prop.id}}</span></v-card-title>
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
                                        <td :class="prop.status ? 'green_text--text' : 'red--text lighten-1'">{{ prop.status ? 'Active' : 'Closed' }} </td>
                                    </tr>
                                    <tr>
                                        <th>Approval:</th>
                                        <td :class="prop.is_approved ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_approved ? 'Approved' : 'Not Approved' }} </td>
                                    </tr>
                                    <tr>
                                        <th>Feature:</th>
                                        <td :class="prop.is_featured ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_featured ? 'Featured' : 'Not Featured' }} </td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ prop.user && prop.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Published:</th>
                                        <td>{{ prop.published }}</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6" v-if="prop && isAuthor">
                        <v-btn large icon color="primary darken-2" class="mx-5" :to="{name: 'StaffPropertyUpdate', params: {id: prop.id}}"><i class="uil uil-edit"></i></v-btn>
                        <!-- <v-btn dark color="primary" :to="{name: 'StaffPropAddFiles'}">Add Files</v-btn> -->
                        <v-btn large icon color="red darken-2" class="mx-5" @click="delListingConfirmDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
            <template v-else>
                <v-col cols="12" md="6">
                    <v-card light raised outlined elevation="3" min-height="100" class="mt-5">
                        <v-card-title class="primary white--text justify-center subtitle-1">Listing Plans <span v-if="prop && plans > 0">&nbsp;<v-chip color="primary lighten-2 white--text">{{ plans.length }}</v-chip></span></v-card-title>
                        <v-card-text class="mt-5">
                            <template v-if="plans.length > 0">
                                <table class="table plans">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Unit</th>
                                            <th>Price(&#8358;)</th>
                                            <th v-if="isAuthor">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(plan, i) in plans" :key="plan.id">
                                            <td>{{ plan.created_at | moment('DD/MM/YYYY') }}</td>
                                            <td class="text-truncate">{{ plan.name }}</td>
                                            <td>{{ plan.unit }}</td>
                                            <td>{{ plan.price / 100 | price }}</td>
                                            <td v-if="isAuthor"><v-btn small icon color="primary darken-2" :to="{name: 'StaffPropertyPlanUpdate', params:{id: plan.id}}"><i class="uil uil-edit"></i></v-btn><v-btn small class="ml-2" icon color="red darken-2" @click="confirmPlanDel(plan.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <v-alert type="warning" border="left">
                                    There are no listing plans set for this listing. The creator of the listing should create listing plan(s).
                                </v-alert>
                            </template>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-6" v-if="isAuthor">
                            <v-btn large dark color="primary" width="50%" :to="{name: 'StaffCreatePropertyPlans', params:{listing: prop.id}}">Add Plan</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <template v-if="files.length > 0">
                        <v-card min-height="500" class="mt-5">
                            <v-carousel height="400" cycle hide-delimiter-background>
                                <!-- <v-carousel-item contain v-for="(file, i) in files" :key="i" :src="`/images/properties/${file.image}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item> -->
                                <v-carousel-item contain v-for="(file, i) in files" :key="i" :src="file" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                            </v-carousel>
                            <v-card-actions class="justify-center px-3 mt-5" v-if="files && isAuthor">
                                <v-btn large icon color="red darken-2 mx-5" @click="confirmDelFile">
                                    <i class="uil uil-trash-alt"></i>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                    <template v-else>
                        <v-alert type="info" class="mt-5">
                            This property listing has no files.
                        </v-alert>
                    </template>
                </v-col>
            </template>
        </v-row>
        <v-dialog v-model="confirmDelFileDial" max-width="450">
            <v-card min-height="100" class="mx-auto">
                <v-card-title class="subtitle-1 justify-center primary white--text">Delete listing file(s)?</v-card-title>
                <v-card-text class="mt-3" v-if="files.delDialFiles > 0">
                    <v-alert type="warning" class="mb-8">
                        Files deleted are not recoverable.
                    </v-alert>
                    <v-list class="files_list">
                        <v-list-item v-for="(file, i) in delDialFiles" :key="i" class="img_wrap">
                            <v-list-item-content>
                                <!-- <v-img class="img_avatar" :alt="file.file" :src="`/images/properties/${file.image}`"></v-img> -->
                                <v-img class="img_avatar" :alt="file.image" :src="`https://pwanplatinum.s3.amazonaws.com/properties/${file.image}`"></v-img>
                            </v-list-item-content>
                            <v-list-item-icon>
                                <v-btn large icon @click="removeFile(file, i)" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-text v-else class="mt-5">
                    <v-alert type="info" class="mt-5">
                        There are no files.
                    </v-alert>
                    <v-card-actions class="mt-5 justify-center">
                        <v-btn outlined color="red darken-2" width="40%" @click="confirmDelFileDial = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card-text>
                <v-card-actions class="justify-space-around mt-6 pb-6" v-if="files.length > 0">
                    <v-btn outlined color="red darken-2" width="40%" @click="confirmDelFileDial = false">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="delListingConfirmDial" max-width="450">
            <v-card min-height="100" class="mx-auto">
                <v-card-title class="subtitle-1 justify-center primary white--text">Delete this property listing?</v-card-title>
                <v-card-text class="mt-4 grey_text--text">
                    If you proceed to delete, you will not be able to recover this listing and its files again.
                </v-card-text>
                <v-card-actions class="justify-space-around mt-4 pb-6">
                    <v-btn outlined color="red darken-2" width="40%" @click="delListingConfirmDial = false">Cancel</v-btn>
                    <v-btn dark color="primary" width="40%" @click="deleteListing" :loading="isDeleting">Yes, Delete</v-btn>
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
        <v-snackbar :value="StaffUpdatedProperty" :timeout="4000" top dark color="green darken-1">
            The listing was successfully updated.
            <v-btn text color="white--text" @click="StaffUpdatedProperty = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="listingFilesUploaded" :timeout="4000" top dark color="green darken-1">
            The new property was successfully listed.
            <v-btn text color="white--text" @click="listingFilesUploaded = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="fileRemoved" :timeout="4000" top dark color="green darken-1">
            The file has been removed.
            <v-btn text color="white--text" @click="fileRemoved = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="listingPlanCreated" :timeout="4000" top dark color="green darken-1">
            A new plan has been added to this listing.
            <v-btn text color="white--text" @click="listingPlanCreated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="listingPlanUpdated" :timeout="4000" top dark color="green darken-1">
            A listing plan has been updated.
            <v-btn text color="white--text" @click="listingPlanUpdated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="listingPlanDeleted" :timeout="4000" top dark color="green darken-1">
            A listing plan has been deleted.
            <v-btn text color="white--text" @click="listingPlanDeleted = false">Close</v-btn>
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
            confirmDelFileDial: false,
            delDialFiles: [],
            fileRemoved: false,
            delListingConfirmDial: false,
            isDeleting: false,
            plans: [],
            confirmPlanDelDial: false,
            planToDelInd: null,
            planToDel: null,
            listingPlanDeleted: false,
        }
    },
    computed:{
        authUser(){
            return this.$store.getters.authUser
        },
        api(){
            return this.$store.getters.api
        },
        authHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authUser.token}`
                }
            }
            return headers
        },
        StaffUpdatedProperty(){
            return this.$store.getters.StaffUpdatedProperty
        },
        isAuthor(){
            if(this.prop && this.prop.user_id == this.authUser.id){
                return true
            }else{
                return false
            }
        },
        listingFilesUploaded(){
            return this.$store.getters.listingFilesUploaded
        },
        listingPlanCreated(){
            return this.$store.getters.listingPlanCreated
        },
        listingPlanUpdated(){
            return this.$store.getters.listingPlanUpdated
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetStaffFlashMsg')
        next()
    },
    methods: {
        getprop(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_property/${this.$route.params.id}`, this.authHeaders).then((res) => {
                this.isLoading = false
                this.prop = res.data
                this.prop.price = parseFloat(res.data.price / 100)
                // this.files = res.data.files
                this.getPropFiles()
                this.plans = res.data.property_listing_plans
                // console.log(res.data)
            })
        },
        getPropFiles(){
            axios.get(this.api + `/auth/get_prop_files/${this.$route.params.id}`, this.authHeaders).then((res) => {
                this.files = res.data
                // console.log(res.data)
            })
        },
        confirmDelFile(){
            this.confirmDelFileDial = true
            this.delDialFiles = this.prop.files
        },
        removeFile(file){
            axios.post(this.api + `/auth/staff_del_property_file/${file.id}`, {}, this.authHeaders).then((res) =>{
            })
            this.delDialFiles.splice(file, 1)
            this.fileRemoved = true
        },
        deleteListing(){
            this.isDeleting = true
            axios.post(this.api + `/auth/delete_listing/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.isDeleting = false
                this.delListingConfirmDial = false
                this.$router.push({name: 'StaffPropertyList'})
                this.$store.commit('listingDeleted')
            })
        },
        confirmPlanDel(plan, i){
            this.confirmPlanDelDial = true
            this.planToDel = plan
            this.planToDelInd = i
        },
        deleteListingPlan(){
            this.isDeleting = true
            axios.post(this.api + `/auth/delete_listing_plan/${this.planToDel}`, {}, this.authHeaders)
            .then((res) => {
                this.isDeleting = false
                this.confirmPlanDelDial = false
                this.listingPlanDeleted = true
                this.plans.splice(this.planToDelInd, 1)
                // console.log(res)
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
        font-size: 1.2rem !important;
    }
    .files_list{
        margin-top: 2rem !important;
    }
    .img_wrap{
        margin: .5rem auto;
        height: 7rem !important;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        overflow: hidden;

        &:nth-child(1){
            margin-top: -1rem;
        }
        &:nth-last-child(1){
            margin-bottom: -2rem;
        }
    }
    .v-image.img_avatar{
        max-height: 80% !important;
        border: 1px solid #f0f0f0;
        box-shadow: 0 3px 5px rgba(0,0,0,.25);
    }
    .v-btn i{
        font-size: 1rem !important;
    }
    table.plans tr td{
        // cursor: pointer;
        white-space: nowrap !important;
        vertical-align: middle !important;
    }
</style>
