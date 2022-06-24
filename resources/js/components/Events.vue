<template>
    <v-container>
        <v-row justify="center" class="">
            <v-col cols="12" md="12">
                <div class="all_events">
                    <div class="pg_header">All Events</div>
                    <div class="events_wrap">
                        <div class="event" v-for="event in events" :key="event.id" @click="goToevent(event)">
                            <img v-if="event.event_files.length > 0" :src="`/images/events/${event.event_files[0].file}`" alt="event">
                            <img v-else src="/images/assets/no-image.png" alt="event">
                            <div class="details">
                                <div class="evnt_title">{{ event.title | truncate(40) }}</div>
                                <div class="date">{{ event.event_date | moment('Do MMM, YYYY')}} - {{ event.evnt_time }}</div>
                                <div class="location"><i class="uil uil-map-marker"></i><span class="ml-1">{{ event.venue }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            events: []
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getEvents(){
            this.isLoading = true
            axios.get(this.api + '/get_all_events').then((res) => {
                this.isLoading = false
                this.events = res.data
            })
        },
        goToevent(ev){
            this.$router.push({name: 'EventDetail', params:{id:ev.id, slug:ev.slug}})
        }
    },
    created(){
        this.getEvents()
    }
}
</script>

<style lang="scss" scoped>
.all_events{
    margin: 0 auto;
    width: 100%;

    .pg_header{
        font-size: 1.2rem;
        text-align: center;
        FONT-WEIGHT: 400;
        color: #2e2e2e;
        margin: 2rem auto;
    }
    .events_wrap{
        width: 100%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 2rem;
        box-sizing: border-box;

        .event{
            border: 1px solid #e3e3e3;
            border-radius: 6px;
            box-sizing: border-box;
            overflow: hidden;
            cursor: pointer;
            transition: all .4s ease;

            &:hover{
                box-shadow: 0 6px 8px rgba(0,0,0,0.25);
            }

            img{
                width: 100%;
                height: 18rem;
            }

            .details{
                text-align: center;
                margin: 1rem auto;

                .evnt_title{
                    font-size: 1rem;
                    font-weight: 400;
                }
                .date, .location{
                    font-size: .9rem;
                    color: rgb(63, 63, 63);
                    padding: 4px;
                }
                .location i{
                    color: #001659;
                    font-size: 1.1rem;
                }
            }
        }
    }
}

@media screen and (max-width: 959px){
    .all_events{
        .pg_header{
            font-size: 1.1rem;
        }
        .events_wrap{
            width: 95%;
            grid-template-columns: 1fr 1fr;
        }
    }
}
@media screen and (max-width: 768px){
    .all_events{
        .events_wrap{
            width: 100%;
            gap: 1rem;
        }
    }
}
@media screen and (max-width: 600px){
    .all_events{
        .events_wrap{
            gap: 2rem;
            width: 90%;
            height: fit-content;
            grid-template-columns: 1fr;
        }
    }
}
</style>
