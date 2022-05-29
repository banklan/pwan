<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="6" offset-md="4">
                <admin-search model="Testimonial" searchFor="testimonials"/>
                <!-- <v-text-field placeholder="Search for events" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="search"></v-text-field> -->
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Testimonials List <span v-if="testimonials && testimonials.length > 0"><v-chip color="primary lighten-2 ml-2">{{ testimonials.length }}</v-chip></span></v-card-title>
                    <v-card-text>
                        <table class="table table-hover table-striped" v-if="testimonials && testimonials.length > 0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Fullname</th>
                                    <th>Title</th>
                                    <th>Feature</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="testimonials_list">
                                <tr v-for="(test, i) in testimonials" :key="test.id">
                                    <td @click="showTestimonial(test)">{{ test.published }}</td>
                                    <td @click="showTestimonial(test)">{{ test.fullname }}</td>
                                    <td @click="showTestimonial(test)" class="text-truncate">{{ test.title }}</td>
                                    <td @click="showTestimonial(test)">{{ test.is_featured ? 'Featured' : 'Not Featured' }}</td>
                                    <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateTestimonial', params:{id: test.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(test.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no testimonials to be displayed at the moment.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDialog" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this testimonial?</v-card-title>
                <v-card-text class="mt-5 subtitle-1 grey_text--text">Once deleted, the process cannot be undone.</v-card-text>
                <v-card-actions class="pb-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDialog = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isDeleting" @click="deleteTestimonial">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="testimonialDeleted" :timeout="4000" top dark color="green darken-2">
            A testimonial was deleted successfully.
            <v-btn text color="white--text" @click="testimonialDeleted = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar :value="adminDeletedTestimonial" :timeout="4000" top dark color="green darken-2">
            A testimonial was deleted successfully.
            <v-btn text color="white--text" @click="adminDeletedTestimonial = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            testimonials: [],
            pagination: null,
            total: null,
            confirmDelDialog: false,
            isDeleting: false,
            testimonialToDelIndex: null,
            testimonialToDel: null,
            testimonialDeleted: false,
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
        getTestimonials(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_testimonials`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.testimonials = res.data
            }).catch(() => {
                this.isLoading = false
            })
        },
        showTestimonial(test){
            this.$router.push({name: 'AdminTestimonialDetail', params:{id: test.id}})
        },
        confirmDel(ev, i){
            this.confirmDelDialog = true
            this.eventToDel = ev
            this.eventToDelIndex = i
        },
        deleteTestimonial(){
            this.isDeleting = true
            axios.post(this.api + `/auth-admin/delete_event/${this.eventToDel}`, {}, this.adminHeaders)
            .then((res) => {
                this.events.splice(this.eventToDelIndex, 1)
                this.isDeleting = false
                this.confirmDelDialog = false
                this.eventDeleted = true
                console.log(res.data)
            })
            console.log(this.eventToDel)
        },
        // search(){
        //     this.$router.push({name: 'AdminEventSearchResult', query: {q: this.q}})
        // }
    },
    mounted() {
        this.getTestimonials()
    },
}
</script>

<style lang="css" scoped>
    .table .testimonials_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1rem !important;
    }
    table .events_list tr{
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

