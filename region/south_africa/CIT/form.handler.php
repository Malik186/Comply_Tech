<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#calculate-corporate').on('click', function(e) {
        e.preventDefault(); // Prevent any default action of the button

        // Collect data from form fields
        const formData = {
            companyName: $('#companyName').val().trim(),
            registrationNumber: $('#registrationNumber').val().trim(),
            taxYear: $('#taxYear').val(),
            yearEnd: $('#yearEnd').val(),
            companyType: $('#companyType').val(),
            residencyStatus: $('#residencyStatus').val(),
            annualTurnover: parseFloat($('#annualTurnover').val()) || 0,
            grossIncome: parseFloat($('#grossIncome').val()) || 0,
            operatingExpenses: parseFloat($('#operatingExpenses').val()) || 0,
            capitalAllowances: parseFloat($('#capitalAllowances').val()) || 0,
            rdExpenses: parseFloat($('#rdExpenses').val()) || 0,
            learnershipAllowances: parseFloat($('#learnershipAllowances').val()) || 0,
            employmentTaxIncentive: parseFloat($('#employmentTaxIncentive').val()) || 0,
            badDebts: parseFloat($('#badDebts').val()) || 0,
            foreignIncome: parseFloat($('#foreignIncome').val()) || 0,
            foreignTaxCredits: parseFloat($('#foreignTaxCredits').val()) || 0,
            assessedLosses: parseFloat($('#assessedLosses').val()) || 0,
            dividendsReceived: parseFloat($('#dividendsReceived').val()) || 0
        };

        // Endpoint URL
        const endpoint = 'https://complytech.mdskenya.co.ke/endpoint/engine/region/southafrica/cit.php';

        // Send data to the server using jQuery's $.ajax
        $.ajax({
            url: endpoint,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function (response) {
                alert(`Tax calculation successful: ${response.message}`);
            },
            error: function (xhr) {
                const errorResponse = xhr.responseJSON;
                alert(`Error: ${errorResponse ? errorResponse.message : 'An error occurred while submitting the form.'}`);
            }
        });
    });
});

</script>
