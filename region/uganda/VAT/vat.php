<div class="box" id="uganda-vat-form" style="display: none;">
    <div class="box-header with-border">
        <h4 class="box-title">Uganda VAT Calculation Input</h4>
    </div>
    <div class="box-body wizard-content">
        <form action="#" class="tab-wizard wizard-circle">
            <!-- Step 1: Basic Information -->
            <h6>Transaction Details</h6>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="transactionType" class="form-label">Transaction Type : <span class="text-danger">*</span></label>
                            <select class="form-select" id="transactionType" required>
                                <option value="">Select Type</option>
                                <option value="sale">Sale</option>
                                <option value="purchase">Purchase</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vatRate" class="form-label">VAT Rate : <span class="text-danger">*</span></label>
                            <select class="form-select" id="vatRate" required>
                                <option value="">Select Rate</option>
                                <option value="16">16% (Standard Rate)</option>
                                <option value="8">8% (Reduced Rate)</option>
                                <option value="0">0% (Zero-Rated)</option>
                                <option value="exempt">Exempt</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 2: Amount Details -->
            <h6>Amount Details</h6>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amountType" class="form-label">Amount Type : <span class="text-danger">*</span></label>
                            <select class="form-select" id="amountType" required>
                                <option value="">Select Type</option>
                                <option value="exclusive">VAT Exclusive</option>
                                <option value="inclusive">VAT Inclusive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount" class="form-label">Amount (KES) : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="amount" required step="0.01">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 3: Additional Information -->
            <h6>Additional Information</h6>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="transactionDate" class="form-label">Transaction Date :</label>
                            <input type="date" class="form-control" id="transactionDate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoiceNumber" class="form-label">Invoice Number :</label>
                            <input type="text" class="form-control" id="invoiceNumber">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="form-label">Description :</label>
                            <textarea id="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 4: Confirmation -->
            <h6>Confirmation</h6>
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="c-inputs-stacked">
                                <input type="checkbox" id="confirmAccuracy" required>
                                <label for="confirmAccuracy" class="d-block">I confirm that the information provided is accurate and complete.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>