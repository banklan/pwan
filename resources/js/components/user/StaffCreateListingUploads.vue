<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New Listing - Upload Files</v-card-title>
                    <v-card-text class="mt-5">
                        <v-alert type="info" class="mt-3">
                            Only files/images of type JPEG, JPG, PNG, PDF and GIF can be uploaded.
                        </v-alert>
                        <template v-if="!previewUploads">
                            <v-card-actions class="justify-space-around mt-5 pb-6">
                                <v-btn test dark color="primary lighten-2" @click="openUpload">Pick File(s)</v-btn>
                                <input type="file" multiple ref="files" style="display:none" @change.prevent="pickImg" accept="image/*">
                            </v-card-actions>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-card-actions v-if="filesPicked" class="grey_text--text justify-center mb-3 mx-3 font-weight-bold">
                                    **{{ uploads.length }} files have been picked for upload.**
                                </v-card-actions>
                                <v-card-actions class="justify-center mt-4 ml-n3">
                                    <v-btn dark color="primary" @click="uploadFiles" :loading="isBusy">Upload files</v-btn>
                                    <v-btn text @click="cancelUploads" color="red darken-2"><i class="uil uil-trash-alt"></i></v-btn>
                                </v-card-actions>
                            </v-card-text>
                        </template>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="maxExceeded" :timeout="6000" top color="red darken-1 white--text">
            You have exceeded your maximum allowable upload limit. You are only allowed to upload a maximum of 5 files per listing.
            <v-btn text color="white--text" @click="maxExceeded = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isBusy: false,
            previewUploads: false,
            previewImgUrl: null,
            files: [],
            previewUploads: false,
            uploads: [],
            filesPicked: false,
            maxExceeded: false,
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
        newPropListing(){
            return this.$store.getters.newPropListing
        },
        listingFilesUploaded(){
            return this.$store.getters.listingFilesUploaded
        }
    },
    methods: {
        openUpload(){
            this.$refs.files.click()
        },
        pickImg(e){
            const files = e.target.files
            if(!files){
                return false
            }
            this.previewUploads = true
            let filesCount = this.files.length
            let uploadAble = parseInt(5 - filesCount)
            if(files.length <= uploadAble){
                for(let i=0; i<files.length; i++){
                    this.uploads.push(files[i])
                }
                this.filesPicked = true
            }else{
                 this.maxExceeded = true
                 this.previewUploads = false
            }
        },
        cancelUploads(){
            this.previewUploads = false
            this.uploads = []
        },
        resetUpload(){
            this.uploads = []
            this.$refs.files.value = ''
        },
        uploadFiles(){
           this.isBusy = true
            let form = new FormData();
            let self = this
            for(let i=0; i<this.uploads.length; i++){
                let file = self.uploads[i]
                form.append('files[' + i + ']', file)
            }

            // let id = this.newPropListing.id
            let listing = JSON.parse(window.localStorage.getItem('new_prop'))
            let id = listing.id
            // console.log(id)
            axios.post(this.api + `/auth/upload_listing_files/${id}`, form, this.authHeaders)
            .then((res)=>{
                this.isBusy = false
                this.$store.commit('listingFilesUploaded')
                this.$store.commit('newListingCleared')
                this.$router.push({name: 'StaffPropertyDetail', params: {id: id}})
            }).catch((err) => {
                this.isLoading = false
            })
        }
    }
}
</script>
