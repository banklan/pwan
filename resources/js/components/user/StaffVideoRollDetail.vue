<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffVideoRollList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
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
                        <v-card-actions class="justify-center pb-8 mt-n5" v-if="video && isAuthor">
                            <v-btn icon color="primary" class="mx-7" :to="{name: 'StaffUpdateVideoRoll', params:{id: video.id}}"><i class="uil uil-edit"></i></v-btn>
                            <v-btn icon color="red darken-2" class="mx-7"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                        </v-card-actions>
                    </v-card>
                    <div class="video_wrap" v-if="video">
                        <video controls height="">
                            <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
                            <!-- <source :src="`/images/videos/${video.video}`"> -->
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="video_update" v-if="!previewUpload">
                        <v-btn dark color="primary" @click="openUpload">Replace Video</v-btn>
                        <input type="file" ref="video" style="display:none" @change.prevent="pickVideo" accept="video/*">
                        <v-btn text color="red darken-2" @click="confirmDelDial = true"><i class="uil uil-trash"></i></v-btn>
                    </div>
                    <div class="vid_preview" v-else>
                        <div class="prev">
                            <video controls height="100%">
                                <source :src="prvUploadUrl" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <v-btn icon large @click="removeFile" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                        </div>
                        <div class="subm">
                            <v-btn large color="red darken-2" text @click="removeFile">Cancel Upload</v-btn>
                            <v-btn large color="primary" dark :loading="isBusy" @click="updateVideo">Update Video</v-btn>
                        </div>
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
        <v-snackbar :value="videoRollUpdated" :timeout="4000" top dark color="green darken-2">
            A video roll was updated successfully.
            <v-btn text color="white--text" @click="videoRollUpdated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="deleteFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to delete the video roll. Please try again.
            <v-btn text color="white--text" @click="deleteFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="invalidFileType" :timeout="6000" top dark color="red darken-2">
            Invalid video type. You are only allowed to upload an MP4 video.
            <v-btn text color="white--text" @click="invalidFileType = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="maxSizeExceeded" :timeout="6000" top dark color="red darken-2">
            Maximum file size exceeded. Please upload a video of size less than 20mb.
            <v-btn text color="white--text" @click="maxSizeExceeded = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="replaceFail" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the video. Please try again later.
            <v-btn text color="white--text" @click="replaceFail = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="replaceSuccess" :timeout="4000" top dark color="green darken-2">
            The video was updated successfully.
            <v-btn text color="white--text" @click="replaceSuccess = false">Close</v-btn>
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
            previewUpload: false,
            maxSizeExceeded: false,
            invalidFileType: false,
            file: '',
            prvUploadUrl: '',
            deleteFailed: false,
            replaceFail: false,
            replaceSuccess: false,
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
        videoRollUpdated(){
            return this.$store.getters.videoRollUpdated;
        }
    },
    methods: {
        getVideo(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_video/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.video = res.data
            })
        },
        delVideoRoll(){
            this.isBusy = true
            axios.post(this.api + `/auth/delete_video_roll/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.confirmDelDial = false
                this.$store.commit('videoDeleted')
                this.$router.push({name: 'StaffVideoRollList'})
            }).catch(() => {
                this.isBusy = false
                this.deleteFailed = true
            })
        },
        openUpload(){
            this.$refs.video.click()
        },
        pickVideo(e){
            const file = e.target.files[0]
            let size = file.size / 1000
            const fileName = file.name
            const fileExt = fileName.split('.').pop();
            // console.log(size)
            if(size > 30000){
                this.maxSizeExceeded = true
                return
            }else if(fileExt !== 'mp4'){
                this.invalidFileType = true
                return
            }else{
                this.file = file
                this.previewUpload = true
                this.prvUploadUrl = URL.createObjectURL(file)
            }
        },
        removeFile(){
            this.isBusy = false
            this.previewUpload = false
            this.prvUploadUrl = ''
        },
        updateVideo(){
            if(this.file !== ''){
                this.isBusy = true
                let form = new FormData();
                form.append('video', this.file)
                // axios.post(this.api + `/auth/update_news_post_file/${this.$route.params.id}`, form, this.authHeaders)
                axios.post(this.api + `/auth/replace_video/${this.$route.params.id}`, form, this.authHeaders).then((res) => {
                    // console.log(res.data)
                    this.video.video = res.data.video
                    this.isBusy = false
                    this.previewUpload = false
                    this.replaceSuccess = true
                }).catch(() => {
                    this.isBusy = false
                    this.replaceFail = true
                })
            }
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
    .video_update{
        margin-top: 1.5rem;
        width: 100%;
        text-align: center;
        height: 15rem;
    }

    .vid_preview{
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;

        .prev{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            width: 100%;
            video{
                width: 15rem;
                height: 12rem;
            }
            button i{
                font-size: 1.2rem !important;
            }
        }

        @media screen and(max-width: 722px) {
            .sub{
                flex-direction: column;
                gap: 1rem;
            }
        }
        .subm{
            margin-top: 1rem;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.2rem;
        }

        @media screen and (max-width: 600px){
            .subm{
                flex-direction: column;
                gap: 1rem;
            }
        }
    }
</style>

