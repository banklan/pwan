<template>
    <div class="listing_card" @click="goToListing(listing)">
        <div class="img">
            <img v-if="listing.files.length > 0" :src="`https://pwanplatinum.s3.amazonaws.com/properties/${listing.files[0].image}`" :alt="listing.name">
            <img v-else src="/images/assets/no-image.png" :alt="listing.name">
        </div>
        <div class="details">
            <div class="name">{{ listing.name }}</div>
            <div class="loc">
                <span><i class="uil uil-map-marker"></i></span> {{ listing.location | truncate(30) }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['listing'],
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        goToListing(listing){
            this.$router.push({name: 'PropertyListingDetail', params: {id: listing.id, slug: listing.slug}})
        }
    },
}
</script>

<style lang="scss" scoped>
    .listing_card{
        height: 30rem;
        cursor: pointer;
        border: 1px solid #e1e1e1;
        border-radius: 12px;
        box-sizing: border-box;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all .4s ease;

        .img{
            height: 75%;
            width: 100%;

            img{
                height: 100%;
                width: 100%;
            }
        }
        .details{
            text-align: center;
            margin: 1.5rem auto 2rem;

            .name{
                font-size: 1rem;
                color: #2e2e2e;
                font-weight: 400;
            }
            .loc{
                span{
                    color: blue;
                    font-size: 1rem;
                }
                font-size: .85rem;
                color: #7c7c7c;
                margin-top: 5px;
            }
        }

        &:hover{
            box-shadow: 0 5px 7px rgba(0,0,0,0.35);
        }
    }
</style>
