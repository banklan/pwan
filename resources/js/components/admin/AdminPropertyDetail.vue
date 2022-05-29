<template>
    <v-container>
        <v-row justify="center" class="justify-center mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminList'}"><i class="uil uil-arrow-left"></i> Back To Listing</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n3 mr-n5': ''">
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Listing ID <span v-if="prop">{{ prop.id}}</span></v-card-title>
                    <v-card-text class="mt-5" v-if="prop">
                        <v-simple-table light>
                            <template v-slot:default>
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="30%">Name:</th>
                                        <td>{{ prop.name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Title:</th>
                                        <td>{{ prop.title }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Location:</th>
                                        <td>{{ prop.location }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Detail:</th>
                                        <td>{{ prop.detail }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Price:</th>
                                        <td>&#8358;{{ prop.price | price }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Status:</th>
                                        <td :class="prop.status ? 'green_text--text' : 'red--text lighten-1'">{{ prop.status ? 'Active' : 'Closed' }} <span class="float-right"><v-btn small dark text :class="prop.status ? 'secondary--text' : 'primary--text'" @click="confirmStatusDial = true">{{ prop.status ?  'Deactivate' : 'Activate' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Approval:</th>
                                        <td :class="prop.is_approved ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_approved ? 'Approved' : 'Not Approved' }} <span class="float-right"><v-btn small dark text :class="prop.is_approved ? 'secondary--text' : 'primary--text'" @click="confirmApprovalDial = true">{{ prop.is_approved ?  'DisApprove' : 'Approve' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Feature:</th>
                                        <td :class="prop.is_featured ? 'green_text--text' : 'red--text lighten-1'">{{ prop.is_featured ? 'Featured' : 'Not Featured' }} <span class="float-right"><v-btn small dark text :class="prop.is_featured ? 'secondary--text' : 'primary--text'" @click="confirmFeatureDial = true">{{ prop.is_featured ?  'Unfeature' : 'Feature' }}</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Created By:</th>
                                        <td>{{ prop.user && prop.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Authorized By:</th>
                                        <td>{{ prop.admin && prop.admin.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Published:</th>
                                        <td>{{ prop.published }}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Updated:</th>
                                        <td>{{ prop.updated }}</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6" v-if="prop">
                        <v-btn large icon color="primary darken-2" class="mr-5" :to="{name: 'AdminPropertyUpdate', params: {id: prop.id}}"><i class="uil uil-edit"></i></v-btn>
                        <v-btn large icon color="red darken-2" class="ml-5"><i class="uil uil-trash-alt"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card min-height="600" min-width="80%" class="mt-5">
                    <v-carousel min-height="600">
                        <v-carousel-item contain v-for="(file, i) in files" :key="i" :src="`/images/properties/${file.image}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                    </v-carousel>
                    <v-card-actions class="justify-center px-5 mt-5" v-if="files">
                        <v-btn large icon color="red darken-2 mx-5" @click="confirmDelFile">
                            <i class="uil uil-trash-alt"></i>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
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
        <v-dialog v-model="confirmApprovalDial" max-width="450" v-if="prop">
            <v-card min-height="120">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to {{ prop.is_approved ? 'Dis-approve': 'Approve' }} this listing?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmApprovalDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeApproval">Yes, {{ prop.status ? 'Dis-approve': 'Approve' }}</v-btn>
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
                <v-card-title class="subtitle-1 justify-center admin white--text">Delete listing file(s)?</v-card-title>
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
                                <v-btn large icon @click="removeFile(file, i)"><i class="uil uil-minus"></i></v-btn>
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
        <v-snackbar v-model="statusChanged" :timeout="4000" top dark color="green darken-1">
            The listing was successfully updated.
            <v-btn text color="white--text" @click="statusChanged = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="AdminUpdatedProperty" :timeout="4000" top dark color="green darken-1">
            The listing was successfully updated.
            <v-btn text color="white--text" @click="AdminUpdatedProperty = false">Close</v-btn>
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
            delDialFiles: []
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
        }
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
                console.log(res.data)
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
</style>
