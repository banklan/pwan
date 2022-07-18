<template>
    <section id="testimonials" class="swiper mySwiper">
        <h2 class="section_head"><span class="section_header">|</span>What Our Clients Said</h2>
        <div class="swiper-wrapper">
            <article class="swiper-slide" v-for="test in testimonials" :key="test.id">
                <div class="client">
                    <div class="avatar">
                        <img v-if="test.picture" :src="`https://pwanplatinum.s3.amazonaws.com/testimonials/${test.picture}`" :alt="test.fullname">
                    </div>
                    <div class="client_details">
                        <p class="tit">{{ test.title }} </p>
                        <p class="name">{{ test.fullname }}</p>
                        <small>{{ test.occupation }}, {{ test.organization }}</small>
                        <p class="body">{{ test.detail | truncate(100) }}</p>
                    </div>
                </div>
            </article>
        </div>
        <div class="swiper-pagination"></div>
    </section>
</template>

<script>
export default {
    data(){
        return{
            testimonials: []
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getTestimonials(){
            axios.get(this.api + '/get_feat_testimonials').then((res) => {
                this.testimonials = res.data
            })
        }
    },
    mounted() {
        this.getTestimonials()

       var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },

        // responsive breakpoints, note that swiperjs is mobile first
            breakpoints: {
                // when window width is >= 600px
                600: {
                    slidesPerView: 1
                },
                1024: {
                    slidesPerView: 2
                }
            }
        })
    },
}
</script>


<style lang="scss" scoped>
    .swiper{
        width: 94vw;
        margin-top: 0 auto;

        & > h2{
            margin-bottom: 2.5rem;
            padding-top: 2rem;
            text-align: center;
        }

        & > p{
            text-align: center;
            width: 42%;
            margin: 0.8rem auto;
            padding-bottom: 2rem;
        }

        .swiper-wrapper{
            width: 100%;
            margin: 0 auto 4rem;

            .swiper-slide{
                background: linear-gradient(135deg, #01134e, #3E4095);
                color: #fff;
                padding: 1.5rem 1rem;
                border-radius: 1rem;
                cursor: default;
                overflow: hidden;

                p{
                    margin-bottom: 1.5rem;
                }

                .client{
                    display: flex;
                    align-items: center;
                    gap: 1.5rem;
                    overflow: hidden;

                    .avatar{
                        width: 5rem;
                        aspect-ratio: 1/1;
                        border-radius: 50%;
                        overflow: hidden;

                        img{
                            width: 100%;
                            height: 100%;
                        }
                    }
                    .client_details{
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                        justify-content: center;
                        padding: 0 5px;
                        overflow: hidden;

                        .tit{
                            font-size: 1rem;
                            margin: 5px 0;

                        }
                        .name{
                            font-size: .9rem;
                        }
                        small{
                            font-size: .8rem;
                            font-style: italic;
                            color: #d1d1d1;
                            margin-top: -27px;
                        }
                        .body{
                            margin-top: .5rem;
                            font-size: .9rem;
                        }
                    }
                }

                @media screen and (max-width: 722px) {
                    .client{
                        flex-direction: column;
                        gap: 1.2rem;
                        margin: 0 auto;

                        .avatar{
                            width: 6rem;
                        }
                    }
                }
            }
        }
        .swiper-pagination-bullet{
            background: #001659;
        }
    }

// *=================================MEDIA QUERIES (SMALL)================================*
@media screen and (max-width: 600px){
    .swiper{
        .swiper-wrapper{
            .swiper-slide{
                padding: 1.5rem;
            }
        }
    }
}

</style>
