<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
                $.ajax({
                    url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/payroll.recent.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#timestamp').text(data.timestamp);
                            $('#employeeName').text(data.employee_name);
                            $('#idNumber').text(data.id_number);
                            $('#employeeNo').text(data.employee_no);
                            $('#jobTitle').text(data.job_title);
                            $('#paymentMethod').text(data.payment_method);
                            $('#bankName').text(data.bank_name);
                            $('#accountNo').text(data.account_no);
                            $('#grossSalary').text(data.gross_salary.toFixed(2));
                            $('#allowances').text(data.allowances.toFixed(2));
                            $('#paye').text(data.paye.toFixed(2));
                            $('#housingLevy').text(data.housing_levy.toFixed(2));
                            $('#nhif').text(data.nhif.toFixed(2));
                            $('#nssf').text(data.nssf.toFixed(2));
                            $('#deductions').text(data.deductions.toFixed(2));
                            $('#totalDeductions').text(data.total_deductions.toFixed(2));
                            $('#netSalary').text(data.net_salary.toFixed(2));
                        } else {
                            alert('Failed to fetch payroll data. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the data. Please try again.');
                    }
                });

            $('#print').click(function() {
                window.print();
            });
        });
    </script>