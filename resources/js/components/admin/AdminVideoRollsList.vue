<template>
    <v-container>
        <v-row justify="center" :class="$vuetify.breakpoint.smAndDown ? 'mr-8' : ''">
            <v-col cols="10" md="6" offset-md="4">
                 <admin-search model="VideoRoll" searchFor="video rolls"/>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Video List <span v-if="videos.length > 0"><v-chip color="primary lighten-2 ml-2">{{ videos.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="videos.length > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Published</th>
                                    <th>Created By</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="videos_list">
                                <tr v-for="video in videos" :key="video.id" :class="!video.is_approved ? 'warning--text' : ''">
                                    <td @click="showVideo(video.id)">{{ video.id }}</td>
                                    <td @click="showVideo(video.id)">{{ video.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td @click="showVideo(video.id)">{{ video.user && video.user.fullname }}</td>
                                    <td @click="showVideo(video.id)" class="text-truncate">{{ video.title }}</td>
                                    <td>{{ video.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                    <td><v-btn icon color="red darken-2" @click="confirmDel(video.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no videos to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="videos.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getVideos(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getVideos(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getVideos(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getVideos(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this video roll?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteVideoRoll">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="adminDeletedVideo" :timeout="4000" top dark color="green darken-2">
            A video roll has been deleted successfully.
            <v-btn text color="white--text" @click="adminDeletedVideo = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            videos: [],
            pagination: null,
            total: null,
            q: '',
            confirmDelDial: false,
            videoToDel: null,
            vidIndx: null,
            isDeleting: false
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
        adminDeletedVideo(){
            return this.$store.getters.adminDeletedVideo
        }
    },
    methods: {
        getVideos(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_paginated_videos`
            axios.get(pag, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.videos = res.data.data
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
        showVideo(vid){
            this.$router.push({name: 'AdminVideoRollsDetail', params:{id: vid}})
        },
        confirmDel(video, i){
            this.confirmDelDial = true
            this.videoToDel = video
            this.vidIndx = i
        },
        deleteVideoRoll(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_video_roll/${this.videoToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.$store.commit('adminDeletedVideo')
                this.videos.splice(this.vidIndx, 1)
            })
        }
    },
    mounted() {
        this.getVideos()
    },
}
</script>

<style lang="css" scoped>
    .table .videos_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .videos_list tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>

