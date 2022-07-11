<template>
    <section class="latest_events">
        <h2 class="section_head"><span class="section_header">|</span>Latest Events</h2>
       <carousel :autoplay="true" :perPage="2" :perPageCustom="[[0, 1],[1024,2]]" :speed="800" :autoplayTimeout="8000" loop :mouse-drag="false">
            <slide v-for="event in events" :key="event.id">
               <div class="slide_wrapper" @click="goToEvent(event)">
                   <div class="event_img">
                       <!-- <v-img :src="`/images/events/${event.event_files[0].file}`"></v-img> -->
                       <v-img :src="`https://pwanplatinum.s3.amazonaws.com/events/${event.event_files[0].file}`"></v-img>
                   </div>
                   <div class="event_details" @click="goToEvent(event)">
                        <div class="subject">
                            <h3>{{ event.title | truncate(45) }}</h3>
                            <small>{{ event.event_date | moment('Do MMM, YYYY')}}</small>
                        </div>
                        <div class="detail">
                            {{ event.detail | truncate(100) }} <span><router-link :to="{name: 'EventDetail', params:{id:event.id, slug:event.slug}}">Read More</router-link></span>
                        </div>
                   </div>
               </div>
            </slide>
        </carousel>
        <div class="cta">
            <v-btn raised elevation="12" x-large dark color="secondary" class="btn-cta justify-center" :to="{name: 'AllEvents'}">All Events</v-btn>
        </div>
    </section>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
export default {
    components: {
        Carousel,
        Slide
    },
    data() {
        return {
            events: [],
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getEvents(){
            this.isLoading = true
            axios.get(this.api + '/get_latest_events').then((res) => {
                this.isLoading = false
                this.events = res.data
            })
        },
        goToEvent(ev){
            this.$router.push({name: 'EventDetail', params:{id:ev.id, slug:ev.slug}})
        }
    },
    mounted() {
        this.getEvents()
    },
}
</script>

<style lang="scss" scoped>
    .latest_events{
        width: 80vw;
        margin: 0 auto;
        margin-top: 4rem;

        h2{
            margin: 2rem 2rem 3.5rem;
            text-align: center;
        }

        .slide_wrapper{
            height: 12rem;
            width: 100%;
            display: flex;
            gap: 1.5rem;
            cursor: pointer;

            .event_img{
                height: 100%;
                width: 100%;

                .v-image{
                    height: 100%;
                    width: 10rem;
                }
            }

            .event_details{
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                cursor: pointer;

                .subject{
                    text-align: center;
                    padding: .5rem;
                    h3{
                        font-size: 1rem;
                        // font-weight: 400;
                        margin-bottom: -.1rem;
                    }
                }
                .detail{
                    font-size: .9rem;
                    a{
                        color: rgb(2, 0, 94);
                        text-decoration: none;
                        transition: all .4s ease;

                        &:hover{
                            color: rgb(5, 2, 153);
                        }
                    }
                }
            }
        }
    }

     @media screen and (max-width: 900px){
        .latest_events{
            width: 100vw;
        }
    }
</style>
