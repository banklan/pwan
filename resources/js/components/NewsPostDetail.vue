<template>
    <div class="cont">
        <div class="back_btn">
            <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i>Back</v-btn>
        </div>
        <div class="wrapper">
            <div class="pg_header">
                <div class="title">{{ post.title }}</div>
                <div class="pub">Published {{ post.published }}</div>
            </div>
            <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
            <div class="news_wrap" v-else>
                <div class="news">
                    <div class="file">
                        <template v-if="post.file.split('.').pop() === 'mp4'">
                            <video height="100%" controls>
                                <source :src="`/images/news/${post.file}`" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                        <template v-else>
                            <img v-if="post.file" :src="`/images/news/${post.file}`" alt="news picture">
                            <img v-else src="/images/assets/no-image.png" alt="news picture">
                        </template>
                    </div>
                    <div class="details">
                        <div class="body">
                            <p> {{ post.detail }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: null,
            isLoading: false,
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getPost(){
            this.isLoading = true
            axios.get(this.api + `/get_news_post/${this.$route.params.id}`)
            .then((res) => {
                this.isLoading = false
                this.post = res.data
            })
        }
    },
    created() {
        this.getPost()
    }
}
</script>

<style lang="scss" scoped>
.cont{
    margin: 0 auto;
    width: 90%;
    .back_btn{
        float: left;
        margin: 3rem 2rem;
    }
    .wrapper{
        margin: 4rem auto;
        text-align: center;
        width: 90%;
        box-sizing: border-box;

        .pg_header{
            text-align: center;
            margin: 1rem 1.2rem 2rem;

            .title{
                font-size: 1.1rem !important;
                color: #2e2e2e;
                font-weight: 400;
                margin-bottom: 5px;
            }
            @media screen and (max-width: 700px){
                .title{
                    font-size: 1rem !important;
                    font-weight: 400;
                }
            }

            .pub{
                font-size: .9rem;
                color: rgb(82, 82, 82);
                font-style: italic;
            }
        }

        .news_wrap{
            box-sizing: border-box;
            width: 100%;
            margin: 0 auto;

            .file{
                margin: 0 auto;
                width: 70%;

                video, img{
                    width: 100%;
                    height: 30rem;
                }

                @media screen and (max-width: 900px){
                    video, img{
                        height: 25rem;
                    }
                }
            }
            @media screen and (max-width: 900px){
                .file{
                    width: 85%;
                }
            }
            @media screen and (max-width: 700px){
                .file{
                    width: 100%;
                }
            }
            .details{
                p{
                    font-size: 1rem;
                    color: #2e2e2e;
                    line-height: 1.8;
                    text-align: left;
                    margin-top: 3rem;
                }

                @media screen and (max-width: 700px){
                    p{
                        font-size: .9rem;
                    }
                }
            }
        }

    }
}
</style>
