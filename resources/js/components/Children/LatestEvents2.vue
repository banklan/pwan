<template>
    <section class="latest_events">
        <h2 class="section_head">Latest Events</h2>
       <carousel :autoplay="true" perPage="3" :perPageCustom="[[0, 1],[1024,3]]" speed="800" autoplayTimeout="8000" loop :navigate-to="someLocalProperty" :mouse-drag="true">
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event1.jpeg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 1 Subject</h3>
                        <small>25th May, 2022</small>
                        <div class="event_details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event2.jpeg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 2 Subject</h3>
                        <small>17th May, 2022</small>
                        <div class="event_details">
                            Event 2 ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event3.jpg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 3 Subject</h3>
                        <small>1st June, 2022</small>
                        <div class="event_details">
                            Event 3 ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event4.jpg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 4 Subject</h3>
                        <small>30th May, 2022</small>
                        <div class="event_details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event5.jpg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 5 Subject</h3>
                        <small>23rd July, 2022</small>
                        <div class="event_details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>
            <slide>
               <div class="slide_wrapper">
                   <div class="event_img">
                       <v-img src="/images/events/event6.jpeg"></v-img>
                   </div>
                   <div class="event_details">
                        <h3 class="event_subject">Event 6 Subject</h3>
                        <small>1st August, 2022</small>
                        <div class="event_details">
                            Event 6 Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed at voluptatum inventore commodi, nemo est, corrupti, maxime explicabo libero hic possimus assumenda beatae repudiandae molestiae dolores..Read More
                        </div>
                   </div>
               </div>
            </slide>

        </carousel>
    </section>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
export default {
    components: {
        Carousel,
        Slide
    }
}
</script>

<style lang="scss" scoped>
    .latest_events{
        width: 80vw;
        // height: 6rem;
        margin: 0 auto;
        margin-top: 15rem;

        h2{
            margin: 2rem 3rem;
            text-align: center;
        }

        .slide_wrapper{
            display: flex;
            flex-direction: column;
            gap: 1rem;

            .event_img{
                height: 12rem;
                width: 8rem;
                // overflow: hidden;

                .v-image{
                    height: 100%;
                    width: 100%;
                }
            }
        }
    }
</style>
