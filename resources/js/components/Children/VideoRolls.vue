<template>
    <div class="video_rolls" v-if="videos.length > 0">
        <h2 class="section_head"><span class="section_header">|</span>Video Rolls</h2>
        <div class="video_wrapper">
            <div class="video" v-for="video in videos" :key="video.id">
                <video controls height="">
                    <source :src="`https://pwanplatinum.s3.amazonaws.com/videos/${video.video}`">
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
    },
    mounted() {
        this.getFeaturedVideo()
    },
}
</script>

<style lang="scss" scoped>
    .video_rolls{
        width: 86vw;
        min-height: 25rem;
        margin: 0 auto;
        padding: 2rem 0;
        text-align: center;
        box-sizing: border-box;

        .video_wrapper{
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            overflow: hidden;
            margin: 0 auto;

            .video{
                display: flex;
                flex-direction: column;
                gap: 1.5rem;

                video{
                    height: 16rem;
                }
            }
        }
    }
    @media screen and (max-width: 720px) {
        .video_rolls{

            .video_wrapper{
                display: grid;
                grid-template-columns: 1fr;
                gap: 2.5rem;

                .video{
                    gap: 1rem;
                }
            }
        }
    }

    @media screen and (max-width: 600px) {
        .video_rolls{
            width: 96vw;
        }
    }
</style>
