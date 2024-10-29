<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    // Define the list of countries and their coordinates
    var countries = {
        "Kenya": { latLng: [-1.286389, 36.817223], activityTotal: 0 },
        "Uganda": { latLng: [0.347596, 32.582520], activityTotal: 0 },
        "Tanzania": { latLng: [-6.792354, 39.208328], activityTotal: 0 },
        "South_Africa": { latLng: [-25.747868, 28.229271], activityTotal: 0 },
        "Nigeria": { latLng: [9.082, 8.6753], activityTotal: 0 },
        "Egypt": { latLng: [30.044420, 31.235712], activityTotal: 0 },
        "Morocco": { latLng: [33.573110, -7.589843], activityTotal: 0 },
        "USA": { latLng: [37.090240, -95.712891], activityTotal: 0 },
        "England": { latLng: [51.509865, -0.118092], activityTotal: 0 },
        "Australia": { latLng: [-33.868820, 151.209290], activityTotal: 0 }
    };

    // Fetch data from the API using AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success" && response.data && response.data.length > 0) {
                var data = response.data;
                var hasActivity = false;

                // Loop through the data to sum up Activity for each country in the list
                data.forEach(function(item) {
                    var taxType = item.Tax_Type;
                    var activity = parseInt(item.Activity); // Assuming Activity is a number

                    // Check if the Tax_Type contains the name of any country in our list
                    for (var country in countries) {
                        if (taxType.includes(country)) {
                            countries[country].activityTotal += activity;
                            hasActivity = true;
                        }
                    }
                });

                if (hasActivity) {
                    // Update the world map with markers for each country with its respective summed activity
                    var markers = [];
                    for (var country in countries) {
                        if (countries[country].activityTotal > 0) {
                            markers.push({
                                latLng: countries[country].latLng,
                                name: country,
                                style: { fill: '#28C76F', r: 7 },
                                description: 'Total Activity: ' + countries[country].activityTotal
                            });

                            // Dynamically update the HTML to display each country's activity in the card
                            $('#activity-cards').append(`
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <p><span class="badge badge-success badge-dot me-5"></span>${country}</p>
                                        <p>${countries[country].activityTotal}</p>
                                    </div>
                                </div>
                            `);
                        }
                    }

                    // Initialize the map with the dynamically generated markers
                    $('#location').vectorMap({
                        map: 'world_mill_en',
                        backgroundColor: '#ffffff00',
                        borderColor: '#818181',
                        borderOpacity: 0.25,
                        borderWidth: 1,
                        color: '#f4f3f0',
                        regionStyle: {
                            initial: {
                                fill: '#eef0fe'
                            }
                        },
                        markerStyle: {
                            initial: {
                                r: 5,
                                'fill': '#EA5455',
                                'fill-opacity': 1,
                                'stroke': '#000',
                                'stroke-width': 1,
                                'stroke-opacity': 0.0
                            }
                        },
                        enableZoom: false,
                        hoverColor: '#bcc3fb',
                        markers: markers,
                        hoverOpacity: null,
                        normalizeFunction: 'linear',
                        scaleColors: ['#b6d6ff', '#005ace'],
                        selectedColor: '#c9dfaf',
                        selectedRegions: [],
                        showTooltip: true,
                        onRegionClick: function(element, code, region) {
                            var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                            alert(message);
                        }
                    });
                } else {
                    displayNoRecordsFound();
                }
            } else {
                displayNoRecordsFound();
            }
        },
        error: function(error) {
            console.log("Error:", error);
            displayNoRecordsFound();
        }
    });

    function displayNoRecordsFound() {
        // Display "No Records Found" message on the map
        $('#location').html('<div class="d-flex justify-content-center align-items-center h-100"><p class="text-muted">No Records Found</p></div>');
        
        // Display "No Records Found" message in the activity cards
        $('#activity-cards').html('<div class="col"><p class="text-muted">No Records Found</p></div>');
    }
});
</script>