<template>
    <div class="cont">
        <div class="pg_header">News</div>
        <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <div class="news_wrap" v-else>
            <div class="news" v-for="post in newsPosts" :key="post.id" @click="showMore(post)">
                <div class="file">
                    <template v-if="post.file.split('.').pop() === 'mp4'">
                        <video height="100%" controls>
                            <!-- <source :src="`/images/news/${post.file}`" type="video/mp4"> -->
                            <source :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </template>
                    <template v-else>
                        <img v-if="post.file" :src="`https://pwanplatinum.s3.amazonaws.com/news/${post.file}`" alt="news picture">
                        <img v-else src="/images/assets/no-image.png" alt="news picture">
                    </template>
                </div>
                <div class="details">
                    <div class="post_title">
                        <p>{{ post.title }}</p>
                        <small>Published {{ post.published }}</small>
                    </div>
                    <div class="body">
                        <span> {{ post.detail | truncate(300) }} <p v-if="post.detail.length > 450" class="more" @click="showMore(post)">Read More...</p></span>
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
            isLoading: false,
            newsPosts: [],
            mini: true,
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getNewsPosts(){
            this.isLoading = true
            axios.get(this.api + '/get_all_newsposts').then((res) => {
                this.isLoading = false
                this.newsPosts = res.data
                console.log(res.data)
            }).catch(() =>{

            })
        },
        showMore(post){
            this.$router.push({name: 'NewsPostDetail', params: {id: post.id, slug: post.slug}})
        }
    },
    created(){
        this.getNewsPosts()
    }
}
</script>

<style lang="scss" scoped>
    .cont{
        margin: 0 auto;
        width: 84%;
        box-sizing: border-box;
        padding: 2rem 1rem;

        .pg_header{
            font-size: 1.2rem;
            text-align: center;
            FONT-WEIGHT: 400;
            color: #2e2e2e;
            margin: 2rem auto;
        }
        .news_wrap{
            width: 100%;
            box-sizing: border-box;

            .news{
                border: 1px solid #e5e5e5;
                border-radius: 4px;
                overflow: hidden;
                display: flex;
                gap: 1.5rem;
                height: 22rem;
                margin: 2rem auto;
                cursor: pointer;

                .file{
                    height: 100%;
                    width: 100%;

                    img{
                        height: 100%;
                        width: 100%;
                    }

                    video{
                        height: 100%;
                        width: 100%;
                    }
                }
                .details{
                    width: fit-content;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;

                    .post_title{
                        margin-bottom: 1.4rem;
                        text-align: center;
                        padding-right: 10px;
                        p{
                            font-size: 1.1rem;
                            color: #2e2e2e;
                            font-weight: 400;
                            margin-bottom: -2px;
                        }
                        small{
                            font-size: .9rem;
                            color: rgb(82, 82, 82);
                            font-style: italic;
                        }
                    }
                    .body{
                        font-size: 1rem;
                        line-height: 1.7;
                        color: #2e2e2e;
                        padding-right: 10px;

                        .more{
                            color: rgb(3, 3, 99);
                            cursor: pointer;
                        }
                    }
                }
            }
        }
    }
@media screen and (max-width: 1200px){
    .cont{
        width: 100%;
    }
}
@media screen and (max-width: 1200px){
    .cont{
        .news_wrap{
            .news{
                .details{
                    .post_title{
                        p{
                            font-size: 1rem;
                            font-weight: 400;
                        }
                        small{
                            font-size: .8rem;
                        }
                    }
                    .body{
                        font-size: .9rem;
                    }
                }
            }
        }
    }
}

@media screen and (max-width: 900px){
    .cont{
        .news_wrap{
            .news{
                gap: 1.3rem;
                height: 20rem;
            }
        }
    }
}

@media screen and (max-width: 700px){
    .cont{
        width: 85%;
        .news_wrap{
            .news{
                flex-direction: column;
                height: 100%;

                .details{
                    .post_title{
                        p{
                            font-size: 1rem;
                            font-weight: 400;
                        }
                    }
                    .body{
                        // margin: 2rem auto;
                        padding: .8rem 1rem 1rem;
                        font-size: .95rem;
                    }
                }
            }
        }
    }
}

@media screen and (max-width: 550px){
    .cont{
        width: 95%;
    }
}
</style>
