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
                var activities = [];
                var months = [];

                // Loop through the data to extract Timestamp and Activity values
                data.forEach(function(item) {
                    var timestamp = item.Timestamp;
                    var activity = parseInt(item.Activity); // Activity is a number

                    // Parse the month from Timestamp (format: YYYY-MM-DD HH:MM:SS)
                    var date = new Date(timestamp);
                    var month = date.toLocaleString('default', { month: 'short' }); // Converts to month abbreviation like 'Jan', 'Feb'

                    // Add the activity and corresponding month
                    activities.push(activity);
                    months.push(month);
                });

                // Remove duplicates from months array (in case of multiple entries in the same month)
                months = [...new Set(months)];

                // Create the chart
                var options = {
                    series: [{
                        name: "Activity",
                        data: activities
                    }],
                    chart: {
                        height: 252,
                        type: 'area',
                        foreColor: "#bac0c7",
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['#EA5455'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            inverseColors: false,
                            opacityFrom: 0.5,
                            opacityTo: 0,
                            stops: [0, 90, 100]
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: months // Use the parsed months for the x-axis
                    }
                };

                var chart = new ApexCharts(document.querySelector("#activity"), options);
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