<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffNewsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">News Post Detail</v-card-title>
                    <v-card-text class="mt-5">
                        <template v-if="post">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%" style="border-top: none">Title</th>
                                        <td style="border-top: none">{{ post.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ post.user && post.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approval Status:</th>
                                        <td :class="!post.is_approved ? 'warning--text': 'green_text--text'">{{ post.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Feature Status:</th>
                                        <td>{{ post.is_featured ? 'Featured' : 'Not Featured' }} </td>
                                    </tr>
                                    <tr v-if="post.admin_id">
                                        <th>Approved By(Admin):</th>
                                        <td>{{ post.admin && post.admin.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Published</th>
                                        <td>{{ post.published }}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail</th>
                                        <td>{{ post.detail }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <v-alert type="warning" border="left" v-else>
                            The news post you are trying to view is not available. Please pick a news post from the list on the news post list page.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8 mt-n5" v-if="post && isAuthor">
                        <v-btn icon color="primary" class="mx-7" :to="{name: 'StaffUpdateNewsPost', params:{id:post.id}}"><i class="uil uil-edit"></i></v-btn>
                        <v-btn icon color="red darken-2" class="mx-7"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="6">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="text-center subtitle-1 grey_text--text mt-5">Post Media</div>
                    <v-card min-height="200" min-width="80%" class="mt-5 file_cont" v-if="post">
                        <template v-if="post && post.file">
                            <template v-if="post.file.toString().split('.').pop() === 'mp4'">
                                <video width="100%" height="100%" controls>
                                    <!-- <source :src="`/images/news/${post.file}`" type="video/mp4"> -->
                                    <source :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </template>
                            <template v-else>
                                <!-- <v-img :src="`/images/news/${post.file}`" transition="scale-transition"></v-img> -->
                                <v-img :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" transition="scale-transition"></v-img>
                            </template>
                            <v-card-actions class="justify-center px-5 mt-5 pb-6" v-if="isAuthor">
                                <template v-if="!previewFile">
                                    <v-btn text dark color="admin_a" @click="openUpload" class="mx-3">Update File</v-btn>
                                    <input type="file" ref="file" style="display:none" @change.prevent="pickImg" accept="image/video*">
                                    <v-btn large icon color="red darken-2" class="mx-5" @click="delFileConfDial = true">
                                        <i class="uil uil-trash-alt"></i>
                                    </v-btn>
                                </template>
                                <template v-else>
                                    <div class="preview_cont">
                                        <v-card-text class="text-center mt-n8 prev_wrap">
                                            <div class="preview">
                                                <div v-if="fileType == 'img'" class="img_wrap">
                                                    <v-img :src="previewFileUrl" alt="file preview" height="100%"></v-img>
                                                </div>
                                                <template v-else>
                                                    <div class="video_wrap">
                                                        <video controls height="100%">
                                                            <source :src="previewFileUrl" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </template>
                                            </div>
                                            <span class="prev_action">
                                                <v-btn icon large @click="removeFile" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                                            </span>
                                        </v-card-text>
                                        <v-card-actions class="justify-center pb-8" :class="previewFile ? 'mt-n5' : ''">
                                            <v-btn dark color="primary" large width="50%" @click="uploadFile" :loading="isUpdating">Submit</v-btn>
                                        </v-card-actions>
                                    </div>
                                </template>
                            </v-card-actions>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="info" class="mx-3 mt-5">
                                    There are no file(s) for this news post.
                                </v-alert>
                            </v-card-text>
                            <v-card-actions class="justify-center">
                                <template v-if="!previewFile">
                                    <v-btn text dark color="admin_a" @click="openUpload" class="mx-3">Upload File</v-btn>
                                    <input type="file" ref="file" style="display:none" @change.prevent="pickImg" accept="*">
                                </template>
                                <template v-else>
                                    <div class="preview_cont">
                                        <v-card-text class="text-center mt-n8 prev_wrap">
                                            <div class="preview">
                                                <div v-if="fileType == 'img'" class="img_wrap">
                                                    <v-img :src="previewFileUrl" alt="file preview" height="100%"></v-img>
                                                </div>
                                                <template v-else>
                                                    <div class="video_wrap">
                                                        <video controls height="100%">
                                                            <source :src="previewFileUrl" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                </template>
                                            </div>
                                            <span class="prev_action">
                                                <v-btn icon large @click="removeFile" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                                            </span>
                                        </v-card-text>
                                        <v-card-actions class="justify-center pb-8" :class="previewFile ? 'mt-n5' : ''">
                                            <v-btn dark color="primary" large width="50%" @click="uploadFile" :loading="isUpdating">Submit</v-btn>
                                        </v-card-actions>
                                    </div>
                                </template>
                            </v-card-actions>
                        </template>

                    </v-card>
                </template>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450" v-if="post">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this news post?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delPost">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
       <v-dialog v-model="delFileConfDial" max-width="450" v-if="post && post.file">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Delete this post file?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="delFileConfDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delFile">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="newsPostUpdated" :timeout="4000" top dark color="green darken-2">
            This post has been updated successfully.
            <v-btn text color="white--text" @click="newsPostUpdated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="postFileDeleted" :timeout="4000" top dark color="green darken-2">
            This post file was deleted successfully.
            <v-btn text color="white--text" @click="postFileDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="fileDelFailed" :timeout="4000" top dark color="red darken-2">
            There was an error while trying to delete the post file. Please try again.
            <v-btn text color="white--text" @click="fileDelFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="cannotUpdatePost" :timeout="4000" top dark color="pink lighten-1">
            Only the creator of the news post is allowed to update the post.
            <v-btn text color="white--text" @click="cannotUpdatePost = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="delPostFailed" :timeout="4000" top dark color="red darken-2">
            There was an error while trying to delete the post. Please try again
            <v-btn text color="white--text" @click="delPostFailed = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="newPostCreated" :timeout="4000" top dark color="green darken-2">
            The news post has been created successfully.
            <v-btn text color="white--text" @click="newPostCreated = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            post: null,
            isLoading: false,
            isBusy: false,
            confirmDelDial: false,
            delFileConfDial: false,
            postFileDeleted: false,
            fileDelFailed: false,
            previewFile: false,
            previewFileUrl: null,
            file: '',
            isUpdating: false,
            delPostFailed: false,
            fileType: null,
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
        newsPostUpdated(){
            return this.$store.getters.newsPostUpdated
        },
        isAuthor(){
            if(this.post && this.post.user_id == this.authUser.id){
                return true
            }else{
                return false
            }
        },
        cannotUpdatePost(){
            return this.$store.getters.cannotUpdatePost
        },
        newPostCreated(){
            return this.$store.getters.newPostCreated
        },
    },
    methods: {
        getNewsPost(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_news_post/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.post = res.data
                this.checkAuthor(res.data)
                // console.log(res.data)
            })
        },
        delPost(){
            this.isBusy = true
            axios.post(this.api + `/auth/delete_news_post/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.confirmDelDial = false
                this.$router.push({name: 'StaffNewsList'})
                this.$store.commit('newsPostDeleted')
                // console.log(res.data)
            }).catch(() => {
                this.isBusy = false
                this.delPostFailed = true
            })
        },
        delFile(){
            this.isBusy = true
            axios.post(this.api + `/auth/del_post_file/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.post.file = null
                this.delFileConfDial = false
                this.postFileDeleted = true
            }).catch(() => {
                this.isBusy = false
                this.delFileConfDial = false
                this.fileDelFailed = true
            })
        },
        UploadNewFile(){
            this.openUpload()
            this.previewFile = true
        },
        openUpload(){
            this.$refs.file.click()
        },
        pickImg(e){
            const file = e.target.files[0]
            const fileName = file.name
            const fileExt = fileName.split('.').pop();
            if(fileExt === 'mp4'){
                this.fileType = 'video'
            }else{
                this.fileType = 'img'
            }
            this.file = file
            this.previewFile = true
            this.previewFileUrl = URL.createObjectURL(file)
        },
        removeFile(){
            this.file = null
            this.previewFile = false
            this.previewFileUrl = ''
            this.file = ''
        },
        uploadFile(){
            if(this.file !== ''){
                console.log(this.file)
                this.isUpdating = true
                let form = new FormData();
                form.append('file', this.file)

                axios.post(this.api + `/auth/update_news_post_file/${this.$route.params.id}`, form, this.authHeaders)
                .then((res) => {
                    this.isUpdating = false
                    this.post.file = res.data
                    this.fileUpdated = true
                    this.removeFile()
                }).catch(() => {
                    this.isUpdating = false
                    this.fileUpdateFailed = true
                })
            }
        },
        checkAuthor(post){
            this.$store.commit('checkAuthor', post)
        },
    },
    mounted() {
        this.getNewsPost()
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
    .file_cont{
        overflow: hidden;

        .v-image{
            width: 100%;
            height: 100%;
        }
        video{
            width: 100%;
            height: 100%;
        }
    }
    .preview_cont{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 1.5rem;

        .prev_wrap{
            margin: 1rem auto;
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            padding-top: 2rem;
            gap: 3rem;
            .preview{
                overflow: hidden;

                .img_wrap{
                    height: 12rem;
                    width: 12rem;
                    margin: 0 auto -2rem;

                    .v-image{
                        height: 100%;
                        width: 100%;
                    }
                }

                .video_wrap{
                    height: 20rem;
                    width: 20rem;
                    margin: 0 auto -2rem;

                    video{
                        margin-top: -3rem;
                        height: 100%;
                        width: 100%;
                    }
                }
            }
        }
    }
</style>

