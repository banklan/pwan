<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <v-card light raised elevation="6" min-height="200" class="mx-auto pb-5">
                        <v-card-title class="justify-center subtitle-1 primary white--text">Create News Post</v-card-title>
                        <v-card-text class="pl-5 mt-6">
                            <v-text-field label="Title" v-model="post.title" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                            <v-textarea label="Detail" rows="2" auto-grow v-model="post.detail" v-validate="'required|min:10|max:1000'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-8 mt-3">
                            <v-btn dark outlined large color="red darken-1" width="40%" @click="clearForm">Cancel</v-btn>
                            <v-btn dark large color="primary" width="40%" @click="updatePost" :loading="isBusy">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-col>
        </v-row>
        <v-snackbar v-model="updatePostFaied" :timeout="4000" top dark color="red darken-2">
            There was an error while trying to update the post. Please ensure all the fileds are validly field while trying again.
            <v-btn text color="white--text" @click="updatePostFaied = false">Close</v-btn>
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
            isBusy: false,
            isLoading: false,
            updatePostFaied: false,
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
        clearForm(){
            this.prop.title = ''
            this.prop.detail = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
            this.valErrors = []
        },
        getPost(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_news_post/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.post = res.data
            })
        },
        updatePost(){
             this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true

                    axios.post(this.api + `/auth/update_news_post/${this.post.id}`, {
                        post: this.post
                    }, this.authHeaders)
                    .then((res) =>{
                        this.isBusy = false
                        this.$router.push({name: 'StaffNewsPostDetail', params:{id:res.data.id}})
                        this.$store.commit('newsPostUpdated')
                        console.log(res.data)
                    }).catch(() => {
                        this.isBusy = false
                        this.updatePostFaied = true
                    })
                }
             })
        }
    },
    created() {
        this.getPost()
    },
}
</script>


<style lang="scss" scoped>
    .v-btn i.uil {
        font-size: 1.2rem !important;
    }
</style>
