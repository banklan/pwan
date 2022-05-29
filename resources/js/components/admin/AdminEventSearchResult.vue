<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <admin-search model="Event" searchFor="events"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <template v-if="events.length > 0">
                        <v-card-title class="subtitle-1 primary white--text justify-center"> Result for {{ $route.query.q }} <v-chip color="primary" class="ml-1" v-if="events.length > 0">{{ events.length }}</v-chip></v-card-title>
                        <v-card-text class="mt-5">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="events_list">
                                    <tr v-for="(event) in events" :key="event.id" :class="!event.is_approved ? 'warning--text' : ''">
                                        <td @click="showEvent(event)">{{ event.id }}</td>
                                        <td @click="showEvent(event)" class="text-truncate">{{ event.title }}</td>
                                        <td @click="showEvent(event)">{{ event.user && event.user.fullname }}</td>
                                        <td>{{ event.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                        <td><v-btn icon color="admin_a" :to="{name: 'AdminEventDetail', params:{id: event.id}}"><i class="uil uil-eye"></i></v-btn> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </template>
                    <template v-else>
                        <v-card-text>
                            <v-alert type="error" border="left" class="mt-8 mx-3">
                                Search for {{ $route.query.q }} returned no event.
                            </v-alert>
                        </v-card-text>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            events: [],
            confirmDelDial: false,
            isUpdating: false,
            serviceTodelIndex: null,
            serviceTodel: null
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.events = newVal
                this.getResult()
            },
            immediate: true
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
        getResult(){
            this.isLoading = true
            axios.post(this.api + '/auth-admin/search_for_events', {
                q: this.$route.query.q
            }, this.adminHeaders).then((res)=>{
                this.isLoading = false
                this.events = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
        showEvent(event){
            this.$router.push({name: 'AdminEventDetail', params:{id: event.id}})
        },
        confirmDel(service, i){
            this.serviceTodel = service
            this.serviceTodelIndex = i
            this.confirmDelDial = true
        },
        deleteService(){
            this.isUpdating = true
            axios.post(this.api + `/auth-admin/admin_del_service/${this.serviceTodel.id}`, {}, this.adminHeaders)
            .then((res) => {
                this.isUpdating = false
                this.confirmDelDial = false
                this.services.splice(this.serviceTodelIndex, 1)
                this.$store.commit('adminDeletedService')
            }).catch(() => {
                this.isUpdating = false
                this.confirmDelDial = false
                this.serviceDeleteFailed = true
            })
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
    .table .events_list tr td{
        vertical-align: middle !important;
    }
</style>
