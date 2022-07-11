<template>
    <div class="featured_props">
        <h2 class="section_head"><span class="section_header">|</span>Latest Properties</h2>
        <div class="properties cont">
            <div class="property" v-for="prop in latests" :key="prop.id">
                <div class="property_img">
                    <!-- <v-img :src="  `/images/properties/${prop.files[0].image}`"></v-img> -->
                    <v-img :src="`https://pwanplatinum.s3.amazonaws.com/properties/${prop.files[0].image}`"></v-img>
                </div>
                <div class="property_details">
                    <h4>{{ prop.name }}</h4>
                    <span><i class="uil uil-map-marker"></i>{{ prop.location }}</span>
                    <p class="text-muted">Published {{ prop.created_at | relDate }}</p>
                </div>
            </div>
        </div>
        <div class="cta">
            <v-btn raised elevation="12" x-large dark color="secondary" class="btn-cta justify-center">View All Listing</v-btn>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            latests: [],
            isLoading: false
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getProps(){
            this.isLoading = true
            axios.get(this.api + '/get_latest_listings').then((res) => {
                this.isLoading = false
                this.latests = res.data
            })
        }
    },
    mounted() {
        this.getProps()
    },
}
</script>

<style lang="scss" scoped>
.featured_props{
    margin:  0;
    padding: 0;
    margin-top: 13rem;
    margin-bottom: 2rem;

    .cont{
        width: 84%;
    }

    & > h2{
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .properties{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;

        .property{
            text-align: center;
            border: 1px solid rgba(209,209,209,0.9);
            border-radius: 1rem;
            padding-bottom: 1rem;
            transition: all 300ms ease;
            cursor: pointer;
            overflow: hidden;

            &:hover{
                box-shadow: 0 0.4rem 1rem rgba(0,10,41,.38);
                background: transparent;
            }

            .property_img{
                width: 100%;

                .v-image{
                    width: 100%;
                    height: 22rem;
                    border-radius: inherit;
                }
            }

            .property_details{
                padding: 1.3rem 1rem .3rem;

                p{
                    font-size: .9rem;
                    margin-top: .8rem;
                    font-style: italic;
                }

                h4{
                    font-size: 1rem;
                    font-weight: 400 !important;
                    line-height: 1.5;
                }

                span{
                    margin: 1.2rem 0 2rem;
                    color: #001659;
                     i{
                         font-size: 1.2rem;
                         padding-right: .3rem;
                     }
                }
            }
        }
    }

    @media screen and (max-width: 1024px){
        .properties{
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
    }

    @media screen and (max-width: 794px){
        .cont{
            width: 90%;
        }
        .properties{
            gap: 1.5rem;
        }
    }

    @media screen and (max-width: 660px){
        .properties{
            .property{
                .property_img{
                    .v-image{
                        height: 18rem;
                    }
                }
            }
        }
    }

    @media screen and (max-width: 600px){
        .cont{
            width: 94%;
        }
        .properties{
            grid-template-columns: 1fr;

            .property{
                .property_img{
                    .v-image{
                        height: 22rem;
                    }
                }
            }
        }
    }
}

</style>
