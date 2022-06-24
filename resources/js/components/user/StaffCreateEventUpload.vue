<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-card light raised elevation="6" min-height="200" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Upload Pictures Of Events</v-card-title>
                    <v-card-text class="mt-5">
                        <v-alert type="info" class="mt-3">
                            You are required to upload at least a picture (maximum of 10 pictures) for every event created. Only files/pictures of type JPEG, JPG, PNG, PDF and GIF can be uploaded.
                        </v-alert>
                        <template v-if="!previewUploads">
                            <v-card-actions class="justify-space-around mt-5 pb-6">
                                <v-btn test dark color="primary lighten-2" @click="openUpload">Pick File(s)</v-btn>
                                <input type="file" multiple ref="images" style="display:none" @change.prevent="pickImg" accept="image/*">
                            </v-card-actions>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <div class="preview">
                                    <div v-for="(prev, i) in prevs" :key="prev" class="prev_wrap">
                                        <img :src="prev" alt="preview">
                                        <v-btn color="red darken-2" icon @click="remove(i)"><i class="uil uil-times"></i></v-btn>
                                    </div>
                                </div>
                                <v-card-actions class="justify-center mt-5 ml-n3" v-if="uploads.length > 0">
                                    <v-btn dark color="primary" @click="uploadFiles" :loading="isBusy" width="40%">Upload files</v-btn>
                                    <v-btn text @click="cancelUploads" color="red darken-2" width="40%">Cancel</v-btn>
                                </v-card-actions>
                            </v-card-text>
                        </template>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="maxExceeded" :timeout="6000" top dark color="red darken-2">
            You have exceeded the maximum number of {{ max }} files for the new event. Please upload less files.
            <v-btn text color="white--text" @click="maxExceeded = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="uploadFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to upload the pictures. Please ensure that the files are of an accepted format before trying again.
            <v-btn text color="white--text" @click="uploadFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
import { store } from '../../store';

export default {
    data() {
        return {
            previewUploads: false,
            files: [],
            uploads: [],
            prevs: [],
            filesPicked: false,
            maxExceeded: false,
            isBusy: false,
            max: 10,
            uploadFailed: false,
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
    },
    beforeRouteEnter (to, from, next) {
        if(store.getters.newEvent){
            next()
        }else{
            next('/staff/events/create-new')
        }
    },
    methods: {
        openUpload(){
            this.$refs.images.click()
        },
        pickImg(e){
            const files = e.target.files
            if(!files){
                return false
            }
            this.previewUploads = true
            let filesCount = this.files.length
            if(files.length <= this.max){
                for(let i=0; i<files.length; i++){
                    let prev = URL.createObjectURL(files[i])
                    this.uploads.push(files[i])
                    this.prevs.push(prev)
                }
                this.filesPicked = true
            }else{
                 this.maxExceeded = true
                 this.previewUploads = false
            }
        },
        remove(i){
            this.uploads.splice(i, 1)
            if(this.uploads.length < 1){
                this.previewUploads = false
            }
        },
        cancelUploads(){
            this.previewUploads = false
            this.uploads = []
            this.prevs = []
        },
        uploadFiles(){
            this.isBusy = true
            let form = new FormData();
            let self = this
            for(let i=0; i<this.uploads.length; i++){
                let file = self.uploads[i]
                form.append('files[' + i + ']', file)
            }
            // console.log(form)
            let id = this.$route.params.id
            axios.post(this.api + `/auth/upload_event_files/${id}`, form, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.uploads = []
                this.$store.commit('eventCreated', id)
                this.$router.push({name: 'StaffEventDetail', params: {id: id}})
            })
            .catch((e) => {
                this.isBusy = false
                this.uploadFailed = true
                // console.log(e)
            })
        }
    },
}
</script>

<style lang="scss" scoped>
    .preview{
        box-sizing: border-box;
        margin: 0 auto;
        padding: 15px 20px;
        width: 80%;
        display: block;

        .prev_wrap{
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 10rem;
            overflow: hidden;

            img{
                height: 8rem;
                width: 8rem;
            }
        }
    }
</style>
