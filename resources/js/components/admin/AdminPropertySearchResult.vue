<template>
    <v-container>
        <div class="upper_row">
            <div class="back">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminPropertyList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </div>
            <div class="search">
                <div class="search_field">
                    <admin-search model="Property" searchFor="properties"/>
                </div>
            </div>
        </div>
        <v-row class="mt-5 mr-5">
            <v-col cols="12">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <div class="grey_text--text text-center mb-5">
                        Search for <strong><em>{{ $route.query.q }}</em></strong> returned {{ properties.length }} listing.
                    </div>
                    <v-card light raised elevation="8" min-height="100" class="scroll">
                        <template v-if="properties.length > 0">
                            <v-card-title class="subtitle-1 primary white--text justify-center"> Properties Listing <v-chip color="primary lighten-2" class="ml-1" v-if="properties.length > 0">{{ properties.length }}</v-chip></v-card-title>
                            <v-card-text class="mt-5">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Approval Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="news_list">
                                        <tr v-for="(prop) in properties" :key="prop.id">
                                            <td @click="showProp(prop)">{{ prop.id }}</td>
                                            <td @click="showProp(prop)">{{ prop.name }}</td>
                                            <td @click="showProp(prop)">{{ prop.status ? 'Active' : 'Inactive'}} </td>
                                            <td @click="showProp(prop)">{{ prop.is_approved ? 'Approved' : 'Not Approved' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </template>
                        <template v-else>
                            <v-card-text>
                                <v-alert type="error" border="left" class="mt-8 mx-3">
                                    Search for {{ $route.query.q }} returned no listing.
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
            properties: [],
        }
    },
    watch: {
        '$route.query.q':{
            handler(newVal){
                this.properties = newVal
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
            axios.post(this.api + '/auth-admin/search_for_properties', {
                q: this.$route.query.q
            }, this.adminHeaders).then((res)=>{
                this.isLoading = false
                this.properties = res.data
            }).catch(()=>{
                this.isLoading = false
            })
        },
       showProp(prop){
            this.$router.push({name: 'AdminPropertyDetail', params:{id: prop.id}})
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
