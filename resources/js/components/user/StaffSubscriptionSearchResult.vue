<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffSubscriptionsList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <staff-search model="Subscription" searchFor="subscriptions"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ subscriptions.length | pluralize('subscription')}}.
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="subscriptions.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> Subscriptions <v-chip color="primary lighten-2" class="ml-1" v-if="subscriptions.length > 0">{{ subscriptions.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
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
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no subscription.
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
            subscriptions: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.subscriptions = newVal
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
            axios.post(this.api + '/auth/search_for_subscriptions', {
                q: this.$route.query.q
            }, this.authHeaders).then((res)=>{
                this.isLoading = false
                this.subscriptions = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showSub(sub){
            this.$router.push({name: 'StaffSubscriptionDetail', params:{id: sub}})
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
    .table .news_list tr td{
        vertical-align: middle !important;
    }
</style>
