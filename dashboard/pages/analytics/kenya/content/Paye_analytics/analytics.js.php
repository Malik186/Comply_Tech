<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Helper function to format numbers in 'K' notation
    function formatK(num) {
        return num >= 1000 ? (num / 1000).toFixed(1) + 'K' : num;
    }

    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/paye.recent.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.status === "success") {
                const data = response.data;

                let total = data.nssf + data.nhif + data.paye + data.housing_levy + data.insurance_premium + data.mortgage_interest;


                // Calculate progress and update progress bars
                updateProgressBars(data, total);

                // Fill in the div section with relevant data
                $(".net-pay h2").text("Ksh " + formatK(data.net_salary));
                $(".gross-pay h2").text("Ksh " + formatK(data.gross_salary));
                $(".deductions h2").text("Ksh " + formatK(data.total_deductions));
                $(".savings h2").text("Ksh " + formatK(data.savings_deposit));

                // Fill in the div section with relevant data
                $(".nssf h3").text("Ksh " + (data.nssf));
                $(".nhif h3").text("Ksh " + (data.nhif));
                $(".paye h3").text("Ksh " + (data.paye));
                $(".housing-levy h3").text("Ksh " + (data.housing_levy));
                $(".insurance h3").text("Ksh " + (data.insurance_premium));
                $(".mortgage h3").text("Ksh " + (data.mortgage_interest));

                // Bar chart to compare deductions
                createBarChart(data);

                // Create doughnut progress charts for mortgage and insurance
                createDoughnutProgressChart("#mortgage_chart", data.mortgage_interest, data.gross_salary, "Mortgage", "#7367F0");
                createDoughnutProgressChart("#insurance_chart", data.insurance_premium, data.gross_salary, "Insurance", "#3699ff");

            } else {
                console.error("Failed to fetch data");
            }
        },
        error: function(error) {
            console.error("API error: ", error);
        }
    });


    // Update the progress bars dynamically
    function updateProgressBars(data, total) {
        let progress1 = data.nssf / total;
        let progress2 = data.nhif / total;
        let progress3 = data.paye / total;
        let progress4 = data.housing_levy / total;
        let progress5 = data.insurance_premium / total;
        let progress6 = data.mortgage_interest / total;

        animateProgressBar('#progress1', progress1, '#3699ff', 'fa fa-building');
        animateProgressBar('#progress2', progress2, '#EA5455', 'fa fa-hospital');
        animateProgressBar('#progress3', progress3, '#FF9F43', 'fa fa-coins');
        animateProgressBar('#progress4', progress4, '#28C76F', 'fa fa-house');
        animateProgressBar('#progress5', progress5, '#3699ff', 'fa fa-money');
        animateProgressBar('#progress6', progress6, '#7367F0', 'fa fa-house');
    }

    // Helper function to animate progress bars
    function animateProgressBar(selector, value, color, iconClass) {
        var bar = new ProgressBar.Circle(selector, {
            color: color,
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: { color: color, width: 4 },
            to: { color: color, width: 4 },
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                var val = Math.round(circle.value() * 100);
                if (val === 0) {
                    circle.setText('');
                } else {
                    circle.setText(`<i class='${iconClass}'></i>`);
                }
            }
        });

        bar.text.style.fontSize = '1.5rem';
        bar.animate(value); // Set progress bar value
    }

    // Function to create bar chart
    function createBarChart(data) {
        var options = {
            series: [{
                name: 'Deductions',
                data: [
                    data.nssf,       // NSSF
                    data.nhif,       // NHIF
                    data.paye,       // PAYE
                    data.total_deductions // Other Deductions
                ]
            }],
            chart: {
                height: 300,
                type: 'bar',
                zoom: { enabled: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '50%',
                    endingShape: 'rounded',
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function (val) {
                    return "Ksh " + formatK(val);
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#3699ff"]
                }
            },
            xaxis: {
                categories: ['NSSF', 'NHIF', 'PAYE', 'Other Deductions'],
                position: 'top',
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return formatK(val);
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#deductions_trend"), options);
        chart.render();
    }

    // Function to create doughnut progress charts
    function createDoughnutProgressChart(selector, value, total, label, color) {
        var options = {
            series: [Math.round((value / total) * 100)],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '70%',
                    },
                    track: {
                        background: '#f2f2f2',
                    },
                    dataLabels: {
                        name: {
                            offsetY: -10,
                            color: "#888",
                            fontSize: "13px"
                        },
                        value: {
                            color: "#111",
                            fontSize: "30px",
                            show: true,
                            formatter: function(val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'solid',
                colors: [color]
            },
            labels: [label],
        };

        var chart = new ApexCharts(document.querySelector(selector), options);
        chart.render();
    }
});
</script>