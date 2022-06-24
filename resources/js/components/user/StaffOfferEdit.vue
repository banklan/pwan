<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <v-card elevation="4" raised min-height="200" class="mx-auto">
                        <v-card-title class="justify-center subtitle-1 primary white--text">Update New Offer Title</v-card-title>
                        <v-card-text class="mt-8" v-if="offer">
                            <v-text-field label="Title" v-model="offer.title" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-8">
                            <v-btn large color="primary" width="40%" dark :loading="isBusy" @click="updateOfferTitle">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                    <v-card elevation="4" raised min-height="200" class="mx-auto mt-5">
                        <v-card-title class="justify-center subtitle-1 primary white--text">Replace New Offer Flier</v-card-title>
                        <v-card-text class="mt-5">
                            <div class="text-center wrap">
                                <div class="img" v-if="offer.flier">
                                    <img  :src="`/images/offers/${offer.flier}`">
                                </div>
                                <div v-else>
                                    <v-alert type="warning" border="left">
                                        The flier/file of this offer has been removed. Kindly upload a replacement.
                                    </v-alert>
                                </div>
                                <div class="btn">
                                    <template v-if="offer.flier">
                                        <v-btn icon color="red darken-2" @click="removeFile"><i class="uil uil-trash-alt"></i></v-btn>
                                    </template>
                                    <template v-else>
                                        <template v-if="!previewUpload">
                                            <v-card-actions class="justify-center mt-2 pb-6 text-center">
                                                <v-btn dark color="primary" @click="openUpload">Pick Flier</v-btn>
                                                <input type="file" ref="file" style="display:none" @change.prevent="pickFile" accept="image/*">
                                            </v-card-actions>
                                        </template>
                                        <template v-else>
                                            <v-card-text class="text-center prev_wrap">
                                                <div class="preview">
                                                    <img :src="prvUploadUrl" alt="file preview">
                                                    <v-btn large icon color="red darken-2" @click="delFile"><i class="uil uil-times"></i></v-btn>
                                                </div>
                                            </v-card-text>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-6 mt-n5" v-if="showSubmitBtn">
                            <v-btn large color="primary" width="40%" dark :loading="isUploading" @click="updateOfferFlier">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-col>
        </v-row>
        <v-snackbar v-model="newOfferUpdateFailed" :timeout="6000" top dark color="red darken-2">
            There was an erro while trying to update the new offer. Please ensure all fields are filled validly before trying again.
            <v-btn text color="white--text" @click="newOfferUpdateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            offer: {
                title: '',
                flier: ''
            },
            isLoading: false,
            previewUpload: false,
            prvUploadUrl: '',
            showSubmitBtn: false,
            isBusy: false,
            file: '',
            newOfferUpdateFailed: false,
            isUploading: false,
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
    methods: {
        getOffer(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_new_offer/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.offer = res.data
                this.file = res.data.flier
            })
        },
        removeFile(){
            axios.post(this.api + `/auth/delete_offer_file/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                // console.log(res.data)
                this.offer.flier = ''
                this.showSubmitBtn = false
            })
        },
        openUpload(){
            this.$refs.file.click()
        },
        pickFile(e){
            const file = e.target.files[0]
            this.file = file
            this.previewUpload = true
            this.prvUploadUrl = URL.createObjectURL(file)
            this.showSubmitBtn = true
        },
        delFile(){
            this.previewUpload = false
            this.prvUploadUrl = ''
            this.file = ''
            this.showSubmitBtn = false
        },
        updateOfferTitle(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    axios.post(this.api + `/auth/update_offer_title/${this.$route.params.id}`, {
                        title: this.offer.title
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('newOfferUpdated')
                        this.$router.push({name:'StaffNewOfferDetail', params: {id: res.data.id}})
                        // console.log(res.data)
                    }).catch(() =>{
                        this.isBusy = false
                        this.newOfferUpdateFailed = true
                    })
                }
            })
        },
        updateOfferFlier(){
            this.isUploading = true
            let form = new FormData();
            form.append('file', this.file)

            axios.post(this.api + `/auth/update_new_offer_flier/${this.$route.params.id}`, form, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.$store.commit('newOfferUpdated')
                this.$router.push({name:'StaffNewOfferDetail', params: {id: res.data.id}})
                // console.log(res.data)
            }).catch(() => {
                this.isBusy = false
                this.newOfferCreateFailed = true
            })
        },
    },
    mounted() {
        this.getOffer()
    },
}
</script>

<style lang="scss" scoped>
.wrap{
    padding-top: 2rem;
    margin: 0 auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    .img{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 25rem;
        width: 25rem;
        overflow: hidden;
        text-align: center;

        img{
            height: 100%;
            margin: 0 auto;
        }
    }
    .btn{
        margin: 1rem auto;
    }

    .prev_wrap{
        margin: 0 auto;
        text-align: center;
        padding: 1rem;
        width: 100%;

        .preview{
            width: 100%;
            text-align: center;
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 5rem;
            margin: 0 auto;
            box-sizing: border-box;
            overflow: hidden;
            padding-bottom: 1rem;

            img{
                height: 12rem;
                width: 10rem;
                border: 1px solid #fff;
            }

            .v-btn{
                i{
                    font-size: 1.1rem !important;
                }
            }
        }

        @media screen and (max-width: 700px){
            .preview{
                width: 100%;
                 img{
                    height: 10rem;
                    width: 8rem;
                 }
            }
        }
    }
    .v-btn i{
        font-size: 1.2rem;
    }
}
</style>
