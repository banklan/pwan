<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <v-card light raised outlined elevation="4" min-height="150">
                        <v-card-title class="primary white--text justify-center subtile-1">Update Video Roll</v-card-title>
                        <v-card-text class="mt-5" v-if="video">
                            <v-text-field label="Video Title" v-model="title" counter="450" required v-validate="'required|min:5|max:450'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-8 mt-n5" v-if="video && isAuthor">
                            <v-btn text @click="cancel" color="red darken-2" width="40%" large>Cancel</v-btn>
                            <v-btn dark color="primary" @click="update" :loading="isBusy" width="40%" large>Update</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-col>
        </v-row>
        <v-snackbar v-model="updateFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the video roll. Please try again later.
          <v-btn text color="white--text" @click="updateFailed = false">Close</v-btn>
        </v-snackbar>

    </v-container>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            isLoading: false,
            isBusy: false,
            confirmDelDial: false,
            updateFailed: false,
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
        isAuthor(){
            if(this.video && this.video.user_id == this.authUser.id){
                return true
            }else{
                return false
            }
        },
    },
    methods: {
        getVideo(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_video/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.title = res.data.title
            })
        },
        cancel(){
            this.title = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
        },
        update(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid && this.file !== '') {
                    this.isBusy = true
                    axios.post(this.api + `/auth/update_video/${this.$route.params.id}`, {
                        title: this.title
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        this.$store.commit('videoRollUpdated')
                        this.$router.push({name: 'StaffVideoRollDetail', params:{id: res.data.id}})
                    }).catch(() => {
                        this.isBusy = false
                        this.updateFailed = true
                    })
                }
            })
        }
    },
    mounted() {
        this.getVideo()
    },
}
</script>

<style lang="scss" scoped>

</style>

