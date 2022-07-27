<template>
    <div class="container">
        <div class="page_title">All Videos</div>
        <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
        <div class="videos_wrapper" v-else>
            <div v-for="video in videos" :key="video.id"  class="video">
                <video controls height="">
                    <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
                    <!-- <source :src="`/images/videos/${video.video}`"> -->
                    Your browser does not support the video tag.
                </video>
                <div class="details"> {{ video.title | truncate(150) }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            videos: [],
            isLoading: false,
        }
    },
   computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getVideos(){
            this.isLoading = true
            axios.get(this.api + '/get_all_video_rolls').then((res) => {
                this.isLoading = false
                this.videos = res.data
            })
        }
    },
    mounted(){
        this.getVideos()
    }
}
</script>

<style lang="scss" scoped>
    .container{
        width: 90vw;
        margin: 0 auto;
        padding: 1.5rem 2rem;
        text-align: center;

        .page_title{
            margin: 1.5rem 0 2rem;
            font-size: 1.3rem;
        }

        .videos_wrapper{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            width: 100%;
            margin: 0 auto;
            overflow: hidden;

            .video{
                display: flex;
                flex-direction: column;
                gap: .85rem;
            }
        }
    }
    @media screen and (max-width: 720px){
        .container{
            width: 94vw;
            padding: 1.5rem 1rem;

            .page_title{
                font-size: 1.2rem;
            }

            .videos_wrapper{
                grid-template-columns: 1fr;

                .video{
                    video{
                        max-height: 25rem;
                    }
                }
            }
        }
    }

</style>
