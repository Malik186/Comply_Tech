<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Document ready, starting AJAX request");
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                var data = response.data;
                
                if (!Array.isArray(data) || data.length === 0) {
                    return;
                }

                var activityByMonth = {};
                
                data.forEach(function(item) {
                    if (!item.timestamp || !item.Activity) {
                        //console.warn("Invalid item:", item);
                        return;
                    }

                    var timestamp = item.timestamp;
                    var activity = parseInt(item.Activity);

                    var yearMonth = timestamp.substring(0, 7);

                    if (activityByMonth[yearMonth]) {
                        activityByMonth[yearMonth] += activity;
                    } else {
                        activityByMonth[yearMonth] = activity;
                    }
                });


                var months = Object.keys(activityByMonth);
                var activities = Object.values(activityByMonth);

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
                        categories: months
                    }
                };

                var chartElement = document.querySelector("#activity");
                if (!chartElement) {
                    return;
                }

                try {
                    var chart = new ApexCharts(chartElement, options);
                    chart.render();
                } catch (error) {
                    
                }
            } else {
                //console.error("Error in API response:", response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.error("AJAX request failed:", textStatus, errorThrown);
        }
    });
});
</script>