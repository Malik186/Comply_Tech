<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const employeeNo = urlParams.get('employee_no');
        console.log(employeeNo);  // Log the employee number to verify it's being fetched correctly

        if (!employeeNo) {
            $('#invoice-content').html('<p>No employee number provided.</p>');
            return;
        }

        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/payroll.list.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);  // Log the full response for debugging
                if (response.status === "success") {
                    const payrollData = response.data.find(item => item.employee_no == employeeNo);  // Use '==' for comparison
                    if (payrollData) {
                        displayPayrollDetails(payrollData);
                        console.log('Payroll Data:', payrollData);
                    } else {
                        $('#invoice-content').html('<p>Employee not found.</p>');
                    }
                } else {
                    alert('Failed to fetch payroll data. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while fetching the data. Please try again.');
            }
        });

        function displayPayrollDetails(item) {
            $('#timestamp').text(item.timestamp);
            $('#employeeName').text(item.employee_name);
            $('#idNumber').text(item.id_number);
            $('#employeeNo').text(item.employee_no);
            $('#jobTitle').text(item.job_title);
            $('#paymentMethod').text(item.payment_method);
            $('#bankName').text(item.bank_name);
            $('#accountNo').text(item.account_no);
            $('#grossSalary').text(item.gross_salary.toFixed(2));
            $('#allowances').text(item.allowances.toFixed(2));
            $('#paye').text(item.paye.toFixed(2));
            $('#housingLevy').text(item.housing_levy.toFixed(2));
            $('#nhif').text(item.nhif.toFixed(2));
            $('#nssf').text(item.nssf.toFixed(2));
            $('#mortgage').text(item.mortgage_interest.toFixed(2));
            $('#insurance').text(item.insurance_premium.toFixed(2));
            $('#savings').text(item.savings_deposit.toFixed(2));
            $('#deductions').text(item.deductions.toFixed(2));
            $('#totalDeductions').text(item.total_deductions.toFixed(2));
            $('#netSalary').text(item.net_salary.toFixed(2));
        }

        $('#print').click(function() {
            window.print();
        });
    });
</script>
