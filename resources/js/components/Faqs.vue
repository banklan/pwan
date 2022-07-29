<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <div class="title pb-5 text-center">Frequently Asked Questions</div>
                <v-progress-circular indeterminate color="primary" :width="3" :size="30" v-if="isLoading" justify="center" class="mx-auto"></v-progress-circular>
                <div v-else min-height="100" class="mx-auto">
                    <div class="mt-5">
                        <div class="cont" v-if="faqs.length > 0">
                            <div v-for="faq in faqs" :key="faq.id" class="faq_wrapper">
                                <div class="faq_qst font-weight-bold"><span>Q:</span>{{ faq.qstn }}</div>
                                <div class="faq_ans" style="white-space: pre-line"><span>A:</span>{{ faq.ans }}</div>
                                <div v-if="faq.extra" class="faq_extra">{{ faq.extra }}</div>
                            </div>
                        </div>
                        <v-alert class="mt-5" type="warning" v-else>
                            There are no presently no frequently asked questions to view.
                        </v-alert>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            faqs: [],
            isLoading: false
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        getFaqs(){
            this.isLoading = true
            axios.get(this.api + '/get_all_faqs').then((res) => {
                this.isLoading = false
                this.faqs = res.data
            })
        }
    },
    mounted() {
        this.getFaqs()
    },
}
</script>

<style lang="scss" scoped>
    .cont{
        margin: 0 auto;
        width: 90%;
        box-sizing: border-box;
        padding: 1.5rem .5rem;
        overflow: hidden;
        .faq_wrapper{
            margin-bottom: 2rem;
            font-size: .9rem;
            line-height: 1.8;
            overflow: hidden;
            padding: 0 10px;
            .faq_qst{
                span{
                    padding-right: 6px;
                }
            }
            .faq_ans{
                margin-top: .75rem;
                color: #5a5a5a;
                white-space: pre-line;
                span{
                    padding-right: 6px;
                }
            }
            .faq_extra{
                font-style: italic;
                margin-top: .7rem;
            }
        }
    }
    @media screen and(max-width: 720px) {
        .cont{
            width: 100vw;
        }
    }
</style>
