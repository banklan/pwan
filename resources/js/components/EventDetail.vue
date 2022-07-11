<template>
    <v-container>
        <v-row justify="center" class="mt-3">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card elevation="4" raised light min-height="200" class="mx-auto" v-else>
                    <v-card-title class="primary white--text justify-center subtile-1">Event Detail</v-card-title>
                    <v-card-text class="mt-8">
                        <template v-if="event">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th width="20%" style="border-top: none">Title</th>
                                        <td style="border-top: none">{{ event.title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Event Date</th>
                                        <td>{{ event.event_date | moment('Do MMM, YYYY') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Event Time</th>
                                        <td>{{ event.evnt_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Venue</th>
                                        <td>{{ event.venue }}</td>
                                    </tr>
                                    <tr>
                                        <th>Detail</th>
                                        <td>{{ event.detail }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <v-alert type="warning" border="left" v-else>
                            The event you are trying to view is not available. Please pick an event from the list on the Events list page.
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card min-height="200" min-width="80%" class="mt-5" v-if="event">
                    <template v-if="event && event.event_files.length > 0">
                        <v-carousel min-height="700">
                            <!-- <v-carousel-item contain v-for="(file, i) in event.event_files" :key="i" :src="`/images/events/${file.file}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item> -->
                            <v-carousel-item contain v-for="(file, i) in event.event_files" :key="i" :src="`https://pwanplatinum.s3.amazonaws.com/events/${file.file}`" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                        </v-carousel>
                    </template>
                    <template v-else>
                        <v-alert type="info" class="mt-5 mx-4">
                            There are no files for this event.
                        </v-alert>
                    </template>
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
            event: null,
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getEvent(){
            this.isLoading = true            //${this.$route.params.id}
            axios.get(this.api + `/get_event/${this.$route.params.id}`)
            .then((res) => {
                this.isLoading = false
                this.event = res.data
                // console.log(res.data)
            })
        }
    },
    mounted() {
        this.getEvent()
    },
}
</script>

<style lang="scss" scoped>
    table tbody tr th, table tbody tr td{
        height: 3rem !important;
        font-size: .9rem !important;
        line-height: 1.8 !important;
    }
</style>
