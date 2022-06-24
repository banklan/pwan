<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminEnquiries'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <admin-search model="Enquiry" searchFor="enquiries"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ enquiries.length }} enquiry(ies).
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="enquiries.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center">Enquiries <v-chip color="primary lighten-2" class="ml-1" v-if="enquiries.length > 0">{{ enquiries.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Email</th>
                                            <th>Sender</th>
                                            <th>Subject</th>
                                        </tr>
                                    </thead>
                                    <tbody class="enquiries_list">
                                        <tr v-for="enquiry in enquiries" :key="enquiry.id">
                                            <td @click="showEnquiry(enquiry)" :class="!enquiry.is_read ? 'font-weight-bold' : ''">{{ enquiry.created_at | moment('DD/MM/YYYY') }} </td>
                                            <td @click="showEnquiry(enquiry)" :class="!enquiry.is_read ? 'font-weight-bold' : ''">{{ enquiry.email }} </td>
                                            <td @click="showEnquiry(enquiry)" :class="!enquiry.is_read ? 'font-weight-bold' : ''">{{ enquiry.fullname }} </td>
                                            <td @click="showEnquiry(enquiry)" :class="!enquiry.is_read ? 'font-weight-bold' : ''">{{ enquiry.subject | truncate(50) }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no enquiry.
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
            enquiries: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.enquiries = newVal
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
            axios.post(this.api + '/auth-admin/search_for_enquiries', {
                q: this.$route.query.q
            }, this.adminHeaders).then((res)=>{
                this.isLoading = false
                this.enquiries = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showEnquiry(enq){
            this.$router.push({name: 'AdminEnquiryDetail', params:{id: enq.id}})
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
    .table .enquiries_list tr td{
        vertical-align: middle !important;
    }
</style>
