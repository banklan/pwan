<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-card elevation="12" raised light min-height="200" class="mx-auto">
                    <v-card-title class="primary white--text subtitle-1 justify-center">Fixtures</v-card-title>
                    <v-card-text>
                        <bar-chart v-if="chartLoaded" :chart-data="totals" :chart-labels="labels" />                 
                        <line-chart v-if="chartLoaded" :chart-data="totals" :chart-labels="labels" />                 
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import LineChart from './charts/LineCharts'
import BarChart from './charts/SubscriptionsBarChart'
export default {
    components: {
        'line-chart': LineChart,
        'bar-chart': BarChart
    },
    data() {
        return {
            leagues: [],
            fixtures: [],
            stages: [],
            subs: [],
            labels: [],
            totals: [],
            chartLoaded: false
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods:{
        getData(){
            axios.get(this.api + '/get_weeks_subscriptions').then((res) => {
                console.log(res.data)
                this.subs = res.data
                this.chartLoaded = true
                res.data.forEach(el => {
                    this.labels.push(el.week_starting)
                    this.totals.push(el.total)
                });
            })
        }
    },
    mounted() {
        console.log('chart component')
        this.getData()
        // const options = {
            // method: 'GET',
            // url: 'https://livescore6.p.rapidapi.com/matches/v2/list-by-date',
            // params: {Category: 'soccer', Date: '20220601'},
            // headers: {
            //     'X-RapidAPI-Host': 'livescore6.p.rapidapi.com',
            //     'X-RapidAPI-Key': 'f7c03575dfmsh0e283a3a82dd75bp1aa8f5jsne93e37700ed8'
            // }
            // };

            // axios.request(options).then(function (response) {
            //     console.log(response.data);
            //     // let res = response.data
            //     let snm = response.data.map(item => item.Snm)
            //     this.stages.push(response.data)
            // }).catch(function (error) {
            //     console.error(error);
            // });
    }
}
</script>