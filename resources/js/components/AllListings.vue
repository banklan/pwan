<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <div class="title justify-center my-5">All Listings</div>
        </v-row>
        <v-row justify="start" class="mt-3">
            <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
            <template v-else>
                <v-col cols="12" md="4" v-for="prop in listings" :key="prop.id">
                    <listing-card :listing="prop"/>
                </v-col>
            </template>
        </v-row>
        <v-row>
            <v-col cols="12">
                <div class="pagination">
                    <span class="pl-4">
                            <v-btn color="primary" @click.prevent="getListings(pagination.first_link)" :disabled="!pagination.prev_link">&lt;&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getListings(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                            <v-btn color="primary" @click.prevent="getListings(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                            <v-btn color="primary" @click.prevent="getListings(pagination.last_link)" :disabled="!pagination.next_link">&gt;&gt;</v-btn>
                        </span>
                        <span class="pl-8">
                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                        </span>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            listings: [],
            pagination: {}
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getListings(pag){
            this.isLoading = true
            pag = pag || `${this.api}/get_listings`
            axios.get(pag).then((res) => {
                this.isLoading = false
                this.listings = res.data.data
                this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
            })
        }
    },
    mounted() {
        this.getListings()
    },
}
</script>
