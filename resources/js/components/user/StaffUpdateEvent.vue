<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click.prevent="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5" >
            <v-col cols="12" md="10">
                <v-progress-circular indeterminate color="primary" :width="4" :size="40" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <v-card v-else light raised outlined elevation="4" min-height="400" class="scroll">
                    <v-card-title class="primary white--text justify-center subtile-1">Event Update</v-card-title>
                    <v-card-text class="mt-8 ml-5">
                        <v-textarea label="Title" v-model="event.title" rows="1" auto-grow required v-validate="'required|min:5|max:300'" :error-messages="errors.collect('title')"  name="title" data-vv-as="title"></v-textarea>
                        <v-textarea label="Detail" v-model="event.detail" rows="2" auto-grow required v-validate="'required|min:10|max:800'" :error-messages="errors.collect('detail')"  name="detail" data-vv-as="detail"></v-textarea>
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
                    <v-card-actions class="justify-center pb-8">
                        <v-btn text large color="red darken-2" @click="$router.go(-1)" width="40%">Cancel</v-btn>
                        <v-btn dark color="primary" large :loading="isBusy" @click="updateEvent" width="40%">Update</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="dateTimeError" :timeout="6000" top dark color="red darken-2">
            The event date and time fields cannot be empty. Please choose appropriate date and time.
            <v-btn text color="white--text" @click="dateTimeError = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="updatefailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to update the event. Ensure all fields are filled validly while trying again.
            <v-btn text color="white--text" @click="updatefailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            event: {},
            isLoading: false,
            datePicker: false,
            timePicker: false,
            isBusy: false,
            dateTimeError: false,
            updatefailed: false
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
        getEvent(){
            this.isLoading = true
            axios.get(this.api + `/auth/get_event/${this.$route.params.id}`, this.authHeaders)
            .then((res) => {
                this.isLoading = false
                this.event = res.data
            })
        },
        updateEvent(){
            this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    if(this.event.event_date != '' && this.event.event_time != ''){
                        this.isBusy = true
                        axios.post(this.api + `/auth/update_event/${this.$route.params.id}`, {
                            event: this.event
                        }, this.authHeaders).then((res) => {
                            this.isBusy = false
                            this.$store.commit('eventUpdated')
                            this.$router.push({name: 'StaffEventDetail', params: {id: res.data.id}})
                            // console.log(res.data)
                        }).catch(()=>{
                            this.isBusy = false
                            this.updatefailed = true
                        })
                    }else{
                        this.dateTimeError = true
                    }
                }
            })
        }
    },
    mounted() {
        this.getEvent()
    },
}
</script>
