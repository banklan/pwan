<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="6">
                <admin-search model="Newsletters" searchFor="newsletters"/>
            </v-col>
            <v-col cols="12" md="4" offset-md="2">
                <v-btn dark color="primary" :to="{name: 'AdminCreateNewsletter'}"><i class="uil uil-plus"></i>New Newsletter</v-btn>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Newsletters List <span v-if="newsletters && newsletters.length > 0"><v-chip color="primary lighten-2 ml-2">{{ newsletters.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="newsletters && newsletters.length > 0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="newsletters_list">
                                <tr v-for="(letter, i) in newsletters" :key="letter.id">
                                    <td @click="showNewsletter(letter.id)">{{ letter.id }}</td>
                                    <td @click="showNewsletter(letter.id)">{{ letter.created_at | moment('DD-MM-YYYY') }}</td>
                                    <td @click="showNewsletter(letter.id)" class="text-truncate">{{ letter.subject | truncate(60) }}</td>
                                    <td><v-btn icon color="red darken-2" @click="confirmDel(letter.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no newsletter(s) to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="newsletters.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getNewsletters(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNewsletters(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNewsletters(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getNewsletters(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
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
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this newsletter?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteNewsletter">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="newsletterDeleted" :timeout="4000" top dark color="green darken-2">
            A newsletter has been deleted successfully.
            <v-btn text color="white--text" @click="newsletterDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminDeleteNewsletter" :timeout="4000" top dark color="green darken-2">
            A newsletter has been deleted successfully.
            <v-btn text color="white--text" @click="adminDeleteNewsletter = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            newsletters: [],
            pagination: null,
            total: null,
            confirmDelDialog: false,
            isDeleting: false,
            newsletterToDelIndex: null,
            newsletterToDel: null,
            newsletterDeleted: false,
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
        adminDeleteNewsletter(){
            return this.$store.getters.adminDeleteNewsletter
        }
    },
    methods: {
        getNewsletters(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_newsletters`
            axios.get(pag, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.newsletters = res.data.data
                this.total = res.data.total
                this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
                console.log(res.data)
            }).catch(() => {
                this.isLoading = false
            })
        },
        confirmDel(letter, i){
            this.confirmDelDialog = true
            this.newsletterToDel = letter
            this.newsletterToDelIndex = i
        },
        deleteNewsletter(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_newsletter/${this.newsletterToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.newsletters.splice(this.newsletterToDelIndex, 1)
                this.isDeleting = false
                this.confirmDelDialog = false
                this.newsletterDeleted = true
            })
        },
        showNewsletter(id){
            this.$router.push({name: 'AdminNewslettersDetail', params:{id: id}})
        }
    },
    mounted() {
        this.getNewsletters()
    },
}
</script>

<style lang="css" scoped>
    .table .newsletters_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1rem !important;
    }
    table .newsletters_list tr{
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

