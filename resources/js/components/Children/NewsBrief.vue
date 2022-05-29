<template>
    <div class="news_brief">
        <v-container>
            <v-row justify="center">
                <v-col cols="12">
                    <h2 class="section_head"><span class="section_header">|</span>Latest News</h2>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-4">
                <v-col cols="12" md="4">
                    <v-card flat outlined min-height="100" class="px-2 py-3" to="/news">
                        <v-card-actions class="justify-space-between">
                            <v-img src="/images/assets/news1.jpg" height="100" width="100" transition="scale-transition"></v-img>
                            <div class="ml-3">
                                <div class="subtitle-2 font-weight-bold primary--text darken-3">Lorem ipsum dolor maxime?</div>
                                <div class="subtitle-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis porro praesentium maxime?</div>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card flat outlined min-height="100" class="px-2 py-3" to="/news">
                        <v-card-actions class="justify-space-between">
                            <v-img src="/images/assets/news2.jpg" height="100" width="100" transition="scale-transition"></v-img>
                            <div class="ml-3">
                                <div class="subtitle-2 font-weight-bold primary--text darken-3">Lorem ipsum dolor maxime?</div>
                                <div class="subtitle-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis porro praesentium maxime?</div>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card flat outlined min-height="100" class="px-2 py-3" to="/news">
                        <v-card-actions class="justify-space-between">
                            <v-img src="/images/assets/news3.jpg" height="100" width="100" transition="scale-transition"></v-img>
                            <div class="ml-3">
                                <div class="subtitle-2 font-weight-bold primary--text darken-3">Lorem ipsum dolor maxime?</div>
                                <div class="subtitle-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis porro praesentium maxime?</div>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center" class="mt-7">
                <v-col cols="12" md="3">
                    <v-btn raised elevation="12" x-large block dark color="secondary" class="px-4">More News</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<style lang="scss" scoped>
    .news_brief{
        margin-top: 10rem !important;
        padding: 10px;

        .v-card{
            cursor: pointer;
            text-decoration: none;
        }

        .v-card .v-image{
            border-radius: 6px !important;
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
    }
</style>
