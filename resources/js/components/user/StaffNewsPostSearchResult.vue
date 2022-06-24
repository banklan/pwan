<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffNewsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <staff-search model="NewsPost" searchFor="news posts"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ posts.length | pluralize('post')}}.
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="posts.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> News Posts <v-chip color="primary lighten-2" class="ml-1" v-if="posts.length > 0">{{ posts.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Created By</th>
                                            <th>Apprvl Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="news_list">
                                        <tr v-for="post in posts" :key="post.id" :class="!post.is_approved ? 'warning--text' : ''">
                                            <td @click="showPost(post.id)">{{ post.published }}</td>
                                            <td @click="showPost(post.id)" class="text-truncate">{{ post.title }}</td>
                                            <td @click="showPost(post.id)">{{ post.user && post.user.fullname }}</td>
                                            <td>{{ post.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no posts.
                                </v-alert>
                            </v-card-text>
                        </template>
                    </v-card>
                </template>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            posts: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.posts = newVal
                this.getResult()
            },
            immediate: true
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
    },
    methods: {
        getResult(){
            this.isLoading = true
            axios.post(this.api + '/auth/search_for_news_posts', {
                q: this.$route.query.q
            }, this.authHeaders).then((res)=>{
                this.isLoading = false
                this.posts = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showPost(post){
            this.$router.push({name: 'StaffNewsPostDetail', params:{id: post}})
        }
    },
    created() {
        this.getResult()
    },
}
</script>

<style lang="css" scoped>
    table tbody tr{
        cursor: pointer;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    table tbody tr td{
        white-space: nowrap;
    }
    .table .news_list tr td{
        vertical-align: middle !important;
    }
</style>
