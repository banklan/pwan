<script>
import { Doughnut } from 'vue-chartjs'

export default{
    extends: Doughnut,
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
                            max: 10,
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
                    display: true
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
                label: 'Bar Chart',
                borderColor: '#FF5200',
                pointBackgroundColor: '#08F7EB',
                borderWidth: 1,
                pointBorderColor: '#2554ff',
                backgroundColor: [
                    'blue', '#E20000','orange', '#001659', 'purple'
                ],
                borderColor: [
                    'blue', '#E20000', 'orange', '#001659', 'violet'
                ],
                hoverBackgroundColor: [
                    '#7a1893', '#157868', '#020070', '#27aadd', 'violet'
                ],
                hoverBorderColor: ['#7a1893', '#157868', '#020070', '#27aadd', 'orange'],
                data: this.chartData
            }]
        }, this.options)
    }
}
</script>

