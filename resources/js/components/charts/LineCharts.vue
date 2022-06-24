<script>
import { Line } from 'vue-chartjs'

export default{
    extends: Line,
    props: {
        chartData:{
            type: Array | Object,
            default: null,
            required: false
        },
        chartLabels:{
            type: Array,
            required: true
        },
    },
    data() {
        return {
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero: true,
                            min: 0,
                            max: 20,
                            stepSize: 5
                        },
                        gridLines:{
                            display: true
                        }
                    }],
                    xAxes:[{
                        gridLines:{
                            display: false
                        }
                    }]
                },
                legend:{
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        }
    },
    mounted(){
        this.renderChart({
            labels: this.chartLabels,
            datasets: [{
                label: 'Services created Chart',
                borderColor: '#FF5200',
                pointBackgroundColor: '#08F7EB',
                borderWidth: 2,
                fill: true,
                pointBorderColor: '#3eff33',
                backgroundColor: 'transparent',
                data: this.chartData
            }]
        }, this.options)
    }
}
</script>

