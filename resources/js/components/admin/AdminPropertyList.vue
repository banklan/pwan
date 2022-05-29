<template>
    <v-container>
        <v-row justify="center" >
            <v-col cols="10" md="6">
                <v-text-field placeholder="Search for Properties" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="filter"></v-text-field>
            </v-col>
            <v-col cols="2" md="1" v-if="filterView">
                <v-btn small text color="red" @click="clear" class="mt-1"><i class="ui uil-clear"></i></v-btn>
            </v-col>
        </v-row>
        <v-row v-if="filterView" justify="center" class="mt-n5" >
            <v-col cols="12">
                <div class="text-center subtitle-1">Search <strong>{{ q }}</strong> returned {{ filtered.length | pluralize('property') }}</div>
            </v-col>
        </v-row>
        <v-row class="mt-2 pr-5" justify="center" >
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised elevation="8" min-height="100" class="scroll">
                        <v-card-title class="primary white--text subtitle-1 justify-center">Properties Listing <span v-if="properties.length > 0 && !filterView"><v-chip color="primary lighten-2 ml-2">{{ properties.length }}</v-chip></span></v-card-title>
                        <v-card-text>
                        <table class="table table-hover table-striped" v-if="properties.length > 0">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Approved</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="properties_list">
                                <template v-if="!filterView">
                                    <tr v-for="(prop, i) in properties" :key="prop.id">
                                        <td @click="showProp(prop)">{{ i + 1 }}</td>
                                        <td @click="showProp(prop)">{{ prop.id }}</td>
                                        <td @click="showProp(prop)">{{ prop.name }}</td>
                                        <td @click="showProp(prop)">{{ prop.status ? 'Active' : 'Inactive'}} </td>
                                        <td @click="showProp(prop)">{{ prop.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                        <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateUser', params:{id: prop.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(prop.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="(prop, i) in filtered" :key="prop.id" :class="!prop.authorized_by ? 'warning--text' : ''">
                                        <td>{{ i + 1 }}</td>
                                        <td @click="showProp(prop)">{{ prop.id }}</td>
                                        <td @click="showProp(prop)">{{ prop.name }}</td>
                                        <td @click="showProp(prop)">{{ prop.status ? 'Active' : 'Inactive'}} </td>
                                        <td @click="showProp(prop)">{{ prop.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                        <td><v-btn icon color="admin_a" :to="{name: 'AdminUpdateUser', params:{id: prop.id}}"><i class="uil uil-edit"></i></v-btn> &nbsp; <v-btn icon color="red darken-2" @click="confirmDel(prop.id, i)"><i class="uil uil-trash-alt"></i></v-btn></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <v-alert class="mt-5" type="info" border="left" v-else>
                            There are no properties to display at the moment.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="my-5" v-if="properties.length > 0 && !filterView">
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
        adminUpdatedUser(){
            return this.$store.getters.adminUpdatedUser
        },
        adminDeletedUser(){
            return this.$store.getters.adminDeletedUser
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetAdminFlashMsg')
        next()
    },
    methods:{
        getProperties(pag){
            this.isLoading = true
            pag = pag || `${this.api}/auth-admin/get_paginated_properties`
            axios.get(pag, this.adminHeaders)
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
            this.$router.push({name: 'AdminPropertyDetail', params:{id: prop.id}})
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
