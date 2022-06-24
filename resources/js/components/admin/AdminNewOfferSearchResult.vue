<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminNewOffersList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <admin-search model="NewOffer" searchFor="New offer"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ offers.length }} offer(s).
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="offers.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> New Offers <v-chip color="primary lighten-2" class="ml-1" v-if="offers.length > 0">{{ offers.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Created By</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Approval Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="offers_list">
                                        <tr v-for="offer in offers" :key="offer.id" :class="!offer.is_approved ? 'warning--text' : ''">
                                            <td @click="showOffer(offer.id)">{{ offer.created_at | moment('DD-MM-YYYY') }}</td>
                                            <td @click="showOffer(offer.id)" class="text-truncate">{{ offer.user && offer.user.fullname }}</td>
                                            <td @click="showOffer(offer.id)" class="text-truncate">{{ offer.title }}</td>
                                            <td @click="showOffer(offer.id)">{{ offer.is_active ? 'Active' : 'Not Active' }}</td>
                                            <td @click="showOffer(offer.id)">{{ offer.is_approved ? 'Approved' : 'Not Apprvd'}} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no offer(s).
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
            offers: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.offers = newVal
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
            axios.post(this.api + '/auth-admin/search_for_offers', {
                q: this.$route.query.q
            }, this.adminHeaders).then((res)=>{
                this.isLoading = false
                this.offers = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showOffer(offer){
            this.$router.push({name: 'AdminNewOfferDetail', params:{id: offer}})
        },
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
    .table .offers_list tr td{
        vertical-align: middle !important;
    }
</style>
