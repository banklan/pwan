<template>
    <v-container fluid>
        <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <template v-else>
            <admin-dash-brief-cards />
            <v-row justify="center" class="mt-5">
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="#e9309f">
                        <v-card-title class="subtitle-1 justify-center">Users & Admins</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead></thead>
                                <tbody class="white--text">
                                    <tr @click="goToAdmins">
                                        <th>No of Admins</th>
                                        <td>{{ admins }}</td>
                                    </tr>
                                    <tr @click="goToUsers">
                                        <th>No of Users(Staff)</th>
                                        <td>{{ users }}</td>
                                    </tr>
                                    <tr>
                                        <th>Inactive Users</th>
                                        <td>{{ disabledUsers }}</td>
                                    </tr>
                                    <tr>
                                        <th>Logged-in Users</th>
                                        <td>{{ loggedInUsers }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_h">
                        <v-card-title class="subtitle-1 justify-center">Properties/Listings</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead></thead>
                                <tbody class="white--text">
                                    <tr @click="goToProperties">
                                        <th>No of Listings</th>
                                        <td>{{ properties }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved Listings</th>
                                        <td>{{ approvedProps }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unapproved Listings</th>
                                        <td>{{ unApprvdProps }}</td>
                                    </tr>
                                    <tr>
                                        <th>Featured Listings</th>
                                        <td>{{ featProperties }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-3">
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_f">
                        <v-card-title class="subtitle-1 justify-center">Top Subscriptions <v-chip color="admin_f lighten-2 white--text" class="ml-1">{{ subscriptions.length }}</v-chip></v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead class="white--text">
                                    <tr>
                                        <th>Listing</th>
                                        <th>No Of Subs</th>
                                    </tr>
                                </thead>
                                <tbody class="white--text" v-if="subsStats">
                                    <tr v-for="sub in subsStats" :key="sub.id">
                                        <td>{{ sub.property_listing.name }}</td>
                                        <td>{{ sub.total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_g">
                        <v-card-title class="subtitle-1 justify-center">Latest Properties/Listings</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped white--text" v-if="latestProps.length > 0">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody class="white--text">
                                    <tr v-for="prop in latestProps" :key="prop.id">
                                        <td class="text-truncate">{{ prop.name }}</td>
                                        <td>{{ prop.status ? 'Approved' : 'Not Approved' }}</td>
                                        <td>{{ prop.created_at | moment('DD/MM/YYYY') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <div v-else class="mt-3 white--text">There are no properties to be displayed at the moment.</div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-5">
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_e">
                        <v-card-title class="subtitle-1 justify-center">Events</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead></thead>
                                <tbody class="white--text">
                                    <tr @click="goToEvents">
                                        <th>No of Events</th>
                                        <td>{{ events }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved Events</th>
                                        <td>{{ apprvdEvents }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unapproved Events</th>
                                        <td>{{ UnApprvdEvents }}</td>
                                    </tr>
                                    <tr>
                                        <th>Featured Events</th>
                                        <td>{{ featEvents }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_j">
                        <v-card-title class="subtitle-1 justify-center">Latest Events</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped white--text" v-if="latestEvents.length > 0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date of Event</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody class="white--text">
                                    <tr v-for="event in latestEvents" :key="event.id">
                                        <td class="text-truncate">{{ event.title | truncate(20)}}</td>
                                        <td>{{ event.evnt_date }}</td>
                                        <td>{{ event.created_at | moment('DD/MM/YYYY') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <div v-else class="mt-3 white--text">There are no events to be displayed at the moment.</div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-5">
                <v-col cols="12" md="5">
                    <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll" color="admin_i white--text">
                        <v-card-title class="subtitle-1 justify-center white--text">Latest News Posts</v-card-title>
                        <v-card-text v-if="news_posts">
                            <table class="table table-hover table-striped white--text" v-if="news_posts.length > 0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="white--text">
                                    <tr v-for="post in news_posts" :key="post.id">
                                        <td>{{ post.created_at | moment('DD/MM/YYYY') }}</td>
                                        <td class="text-truncate">{{ post.title }}</td>
                                        <td>{{ post.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                        <div v-else class="mt-3 white--text">There are no properties to be displayed at the moment.</div>
                    </v-card>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll" color="admin_a darken-2">
                        <v-card-title class="subtitle-1 justify-center white--text">Testimonials</v-card-title>
                            <v-card-text v-if="testimonials">
                                <table class="table table-hover table-striped white--text" v-if="testimonials.length > 0">
                                    <thead></thead>
                                    <tbody class="white--text">
                                        <tr>
                                            <th>Total</th>
                                            <td>{{ testimonials.length }}</td>
                                        </tr>
                                        <tr>
                                            <th>Featured</th>
                                            <td>{{ feat_testimonials }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </v-card-text>
                        <div v-else class="mt-3 white--text">There are no testimonials to be displayed at the moment.</div>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-5">
                <v-col cols="12" md="5">
                    <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll">
                        <v-card-title class="subtitle-1 justify-center">Previous weeks subscriptions</v-card-title>
                        <v-card-text>
                            <subs-bar-chart v-if="subscriptionsChartLoaded" :chart-data="subTotals" :chart-labels="subLabels" />
                            <template v-else>
                                <v-alert type="info" class="mt-5">
                                    There are no subscriptions data to view at the moment.
                                </v-alert>
                            </template>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll">
                        <v-card-title class="subtitle-1 justify-center">Previous weeks subscriptions</v-card-title>
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
            </v-row>
        </template>
    </v-container>
</template>

<script>
import SubscriptionsLineChart from '../charts/SubscriptionsLineChart.vue'
import SubscriptionBarChart from '../charts/SubscriptionsBarChart'

export default {
    components: {
        'subs-bar-chart': SubscriptionBarChart,
        'subs-line-chart': SubscriptionsLineChart,
    },
    props: ['toggleMini', 'smAndDown'],
    data() {
        return {
            isLoading: false,
            admins: null,
            users: null,
            disabledUsers: null,
            loggedInUsers: null,
            properties: null,
            unApprvdProps: null,
            featProperties: null,
            approvedProps: null,
            events: null,
            apprvdEvents: null,
            UnApprvdEvents: null,
            featEvents: null,
            latestProps: [],
            latestEvents: [],
            notApprvdProperties: null,
            servChartLoaded: false,
            chartSubscriptionsCount: [],
            chartSubscriptionsLabels: [],
            testimonials: [],
            chartUsersCount: [],
            subscriptions: [],
            sub3: null,
            sub12: null,
            subsStats: [],
            news_posts: [],
            feat_testimonials: null,
            subscriptionsChartLoaded: false,
            SubscriptionChartError: null,
            subscriptionsChartLoaded: false,
            subLabels: [],
            subTotals: [],
        }
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
    },
    methods: {
        getAdminStats(){
            this.isLoading = true
            axios.get(this.api + '/auth-admin/all_superusers', this.adminHeaders).then((res) => {
                this.isLoading = false
                this.admins = res.data
            })
        },
        getUsersStats(){
            axios.get(this.api + '/auth-admin/all_users', this.adminHeaders).then((res) => {
                this.users = res.data.length
                let auth = res.data.filter(item =>item.is_loggedin)
                this.loggedInUsers = auth.length
                let disabled = res.data.filter(item => item.status == false)
                this.disabledUsers = disabled.length
            })
        },
        getPropertiesStats(){
            axios.get(this.api + '/auth-admin/all_properties', this.adminHeaders).then((res) => {
                this.properties = res.data.length
                let approvedProps = res.data.filter(item =>item.is_approved == true)
                this.approvedProps = approvedProps.length
                let unApprvdProps = res.data.filter(item =>item.is_approved == false)
                this.unApprvdProps = unApprvdProps.length
                let featProps = res.data.filter(item =>item.is_featured)
                this.featProperties = featProps.length

                // get latest 5
                let latest = res.data.slice(0, 5)
                this.latestProps = latest
            })
        },
        getEventsStats(){
            axios.get(this.api + '/auth-admin/all_events', this.adminHeaders).then((res) => {
                this.latestEvents = res.data.slice(0 ,5)
                this.events = res.data.length
                let UnApprvdEvents = res.data.filter(item =>item.is_approved === false)
                this.UnApprvdEvents = UnApprvdEvents.length
                this.apprvdEvents = res.data.length - UnApprvdEvents.length
                let featEvents = res.data.filter(item =>item.is_featured === true)
                this.featEvents = featEvents.length
            })
        },
        getSubscriptionsStats(){
            axios.get(this.api + `/auth-admin/all_subscriptions`, this.adminHeaders).then((res) => {
                this.subscriptions = res.data
                let sub3 = res.data.filter(item =>item.pay_plans === '3')
                this.sub3 = sub3.length
                let sub12 = res.data.filter(item =>item.pay_plans === '12')
                this.sub12 = sub12.length
            })
        },
        getSubStats(){
            axios.get(this.api + '/auth-admin/get_sub_stats', this.adminHeaders)
            .then((res) => {
                this.subsStats = res.data
                console.log("subscr stats", res.data)
            })
        },
        getTestimonials(){
             axios.get(this.api + `/auth-admin/get_testimonials`, this.adminHeaders).then((res) => {
                this.testimonials = res.data
                let feat = res.data.filter(item => item.is_featured)
                this.feat_testimonials = feat.length
             })
        },
        goToAdmins(){
            this.$router.push({name: 'AdminList'})
        },
        goToUsers(){
            this.$router.push({name: 'AdminUsersList'})
        },
        goToProperties(){
            this.$router.push({name: 'AdminPropertyList'})
        },
        goToEvents(){
            this.$router.push({name: 'AdminEventsList'})
        },
        getServicesChartData(){
            this.servChartLoaded = false
            axios.get(this.api + '/auth-admin/get_last_weeks_services', this.adminHeaders).then((res) => {
                this.chartServicesCount = res.data.map(item => item.services_count)
                this.chartServicesLabels = res.data.map(item => item.week_starting)
                this.servChartLoaded = true
                // console.log('services chart ', res.data)
            }).catch((e) =>{
                this.ServiceChartError = e
            })
        },
        getNewsPosts(){
            axios.get(this.api + '/auth-admin/get_last_news_posts', this.adminHeaders).then((res) =>{
                this.news_posts = res.data.slice(0, 5)
            })
        },
        getSubscriptionsChartData(){
            this.subscriptionsChartLoaded = false
            axios.get(this.api + '/auth-admin/get_previous_weeks_subscriptions', this.adminHeaders).then((res) => {
                this.chartSubscriptionsCount = res.data.map(item => item.subscription_count)
                this.chartSubscriptionsLabels = res.data.map(item => item.week_starting)
                this.subscriptionsChartLoaded = true
                // console.log('sub chart ', res.data)
            }).catch((e) =>{
                this.SubscriptionChartError = e
            })
        },
        getSubscriptionChartData(){
            axios.get(this.api + '/auth-admin/get_weekly_subscriptions_data', this.adminHeaders).then((res) => {
                console.log(res.data)
                this.subs = res.data
                this.subscriptionsChartLoaded = true
                res.data.forEach(el => {
                    this.subLabels.push(el.week_starting)
                    this.subTotals.push(el.total)
                });
            })
        }
    },
    mounted() {
        this.getAdminStats()
        this.getUsersStats()
        this.getPropertiesStats()
        this.getEventsStats()
        this.getSubscriptionsStats()
        this.getNewsPosts()
        this.getTestimonials()
        // this.getSubscriptionsChartData()
        this.getSubscriptionChartData()
        this.getSubStats()
    },
}

</script>

<style lang="scss" scoped>
    table tbody tr{
        cursor: pointer;

        &:hover{
            color: #e9e9e9 !important;
        }
    }
</style>
