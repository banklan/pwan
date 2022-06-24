<template>
    <v-row justify="center" class="briefs">
        <v-col cols="12" md="4">
            <v-card dark raised elevation="18" min-height="200" class="online_sub" shaped :to="{name: 'AdminSubscriptionList'}">
                <v-card-title class="justify-center model">Online Subscriptions</v-card-title>
                <v-card-text class="val">
                    {{ subsCount }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="4">
            <v-card dark raised elevation="20" min-height="200" class="events_count" shaped :to="{name: 'StaffEventsList'}">
                <v-card-title class="justify-center model">Events</v-card-title>
                <v-card-text class="val">{{ eventsCount }}</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="4">
            <v-card dark raised elevation="18" min-height="200" class="news_count" shaped :to="{name: 'StaffNewsList'}">
                <v-card-title class="justify-center model">News</v-card-title>
                <v-card-text class="val">{{ newsCount }}</v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    // props: ['isLoading'],
    data() {
        return {
            isLoading: false,
            subsCount: null,
            eventsCount: null,
            newsCount: null,
        }
    },
    computed: {
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
    },
    methods: {
        getSubsCount(){
            this.isLoading = true
            axios.get(this.api + '/auth-admin/get_subs_count', this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.subsCount = res.data
            })
        },
        getEventsCount(){
            axios.get(this.api + '/auth-admin/get_events_count', this.adminHeaders)
            .then((res) => {
                this.eventsCount = res.data
            })
        },
        getNewsCount(){
            axios.get(this.api + '/auth-admin/get_news_count', this.adminHeaders)
            .then((res) => {
                this.newsCount = res.data
            })
        }
    },
    mounted() {
        this.getSubsCount()
        this.getEventsCount()
        this.getNewsCount()
    },
}
</script>
