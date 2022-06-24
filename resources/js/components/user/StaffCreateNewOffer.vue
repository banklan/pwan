<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffNewOffers'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-card raised elevation="6" light min-height="200" class="mx-auto">
                    <v-card-title class="justify-center primary white--text subtitle-1">Create New Offer</v-card-title>
                    <v-card-text class="mt-5 ml-3">
                        <v-text-field label="Title" v-model="title" hint="Title of Offer" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                    </v-card-text>
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
                                <v-btn large icon color="red darken-2" @click="removeFile"><i class="uil uil-times"></i></v-btn>
                            </div>
                            <v-card-actions class="justify-center mt-4 pb-7" v-if="showSubmitBtn">
                                <v-btn text color="red darken-2" width="40%" @click="cancelUpload">Cancel</v-btn>
                                <v-btn large color="primary" width="40%" dark :loading="isBusy" @click="saveOffer">Submit</v-btn>
                            </v-card-actions>
                        </v-card-text>
                    </template>
                </v-card>
            </v-col>
        </v-row>
         <v-snackbar v-model="newOfferCreateFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to create the new offer. Please ensure all the fields are validly filled and that the uploaded file is of one of these formats (jpeg, jpg, bmp, png, pdf, gif).
            <v-btn text color="white--text" @click="newOfferCreateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            file: '',
            previewUpload: false,
            prvUploadUrl: '',
            showSubmitBtn: false,
            isBusy: false,
            newOfferCreateFailed: false,
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
        removeFile(){
            this.previewUpload = false
            this.prvUploadUrl = ''
            this.file = ''
            this.showSubmitBtn = false
        },
        cancelUpload(){
            this.title = ''
            this.file = ''
            this.previewUpload = false
            this.prvUploadUrl = ''
        },
        saveOffer(){
             this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    let form = new FormData();
                    form.append('file', this.file)
                    form.append('title', this.title)

                    axios.post(this.api + '/auth/create_new_offer', form, this.authHeaders)
                    .then((res) => {
                        this.isBusy = false
                        this.$store.commit('newOfferCreated')
                        this.$router.push({name:'StaffNewOffers'})
                        // console.log(res.data)
                    }).catch(() => {
                        this.isBusy = false
                        this.newOfferCreateFailed = true
                    })
                }
             })
        }
    }
}
</script>

<style lang="scss" scoped>
    .prev_wrap{
        margin: 0 auto;
        text-align: center;
        padding: 1rem;
        width: 100%;

        .preview{
            width: 50%;
            text-align: center;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 0 auto;
            box-sizing: border-box;
            overflow: hidden;
            padding-bottom: 1rem;

            img{
                height: 12rem;
                width: 12rem;
                border: 1px solid #fff;
            }
        }

        @media screen and (max-width: 700px){
            .preview{
                width: 100%;
                 img{
                    height: 10rem;
                    width: 10rem;
                 }
            }
        }
    }
    .v-btn i{
        font-size: 1.2rem;
    }
</style>
