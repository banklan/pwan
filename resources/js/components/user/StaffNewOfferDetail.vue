<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'StaffNewOffers'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="6">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else elevation="4" raised min-height="200" class="mx-auto">
                    <template v-if="offer">
                        <!-- <v-img :src="`/images/offers/${offer.flier}`" :alt="offer.title"></v-img> -->
                        <v-img :src="offerFlier" :alt="offer.title"></v-img>
                        <v-card-text>
                            <div class="text-center tit">{{ offer.title }}</div>
                        </v-card-text>
                        <v-card-actions class="justify-center pb-6 mt-n5" v-if="authUser.id === offer.user_id">
                            <v-btn icon color="primary" class="mx-4" :to="{name: 'StaffOfferEdit', params:{id: offer.id}}"><i class="uil uil-edit"></i></v-btn>
                            <v-btn icon color="red darken-1" class="mx-4" @click="confirmDelDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                        </v-card-actions>
                    </template>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this new offer?</v-card-title>
                <v-card-text class="mt-5 grey_text--text">
                    Once deleted, the new offer cannot be retrieved.
                </v-card-text>
                <v-card-actions class="pb-8 mt-5justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delNewOffer">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar :value="newOfferUpdated" :timeout="4000" top dark color="green darken-2">
            A new offer has been updated successfully.
            <v-btn text color="white--text" @click="newOfferUpdated = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            offer: null,
            isLoading: false,
            confirmDelDial: false,
            isBusy: false,
            offerFlier: ''
        }
    },
    beforeRouteLeave (to, from, next) {
        this.$store.commit('resetStaffFlashMsg')
        next()
    },
    computed: {
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
        newOfferUpdated(){
            return this.$store.getters.newOfferUpdated
        }
    },
    methods: {
        getOffer(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_new_offer/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.offer = res.data
                console.log(res.data)
                // this.getFlierFromS3()
            })
        },
        getFlierFromS3(){
            axios.get(this.api + `/auth/get_new_offer_flier/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                console.log(res.data)
                this.offerFlier = res.data
            })
        },
        delNewOffer(){
            this.isBusy = true
            axios.post(this.api + `/auth/delete_new_offer/${this.$route.params.id}`, {}, this.authHeaders)
            .then((res) => {
                this.isBusy = false
                this.$router.push({name:'StaffNewOffers'})
                this.$store.commit('newOfferDeleted')

            })
        }
    },
    mounted() {
        this.getOffer()
    },
}
</script>


<style lang="scss" scoped>
.v-card{
    .v-image{
        height: 80%;
        width: 100%;
    }
    .tit{
        font-size: 1rem;
        color: #2e2e2e;
        text-align: center;
        margin: 1rem auto;
    }
    .v-card__actions{
        .v-btn{
            i{
                font-size: 1rem !important;
            }
        }
    }
}
</style>
