<script>
import { Bar } from 'vue-chartjs'

export default{
    extends: Bar,
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
                label: 'Bar Chart',
                borderColor: '#FF5200',
                pointBackgroundColor: '#08F7EB',
                borderWidth: 1,
                pointBorderColor: '#2554ff',
                backgroundColor: [
                    '#01217a', '#7a014a','#fd3232', '#5b0095', '#5b0095'
                ],
                borderColor: [
                    '#002487', '#740247', '#fd3c3c', '#52018d', '#5b0095'
                ],
                hoverBackgroundColor: [
                    '#011c66', '#4e0130', '#dd2929', '#480374', '#4a0278'
                ],
                hoverBorderColor: ['#011c66', '#4e0130', '#dd2929', '#480374', '#4a0278'],
                data: this.chartData
            }]
        }, this.options)
    }
}
</script>

