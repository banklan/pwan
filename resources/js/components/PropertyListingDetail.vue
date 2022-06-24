<template>
    <v-container>
        <v-row class="mt-5">
            <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i>Back</v-btn>
        </v-row>
        <v-row justify="center">
            <v-col cols="12">
                <div class="prop_title text-center">{{ prop && prop.name }}</div>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <div class="wrapper" v-else>
                    <div class="files">
                        <v-card min-height="650" class="mt-5" v-if="prop && prop.files.length > 0">
                            <v-carousel height="650" cycle hide-delimiter-background>
                                <v-carousel-item contain v-for="(file, i) in prop.files" :key="i" :src="`/images/properties/${file.image}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                            </v-carousel>
                        </v-card>
                    </div>
                    <div class="details">
                        <div class="text-center subj">Details</div>
                        <table class="table">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <th style="border-top: none" width="20%">Location:</th>
                                    <td style="border-top: none">{{ prop.location }}</td>
                                </tr>
                                <tr>
                                    <th>Landmark:</th>
                                    <td>{{ prop.landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Title:</th>
                                    <td>{{ prop.title }}</td>
                                </tr>
                                <tr>
                                    <th>Details:</th>
                                    <td>{{ prop.detail }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cta">
                        <v-btn x-large dark color="secondary" raised elevation="6" :to="{name: 'SubscriptionForm' }">Subscribe</v-btn>
                    </div>
                </div>
            </v-col>
            <v-col cols="12" md="4">
                <v-card light min-height="200" class="mt-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Plans</v-card-title>
                    <v-card-text class="mt-5">
                        <template v-if="prop.property_listing_plans.length > 0">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Sub. Plan</th>
                                        <th>Unit</th>
                                        <th>Price(&#8358;)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="plan in prop.property_listing_plans" :key="plan.id">
                                        <td>{{ plan.name }}</td>
                                        <td>{{ plan.unit }}</td>
                                        <td>{{ plan.price / 100 | price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <template v-else>
                            <v-alert type="info" class="mt-5">
                                Kindly contact us on 08025886719, 08057165471, 08025886718, 08163451098 or email pwan.platinum@gmail.com for the available plans for this listing.
                            </v-alert>
                        </template>
                    </v-card-text>
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
            prop: null,
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getListing(){
            this.isLoading = true
            axios.get(this.api + `/get_listing/${this.$route.params.id}`)
            .then((res) => {
                this.isLoading = false
                this.prop = res.data
            })
        }
    },
    mounted() {
        this.getListing()
    },
}
</script>

<style lang="scss" scoped>
    table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
    table tbody tr th{
        white-space: nowrap !important;
    }
    .table tr td, table tr th{
        vertical-align: middle !important;
    }
    .prop_title{
        text-align: center;
        font-size: 1.2rem;
        color: #2c2c2c;
        margin: 1rem auto;
    }
    .wrapper{
        .files{
            width: 100%;
        }
        .details{
            margin-top: 2rem;

            .subj{
                text-align: center;
                font-size: 1.1rem;
                margin-top: 1rem;
                margin-bottom: 1.2rem;
            }
        }
    }
</style>
