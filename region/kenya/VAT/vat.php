<div class="box" id="kenya-vat-form">
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Kenya VAT Calculation and Invoice Data Input</h4>
        </div>
        <div class="card-body">
            <form id="VAT-INVOICE-CALC">
                <!-- Customer Details -->
                <div class="mb-4">
                    <h5>Customer Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Customer Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customerName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerAddress" class="form-label">Customer Address:</label>
                                <input type="text" class="form-control" id="customerAddress">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Details -->
                <div class="mb-4">
                    <h5>Item Details</h5>
                    <div id="itemsContainer">
                        <div class="item-entry mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="itemDescription0" class="form-label">Item Description: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="itemDescription[]" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity0" class="form-label">Quantity: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="quantity[]" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="unitPrice0" class="form-label">Unit Price (Ksh): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="unitPrice[]" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-item" style="display: none;">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addItem" class="btn btn-secondary mt-2">Add Another Item</button>
                </div>

                <!-- Additional Invoice Details -->
                <div class="mb-4">
                    <h5>Additional Invoice Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="paymentTerms" class="form-label">Payment Terms:</label>
                                <input type="text" class="form-control" id="paymentTerms">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Due Date:</label>
                                <input type="date" class="form-control" id="dueDate">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <h5>Confirmation</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
                        <label class="form-check-label" for="confirmAccuracy">I confirm that the information provided is accurate and complete.</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" id="calculate-vat" class="btn btn-primary">Calculate VAT and Prepare Invoice Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php
    include_once site . "/region/kenya/VAT/vat.form.handler.php";
    ?>