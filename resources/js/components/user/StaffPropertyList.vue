<template>
    <v-container>
        <v-row justify="center" :class="$vuetify.breakpoint.smAndDown ? 'mr-8' : ''">
            <v-col cols="9" md="6">
                <staff-search model="Property" searchFor="properties"/>
            </v-col>
            <v-col cols="3" md="3" offset-md="2">
                <v-btn dark color="primary" :to="{name: 'StaffCreateListing'}" :class="$vuetify.breakpoint.smAndDown ? 'ml-n4' : ''"><span><i class="uil uil-plus" left></i></span>New</v-btn>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                        <v-card-title class="primary white--text subtitle-1 justify-center">Properties Listing <span v-if="properties.length > 0"><v-chip color="primary lighten-2 ml-2">{{ properties.length }}</v-chip></span></v-card-title>
                        <v-card-text>
                        <table class="table table-hover table-striped" v-if="properties.length > 0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Approval Status</th>
                                </tr>
                            </thead>
                            <tbody class="properties_list">
                                <tr v-for="(prop) in properties" :key="prop.id">
                                    <td @click="showProp(prop)">{{ prop.id }}</td>
                                    <td @click="showProp(prop)">{{ prop.name }}</td>
                                    <td @click="showProp(prop)">{{ prop.status ? 'Active' : 'Inactive'}} </td>
                                    <td @click="showProp(prop)">{{ prop.user && prop.user.fullname }} </td>
                                    <td @click="showProp(prop)">{{ prop.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no properties to display at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="properties.length > 0">
                        <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getProperties(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getProperties(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getProperties(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getProperties(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar :value="listingDeleted" :timeout="4000" top color="green darken-1 white--text">
            A property listing has been deleted successfully.
            <v-btn text color="white--text" @click="listingDeleted = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            properties: [],
            filterView: false,
            q: '',
            filtered: [],
            pagination: {},
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
        listingDeleted(){
            return this.$store.getters.listingDeleted
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetStaffFlashMsg')
        next()
    },
    methods:{
        getProperties(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth/get_paginated_properties`
            axios.get(pag, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.properties = res.data.data
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
        showProp(prop){
            this.$router.push({name: 'StaffPropertyDetail', params:{id: prop.id}})
        }
    },
    mounted() {
        this.getProperties()
    },
}
</script>


<style lang="css" scoped>
    .table .properties_list tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table .properties_list tr td{
        cursor: pointer;
    }
    table tbody tr td{
        white-space: nowrap !important;
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }
</style>
