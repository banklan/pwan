<template>
  <div class="swiper-container">
      <div class="swiper-wrapper">
          <!-- Slides -->

          <!-- <div class="swiper-slide">Slide 3</div> -->
          <div class="swiper-slide" v-for="event in events" :key="event.id">
              <div class="slide_wrapper" @click="goToEvent(event)">
                   <div class="event_img">
                       <v-img :src="`/images/events/${event.event_files[0].file}`"></v-img>
                       <!-- <v-img :src="`https://pwanplatinum.s3.amazonaws.com/events/${event.event_files[0].file}`"></v-img> -->
                   </div>
                   <div class="event_details" @click="goToEvent(event)">
                        <div class="subject">
                            <h3>{{ event.title | truncate(45) }}</h3>
                            <small>{{ event.event_date | moment('Do MMM, YYYY')}}</small>
                        </div>
                        <div class="detail">
                            {{ event.detail | truncate(120) }} <span><router-link :to="{name: 'EventDetail', params:{id:event.id, slug:event.slug}}">Read More</router-link></span>
                        </div>
                   </div>
               </div>
          </div>
      </div>
      <!-- If we need pagination -->
      <div class="swiper-pagination"></div>

      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>

      <!-- If we need scrollbar -->
      <div class="swiper-scrollbar"></div>
  </div>
</template>

<script>
import Swiper, { Navigation, Pagination } from 'swiper'
import 'swiper/swiper-bundle.css'

Swiper.use([ Navigation, Pagination ])

export default {
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
  mounted() {
      this.getEvents()
    new Swiper('.swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      scrollbar: {
        el: '.swiper-scrollbar',
      },
    })
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
    }
}
</script>

<style lang="scss" scoped>
    .swiper-container {
    width: 35vw;
    height: 300px;
    }
    .slide_wrapper{
            height: 12rem;
            width: 100%;
            display: flex;
            // gap: 1rem;
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
                margin-left: -2rem;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: flex-start;
                cursor: pointer;

                .subject{
                    text-align: center;
                    padding: .5rem;
                    h3{
                        font-size: 1rem;
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
</style>
