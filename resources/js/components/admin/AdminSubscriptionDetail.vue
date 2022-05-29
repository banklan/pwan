<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><i class="uil uil-arrow-left"></i>Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" :class="$vuetify.breakpoint.smAndDown ? 'ml-n3 mr-n5': ''">
            <v-col cols="12" md="11">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card light elevation="6" raised min-height="200" class="mx-auto" v-else>
                    <v-card-title class="justify-center primary white--text subtitle-1">Subscription Detail</v-card-title>
                    <v-card-text class="mt-5" v-if="sub">

                        <v-row justify="center" class="details">
                            <v-col cols="12" md="9">
                                <div class="subtitle-1 text-center primary white--text py-3">Subscriber's Details</div>
                                <div class="mt-5 sub_det">
                                    <table class="table table-striped table-hover" v-if="sub">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <th width="30%">Surname: </th>
                                                <td>{{ sub.surname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Other Names: </th>
                                                <td>{{ sub.other_names }}</td>
                                            </tr>
                                            <tr>
                                                <th>Spouse Surname: </th>
                                                <td>{{ sub.spouse_surname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Spouse Other Names: </th>
                                                <td>{{ sub.spouse_names }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender: </th>
                                                <td>{{ sub.gender }}</td>
                                            </tr>
                                            <tr>
                                                <th>Marital Status: </th>
                                                <td>{{ sub.mar_status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nationality: </th>
                                                <td>{{ sub.nationality }}</td>
                                            </tr>
                                            <tr>
                                                <th>Occupation: </th>
                                                <td>{{ sub.occupation }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date Of Birth: </th>
                                                <td>{{ sub.date_of_bt }}</td>
                                            </tr>
                                            <tr>
                                                <th>Employer: </th>
                                                <td>{{ sub.employer }}</td>
                                            </tr>
                                            <tr>
                                                <th>Residential Country: </th>
                                                <td>{{ sub.res_country }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone No: </th>
                                                <td>{{ sub.phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Mobile No: </th>
                                                <td>{{ sub.mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address: </th>
                                                <td>{{ sub.address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5 next_kin">
                                    <div class="subtitle-1 text-center primary white--text py-3">Subscriber's Next Of Kin Details</div>
                                    <table class="table table-hover table-striped">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <th width="30%">Next Of Kin Name: </th>
                                                <td>{{ sub.kin_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Next Of Kin Phone No: </th>
                                                <td>{{ sub.phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Next Of Kin Mobile No: </th>
                                                <td>{{ sub.mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th>Next Of Kin Address: </th>
                                                <td>{{ sub.kin_address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5 plot">
                                    <div class="subtitle-1 text-center primary white--text py-3">Other Details</div>
                                    <table class="table table-hover table-striped">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <th width="30%">Plot Type: </th>
                                                <td>{{ sub.plot_type }}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Plans: </th>
                                                <td>{{ sub.pay_plans }} months</td>
                                            </tr>
                                            <tr>
                                                <th>Plot Size: </th>
                                                <td>{{ sub.plot_size }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date Submitted: </th>
                                                <td>{{ sub.created }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </v-col>
                            <v-col cols="12" md="3">
                                <div class="pspt">
                                    <v-img :src="`/images/subscriptions/${sub.picture}`" width="200" height="240" alt="Passport Picture"></v-img>
                                </div>
                            </v-col>
                        </v-row>
                   </v-card-text>
                   <v-card-actions class="justify-center pb-8">
                       <v-btn v-if="sub" dark text color="admin_a" :href="`http://localhost:8000/download-subscription-form/${sub.id}`"><i class="uil uil-download-alt"></i><span class="pl-1">Download</span></v-btn>
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
            sub: null,
            isDownloading: false
        }
    },
    computed: {
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
        }
    },
    methods: {
        getSub(){
            this.isLoading = true
            axios.get(this.api + `/auth-admin/get_subscription/${this.$route.params.id}`, this.adminHeaders)
            .then((res) => {
                this.isLoading = false
                this.sub = res.data
            })
        },
    },
    mounted(){
        this.getSub()
    }
}
</script>

<style lang="scss" scoped>
    .pspt{
        border: 1px solid #fcfcfc;
        border-radius: 3px;
        overflow: hidden;
        box-sizing: border-box;
        box-shadow: 0 3px 3px rgba(0,0,0,0.1);
    }
    table tbody tr {
        height: 3rem !important;
        th, td{
            vertical-align: middle !important;
            white-space: nowrap !important;
        }
    }
    .v-card.scroll .v-card__text{
        overflow-x: scroll !important;
    }

</style>
