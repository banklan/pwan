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
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Event Detail</v-card-title>
                    <v-card-text class="mt-8">
                        <template v-if="event">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%" style="border-top: none">Title</th>
                                        <td style="border-top: none">{{ event.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ event.user && event.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approval Status:</th>
                                        <td :class="!event.is_approved ? 'warning--text': 'green_text--text'">{{ event.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Feature Status:</th>
                                        <td>{{ event.is_featured ? 'Featured' : 'Not Featured' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Event Date</th>
                                        <td>{{ event.evnt_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Event Time</th>
                                        <td>{{ event.evnt_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail</th>
                                        <td>{{ event.detail }}</td>
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
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card min-height="200" min-width="80%" class="mt-5" v-if="event">
                    <v-card-title class="justify-center primary subtitle-1 white--text">Event files</v-card-title>
                    <template v-if="event && event.event_files.length > 0">
                        <v-carousel min-height="700">
                            <!-- <v-carousel-item contain v-for="(file, i) in event.event_files" :key="i" :src="`/images/events/${file.file}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item> -->
                            <v-carousel-item contain v-for="(file, i) in event.event_files" :key="i" :src="`https://pwanplatinum.s3.amazonaws.com/events/${file.file}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                        </v-carousel>
                        <v-card-actions class="justify-center px-5 mt-5" v-if="event.event_files.length > 0 && isAuthor">
                            <v-btn large icon color="red darken-2 mx-5" @click="delFileDial = true">
                                <i class="uil uil-trash-alt"></i>
                            </v-btn>
                        </v-card-actions>
                    </template>
                    <template v-else>
                        <v-alert type="info" class="mt-5 mx-4">
                            There are no files for this event.
                        </v-alert>
                    </template>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450" v-if="event">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this event?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delEvent">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="delFileDial" max-width="500" v-if="event && event.event_files.length > 0">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Choose an event file to delete</v-card-title>
                <v-card-text class="mx-3 mt-4 grey_text--text" v-if="event.event_date.length > 0">
                    <div v-for="(file, i) in event.event_files" :key="file.id">
                        <div class="file_wrap">
                            <div class="img">
                                <img :src="`/images/events/${file.file}`" alt="event file">
                            </div>
                            <div class="del_btn">
                                <v-btn small icon color="red darken-2" @click="confirmDelFile(file.id, i)"><i class="uil uil-times"></i></v-btn>
                            </div>
                        </div>
                        <v-divider></v-divider>
                    </div>
                </v-card-text>
                <div class="mt-5 mx-3" v-else>
                    <v-alert type="warning" border="left">
                        There are no event files for this event.
                    </v-alert>
                </div>
                <v-card-actions class="justify-center pb-5" v-if="event.event_files.length > 0">
                    <v-btn text color="red darken--2" @click="delFileDial = false">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmDelFileDial" max-width="450" v-if="event && event.event_files">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Delete this event file?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelFileDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delFile">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="eventUpdated" :timeout="4000" top dark color="green darken-2">
            This event has been updated successfully.
            <v-btn text color="white--text" @click="eventUpdated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="eventFileDeleted" :timeout="4000" top dark color="green darken-2">
            An event file was deleted successfully.
            <v-btn text color="white--text" @click="eventFileDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="fileDelFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to delete the event file. Please try again.
            <v-btn text color="white--text" @click="fileDelFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="eventCreated" :timeout="4000" top dark color="green darken-2">
            The event was created successfully.
            <v-btn text color="white--text" @click="eventCreated = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            event: null,
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
        eventUpdated(){
            return this.$store.getters.eventUpdated
        },
        isAuthor(){
            if(this.event && this.event.user_id == this.authUser.id){
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
        getEvent(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_event/${this.$route.params.id}`, this.authHeaders)
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
        this.getEvent()
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
    .file_wrap{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;

        .img{
            height: 6rem;
            width: 6rem;
            overflow: hidden;
            border: 1px solid rgb(226, 226, 226);
            text-align: center;

            img{
                height: 100%;
            }
        }
        .del_btn{
            padding-right: 2rem;
        }
    }
</style>

