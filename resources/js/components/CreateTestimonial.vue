<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-alert type="info">
                    Are you impressed about our services? Kindly take a minute to drop a short testimonial. We will appreciate it!
                </v-alert>
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Write Neww Testimonial</v-card-title>
                    <v-card-text class="mt-5 ml-3">
                        <v-text-field label="Fullname" v-model="testimonial.fullname" hint="Your Surname and given name" required v-validate="'required|min:4|max:200'" :error-messages="errors.collect('fullname')" name="fullname"></v-text-field>
                        <v-text-field label="Occupation" v-model="testimonial.occupation" hint="What kind of job do you do?" required v-validate="'required|min:3|max:60'" :error-messages="errors.collect('occupation')" name="occupation"></v-text-field>
                        <v-text-field label="Organization" v-model="testimonial.organization" hint="What organization/company do you work for?" required v-validate="'required|min:3|max:250'" :error-messages="errors.collect('organization')" name="organization"></v-text-field>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field label="Phone No" v-model="testimonial.phone" required v-validate="'required|max:16'" :error-messages="errors.collect('phone')" name="phone"></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field label="Email" v-model="testimonial.email" v-validate="'email'" :error-messages="errors.collect('email')" name="email"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-text-field label="Title" v-model="testimonial.title" hint="Title of your testimonial" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <v-textarea label="Detail" rows="2" auto-grow v-model="testimonial.detail" hint="Your testimonial" required v-validate="'required|min:10|max:600'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                    </v-card-text>
                    <v-card-text class="text-center">
                        <v-alert type="info">Kindly upload a picture of you.</v-alert>
                        <template v-if="!previewUpload">
                            <v-card-actions class="justify-center mt-5 pb-6">
                                <v-btn test dark color="primary lighten-2" @click="openUpload">Pick Picture</v-btn>
                                <input type="file" ref="image" style="display:none" @change.prevent="pickImg" accept="image/*">
                            </v-card-actions>
                        </template>
                        <template v-else>
                            <div class="text-center subtitle-1 grey_text--text">Preview Upload</div>
                            <div class="prev_wrap">
                                <div class="pic">
                                    <img :src="previewUploadUrl" alt="preview picture">
                                </div>
                                <div class="action_icon">
                                    <v-btn large icon color="red darken-2" @click="removeFile"><i class="uil uil-times"></i></v-btn>
                                </div>
                            </div>
                        </template>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6">
                        <v-btn large text color="red darken-2" width="40%">Cancel</v-btn>
                        <v-btn large dark color="primary" width="40%" :loading="isBusy" @click="submit">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            testimonial: {

            },
            isBusy: false,
            previewUpload: false,
            previewUploadUrl: '',
            image: ''
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        },
    },
    methods: {
        openUpload(){
            this.$refs.image.click()
        },
        pickImg(e){
            const file = e.target.files[0]
            this.image = file
            this.previewUpload = true
            this.previewUploadUrl = URL.createObjectURL(file)
        },
        removeFile(){
            this.image = null
            this.previewUpload = false
            this.previewUploadUrl = ''
            this.image = ''
        },
        submit(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    let form = new FormData();
                    form.append('image', this.image)
                    form.append('fullname', this.testimonial.fullname)
                    form.append('organization', this.testimonial.organization)
                    form.append('occupation', this.testimonial.occupation)
                    form.append('phone', this.testimonial.phone)
                    form.append('email', this.testimonial.email)
                    form.append('title', this.testimonial.title)
                    form.append('detail', this.testimonial.detail)
                    // form.append('fullname', this.test.fullname)

                    axios.post(this.api + '/post_testimonial', form).then((res) =>{
                        this.isBusy = false
                        this.$router.push({name: 'TestimonialSent'})
                        this.$store.commit('testimonialSent')

                        console.log(this.test)
                    }).catch(() => {
                        this.isBusy = false
                    })
                }
            })
        }
    },
}
</script>

<style lang="scss" scoped>
    .prev_wrap{
        margin: 2rem auto;
        width: 60%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        // mar

        .pic{
            width: 10rem;
            aspect-ratio: 1/1;
            overflow: hidden;

            img{
                height: 100%;
            }
        }
        .action_icon{
            .v-btn i{
                font-size: 1.4rem !important;
            }
        }
    }

</style>
