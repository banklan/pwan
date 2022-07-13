<template>
<div class="core_values">
    <v-container>
        <v-row justify="center" class="mt-2 mb-5">
            <v-col cols="12" md="6">
                <v-card elevation="12" raised rounded="12" height="300" color="white" class="mx-auto px-5 mt-n10">
                    <v-card-title class="justify-center secondary--text font-weight-regular headline">Our Core values</v-card-title>
                    <v-card-text>
                        <div class="listed">A - Accountability </div>
                        <div class="listed">R - Responsibility </div>
                        <div class="listed">I - Integrity </div>
                        <div class="listed">S - Service </div>
                        <div class="listed">E - Excellence </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    </div>
</template>

<style lang="css" scoped>
    .core_values{
        min-height: 15rem;
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100vw;
        /* background-image: linear-gradient(to bottom left,  rgba(18, 19, 60, 0.87), rgba(14, 14, 53, 0.87), rgba(10, 10, 54, 0.87), rgba(6, 7, 49, .88)); */
        background-image: linear-gradient(to bottom left,  rgb(226 0 0 / 90%), rgb(179 0 0 / 94%), rgb(177 6 6 / 90%), rgb(255 0 0 / 90%));
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .row{
        height: 60px;
        padding:  0 20px;
    }
    .core_values .v-card__text{
        margin-left: 15px;
    }
    .core_values .v-card__text .listed{
        font-size: 1.3rem;
        line-height: 1.8;
        color: rgb(48, 48, 48);
    }

    @media screen and (max-width: 722px) {
        .v-card{
            height: 380px;
        }
    }
</style>
