<template>
    <v-container>
        <v-row justify="center" class="">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminNewsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
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
                                        <td :class="!post.is_approved ? 'warning--text': 'green_text--text'">{{ post.is_approved ? 'Approved' : 'Not Approved' }}<span right class="ml-10 mr-1"><v-btn small text color="admin_a" @click="changeApproveDial = true">Change</v-btn></span></td>
                                    </tr>
                                    <tr>
                                        <th>Feature Status:</th>
                                        <td>{{ post.is_featured ? 'Featured' : 'Not Featured' }} <span right class="ml-10"><v-btn small text color="admin_c" @click="changeFeatureDial = true">Change</v-btn></span></td>
                                    </tr>
                                    <tr v-if="post.admin_id">
                                        <th>Approved By:</th>
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
                    <v-card-actions class="justify-center pb-8 mt-n5" v-if="post">
                        <v-btn icon color="primary" class="mx-7" :to="{name: 'AdminUpdateNewsPost', params:{id: post.id}}"><i class="uil uil-edit"></i></v-btn>
                        <v-btn icon color="red darken-2" class="mx-7"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card min-height="200" min-width="80%" class="mt-5" v-if="post">
                    <v-card-title class="justify-center primary subtitle-1 white--text">Post File</v-card-title>
                    <template v-if="post && post.file">
                        <template v-if="post.file.split('.').pop() === 'mp4'">
                            <video width="100%" height="100%" controls>
                                <source :src="`/images/news/${post.file}`" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                        <template v-else>
                            <v-img :src="`/images/news/${post.file}`" height="100%" transition="scale-transition"></v-img>
                        </template>
                        <v-card-actions class="justify-center px-5 mt-5 pb-6">
                            <v-btn v-if="post.file && !previewImg" large icon color="red darken-2" class="mx-5" @click="delFileConfDial = true">
                                <i class="uil uil-trash-alt"></i>
                            </v-btn>
                            <template v-if="!previewImg">
                                <v-btn test dark color="admin_a" @click="openUpload" class="mx-3">Update File</v-btn>
                                <input type="file" ref="image" style="display:none" @change.prevent="pickImg" accept="image/video*">
                            </template>
                            <v-card-text v-else class="text-center">
                                <v-img :src="previewImgUrl" height="150" contain alt="post photo" aspect-ratio="1"></v-img>
                                <v-card-actions class="justify-center mt-4 ml-n3">
                                    <v-btn dark color="primary" @click="uploadFile" :loading="isUpdating">Upload File</v-btn>
                                    <v-btn icon @click="removeImg" color="red darken-2"><i class="uil uil-trash-alt"></i></v-btn>
                                </v-card-actions>
                            </v-card-text>
                        </v-card-actions>
                    </template>
                    <template v-else>
                        <v-alert type="info" class="mt-5 mx-4">
                            There is no file for this post.
                        </v-alert>
                        <v-card-actions v-if="!previewImg" class="justify-center pb-5">
                             <v-btn test dark color="admin_a" @click="openUpload">Update File</v-btn>
                            <input type="file" ref="image" style="display:none" @change.prevent="pickImg" accept="image/*">
                        </v-card-actions>
                        <v-card-text v-else class="text-center">
                            <v-img :src="previewImgUrl" height="150" contain alt="post photo" aspect-ratio="1"></v-img>
                            <v-card-actions class="justify-center mt-4 ml-n3">
                                <v-btn dark color="primary" @click="uploadFile" :loading="isUpdating">Upload File</v-btn>
                                <v-btn icon @click="removeImg" color="red darken-2"><i class="uil uil-trash-alt"></i></v-btn>
                            </v-card-actions>
                        </v-card-text>
                    </template>
                </v-card>
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
        <v-dialog v-model="changeApproveDial" max-width="450" v-if="post">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to <span class="font-weight-bold"> &nbsp;{{ post.is_approved ? 'dis-approve' : 'approve' }} </span> &nbsp;this news post?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="changeApproveDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeApprove">Yes, {{ post.is_approved ? 'dis-approve' : 'approve' }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="changeFeatureDial" max-width="450" v-if="post">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to &nbsp;<span class="font-weight-bold">{{ post.is_featured ? 'un-feature' : 'feature' }} </span>&nbsp; this news post?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="changeFeatureDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="changeFeature">Yes, {{ post.is_featured ? 'un-feature' : 'feature' }}</v-btn>
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
        <v-snackbar v-model="postApprovalChanged" :timeout="4000" top dark color="green darken-2">
            This post has been {{ post && post.is_approved ? ' approved' : ' dis-approved' }}.
            <v-btn text color="white--text" @click="posttApprovalChanged = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="postFeatureChanged" :timeout="4000" top dark color="green darken-2">
            This post is now been {{ post && post.is_featured ? ' featured' : ' un-featured' }}.
            <v-btn text color="white--text" @click="postFeatureChanged = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminUpdatedNewsPost" :timeout="4000" top dark color="green darken-2">
            This post has been updated successfully.
            <v-btn text color="white--text" @click="adminUpdatedNewsPost = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="postFileDeleted" :timeout="4000" top dark color="green darken-2">
            This post file was deleted successfully.
            <v-btn text color="white--text" @click="postFileDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="fileDelFailed" :timeout="4000" top dark color="red darken-2">
            There was an error while trying to delete the post file. Please try again.
            <v-btn text color="white--text" @click="fileDelFailed = false">Close</v-btn>
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
            isFeaturing: false,
            isApproving: false,
            changeApproveDial: false,
            changeFeatureDial: false,
            postApprovalChanged: false,
            postFeatureChanged: false,
            delFileConfDial: false,
            postFileDeleted: false,
            fileDelFailed: false,
            previewImg: false,
            previewImgUrl: null,
            image: '',
            isUpdating: false,
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
        adminUpdatedNewsPost(){
            return this.$store.getters.adminUpdatedNewsPost
        },
    },
    methods: {
        getNewsPost(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_news_post/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.post = res.data
                // console.log(res.data)
            })
        },
        delPost(){
            axios.post(this.api + `/auth-admin/delete_news_post/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.confirmDelDial = false
                this.$store.commit('adminDeletedNewsPost')
                this.$router.push({name: 'AdminNewsList'})
                // console.log(res.data)
            })
        },
        changeFeature(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_news_post_feature/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.post.is_featured = res.data
                this.changeFeatureDial = false
                this.postFeatureChanged = true
            })
        },
        changeApprove(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/change_news_post_approval/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isBusy = false
                this.post.is_approved = res.data
                this.changeApproveDial = false
                this.postApprovalChanged = true
            })
        },
        delFile(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/del_post_file/${this.$route.params.id}`, {}, this.adminHeaders)
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
        openUpload(){
            this.$refs.image.click()
        },
        pickImg(e){
            const file = e.target.files[0]
            this.file = file
            this.previewImg = true
            this.previewImgUrl = URL.createObjectURL(file)
        },
        removeImg(){
            this.file = null
            this.previewImg = false
            this.previewImgUrl = ''
        },
        uploadFile(){
            if(this.file !== ''){
                this.isUpdating = true
                let form = new FormData();
                form.append('file', this.file)

                axios.post(this.api + `/auth-admin/update_news_post_file/${this.$route.params.id}`, form, this.adminHeaders)
                .then((res) => {
                    this.isUpdating = false
                    this.post.file = res.data
                    this.fileUpdated = true
                    this.removeImg()
                }).catch(() => {
                    this.isUpdating = false
                    this.fileUpdateFailed = true
                })
            }
        }
    },
    mounted() {
        this.getNewsPost()
        console.log('mounted now')
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

