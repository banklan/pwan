<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffEventsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
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
                                The event you are trying to view is not available. Please pick an event from the list on the Events list page.
                            </v-alert>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-8 mt-n5" v-if="event && isAuthor">
                            <v-btn icon color="primary" class="mx-7" :to="{name: 'StaffUpdateEvent', params:{id: event.id}}"><i class="uil uil-edit"></i></v-btn>
                            <v-btn icon color="red darken-2" class="mx-7"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                        </v-card-actions>
                    </v-card>
                    <div class="video_wrap">
                        <video controls height="100%">
                            <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
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

        <v-snackbar :value="newVideoRollCreated" :timeout="4000" top dark color="green darken-2">
            New Video roll has been created.
            <v-btn text color="white--text" @click="newVideoRollCreated = false">Close</v-btn>
        </v-snackbar>
        <!-- <v-snackbar v-model="eventFileDeleted" :timeout="4000" top dark color="green darken-2">
            An event file was deleted successfully.
            <v-btn text color="white--text" @click="eventFileDeleted = false">Close</v-btn>
        </v-snackbar> -->
        <!-- <v-snackbar v-model="fileDelFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to delete the event file. Please try again.
            <v-btn text color="white--text" @click="fileDelFailed = false">Close</v-btn>
        </v-snackbar> -->
        <!-- <v-snackbar :value="eventCreated" :timeout="4000" top dark color="green darken-2">
            The event was created successfully.
            <v-btn text color="white--text" @click="eventCreated = false">Close</v-btn>
        </v-snackbar> -->
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
            isFeaturing: false,
            isApproving: false,
            changeApproveDial: false,
            changeFeatureDial: false,
            eventApprovalChanged: false,
            eventFeatureChanged: false,
            delFileDial: false,
            fileTodelIndex: null,
            fileTodel: null,
            eventFileDeleted: false,
            confirmDelFileDial: false,
            fileDelFailed: false,
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetStaffFlashMsg')
        next()
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
        newVideoRollCreated(){
            return this.$store.getters.newVideoRollCreated
        },
        isAuthor(){
            if(this.video && this.video.user_id == this.authUser.id){
                return true
            }else{
                return false
            }
        },
        eventCreated(){
            return this.$store.getters.eventCreated
        }
    },
    methods: {
        getVideo(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_video/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.event = res.data
            })
        },
        delEvent(){
            axios.post(this.api + `/auth/delete_event/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.confirmDelDial = false
                this.$store.commit('eventDeleted')
                this.$router.push({name: 'StaffEventsList'})
            }).catch(() => {
                this.isBusy = false
            })
        },
        confirmDelFile(file, i){
            this.fileTodel = file
            this.fileTodelIndex = i
            this.confirmDelFileDial = true
        },
        delFile(){
            this.isBusy = true
            axios.post(this.api + `/auth/del_event_file/${this.fileTodel}`, {}, this.authHeaders)
            .then((res) => {
                console.log(res.data)
                this.isBusy = false
                this.confirmDelFileDial = false
                this.event.event_files.splice(this.fileTodelIndex, 1)
                this.eventFileDeleted = true
            }).catch(() => {
                this.isBusy = false
                this.confirmDelFileDial = false
                this.fileDelFailed = true
            })
        }
    },
    mounted() {
        this.getVideo()
    },
}
</script>

<style lang="scss" scoped>
    .table tr{
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
        height: 40rem;
        background: red;

        video{
            width: 100%;
            height: fit-content;
        }
    }
</style>

