<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffEventsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <staff-search model="Event" searchFor="events"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ events.length | pluralize('event')}}.
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="events.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> Events <v-chip color="primary lighten-2" class="ml-1" v-if="events.length > 0">{{ events.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Published</th>
                                            <th>Title</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="events_list">
                                        <tr v-for="event in events" :key="event.id" :class="!event.is_approved ? 'warning--text' : ''">
                                            <td @click="showEvent(event.id)">{{ event.id }}</td>
                                            <td @click="showEvent(event.id)">{{ event.created_at | moment('DD-MM-YYYY') }}</td>
                                            <td @click="showEvent(event.id)" class="text-truncate">{{ event.title }}</td>
                                            <td @click="showEvent(event.id)">{{ event.user && event.user.fullname }}</td>
                                            <td>{{ event.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no events.
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
            events: [],
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
            axios.post(this.api + '/auth/search_for_events', {
                q: this.$route.query.q
            }, this.authHeaders).then((res)=>{
                this.isLoading = false
                this.events = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showEvent(event){
            this.$router.push({name: 'StaffEventDetail', params:{id: event}})
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
