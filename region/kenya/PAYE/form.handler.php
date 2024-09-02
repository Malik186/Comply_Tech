<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission for updating PAYE tax rules
    $('#update-paye').on('click', function(event) {
        event.preventDefault();

        // Capture PAYE tax bands and rates
        var payeBands = [
            { "band": "Up to 24,000", "rate": 10 },
            { "band": "24,001 - 32,333", "rate": 25 },
            { "band": "32,334 - 500,000", "rate": 30 },
            { "band": "500,001 - 800,000", "rate": 32.5 },
            { "band": "Above 800,000", "rate": 35 }
        ];

        // Capture Housing Levy percentage
        var housingLevy = $('#housing-levy').val();

        // Capture NSSF contributions
        var nssfTierI = $('#nssf-tier-1').val();
        var nssfTierII = $('#nssf-tier-2').val();

        // Capture NHIF contributions
        var nhifRates = [
            { "income_range": "0 - 5,999", "contribution": 150 },
            { "income_range": "6,000 - 7,999", "contribution": 300 },
            { "income_range": "8,000 - 11,999", "contribution": 400 },
            { "income_range": "12,000 - 14,999", "contribution": 500 },
            { "income_range": "15,000 - 19,999", "contribution": 600 },
            { "income_range": "20,000 - 24,999", "contribution": 750 },
            { "income_range": "25,000 - 29,999", "contribution": 850 },
            { "income_range": "30,000 - 34,999", "contribution": 900 },
            { "income_range": "35,000 - 39,999", "contribution": 950 },
            { "income_range": "40,000 - 44,999", "contribution": 1000 },
            { "income_range": "45,000 - 49,999", "contribution": 1100 },
            { "income_range": "50,000 - 59,999", "contribution": 1200 },
            { "income_range": "60,000 - 69,999", "contribution": 1300 },
            { "income_range": "70,000 - 79,999", "contribution": 1400 },
            { "income_range": "80,000 - 89,999", "contribution": 1500 },
            { "income_range": "90,000 - 99,999", "contribution": 1600 },
            { "income_range": "100,000+", "contribution": 1700 }
        ];

        // Consolidate all data
        var data = {
            "paye_bands": payeBands,
            "housing_levy": housingLevy,
            "nssf": {
                "tier_1": nssfTierI,
                "tier_2": nssfTierII
            },
            "nhif_rates": nhifRates
        };

        // Send data via AJAX
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/tax_rules/kenya/paye.php',
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: JSON.stringify(data),
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    showPopup('Success', 'Tax rules updated successfully.');
                } else {
                    // Show error message
                    showPopup('Error', result.message || 'An error occurred. Please try again.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus + ' : ' + errorThrown);
                console.log("Response Text: " + jqXHR.responseText);
                showPopup('Error', 'An error occurred. Please try again later.');
            }
        });
    });

    // Function to show popup
    function showPopup(title, message) {
        alert(title + ': ' + message);
    }
});
</script>
