<template>
    <div class="fliers">
        <h2 class="section_head"><span class="section_header">|</span>New Offers!</h2>
        <div class="wrap">
            <div class="flier_wrap">
                <div class="offer_wrap" v-for="offer in offers" :key="offer.id">
                    <!-- <img :src="`/images/offers/${offer.flier}`" :alt="offer.title"> -->
                    <img :src="s3Flier" :alt="offer.title">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            offers: [],
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getOffers(){
            axios.get(this.api + '/get_featured_new_offers').then((res) => {
                this.offers = res.data
                console.log("new_offers", res.data)
            })
        }
    },
    mounted() {
        this.getOffers()
    },
}
</script>

<style lang="scss" scoped>
    .fliers{
        width: 80%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;

        .wrap{
            width: 100%;
            margin: 1rem auto 3rem;
            display: flex;
            justify-content: center;
            align-items: center;

           .flier_wrap{
               display: grid;
               grid-template-columns: 1fr 1fr;
               gap: 10rem;

               .offer_wrap{
                   height: 32rem;
                   width: 25rem;

                   img{
                       height: 100%;
                       width: 100%;
                   }
               }
           }
        }
    }

    @media screen and(max-width: 900px){
        .fliers{
            width: 90%;

            .wrap{
                .flier_wrap{
                    gap: 1.5rem;
                    .offer_wrap{
                        width: 22rem;
                        height: 28rem;
                    }
                }
            }
        }
    }

    @media screen and(max-width: 720px){
        .fliers{
            width: 90%;

            .wrap{
                .flier_wrap{
                    grid-template-columns: 1fr;

                    .offer_wrap{
                        height: 32rem;
                        width: 25rem;
                    }
                }
             }
        }
    }
</style>
