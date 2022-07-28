<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left :to="{name: 'AdminFaqList'}"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n10':''">
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Faq Detail</v-card-title>
                    <v-card-text class="mt-8">
                        <template v-if="faq">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%" style="border-top: none">Question</th>
                                        <td style="border-top: none">{{ faq.qstn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Answer</th>
                                        <td>{{ faq.ans }}</td>
                                    </tr>
                                    <tr>
                                        <th>Extra</th>
                                        <td>{{ faq.extra }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ faq.user && faq.user.fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Published</th>
                                        <td>{{ faq.created_at | moment('Do MM, YYYY') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <template v-else>
                            <v-alert type="warning" border="left" class="mt-5">
                                The faq you are trying to view does not exist.
                            </v-alert>
                        </template>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn icon color="red darken-2" @click="confirmDelDial = true"><i class="uil uil-trash-alt"></i></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="confirmDelDial" max-width="450" v-if="faq">
            <v-card min-height="100">
                <v-card-title class="subtitle-1 white--text primary justify-center">Are you sure you want to delete this faq?</v-card-title>
                <v-card-actions class="pb-8 mt-8 justify-center">
                    <v-btn text width="40%" color="red darken--2" @click="confirmDelDial = false">Cancel</v-btn>
                    <v-btn dark width="40%" color="primary" :loading="isBusy" @click="delFaq">Yes, Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            faq: null,
            isLoading: false,
            confirmDelDial: false,
            isBusy: false,
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
        getFaq(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_faq/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.faq = res.data
            })
        },
        delFaq(){
            this.isBusy = true
            axios.post(this.api + `/auth-admin/del_faq/${this.$route.params.id}`, {}, this.adminHeaders)
            .then((res) =>{
                this.isBusy = false
                this.confirmDelDial = false
                this.$store.commit('faqDeleted')
                this.$router.push({name: 'AdminFaqList'})
            })
        }
    },
    mounted() {
        this.getFaq()
    },
}
</script>

<style lang="scss" scoped>
    .table tr{
        cursor: pointer;
    }
    .table tr td{
        vertical-align: middle !important;
    }
    .v-btn i{
        font-size: 1.1rem !important;
    }
    table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
    table tbody tr th{
        white-space: nowrap !important;
    }

    .v-card__actions button{
        margin: 0 20px !important;
    }

</style>
