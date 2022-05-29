<template>
    <v-container>
        <v-row justify="center" class="mt-7">
            <v-col cols="12" md="4">
                <v-card elevation="16" color="primary white--text" raised height="450" shaped class="animate__animated animate__slideInLeft">
                    <v-card-title class="justify-center --text pt-10 headline font-weight-light">Our Mission</v-card-title>
                    <v-card-title class="justify-center">
                        <fas icon="space-shuttle" size="5x" color="#fff" id="space-shuttle"></fas>
                    </v-card-title>
                    <v-card-text class="title px-8 white--text">
                        To discover affordable land in fast developing areas and make these known to you and also show how you can make money to buy land and build your own home.
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" transition="scale-transition">
                <v-card elevation="16" color="primary white--text" raised height="450" shaped class="animate__animated animate__slideInRight ">
                    <v-card-title class="justify-center --text pt-10 headline font-weight-light">Our Vision</v-card-title>
                    <v-card-title class="justify-center">
                        <fas icon="binoculars" size="5x" color="#fff" id="space-shuttle"></fas>
                    </v-card-title>
                    <v-card-text class="title mt-10 px-8 white--text">
                        To make home ownership dream a reality for all in Nigeria, Africa and beyond.
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    methods: {
        divIntoView(){
            let docViewTop = window.screenTop
            let docViewBtm = docViewTop + window.height
            // console.log(docViewBtm)
        }
    },
    mounted(){
        this.divIntoView()
    }
}
</script>

<style lang="css" scoped>
    #space-shuttle{
        fill: yellow !important;
        width: 10.25rem !important;
    }
</style>
