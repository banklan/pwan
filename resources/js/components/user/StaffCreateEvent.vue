<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New Event</v-card-title>
                    <v-card-text class="mt-5">
                        <v-text-field label="Event Title" v-model="event.title" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <v-textarea label="Detail" rows="2" auto-grow v-model="event.detail" v-validate="'required|min:10|max:800'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                        <v-text-field label="Venue" v-model="event.venue" v-validate="'required|min:3|max:220'" :error-messages="errors.collect('venue')" name="venue"></v-text-field>
                        <div class="text-center subtitle-1">Choose event date and time</div>
                        <v-menu ref="datePicker" v-model="datePicker" :close-on-content-click="false" :return-value.sync="event.event_date" transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="event.event_date" label="Date of Event" prepend-icon="event" readonly v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="event.event_date" color="primary" elevation="4" scrollable>
                                <div class="flex-grow-1"></div>
                                <v-btn text color="red darken-2" @click="datePicker = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.datePicker.save(event.event_date)">Ok</v-btn>
                            </v-date-picker>
                        </v-menu>
                        <v-menu ref="timePicker" v-model="timePicker" :close-on-content-click="false" :return-value.sync="event.event_time" transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="event.event_time" label="Time of Event" prepend-icon="event" readonly v-on="on"></v-text-field>
                            </template>
                            <v-time-picker v-model="event.event_time" color="primary" elevation="4" scrollable>
                                <div class="flex-grow-1"></div>
                                <v-btn text color="red darken-2" @click="timePicker = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.timePicker.save(event.event_time)">Ok</v-btn>
                            </v-time-picker>
                        </v-menu>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-6">
                        <v-btn large dark color="primary" @click="goToUploads" :loading="isBusy">Save & Upload Pictures<span right><i class="uil uil-arrow-right"></i></span></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="dateTimeError" :timeout="6000" top dark color="red darken-2">
            The event date and event time fields are required to create an event.
            <v-btn text color="white--text" @click="dateTimeError = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="createFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to create the event. Please ensure all fields are validly filled while trying again.
            <v-btn text color="white--text" @click="createFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isBusy: false,
            event: {
                title: '',
                detail: '',
                event_time: '',
                event_date: '',
                venue: ''
            },
            datePicker: false,
            timePicker: false,
            dateTimeError: false,
            createFailed: false,
        }
    },
    computed:{
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
    },
    methods: {
        goToUploads(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    if(this.event.event_date != '' && this.event.event_time !== ''){
                        this.isBusy = true
                        axios.post(this.api + '/auth/create_event', {
                            event: this.event
                        }, this.authHeaders).then((res) => {
                            this.isBusy = false
                            this.$store.commit('storeCreatedEvent', res.data)
                            this.$router.push({name: 'StaffCreateEventUpload', params:{id: res.data.id}})
                        }).catch(() => {
                            this.isBusy = false
                            this.createFailed = true
                        })
                    }else{
                        this.dateTimeError = true
                    }
                }
            })
        }
    },
}
</script>
