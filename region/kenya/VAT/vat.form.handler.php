<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let itemCount = 1;

        // Function to add new item fields
        $('#addItem').click(function() {
            const newItem = `
                <div class="item-entry mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="itemDescription${itemCount}" class="form-label">Item Description: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="itemDescription[]" required>
                        </div>
                        <div class="col-md-3">
                            <label for="quantity${itemCount}" class="form-label">Quantity: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="quantity[]" required>
                        </div>
                        <div class="col-md-3">
                            <label for="unitPrice${itemCount}" class="form-label">Unit Price (Ksh): <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="unitPrice[]" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        </div>
                    </div>
                </div>
            `;
            $('#itemsContainer').append(newItem);
            itemCount++;
            
            // Show the remove button for the first item if there's more than one item
            if (itemCount > 1) {
                $('.remove-item').show();
            }
        });

        // Remove item when the remove button is clicked
        $(document).on('click', '.remove-item', function() {
            $(this).closest('.item-entry').remove();
            itemCount--;
            
            // Hide the remove button for the first item if there's only one item left
            if (itemCount === 1) {
                $('.remove-item').hide();
            }
        });

        // Capture form data and send to the endpoint using AJAX on button click
        $('#calculate-vat').click(function () {
            console.log('VAT calculation initiated');  // Log to confirm button click event
        
            const items = [];
            $('.item-entry').each(function() {
                items.push({
                    item_description: $(this).find('input[name="itemDescription[]"]').val(),
                    quantity: parseInt($(this).find('input[name="quantity[]"]').val()),
                    unit_price: parseFloat($(this).find('input[name="unitPrice[]"]').val())
                });
            });
        
            const data = {
                customer_name: $('#customerName').val(),
                customer_address: $('#customerAddress').val(),
                items: items,
                payment_terms: $('#paymentTerms').val(),
                due_date: $('#dueDate').val()
            };
        
            console.log('Data sent to the endpoint:', data);  // Log the data being sent
        
            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/vat.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (result) {
                    console.log('VAT Calculation and Invoice Data Result:', result);
                    displayResult(result);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    displayError(error);
                }
            });
        });

        function displayResult(result) {
            if (!$('#result-display').length) {
                $('<div id="result-display"></div>').insertAfter('#VAT-INVOICE-CALC');
            }

            let itemsHtml = result.items.map((item, index) => `
                <tr>
                    <td>${item.item_description}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_price}</td>
                    <td>${item.total_price}</td>
                    <td>${item.vat_amount}</td>
                </tr>
            `).join('');

            $('#result-display').html(`
                <h3>Calculation Result:</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>VAT Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsHtml}
                    </tbody>
                </table>
                <p>Total Amount: ${result.total_amount}</p>
                <p>Total VAT: ${result.total_vat}</p>
                <p>Invoice Number: ${result.invoice_number}</p>
                <p>Invoice Date: ${result.invoice_date}</p>
            `);
        }

        function displayError(error) {
            if (!$('#error-display').length) {
                $('<div id="error-display"></div>').insertAfter('#VAT-INVOICE-CALC');
            }

            $('#error-display').html(`
                <h3>Error:</h3>
                <p>${error}</p>
            `);
        }
    });
</script>