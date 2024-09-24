<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchPayrolls() {
            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/payroll.list.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); 
                    if (response.status === 'success') {
                        displayPayrolls(response.data);
                    } else {
                        console.error('Error fetching payrolls:', response.status);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }

        function displayPayrolls(payrolls) {
            var tableBody = $('#payrollTable tbody');
            tableBody.empty();

            $.each(payrolls, function(index, payroll) {
                var row = $('<tr>');
                row.append($('<td>').html('<a href="payroll.php?employee_no=' + encodeURIComponent(payroll.employee_no) + '">' + payroll.employee_no + '</a>'));
                row.append($('<td>').text(payroll.timestamp));
                row.append($('<td>').text(payroll.job_title));
                row.append($('<td>').html('<img src="/dashboard/img/flag/kenya.png" alt="Kenya Flag" width="30">'));
                tableBody.append(row);
            });
        }

        fetchPayrolls();

        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('#payrollTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });
</script>
