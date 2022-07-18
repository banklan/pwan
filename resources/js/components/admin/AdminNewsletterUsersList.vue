<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="5" offset-md="1">
                <admin-search model="NewsletterUser" searchFor="newsletter subscriber"/>
            </v-col>
            <v-col cols="12" md="4" offset-md="2">
                <v-btn dark color="primary" :to="{name: 'AdminCreateNewsletter'}"><i class="uil uil-plus"></i>New Newsletter</v-btn>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Testimonials List <span v-if="subscribers && subscribers.length > 0"><v-chip color="primary lighten-2 ml-2">{{ subscribers.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="subscribers && subscribers.length > 0">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="subscribers_list">
                                <tr v-for="(sub, i) in subscribers" :key="sub.id">
                                    <td>{{ sub.id }}</td>
                                    <td>{{ sub.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td class="text-truncate">{{ sub.name }}</td>
                                    <td>{{ sub.email }}</td>
                                    <td><v-btn icon color="red darken-2" @click="confirmDel(sub.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no newsletter subscribers to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="subscribers.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getSubscribers(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubscribers(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubscribers(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubscribers(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
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
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this newsletter subscriber?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteSubscriber">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="subscriberDeleted" :timeout="4000" top dark color="green darken-2">
            A subscriber has been deleted successfully.
            <v-btn text color="white--text" @click="subscriberDeleted = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            subscribers: [],
            pagination: null,
            total: null,
            confirmDelDialog: false,
            isDeleting: false,
            subscriberToDelIndex: null,
            subscriberToDel: null,
            subscriberDeleted: false,
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
        adminDeletedTestimonial(){
            return this.$store.getters.adminDeletedTestimonial
        }
    },
    methods: {
        getSubscribers(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_newsletter_subscribers`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.subscribers = res.data.data
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
        confirmDel(sub, i){
            this.confirmDelDialog = true
            this.subscriberToDel = sub
            this.subscriberToDelIndex = i
        },
        deleteSubscriber(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_newsletter_subscriber/${this.subscriberToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.subscribers.splice(this.subscriberToDelIndex, 1)
                this.isDeleting = false
                this.confirmDelDialog = false
                this.subscriberDeleted = true
            })
        },
    },
    mounted() {
        this.getSubscribers()
    },
}
</script>

<style lang="css" scoped>
    .table .subscribers_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1rem !important;
    }
    table .subscribers_list tr{
        cursor: pointer;
    }
    table tbody tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>

