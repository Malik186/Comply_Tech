<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    // Fetch data from the API using AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                var data = response.data;
                var kenyaActivityTotal = 0;

                // Loop through the data to sum up Activity for Tax_Type containing 'Kenya'
                data.forEach(function(item) {
                    var taxType = item.Tax_Type;
                    var activity = parseInt(item.Activity); // Assuming Activity is a number

                    // Check if the Tax_Type contains "Kenya"
                    if (taxType.includes("Kenya")) {
                        kenyaActivityTotal += activity;
                    }
                });

                // Modify the map to plot Kenya and display the summed Activity
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
                        },
                    },
                    enableZoom: false,
                    hoverColor: '#bcc3fb',
                    markers: [
                        // Plot Kenya's coordinates with the summed Activity value
                        {
                            latLng: [-1.286389, 36.817223], // Coordinates for Nairobi, Kenya
                            name: 'Kenya',
                            style: { fill: '#28C76F', r: 7 }, // Style Kenya marker
                            description: 'Total Activity: ' + kenyaActivityTotal // Add the activity total as a description
                        }
                    ],
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

                // Update the HTML to display Kenya's Activity in the card
                $('#kenya-activity-card').html(`
                <div class="col">
                    <div class="d-flex justify-content-between">
                        <p><span class="badge badge-success badge-dot me-5"></span>Kenya</p>
                        <p>${kenyaActivityTotal}</p>
                    </div>
                </div>
                `);

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