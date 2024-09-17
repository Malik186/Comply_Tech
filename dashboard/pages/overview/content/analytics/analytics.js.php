<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Fetch data via AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                var data = response.data;
                var bookedCount = 0;
                var cancelledCount = 0;

                // Loop through the data to sum Status 1 (Booked) and Status 0 (Cancelled)
                data.forEach(function(item) {
                    if (item.Status === "1") {
                        bookedCount++;
                    } else if (item.Status === "0") {
                        cancelledCount++;
                    }
                });

                // Calculate the total and percentages
                var totalCount = bookedCount + cancelledCount;
                var bookedPercent = (bookedCount / totalCount) * 100;
                var cancelledPercent = (cancelledCount / totalCount) * 100;

                // Update percentages in HTML
                $('#booked-percent').html('<span class="fs-12">Booked</span><br>' + bookedPercent.toFixed(2) + '%');
                $('#cancelled-percent').html('<span class="fs-12">Cancelled</span><br>' + cancelledPercent.toFixed(2) + '%');

                // Create the chart
                var options = {
                    series: [bookedPercent, cancelledPercent],
                    labels: ['Booked', 'Cancelled'],
                    chart: {
                        width: 202,
                        type: 'donut',
                    },
                    colors: ['#7367F0', '#EA5455'],
                    dataLabels: {
                        enabled: false
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                show: false
                            }
                        }
                    }],
                    legend: {
                        show: false
                    }
                };

                var chart = new ApexCharts(document.querySelector("#analytics_chart"), options);
                chart.render();
            } else {
                console.log("Error fetching data from the API");
            }
        },
        error: function(error) {
            console.log("Error:", error);
        }
    });
});

</script>