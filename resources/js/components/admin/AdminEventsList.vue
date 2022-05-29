<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="10" md="6">
                <v-text-field placeholder="Search for events" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="search"></v-text-field>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Events List <span v-if="events.length > 0"><v-chip color="primary lighten-2 ml-2">{{ events.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="events.length > 0">
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
                                <tr v-for="(event, i) in events" :key="event.id" :class="!event.is_approved ? 'warning--text' : ''">
                                    <td @click="showEvent(event)">{{ event.id }}</td>
                                    <td @click="showEvent(event)" class="text-truncate">{{ event.title }}</td>
                                    <td @click="showEvent(event)">{{ event.user && event.user.fullname }}</td>
                                    <td>{{ event.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                    <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateEvent', params:{id: event.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(event.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no events to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="events.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getEvents(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getEvents(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getEvents(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getEvents(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDialog" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this event?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteEvent">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="eventDeleted" :timeout="4000" top dark color="green darken-2">
            An event was deleted successfully.
            <v-btn text color="white--text" @click="eventDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminDeletedEvent" :timeout="4000" top dark color="green darken-2">
            An event was deleted successfully.
            <v-btn text color="white--text" @click="adminDeletedEvent = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            events: [],
            pagination: null,
            total: null,
            confirmDelDialog: false,
            isDeleting: false,
            eventToDelIndex: null,
            eventToDel: null,
            eventDeleted: false,
            q: ''
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
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
        adminDeletedEvent(){
            return this.$store.getters.adminDeletedEvent
        }
    },
    methods: {
        getEvents(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_paginated_events`
            axios.get(pag, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.events = res.data.data
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
        showEvent(ev){
            this.$router.push({name: 'AdminEventDetail', params:{id: ev.id}})
        },
        confirmDel(ev, i){
            this.confirmDelDialog = true
            this.eventToDel = ev
            this.eventToDelIndex = i
        },
        deleteEvent(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_event/${this.eventToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.events.splice(this.eventToDelIndex, 1)
                this.isDeleting = false
                this.confirmDelDialog = false
                this.eventDeleted = true
                console.log(res.data)
            })
            console.log(this.eventToDel)
        },
        search(){
            this.$router.push({name: 'AdminEventSearchResult', query: {q: this.q}})
        }
    },
    mounted() {
        this.getEvents()
    },
}
</script>

<style lang="css" scoped>
    .table .events_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .events_list tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>

