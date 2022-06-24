<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <div class="page_title">
                    <div class="title">Testimonials</div>
                    <div class="btn">
                        <v-btn class="primary" dark elevation="6" ripple rounded :to="{name: 'CreateTestimonial'}"><span left><i class="uil uil-plus"></i></span> New</v-btn>
                    </div>
                </div>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-3">
            <v-col cols="12" md="9">
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <template v-else>
                    <template v-if="testimonials.length > 0">
                        <div class="test_card" v-for="test in testimonials" :key="test.id">
                            <div class="avatar">
                                <img :src="`/images/testimonials/${test.picture}`" :alt="`${test.fullname}'s picture`">
                            </div>
                            <div class="details">
                                <div class="title">{{ test.title }}</div>
                                <div class="author">
                                    <div class="name">{{ test.fullname }} | {{ test.occupation }}</div>
                                    <div class="orgz">{{ test.organization }}</div>
                                </div>
                                <div class="body">{{ test.detail }}</div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <v-alert type="info" class="mt-5">
                            There are no testimonials to view at the moment.
                        </v-alert>
                    </template>
                </template>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            testimonials: [],
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        },
    },
    methods: {
        getTestimonials(){
            this.isLoading = true
            axios.get(this.api + '/get_testimonials').then((res) => {
                this.isLoading = false
                this.testimonials = res.data
            })
        }
    },
    mounted() {
        this.getTestimonials()
    },
}
</script>

<style lang="scss" scoped>
    .page_title{
        display: flex;
        justify-content: space-around;
        align-items: center;
        .title{
            color: #2c2c2c;
            font-size: 1.4rem;
            font-weight: 500;
        }
    }
    .test_card{
        min-height: 120px;
        border-radius: 4px;
        background-color: #fff;
        border-color: #fff;
        margin: 3rem auto;
        // box-shadow: 0 5px 5px -3px rgba(0,0,0,.2),0 8px 10px 1px rgba(0,0,0,.14),0 3px 14px 2px rgba(0,0,0,.12)!important;
        border-width: thin;
        display: block;
        max-width: 100%;
        outline: none;
        text-decoration: none;
        padding: 1.2rem;
        box-shadow: 0 0 3px rgba(0,0,0,0.15);

        gap: 1.5rem;
        display: grid;
        grid-template-columns: 1fr 3fr;
        box-sizing: border-box;
        cursor: pointer;
        transition: all .4s ease;

        &:hover{
            box-shadow: 0 5px 5px -3px rgba(0,0,0,.2),0 8px 10px 1px rgba(0,0,0,.14),0 3px 14px 2px rgba(0,0,0,.12)!important;
        }

        .avatar{
            display: flex;
            align-items: center;
            overflow: hidden;
            height: 12rem;
            width: 12rem;
            margin: .8rem auto;
            border-radius: 50%;
            box-shadow:  0px 0px 3px 1px rgb(0 0 0 / 9%);

            img{
                height: 100%;
                // width: 100%;
                aspect-ratio: 1/1;
            }

        }
        .details{
            display: flex;
            flex-direction: column;
            justify-content: center;
            .title{
                font-size: 1.2rem !important;
                color: #3a3a3a;
            }

            .author{
                padding: 2px 0;
                margin-top: -4px;
                .name{
                    font-size: .85rem;
                    color: #6c6c6c;
                }
                .orgz{
                    color: #4e4e4e;
                    font-size: .9rem;
                }
            }
            .body{
                margin-top: .8rem;
                color: #2e2e2e;
                font-size: 1rem;
            }
        }
    }
</style>
