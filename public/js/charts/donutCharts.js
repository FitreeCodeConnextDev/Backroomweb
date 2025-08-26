

document.addEventListener("DOMContentLoaded", function () {
    let donutCharts = new ApexCharts(document.getElementById("column-chart"), getdonutChartsOptions());
    donutCharts.render();
});

function getdonutChartsOptions() {
    return {
        series: [44, 55, 41, 17, 15],
        labels: ['Apple', 'Mango', 'Orange', 'Watermelon', 'Banana'],
        colors: ['#FF4560', '#00E396', '#008FFB', '#775DD0', '#FEB019'],
        chart: {
            height: 520,
            width: "100%",
            type: "donut",

        },
        stroke: {
            colors: ["transparent"],
            lineCap: "",
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontFamily: "Anuphan, sans-serif",
                            offsetY: -190,
                        },
                        total: {
                            showAlways: true,
                            show: true,
                            label: "Total",
                            fontFamily: "Anuphan, sans-serif",
                            formatter: function (w) {
                                const sum = w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0)
                                return sum.toLocaleString() + " บาท"
                            },
                        },
                        value: {
                            show: true,
                            fontFamily: "Anuphan, sans-serif",
                            offsetY: -230,
                            formatter: function (value) {
                                // Format the number with commas and append 'บาท'
                                let formattedValue = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                return formattedValue + " บาท";
                            }
                        },
                    },
                    size: "50%",
                },
            },
        },
        grid: {
            padding: {
                top: 100,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            position: "bottom",
            fontFamily: "Anuphan, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value.toLocaleString() + " บาท"
                },
            },
        },
    };
}
