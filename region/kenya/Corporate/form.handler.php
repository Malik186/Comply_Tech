<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Handle click event of the submit button
    $('#calculate-corporate').on('click', function(e) {
        e.preventDefault(); // Prevent any default action of the button

        // Gather form data
        var companyName = $('#companyName').val();
        var yearsOfOperation = $('#yearsOfOperation').val();
        var typeOfCompany = $('#typeOfCompany').val();
        var yearlyProfit = $('#yearlyProfit').val();
        var specialRatesType = $('#specialRatesType').val();

        // Prepare data object
        var data = {
            companyName: companyName,
            yearsOfOperation: yearsOfOperation,
            typeOfCompany: typeOfCompany,
            yearlyProfit: yearlyProfit,
        };

        // Include specialRatesType only if "Special Rates" is selected
        if (typeOfCompany === 'Special Rates') {
            data.specialRatesType = specialRatesType;
        }

        // Log the data to console for inspection
        console.log('Data Sent:', data);

        // AJAX request
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/corporate.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (result) {
                // SweetAlert2 success message with redirect
                Swal.fire({
                    title: "Good job!",
                    text: "Now let's go and see the analysis.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the analytics page
                        window.location.href = 'corporate.php';
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                // SweetAlert2 error message
                Swal.fire({
                    title: "Oops",
                    text: "Failed to submit data. Try again later.",
                    icon: "error",
                    confirmButtonText: "Close"
                });
            }
        });
    });

    // Show or hide the Special Rates section based on the selected company type
    $('#typeOfCompany').on('change', function() {
        var specialRatesSection = $('#specialRatesSection');
        if ($(this).val() === 'Special Rates') {
            specialRatesSection.show();
        } else {
            specialRatesSection.hide();
        }
    });
});
</script>
