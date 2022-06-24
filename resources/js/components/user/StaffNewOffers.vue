<template>
    <v-container>
        <v-row justify="center" :class="$vuetify.breakpoint.smAndDown ? 'mr-8' : ''">
            <v-col cols="9" md="6">
                <staff-search model="NewOffer" searchFor="new offers/fliers"/>
            </v-col>
            <v-col cols="3" md="3" offset-md="2">
                <v-btn dark color="primary" :to="{name: 'StaffCreateNewOffer'}" :class="$vuetify.breakpoint.smAndDown ? 'ml-n4' : ''"><span><i class="uil uil-plus" left></i></span>New</v-btn>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Offers List <span v-if="offers.length > 0"><v-chip color="primary lighten-2 ml-2">{{ offers.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="offers.length > 0">
                            <thead>
                                <tr>
                                    <th>Created</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Approval Status</th>
                                </tr>
                            </thead>
                            <tbody class="offers_list">
                                <tr v-for="offer in offers" :key="offer.id" :class="!offer.is_approved ? 'warning--text' : ''">
                                    <td @click="showOffer(offer.id)">{{ offer.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td @click="showOffer(offer.id)" class="text-truncate">{{ offer.title }}</td>
                                    <td @click="showOffer(offer.id)">{{ offer.is_active ? 'Active' : 'Not Active' }}</td>
                                    <td @click="showOffer(offer.id)">{{ offer.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no offers to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="offers.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getOffers(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getOffers(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getOffers(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getOffers(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar :value="newOfferCreated" :timeout="4000" top dark color="green darken-2">
            A new offer has been created successfully.
            <v-btn text color="white--text" @click="newOfferCreated = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="newOfferDeleted" :timeout="4000" top dark color="green darken-2">
            A new offer has been deleted.
            <v-btn text color="white--text" @click="newOfferDeleted = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            offers: [],
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
        newOfferCreated(){
            return this.$store.getters.newOfferCreated
        },
        newOfferDeleted(){
            return this.$store.getters.newOfferDeleted
        },
    },
    methods: {
        getOffers(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth/get_paginated_offers`
            axios.get(pag, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.offers = res.data.data
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
        showOffer(offer){
            this.$router.push({name: 'StaffNewOfferDetail', params:{id: offer}})
        },
    },
    mounted() {
        this.getOffers()
    },
}
</script>

<style lang="css" scoped>
    table tr{
        cursor: pointer;
    }
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

