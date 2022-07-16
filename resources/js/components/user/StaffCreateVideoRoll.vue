<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-alert type="info">
                    Use Video-rolls to show clients short videos of events or adverts. Kindly ensure that videos are less than 30mb and of format MP4 or MPEG.
                </v-alert>
                <v-card light raised elevation="6" min-height="250" class="mt-4 mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New Video-Roll</v-card-title>
                    <v-card-text class="mt-5 text-center">
                        <v-text-field label="Video Title" v-model="title" counter="450" required v-validate="'required|min:5|max:450'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <div class="upload">
                            <template v-if="!previewUpload">
                                <v-card-actions class="justify-space-around mt-5 pb-6">
                                    <v-btn dark color="primary lighten-2" @click="openUpload">Pick Video</v-btn>
                                    <input type="file" ref="video" style="display:none" @change.prevent="pickVideo" accept="video/*">
                                </v-card-actions>
                            </template>
                            <template v-else>
                                <v-card-text>
                                    <div class="preview">
                                        <video controls height="100%">
                                            <source :src="prvUploadUrl" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <v-btn icon large @click="removeFile" color="red darken-2"><i class="uil uil-times"></i></v-btn>
                                    </div>
                                </v-card-text>
                            </template>
                        </div>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-5" v-if="isReady">
                        <v-btn text @click="cancelUploads" color="red darken-2" width="40%" large>Cancel</v-btn>
                        <v-btn dark color="primary" @click="submit" :loading="isBusy" width="40%" large>Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="invalidFileType" :timeout="6000" top dark color="red darken-2">
            Invalid video type. You are only allowed to upload an MP$ video.
            <v-btn text color="white--text" @click="invalidFileType = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="maxSizeExceeded" :timeout="6000" top dark color="red darken-2">
            Maximum file size exceeded. Please upload a video of size less than 20mb.
            <v-btn text color="white--text" @click="maxSizeExceeded = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="createFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to create the video roll. Please ensure the video is of type MP4 or MPEG and that the size is less than 30mb.
          <v-btn text color="white--text" @click="createFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isBusy: false,
            title:  '',
            createFailed: false,
            prvUploadUrl: '',
            previewUpload: false,
            file: '',
            maxSizeExceeded: '',
            invalidFileType: ''
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
        isReady(){
            if(this.title.trim() !== '' && this.file !== ''){
                return true
            }
        }
    },
    methods: {
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
            this.previewUpload = false
            this.file = ''
            this.previewUpload = false
        },
        cancelUploads(){
            this.removeFile()
            this.title = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
        },
        submit(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid && this.file !== '') {
                    this.isBusy = true
                     let form = new FormData();
                     form.append('video', this.file)
                     form.append('title', this.title)
                    axios.post(this.api + '/auth/create_video_roll', form, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('newVideoRollCreated')
                        this.$router.push({name: 'StaffVideoRollDetail', params:{id: res.data.id}})
                    }).catch(() => {
                        this.isBusy = false
                        this.createFailed = true
                    })
                }
            })
        }
    },
}
</script>

<style lang="scss" scoped>
.v-card{
    .upload{
        overflow: hidden;
        .preview{
            width: 80%;
            // height: 15rem;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            align-items: center;

            video{
                width: 15rem;
                height: 15rem;
            }
            .v-btn{
                i{
                    font-size: 1.3rem !important;
                }
            }
        }
        @media screen and (max-width: 722px) {
            .preview{
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
        }
    }
}
</style>
