<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="10" md="6" offset-md="3">
                <staff-search model="Subscription" searchFor="subscriptions"/>
            </v-col>
        </v-row>
        <v-row class="mt-5" :justify="$vuetify.breakpoint.smAndDown ? 'start' : 'center'" :class="$vuetify.breakpoint.smAndDown ? 'mr-5 ml-n7' : ''">
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Subscriptions List <span v-if="total > 0"><v-chip color="primary lighten-2 ml-2">{{ total }}</v-chip></span></v-card-title>
                    <v-card-text class="mt-3">
                        <table class="table table-hover table-striped" v-if="total > 0">
                            <thead>
                                <tr>
                                    <th>Sub ID</th>
                                    <th>Date</th>
                                    <th>Fullname</th>
                                    <th>Listing</th>
                                    <th>Plan</th>
                                </tr>
                            </thead>
                            <tbody class="sub_list">
                                <tr v-for="sub in subscriptions" :key="sub.id">
                                    <td @click="showSub(sub.id)">{{ sub.id }}</td>
                                    <td @click="showSub(sub.id)">{{ sub.created }}</td>
                                    <td @click="showSub(sub.id)">{{ sub.client_fullname }}</td>
                                    <td @click="showSub(sub.id)" class="text-truncate">{{ sub.property_listing && sub.property_listing.name }}</td>
                                    <td @click="showSub(sub.id)" class="text-truncate">{{ sub.property_listing_plan && sub.property_listing_plan.name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert type="info" class="mt-5" v-else>
                            There are no subscriptions to view yet.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5 pb-8" v-if="subscriptions.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getSubs(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getSubs(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
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
            subscriptions: [],
            pagination: null,
            total: null,
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
        getSubs(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth/get_paginated_subscriptions`
            axios.get(pag, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.subscriptions = res.data.data
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
        showSub(sub){
            this.$router.push({name: 'StaffSubscriptionDetail', params:{id: sub}})
        },
    },
    mounted() {
        this.getSubs()
    },
}
</script>

<style lang="css" scoped>
.v-btn{
    text-decoration: none;
}
    table .sub_list tr td{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    .table .sub_list tr td{
        vertical-align: middle !important;
    }
</style>

