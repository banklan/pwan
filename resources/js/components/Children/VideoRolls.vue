<template>
    <div class="video_rolls" v-if="videos.length > 0">
        <h2 class="section_head"><span class="section_header">|</span>Video Rolls</h2>
        <div class="video_wrapper" v-for="video in videos" :key="video.id">
            <div class="video" @click="goToVideo(video.id)">
                <video controls height="">
                    <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="details"> {{ video.title | truncate(150) }}</div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            videos: [],
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getFeaturedVideo(){
            axios.get(this.api + '/get_featured_video').then((res) => {
                this.videos = res.data
            })
        },
        goToVideo(id){

        }
    },
    mounted() {
        this.getFeaturedVideo()
    },
}
</script>

<style lang="scss" scoped>
    .video_rolls{
        width: 70vw;
        margin: 0 auto;
        padding: 2.5rem 0;
        text-align: center;

        .video_wrapper{
            width: 100%;
            max-height: 20rem;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            overflow: hidden;

            video{
                width: 100%;
                height: 20rem;
            }
        }
    }
    @media screen and (max-width: 720px) {
        .video_rolls{
            width: 94vw;

            .video_wrapper{
                margin-top: -3rem;
                height: 18rem;
                width: 100%;

                .video{
                    height: 100%;
                    width: 100%;
                }
            }
        }
    }
</style>
