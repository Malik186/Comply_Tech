<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchInvoices() {
            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/vat.list.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        displayInvoices(response.data);
                    } else {
                        console.error('Error fetching invoices:', response.status);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }

        function displayInvoices(invoices) {
            var tableBody = $('#invoiceTable tbody');
            tableBody.empty();

            var groupedInvoices = groupInvoices(invoices);

            $.each(groupedInvoices, function(invoice, data) {
                var row = $('<tr>');
                var dueDate = new Date(data.due_date);
                var currentDate = new Date();
                var status = dueDate > currentDate ? 'Active' : 'Due';
                var statusClass = status === 'Active' ? 'success' : 'danger';

                row.append($('<td>').html('<a href="invoice.php?invoice=' + encodeURIComponent(invoice) + '">' + invoice + '</a>'));
                row.append($('<td>').text(data.customer_name));
                row.append($('<td>').text(data.due_date));
                row.append($('<td>').text('Ksh ' + data.total_amount.toFixed(2)));
                row.append($('<td>').html('<span class="badge bg-' + statusClass + '">' + status + '</span>'));
                row.append($('<td>').html('<img src="/dashboard/img/flag/kenya.png" alt="Kenya Flag" width="30">'));

                tableBody.append(row);
            });
        }

        function groupInvoices(invoices) {
            var grouped = {};
            $.each(invoices, function(index, invoice) {
                if (!grouped[invoice.invoice]) {
                    grouped[invoice.invoice] = {
                        customer_name: invoice.customer_name,
                        due_date: invoice.due_date,
                        total_amount: 0
                    };
                }
                grouped[invoice.invoice].total_amount += invoice.unit_price;
            });
            return grouped;
        }

        fetchInvoices();

        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('#invoiceTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });
</script>