<template>
    <v-container>
        <v-row justify="center" class="justify-center mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminVideoRollsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <v-card light raised outlined elevation="4" min-height="400" class="scroll">
                        <v-card-title class="primary white--text justify-center subtile-1">Video Detail</v-card-title>
                        <v-card-text class="mt-8">
                            <template v-if="video">
                                <table class="table">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th width="20%" style="border-top: none">Title</th>
                                            <td style="border-top: none">{{ video.title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By:</th>
                                            <td>{{ video.user && video.user.fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval Status:</th>
                                            <td :class="!video.is_approved ? 'warning--text': 'green_text--text'">{{ video.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Feature Status:</th>
                                            <td>{{ video.is_featured ? 'Featured' : 'Not Featured' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <v-alert type="warning" border="left" v-else>
                                The video you are trying to view is not available. Please pick a video from the list on the Video rolls list page.
                            </v-alert>
                        </v-card-text>
                        <v-card-actions class="justify-space-around pb-8 mt-n5" v-if="video">
                            <v-btn dark color="admin_a" class="" @click="confirmApprovalDial = true">{{ video.is_approved ? 'Dis-approve' : 'Approve' }}</v-btn>
                            <v-btn dark color="admin_b" class="" @click="confirmFeatureDial = true">Feature</v-btn>
                            <v-btn icon color="red darken-2"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                        </v-card-actions>
                    </v-card>
                    <div class="video_wrap" v-if="video">
                        <video controls height="">
                            <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
                            <!-- <source :src="`/images/videos/${video.video}`"> -->
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </template>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450" v-if="video">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this video roll?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delVideoRoll">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmApprovalDial" max-width="450" v-if="video">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Do you want to {{ video.is_approved ? 'dis-approve' : 'approve' }} this video roll?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmApprovalDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeVideoApproval">Yes, {{ video.is_approved ? 'Dis-Approve' : 'Approve' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmFeatureDial" max-width="450" v-if="video">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Do you want to {{ video.is_featured ? 'un-feature' : 'feature' }} this video roll?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmFeatureDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeVideoFeature">Yes, {{ video.is_featured ? 'Un-feature' : 'Feature' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="deleteFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to delete the video roll. Please try again.
            <v-btn text color="white--text" @click="deleteFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="videoRollUpdated" :timeout="3000" top dark color="green darken-2">
            Video roll has been updated.
            <v-btn text color="white--text" @click="videoRollUpdated = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            video: null,
            isLoading: false,
            isBusy: false,
            confirmDelDial: false,
            deleteFailed: false,
            confirmApprovalDial: false,
            videoRollUpdated: false,
            confirmFeatureDial: false,
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
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
        getVideo(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_video/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.video = res.data
            })
        },
        delVideoRoll(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/delete_video_roll/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.$store.commit('adminDeletedVideo')
                this.$route.push({name: 'AdminVideoRollsList'})
            }).catch(() => {
                this.isBusy = false
                this.deleteFailed = true
            })
        },
        changeVideoApproval(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_video_approval/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.video.is_approved = res.data
                this.videoRollUpdated = true
                this.confirmApprovalDial = false
            })
        },
        changeVideoFeature(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_video_feature/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.video.is_featured = res.data
                this.videoRollUpdated = true
                this.confirmFeatureDial = false
            })
        }
    },
    mounted() {
        this.getVideo()
    },
}
</script>

<style lang="scss" scoped>
    table tbody tr{
        cursor: pointer;
    }
    .table tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
    table tbody tr th{
        white-space: nowrap !important;
    }
    .video_wrap{
        margin: 0 auto;
        overflow: hidden;
        width: 100%;
        height: 30rem;
        margin-top: 2rem;

        video{
            width: 100%;
            height: 100%;
        }
    }
    @media screen and (max-width: 1200px){
        .video_wrap{
            height: 25rem;
        }
    }
    @media screen and (max-width: 900px){
        .video_wrap{
            height: 20rem;
        }
    }

</style>

