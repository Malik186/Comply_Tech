<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
</script>