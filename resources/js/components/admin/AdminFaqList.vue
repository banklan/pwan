<template>
    <v-container>
        <v-row justify="center" :class="$vuetify.breakpoint.smAndDown ? 'mr-8' : ''">
            <v-col cols="12" md="6" offset-md="6">
                <admin-search model="FAQ" searchFor="faq's"/>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">FAQ's List <span v-if="faqs && faqs.length > 0"><v-chip color="primary lighten-2 ml-2" v-if="faqs.length > 0">{{ faqs.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="faqs && faqs.length > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Published</th>
                                    <th>Created By</th>
                                    <th>Qstn</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="faqs_list">
                                <tr v-for="(faq, index) in faqs" :key="faq.id">
                                    <td @click="goToFaqDetail(faq)">{{ faq.id }}</td>
                                    <td @click="goToFaqDetail(faq)">{{ faq.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td @click="goToFaqDetail(faq)" class="text-truncate">{{ faq.user && faq.user.fullname }}</td>
                                    <td @click="goToFaqDetail(faq)" class="text-truncate">{{ faq.qstn }}</td>
                                    <td><v-btn icon color="red darken-2" class="ml-2" @click="confirmDel(index, faq.id)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no faq's to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5 justify-center" v-if="faqs && faqs.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getFaqs(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getFaqs(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getFaqs(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getFaqs(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this faq?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delFaq">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar :value="faqDeleted" :timeout="4000" top dark color="green darken-2">
            A frequenty-asked-question has been deleted.
            <v-btn text color="white--text" @click="faqDeleted = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            faqs: [],
            pagination: null,
            total: null,
            confirmDelDial: false,
            faqToDel: null,
            faqToDelIndex: null,
            isBusy: false,
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
        faqDeleted(){
            return this.$store.getters.faqDeleted
        }
    },
    methods: {
        getFaqs(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_paginated_faqs`
            axios.get(pag, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.faqs = res.data.data
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
        goToFaqDetail(faq){
            this.$router.push({name: 'AdminFaqDetail', params: {id: faq.id}})
        },
        confirmDel(index, id){
            this.confirmDelDial = true
            this.faqToDelIndex = index
            this.faqToDel = id
        },
        delFaq(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/del_faq/${this.faqToDel}`, {}, this.adminHeaders)
            .then((res) =>{
                this.isBusy = false
                this.confirmDelDial = false
                this.$store.commit('faqDeleted')
                this.faqs.splice(this.faqToDelIndex, 1)
            })
        }
    },
    mounted() {
        this.getFaqs()
    },
}
</script>

<style lang="css" scoped>
    .table .faqs_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .faqs_list tr{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>

