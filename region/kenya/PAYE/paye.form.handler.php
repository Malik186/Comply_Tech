<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle visibility of mortgage, insurance, and savings fields based on user input
    function toggleMortgageField(show) {
        $('#mortgageInterestField').toggle(show);
    }
    
    function toggleInsuranceField(show) {
        $('#insurancePremiumField').toggle(show);
    }
    
    function toggleSavingsField(show) {
        $('#savingsDepositField').toggle(show);
    }
    
    // Capture form data and send to the endpoint using AJAX
    $('#calculate-paye').on('click', function (event) {
        event.preventDefault();  // Prevent the default form submission
    
        console.log('Submit button clicked');  // Log to confirm the button click event
    
        const data = {
            gross_salary: $('#grossSalary').val(),
            calculation_period: $('#calculationPeriod').val(),
            nssf_tier: $('#nssfTier').val(),
            housing_levy: $('#housingLevy').is(':checked') ? 1 : 0,
            mortgage_interest: $('#mortgageInterest').val() || 0,
            insurance_premium: $('#insurancePremium').val() || 0,
            savings_deposit: $('#savingsDeposit').val() || 0,
            other_deductions: $('#otherDeductions').val() || 0
        };
    
        console.log('Data sent to the endpoint:', data);  // Log the data being sent
    
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/kenya.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (result) {
                console.log('PAYE Calculation Result:', result);
                // Handle the result here, e.g., display it to the user
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                // Handle the error here, e.g., display an error message
            }
        });
    });
</script>