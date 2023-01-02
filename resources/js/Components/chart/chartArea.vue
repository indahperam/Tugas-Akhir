<template lang="">
    <div id="chart" class="h-full">
        <apexchart type="area" height="100%" :options="chartOptions" :series="series">
        </apexchart>
    </div>
</template>
<script>
import VueApexCharts from 'vue3-apexcharts';
export default {
    components: {
        apexchart: VueApexCharts,
    },
    props: {
        data_chart: Array,
        title: String,
        label: String,
    },
    data() {
        return {
            series: [{
                name: this.label,
                data: this.data_chart
            }],
            chartOptions: {
                chart: {
                    type: 'area',
                    zoom: {
                        enabled: true,
                        type: 'x',
                        autoScaleYaxis: false,
                        zoomedArea: {
                            fill: {
                                color: '#90CAF9',
                                opacity: 0.4
                            },
                            stroke: {
                                color: '#0D47A1',
                                opacity: 0.4,
                                width: 1,
                            }
                        }
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },

                title: {
                    text: this.title,
                    align: 'left'
                },
                xaxis: {
                    type: 'datetime',
                },
                yaxis: {
                    opposite: true
                },
                legend: {
                    horizontalAlign: 'left'
                }
            },
        }
    }
};
</script>
<style lang=""></style>
