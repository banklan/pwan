<template>
    <v-container>
        <v-row justify="center" class="mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminTestimonialList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Testimonial Detail</v-card-title>
                    <v-card-text class="mt-8">
                        <template v-if="testimonial">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%" style="border-top: none">Title</th>
                                        <td style="border-top: none">{{ testimonial.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Client Name:</th>
                                        <td>{{ testimonial.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Client Occupation:</th>
                                        <td>{{ testimonial.occupation }}</td>
                                    </tr>
                                    <tr>
                                        <th>Client Organization:</th>
                                        <td>{{ testimonial.organization }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ testimonial.user && testimonial.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Feature Status:</th>
                                        <td>{{ testimonial.is_featured ? 'Featured' : 'Not Featured' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail</th>
                                        <td>{{ testimonial.detail }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td >{{ testimonial.published }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated</th>
                                        <td >{{ testimonial.updated_at | moment('DD/MM/YYYY, H:ma')  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <v-alert type="warning" border="left" v-else>
                            The testimonial you are trying to view is not available. Please pick a testimonial from the list on the testimonials list page.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8 mt-n5" v-if="testimonial">
                        <v-btn icon color="primary" class="mx-7" :to="{name: 'AdminUpdateTestimonial', params:{id: testimonial.id}}"><i class="uil uil-edit"></i></v-btn>
                        <v-btn icon color="red darken-2" class="mx-7"><i class="uil uil-trash-alt" @click="confirmDelDial = true"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400">
                    <v-img v-if="testimonial && testimonial.picture" :src="`/images/testimonials/${testimonial.picture}`" min-height="150" contain aspect-ratio="1" transition="scale-transition"></v-img>
                    <v-img v-else src="/images/assets/no-image.png" height="250" transition="scale-transition"></v-img>
                    <template v-if="!previewImg">
                        <v-card-actions class="justify-space-around mt-5 pb-6">
                            <v-btn test dark color="admin_a" @click="openUpload">Replace</v-btn>
                            <input type="file" ref="image" style="display:none" @change.prevent="pickImg" accept="image/*">
                            <v-btn v-if="testimonial && testimonial.picture" icon color="red darken-2" @click="confirmPicDelDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                        </v-card-actions>
                    </template>
                    <template v-else>
                        <v-card-text>
                            <v-img :src="previewImgUrl" height="150" contain alt="service photo" aspect-ratio="1"></v-img>
                            <v-card-actions class="justify-center mt-4 ml-n3">
                                <v-btn dark color="primary" @click="uploadImg" :loading="isUpdating">Upload Image</v-btn>
                                <v-btn text small @click="removeImg"><i class="uil uil-trash-alt"></i></v-btn>
                            </v-card-actions>
                        </v-card-text>
                    </template>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450" v-if="testimonial">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this testimonial?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delTestimonial">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="confirmPicDelDial" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Delete this testimonial picture?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmPicDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteTestPic">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="adminUpdatedTestimonial" :timeout="4000" top dark color="green darken-2">
            This testimonial has been updated successfully.
            <v-btn text color="white--text" @click="adminUpdatedTestimonial = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="picDeleted" :timeout="4000" top dark color="green darken-2">
            The testimonial picture was deleted successfully.
            <v-btn text color="white--text" @click="picDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="picUpdated" :timeout="4000" top dark color="green darken-2">
            The testimonial picture was updated successfully.
            <v-btn text color="white--text" @click="picUpdated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="picUpdateFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the testimonial picture. Please upload a valid picture image and try again.
            <v-btn text color="white--text" @click="picUpdateFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            testimonial: null,
            isLoading: false,
            isBusy: false,
            confirmDelDial: false,
            isFeaturing: false,
            confirmDelFileDial: false,
            confirmPicDelDial: false,
            isDeleting: false,
            picDeleted: false,
            previewImg: false,
            image: '',
            previewImgUrl: null,
            isUpdating: false,
            picUpdated: false,
            picUpdateFailed: false,
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
        adminUpdatedTestimonial(){
            return this.$store.getters.adminUpdatedTestimonial
        },
    },
    methods: {
        getTestimonial(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_testimonial/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.testimonial = res.data
                console.log(res.data)
            })
        },
        delTestimonial(){
            axios.post(this.api + `/auth-admin/delete_testimonial/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.confirmDelDial = false
                this.$store.commit('adminDeletedTestimonial')
                this.$router.push({name: 'AdminTestimonialList'})
                console.log(res.data)
            })
        },
        deleteTestPic(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/del_testimonial_pic/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isDeleting = false
                this.picDeleted = true
                this.confirmPicDelDial = false
                this.testimonial.picture = ''
            })
        },
        openUpload(){
            this.$refs.image.click()
        },
        pickImg(e){
            const file = e.target.files[0]
            this.image = file
            this.previewImg = true
            this.previewImgUrl = URL.createObjectURL(file)
        },
        removeImg(){
            this.image = null
            this.previewImg = false
            this.previewImgUrl = ''
        },
        uploadImg(){
            if(this.image !== ''){
                this.isUpdating = true
                let form = new FormData();
                form.append('image', this.image)

                axios.post(this.api + `/auth-admin/update_testimonial_pic/${this.$route.params.id}`, form, this.adminHeaders)
                .then((res) => {
                    this.isUpdating = false
                    this.testimonial.picture = res.data
                    this.picUpdated = true
                    this.removeImg()
                }).catch(() => {
                    this.isUpdating = false
                    this.picUpdateFailed = true
                })
            }
        }
    },
    mounted() {
        this.getTestimonial()
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
    .v-card.scroll{
        overflow-x: scroll !important;
    }
</style>

