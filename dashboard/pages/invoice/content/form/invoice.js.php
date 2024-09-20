<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/vat.recent.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                let data = response.data;
                let invoiceTable = '';
                let subTotal = 0;
                let totalVat = 0;
                let invoiceNumber = 1;

                // Loop through each item in the response
                data.forEach(function(item, index) {
                    // Format date for date_generated and due_date
                    let dateGenerated = new Date(item.date_generated);
                    let formattedDateGenerated = dateGenerated.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

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
                    
                    // Populate "To" address
                    $('#to-address').html(`
                        <strong class="text-blue fs-24">${item.customer_name}</strong><br>
                        ${item.customer_address}<br>
                        <strong>Phone: ${item.phone_number} &nbsp;&nbsp;&nbsp;&nbsp; Email: ${item.email_address}</strong>
                    `);

                    // Populate other invoice details
                    $('#invoice-number').text(item.Invoice);
                    $('#payment-due').text(formattedDueDate);
                    $('#payment-method').text(item.payment_terms);
                    $('#account-number').text(item.account_no ? item.account_no : 'No account number');
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
        },
        error: function(error) {
            console.error("Error fetching the invoice data: ", error);
        }
    });
});

</script>