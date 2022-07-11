<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create News Post</v-card-title>
                    <v-card-text class="pl-5 mt-6">
                        <v-text-field label="Title" v-model="post.title" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <v-textarea label="Detail" rows="2" auto-grow v-model="post.detail" v-validate="'required|min:10|max:900'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                    </v-card-text>
                    <v-card-text>
                        <div class="subtitle-1 grey_text--text px-2">Upload Post File (Image or video)</div>
                        <v-alert type="info" class="mt-3">
                            Please note that you must post pictures or videos for your news post. Only files/images/videos of type JPEG, JPG, PNG, PDF, GIF, MP4(video) can be uploaded.
                        </v-alert>
                        <template v-if="!previewUpload">
                            <v-card-actions class="justify-start mt-5 pb-6">
                                <v-btn test dark color="primary lighten-2" @click="openUpload">Pick File</v-btn>
                                <input type="file" ref="file" style="display:none" @change.prevent="pickFile" accept="image/video/mp4*">
                            </v-card-actions>
                        </template>
                        <template v-else>
                            <v-card-text class="text-center mt-n8 prev_wrap">
                                <div class="preview">
                                    <div v-if="fileType == 'img'" class="img_wrap">
                                        <v-img :src="prvUploadUrl" alt="file preview" height="100%"></v-img>
                                    </div>
                                    <template v-else>
                                        <div class="video_wrap">
                                            <video controls height="100%">
                                                <source :src="prvUploadUrl" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </template>
                                </div>
                                <span class="prev_action">
                                    <v-btn icon large @click="removeFile" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                                </span>
                            </v-card-text>
                        </template>
                    </v-card-text>
                    <v-card-actions v-if="readyToUpload" class="justify-center pb-8" :class="previewUpload ? 'mt-n5' : ''">
                        <v-btn dark outlined large color="red darken-1" width="40%" @click="clearForm">Cancel</v-btn>
                        <v-btn dark large color="primary" width="40%" @click="createPost" :loading="isBusy">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="createPostFaied" :timeout="8000" top dark color="red darken-2">
            There was an error while trying to create the post. Please ensure all the fields are validly filled and that the uploaded file is of one of these formats (jpeg, jpg, bmp, png, pdf, gif, mp4) and not more than 20MB in size.
            <v-btn text color="white--text" @click="createPostFaied = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            post: {
                title: '',
                detail: '',
            },
            file: '',
            isBusy: false,
            previewUpload: false,
            prvUploadUrl: '',
            valErrors: [],
            fileType: null,
            createPostFaied: false,
        }
    },
    computed: {
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
        readyToUpload(){
            if(this.file !== '' && this.post.title !== '' && this.post.detail !== ''){
                return true
            }else{
                return false
            }
        }
    },
    methods: {
        openUpload(){
            this.$refs.file.click()
        },
        pickFile(e){
            const file = e.target.files[0]
            const fileName = file.name
            const fileExt = fileName.split('.').pop();
            if(fileExt === 'mp4'){
                this.fileType = 'video'
            }else{
                this.fileType = 'img'
            }
            this.file = file
            this.previewUpload = true
            this.prvUploadUrl = URL.createObjectURL(file)
        },
        removeFile(){
            this.previewUpload = false
            this.fileType = ''
            this.prvUploadUrl = ''
            this.file = ''
        },
        clearForm(){
            this.prop.title = ''
            this.prop.detail = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
            this.valErrors = []
        },
        createPost(){
             this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    let form = new FormData();
                    form.append('file', this.file)
                    form.append('title', this.post.title)
                    form.append('detail', this.post.title)

                    axios.post(this.api + '/auth/create_news_post', form, this.authHeaders)
                    .then((res) =>{
                        this.isBusy = false
                        this.$router.push({name: 'StaffNewsPostDetail', params:{id:res.data.id}})
                        this.$store.commit('newPostCreated')
                        console.log(res.data)
                    }).catch(() => {
                        this.isBusy = false
                        this.createPostFaied = true
                    })
                }
             })
        }
    },
}
</script>


<style lang="scss" scoped>
    .prev_wrap{
        margin: 1rem auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 80%;
        padding-top: 2rem;
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

    .v-btn i.uil {
        font-size: 1.2rem !important;
    }
</style>
