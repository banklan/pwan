<template>
    <div class="news_slider">
        <section id="latest_news" class="swiper mySwiper">
            <h2 class="section_head"><span class="section_header">|</span>Latest News</h2>
            <div class="swiper-wrapper">
                <article class="swiper-slide" v-for="post in newsPosts" :key="post.id">
                    <div class="news">
                        <div class="file">
                            <template v-if="post.file.split('.').pop() === 'mp4'">
                                <video height="100%" controls>
                                    <!-- <source :src="`/images/news/${post.file}`" type="video/mp4"> -->
                                    <source :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </template>
                            <template v-else>
                                <!-- <v-img :src="`/images/news/${post.file}`" transition="scale-transition"></v-img> -->
                                <v-img :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" transition="scale-transition"></v-img>
                            </template>
                        </div>
                        <div class="news_details">
                            <p class="tit">{{ post.title | truncate(45)}} </p>
                            <small>Published {{ post.created_at | moment('Do, MMM YYYY') }}</small>
                            <p class="body">{{ post.detail | truncate(120) }}</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="swiper-pagination"></div>
        </section>
        <div class="cta">
            <v-btn raised elevation="12" x-large dark color="secondary" class="btn-cta justify-center" :to="{name: 'NewsPosts'}">View All News</v-btn>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newsPosts: [],
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getPosts(){
            this.isLoading = true
            axios.get(this.api + '/get_latest_news').then((res) => {
                this.isLoading = false
                this.newsPosts = res.data
                // console.log(res.data)
            })
        },
    },
    mounted() {
        this.getPosts()

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

        .swiper-wrapper{
            width: 100%;
            margin: 0 auto 4rem;

            .swiper-slide{
                border-radius: 6px;
                cursor: default;
                height: 11rem;
                overflow: hidden;
                border: 1px solid #e1e1e1;
                .news{
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    overflow: hidden;
                    height: 100%;
                    width: 100%;

                    .file{
                        width: 15rem;
                        height: 100%;
                        overflow: hidden;

                        img{
                            width: 100%;
                            height: 100%;
                        }

                        video{
                            width: 100%;
                            height: 100%;
                        }
                    }
                    .news_details{
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                        justify-content: center;
                        overflow: hidden;

                        .tit{
                            font-size: .9rem;
                            margin: 8px 0 0;
                            padding-top: 6px;
                        }
                        small{
                            font-size: .8rem;
                            font-style: italic;
                            color: #838383;
                        }
                        .body{
                            margin-top: .7rem;
                            font-size: .9rem;
                        }
                    }
                }
            }
        }
        .swiper-pagination-bullet{
            background: #001659;
        }
    }
    @media screen and (max-width: 900px){
        .latest_news{
            width: 100vw;
        }
    }
</style>
