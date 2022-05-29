<template>
    <v-container fluid>
        <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <template v-else>
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
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_a">
                        <v-card-title class="subtitle-1 justify-center">Properties</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead></thead>
                                <tbody class="white--text">
                                    <tr @click="goToProperties">
                                        <th>No of Properties</th>
                                        <td>{{ properties }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unapproved Properties</th>
                                        <td>{{ unApprvdProps }}</td>
                                    </tr>
                                    <tr>
                                        <th>Featured Properties</th>
                                        <td>{{ featProperties }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sold Properties</th>
                                        <td>{{ soldProps }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-3">
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
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_f">
                        <v-card-title class="subtitle-1 justify-center">Subscriptions</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped">
                                <thead></thead>
                                <tbody class="white--text">
                                    <tr>
                                        <th>No of Subscriptions</th>
                                        <td>22*</td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-5">
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_g">
                        <v-card-title class="subtitle-1 justify-center">Latest Properties</v-card-title>
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
                <v-col cols="12" md="5">
                    <v-card dark elevation="6" raised outlined width="100%" min-height="200" class="mx-auto scroll" color="admin_h">
                        <v-card-title class="subtitle-1 justify-center">Latest Events</v-card-title>
                        <v-card-text>
                            <table class="table table-hover table-striped white--text" v-if="latestEvents.length > 0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date of Event</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody class="white--text">
                                    <tr v-for="event in latestEvents" :key="event.id">
                                        <td class="text-truncate">{{ event.title }}</td>
                                        <td>{{ event.date }} / {{ event.time }}</td>
                                        <td>{{ event.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                        <td>{{ event.created_at | moment('DD/MM/YYYY') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <div v-else class="mt-3 white--text">There are no properties to be displayed at the moment.</div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </template>
        <v-row justify="center" class="mt-5">
            <!-- <v-col cols="12" md="6">
                <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll">
                    <v-card-title class="subtitle-1 justify-center">Properties Created Last Weeks</v-card-title>
                    <v-card-text v-if="chartServicesCount.length > 0">
                        <service-line-charts v-if="servChartLoaded" :chart-data="chartServicesCount" :chart-labels="chartServicesLabels"></service-line-charts>
                        <template v-if="ServiceChartError">{{ ServiceChartError }}</template>
                    </v-card-text>
                    <v-card-text v-else>
                        There are no properties data to be displayed at the moment.
                    </v-card-text>
                </v-card>
            </v-col> -->
            <!-- <v-col cols="12" md="6">
                <v-card light elevation="6" raised outlined width="100%" min-height="100" class="mx-auto scroll">
                    <v-card-title class="subtitle-1 justify-center admin--text">Subscriptions Created Last Weeks</v-card-title>
                    <v-card-text v-if="chartUsersCount.length > 0">
                        <service-line-charts v-if="usersChartLoaded" :chart-data="chartUsersCount" :chart-labels="chartUsersLabels" />
                        <template v-if="UsersChartError">{{ UsersChartError }}</template>
                    </v-card-text>
                    <v-card-text v-else>
                        There are no subscriptions data to be displayed at the moment.
                    </v-card-text>
                </v-card>
            </v-col> -->
        </v-row>
    </v-container>
</template>

<script>
// import SalesLineChart from '../charts/SalesLineChart.vue'

export default {
    components: {
        // 'sales-line-charts': SalesLineChart,
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
            soldProps: null,
            events: null,
            UnApprvdEvents: null,
            featEvents: null,
            latestProps: [],
            latestEvents: [],

            notApprvdProperties: null,
            servChartLoaded: false,
            chartServicesCount: [],
            chartServicesLabels: [],
            ServiceChartError: null,
            testimonials: null,
            chartUsersCount: []
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
                let unApprvdProps = res.data.filter(item =>item.is_approved == false)
                this.unApprvdProps = unApprvdProps.length
                let featProps = res.data.filter(item =>item.is_featured)
                this.featProperties = featProps.length
                let soldProps = res.data.filter(item =>item.is_sold)
                this.soldProps = soldProps.length
                // get latest 5
                let latest = res.data.slice(0, 4)
                this.latestProps = latest

            })
        },
        getEventsStats(){
            axios.get(this.api + '/auth-admin/all_events', this.adminHeaders).then((res) => {
                this.events = res.data.length
                let UnApprvdEvents = res.data.filter(item =>item.is_approved == false)
                this.UnApprvdEvents = UnApprvdEvents.length
                let featEvents = res.data.filter(item =>item.is_featured == false)
                this.featEvents = featEvents.length
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
                console.log('services chart ', res.data)
            }).catch((e) =>{
                this.ServiceChartError = e
            })
        },
        // getLatestProperties(){
        //     axios.get(this.api + '/auth-admin/latest_props', this.adminHeaders).then((res) => {
        //         this.latestProps = res.data
        //     })
        // },
        getTestimonials(){
            axios.get(this.api + '/auth-admin/get_testimonial_count', this.adminHeaders).then((res) => {
                this.testimonials = res.data
            })
        }
    },
    mounted() {
        this.getAdminStats()
        this.getUsersStats()
        this.getPropertiesStats()
        this.getEventsStats()
        // this.getLatestProperties()
        // this.getServicesStats()
        // this.getPortfolioStats()
        // this.getReviewsStats()
        // this.getPopularServices()
        // this.getLatestServices()
        // this.getTestimonials()
        // this.getServicesChartData()
        // this.getUsersChartData()
    },
}

</script>

<style lang="scss" scoped>
    table tbody tr{
        cursor: pointer;
    }
</style>
