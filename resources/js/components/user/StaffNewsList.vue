<template>
    <v-container>
        <v-row justify="center" :class="$vuetify.breakpoint.smAndDown ? 'mr-8' : ''">
            <v-col cols="9" md="6">
                <staff-search model="NewsPost" searchFor="news"/>
            </v-col>
            <v-col cols="3" md="3" offset-md="2">
                <v-btn dark color="primary" :to="{name: 'StaffCreateNewsPost'}" :class="$vuetify.breakpoint.smAndDown ? 'ml-n4' : ''"><span><i class="uil uil-plus" left></i></span>New</v-btn>
            </v-col>
        </v-row>
        <v-row class="pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">News List <span v-if="news_posts.length > 0"><v-chip color="primary lighten-2 ml-2">{{ news_posts.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="news_posts.length > 0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Created By</th>
                                    <th>Apprvl Status</th>
                                </tr>
                            </thead>
                            <tbody class="news_list">
                                <tr v-for="post in news_posts" :key="post.id" :class="!post.is_approved ? 'warning--text' : ''">
                                    <td @click="showNews(post)">{{ post.published }}</td>
                                    <td @click="showNews(post)" class="text-truncate">{{ post.title }}</td>
                                    <td @click="showNews(post)">{{ post.user && post.user.fullname }}</td>
                                    <td>{{ post.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no news to display at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="news_posts.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getNews(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNews(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNews(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNews(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar :value="newsPostDeleted" :timeout="4000" top dark color="green darken-2">
            A news post was deleted successfully.
            <v-btn text color="white--text" @click="newsPostDeleted">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            news_posts: [],
            pagination: null,
            total: null,
            q: ''
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetStaffFlashMsg')
        next()
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
        newsPostDeleted(){
            return this.$store.getters.newsPostDeleted
        },
    },
    methods: {
        getNews(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth/get_paginated_news`
            axios.get(pag, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.news_posts = res.data.data
                this.total = res.data.total
                this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
            }).catch(() => {
                this.isLoading = false
            })
        },
        showNews(post){
            this.$router.push({name: 'StaffNewsPostDetail', params:{id: post.id}})
        },
    },
    mounted() {
        this.getNews()
    },
}
</script>

<style lang="css" scoped>
    .table .news_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .news_list tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>

