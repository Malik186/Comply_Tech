<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Get the invoice number from the URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const invoiceNumber = urlParams.get('invoice');

    if (invoiceNumber) {
        fetchInvoiceDetails(invoiceNumber);
    } else {
        $('#invoice-content').html('<p>No invoice number provided.</p>');
    }

    function fetchInvoiceDetails(invoiceNumber) {
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/vat.list.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    const invoiceData = response.data.filter(item => item.invoice === invoiceNumber);
                    if (invoiceData.length > 0) {
                        displayInvoiceDetails(invoiceData);
                        console.log('Invoice Data:', invoiceData);
                    } else {
                        $('#invoice-content').html('<p>Invoice not found.</p>');
                    }
                } else {
                    console.error('Error fetching invoice data:', response.status);
                    $('#invoice-content').html('<p>Error fetching invoice data.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                $('#invoice-content').html('<p>Error fetching invoice data.</p>');
            }
        });
    }

    function displayInvoiceDetails(data) {
        let invoiceTable = '';
        let subTotal = 0;
        let totalVat = 0;
        let invoiceNumber = 1;
        let formattedDateGenerated = '';

        // Format date generated using the first item
        if (data.length > 0) {
            let dateGenerated = new Date(data[0].date_generated);
            formattedDateGenerated = dateGenerated.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        // Loop through each item in the invoice
        data.forEach(function(item, index) {
            let dueDate = new Date(item.due_date);
            let formattedDueDate = dueDate.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            // Calculate subtotal for each item
            let itemSubtotal = parseFloat(item.quantity) * parseFloat(item.unit_price);
            subTotal += itemSubtotal;
            totalVat += parseFloat(item.vat);

            // Add table rows for each item
            invoiceTable += `
                <tr>
                    <td>${invoiceNumber++}</td>
                    <td>${item.item_description}</td>
                    <td class="text-end">${parseInt(item.quantity).toLocaleString()}</td>
                    <td class="text-end">Ksh ${parseFloat(item.unit_price).toLocaleString()}</td>
                    <td class="text-end">Ksh ${itemSubtotal.toLocaleString()}</td>
                </tr>
            `;
            
            // Populate "To" address (using the first item's data)
            if (index === 0) {
                $('#to-address').html(`
                    <strong class="text-blue fs-24">${item.customer_name}</strong><br>
                    ${item.customer_address}<br>
                    <strong>Phone: ${item.phone_number || 'N/A'} &nbsp;&nbsp;&nbsp;&nbsp; Email: ${item.email_address || 'N/A'}</strong>
                `);

                // Populate other invoice details
                $('#invoice-number').text(item.invoice);
                $('#payment-due').text(formattedDueDate);
                $('#payment-due-2').text(formattedDueDate);
                $('#payment-method').text(item.payment_terms);
                $('#account-number').text(item.account_no ? item.account_no : 'No account number');
            }
        });

        // Insert data into the table
        $('#invoice-items').html(invoiceTable);

        // Populate Sub-Total, VAT, and Total fields
        $('#sub-total').text(`Ksh ${subTotal.toLocaleString()}`);
        $('#tax-amount').text(`Ksh ${totalVat.toLocaleString()}`);
        $('#total-amount').text(`Ksh ${(subTotal + totalVat).toLocaleString()}`);

        // Populate date generated
        $('#date-generated').text(formattedDateGenerated);
    }
});
</script>