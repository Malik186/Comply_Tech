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

            // Update the h3 elements
            updateValues(data);

            // Calculate progress and update progress bars
            updateProgressBars(data, total);

            // Fill in the div section with relevant data
            $(".net-pay h2").text("Ksh " + formatK(data.net_salary));
            $(".gross-pay h2").text("Ksh " + formatK(data.gross_salary));
            $(".deductions h2").text("Ksh " + formatK(data.total_deductions));
            $(".savings h2").text("Ksh " + formatK(data.savings_deposit));

            // Bar chart to compare deductions
            var options = {
                series: [{
                    name: 'Deductions',
                    data: [
                        data.nssf,       // NSSF
                        data.nhif,       // NHIF
                        data.paye,       // PAYE
                        data.total_deductions - (data.nssf + data.nhif + data.paye) // Other Deductions
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
                    enabled: true,
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
        } else {
            console.error("Failed to fetch data");
        }
    },
    error: function(error) {
        console.error("API error: ", error);
    }
});
// Update the h3 values dynamically
function updateValues(data) {
    // Update NSSF
    $('h3:contains("NSSF")').html(`Ksh ${data.nssf.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 3%</span>`);
    
    // Update NHIF
    $('h3:contains("NHIF")').html(`Ksh ${data.nhif.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update PAYE
    $('h3:contains("PAYE")').html(`Ksh ${data.paye.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span>`);
    
    // Update Housing Levy
    $('h3:contains("Housing Levy")').html(`Ksh ${data.housing_levy.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update Insurance
    $('h3:contains("Insurance")').html(`Ksh ${data.insurance_premium.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update Mortgage
    $('h3:contains("Mortgage")').html(`Ksh ${data.mortgage_interest.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span>`);
}

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
});
</script>