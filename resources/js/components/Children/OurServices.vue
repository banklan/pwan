<template>
    <v-container>
        <v-row justify="center">
            <h2 class="section_head"><span class="section_header">|</span>Our Services</h2>
        </v-row>
        <v-row justify="start" wrap>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="/images/assets/constr.jpg" height="250" transition="fab-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Real Estate Development
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="/images/assets/mgt.jpg" height="250" transition="scale-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Real Estate Management
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="/images/assets/market.jpg" height="250" transition="scale-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Real Estate Marketing
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="/images/assets/survey.jpg" height="250" transition="scale-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Land Survey
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="/images/assets/training.jpg" height="250" transition="scale-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Trainings & Seminars
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="4" raised min-height="350">
                    <v-img src="images/assets/consultancy.jpg" height="250" transition="scale-transition"></v-img>
                    <v-card-title class="justify-center primary--text mt-4">
                        Consultancy
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-7">
            <v-col cols="12" md="3">
                <v-btn raised elevation="12" x-large block dark color="secondary" class="px-4" :to="{name: 'SubscriptionForm'}">Subscribe</v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<style lang="scss" scoped>
    .v-card{
        cursor: pointer;
        transition: all .4s ease !important;

        &:hover{
            box-shadow: 0 .8rem .8rem rgba(0, 0, 0, 0.1) !important;
        }
    }

    .v-btn{
        transition: all 0.4s ease;

        &:hover{
            border: 1px solid #E20000 !important;
            color: #E20000 !important;
            background: transparent !important;
            box-shadow: none !important;
        }
    }
</style>
