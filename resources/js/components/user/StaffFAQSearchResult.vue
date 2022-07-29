<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffFaqList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <staff-search model="FAQ" searchFor="faq's"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ faqs.length | pluralize('faq')}}.
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="faqs.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> FAQ's<v-chip color="primary lighten-2" class="ml-1" v-if="faqs.length > 0">{{ faqs.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Published</th>
                                            <th>Created By</th>
                                            <th>Qstn</th>
                                        </tr>
                                    </thead>
                                    <tbody class="faqs_list">
                                        <tr v-for="faq in faqs" :key="faq.id">
                                            <td @click="goToFaqDetail(faq)">{{ faq.id }}</td>
                                            <td @click="goToFaqDetail(faq)">{{ faq.created_at | moment('DD-MM-YYYY') }}</td>
                                            <td @click="goToFaqDetail(faq)" class="text-truncate">{{ faq.user && faq.user.fullname }}</td>
                                            <td @click="goToFaqDetail(faq)" class="text-truncate">{{ faq.qstn }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no faqs.
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
            faqs: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.faqs = newVal
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
            axios.post(this.api + '/auth/search_for_faqs', {
                q: this.$route.query.q
            }, this.authHeaders).then((res)=>{
                this.isLoading = false
                this.faqs = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showFaq(faq){
            this.$router.push({name: 'StaffFaqDetail', params:{id: faq}})
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
    .table .faqs_list tr td{
        vertical-align: middle !important;
    }
</style>
