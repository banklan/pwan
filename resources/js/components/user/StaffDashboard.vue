<template>
    <v-container>
        <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <v-row justify="center" class="briefs" v-else>
            <v-col cols="12" md="4">
                <v-card dark raised elevation="18" min-height="200" class="online_sub" shaped :to="{name: 'StaffSubscriptionsList'}">
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
        <v-row justify="center" class="listings">
            <v-col cols="12" md="6">
                <v-card light raised elevation="18" min-height="200" class="my-5 mx-5 mx-auto">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Latest Listings</v-card-title>
                    <v-card-text class="">
                        <table class="table table-condensed" v-if="listings.length > 0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in listings.slice(0, 4)" :key="list.id">
                                    <td>{{ list.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td>{{ list.name }}</td>
                                    <td>{{ list.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert type="info" class="mt-5" v-else>
                            There are no properties listed in the database at the moment.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card light raised elevation="18" min-height="200" class="my-5 mx-5 mx-auto">
                    <v-card-title class="justify-center subtitle-1 primary white--text"> Listings Stats</v-card-title>
                    <v-card-text class="val">
                        <table class="table">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <th>No Of Listings:</th>
                                    <td>{{ listings.length }}</td>
                                </tr>
                                <tr>
                                    <th>Approved:</th>
                                    <td>{{ listings_apprvd }}</td>
                                </tr>
                                <tr>
                                    <th>Not Approved:</th>
                                    <td>{{ listings_not_apprvd }}</td>
                                </tr>
                                <tr>
                                    <th>Featured:</th>
                                    <td>{{ listings_featured }}</td>
                                </tr>
                                <tr>
                                    <th>My Listings:</th>
                                    <td>{{ my_listing }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <v-row justify="center" class="charts" v-else>
            <v-col cols="12" md="6">
                <v-card light raised elevation="18" min-height="250" class="my-5 mx-5 mx-auto">
                    <v-card-title class="justify-center subtitle-1 secondary--text">Subscriptions in previous weeks</v-card-title>
                    <v-card-text>
                        <subs-line-chart v-if="subscriptionsChartLoaded" :chart-data="subTotals" :chart-labels="subLabels" />
                        <template v-else>
                            <v-alert type="info" class="mt-5">
                                There are no subscriptions data to view at the moment.
                            </v-alert>
                        </template>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <v-card light raised elevation="18" min-height="250" class="my-5 mx-5">
                    <v-card-title class="justify-center subtitle-1 secondary--text">Subscriptions in previous weeks</v-card-title>
                    <v-card-text>
                        <subs-doughnut-chart v-if="subscriptionsChartLoaded" :chart-data="subTotals" :chart-labels="subLabels" />
                        <template v-else>
                            <v-alert type="info" class="mt-5">
                                There are no subscriptions data to view at the moment.
                            </v-alert>
                        </template>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SubscriptionsLineChart from '../charts/SubscriptionsLineChart'
import SubDoughnutChart from '../charts/SubDoughnutChart'

export default {
    data() {
        return {
            isLoading: false,
            subscriptionsChartLoaded: false,
            subTotals: [],
            subLabels: [],
            listings: [],
            subsCount: null,
            eventsCount: null,
            newsCount: null,
            listings_apprvd: null,
            listings_not_apprvd: null,
            listings_featured: null,
            my_listing: null,
        }
    },
    components: {
        'subs-line-chart': SubscriptionsLineChart,
        'subs-doughnut-chart': SubDoughnutChart,
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
        getSubscriptionChartData(){
            this.isLoading = true
            axios.get(this.api + '/auth/get_weekly_subscriptions_data', this.authHeaders).then((res) => {
                // console.log(res.data)
                this.isLoading = false
                this.subs = res.data
                this.subscriptionsChartLoaded = true
                res.data.forEach(el => {
                    this.subLabels.push(el.week_starting)
                    this.subTotals.push(el.total)
                });
            })
        },
        getListings(){
            this.isLoading = true
            axios.get(this.api + '/auth/get_properties', this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.listings = res.data
                // let apprvd = res.data.map(item => item.is_approved == 1)
                let apprvd = res.data.filter(item => item.is_approved === true)
                this.listings_apprvd = apprvd.length
                this.listings_not_apprvd = this.listings.length - apprvd.length
                let feat = res.data.filter(item => item.is_featured)
                this.listings_featured = feat.length
                let my_list = res.data.filter(item => item.user_id === this.authUser.id)
                this.my_listing = my_list.length
                // console.log(my_list)
            })
        },
        getSubCount(){
            axios.get(this.api + '/auth/get_subs_count', this.authHeaders)
            .then((res) => {
                this.subsCount = res.data
            })
        },
        getEventsCount(){
            axios.get(this.api + '/auth/get_events_count', this.authHeaders)
            .then((res) => {
                this.eventsCount = res.data
            })
        },
        getNewsCount(){
            axios.get(this.api + '/auth/get_news_count', this.authHeaders)
            .then((res) => {
                this.newsCount = res.data
            })
        },

    },
    mounted() {
        this.getSubscriptionChartData()
        this.getListings()
        this.getSubCount()
        this.getEventsCount()
        this.getNewsCount()
    },
}
</script>

<style lang="scss" scoped>
    .charts{
        background: #caccd3;
        border: 1px solid #b4b6bb;
        border-radius: 5px;
    }

    .listings{
        margin: 0 auto;
        background: #c9cbd2 !important;
        margin-bottom: 2rem;

        .v-card{
            border-radius: 9px !important;
        }
    }
    a{
        text-decoration: none;
    }
</style>
