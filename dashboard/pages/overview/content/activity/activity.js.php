<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Document ready, starting AJAX request");
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success" && response.data && Array.isArray(response.data) && response.data.length > 0) {
                var data = response.data;
                var activityByMonth = {};
                
                data.forEach(function(item) {
                    if (!item.timestamp || !item.Activity) {
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

                if (months.length > 0 && activities.length > 0) {
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
                    if (chartElement) {
                        try {
                            var chart = new ApexCharts(chartElement, options);
                            chart.render();
                        } catch (error) {
                            console.error("Error rendering chart:", error);
                            displayNoRecordsFound(chartElement);
                        }
                    } else {
                        console.error("Chart element not found");
                        displayNoRecordsFound(document.body);
                    }
                } else {
                    displayNoRecordsFound(document.querySelector("#activity") || document.body);
                }
            } else {
                console.error("Error in API response or no data:", response);
                displayNoRecordsFound(document.querySelector("#activity") || document.body);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed:", textStatus, errorThrown);
            displayNoRecordsFound(document.querySelector("#activity") || document.body);
        }
    });

    function displayNoRecordsFound(element) {
        if (element) {
            element.innerHTML = '<div class="d-flex justify-content-center align-items-center" style="height: 252px;"><p class="text-muted">No Records Found</p></div>';
        }
    }
});
</script>