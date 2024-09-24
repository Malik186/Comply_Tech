<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    $('#calculate-payroll').on('click', function (event) {
        event.preventDefault();  // Prevent the default form submission

        console.log('Submit button clicked');  // Log to confirm the button click event

        // Gather form data
        const data = {
            employee_name: $('#employeeName').val(),
            id_number: $('#idNumber').val(),
            employee_no: $('#employeeNo').val(),
            job_title: $('#jobTitle').val(),
            gross_salary: $('#grossSalary').val(),
            allowances: $('#allowances').val() || 0,
            calculation_period: $('#calculationPeriod').val(),
            nssf_tier: $('#nssfTier').val(),
            housing_levy: $('#housingLevy').is(':checked') ? 1 : 0,
            other_deductions: $('#otherDeductions').val() || 0,
            payment_method: $('#paymentMethod').val(),
            bank_name: $('#bankName').val() || '',
            account_number: $('#accountNumber').val() || '',
            mortgage_interest: $('#mortgageInterest').val() || 0,
            insurance_premium: $('#insurancePremium').val() || 0,
            savings_deposit: $('#savingsDeposit').val() || 0
        };

        console.log('Data sent to the endpoint:', data);  // Log the data being sent

        // Send data to the backend using AJAX
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/payroll.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (result) {
                // SweetAlert2 success message with redirect
                Swal.fire({
                    title: "Good job!",
                    text: "Now let's go and see the Payroll Receipt!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the analytics page
                        window.location.href = 'payroll.recent.php';
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
</script>