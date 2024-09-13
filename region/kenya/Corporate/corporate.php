<div class="box" id="kenya-corporate-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kenya Corporate Tax Information Input</h4>
            </div>
            <div class="card-body">
                <form id="CORPORATE-TAX-CALC">
                    <!-- Corporate Details -->
                    <div class="mb-4">
                        <h5>Corporate Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="companyName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="yearsOfOperation" class="form-label">Years of Operation: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="yearsOfOperation" required min="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Type of Company -->
                    <div class="mb-4">
                        <h5>Type of Company</h5>
                        <div class="mb-3">
                            <label for="typeOfCompany" class="form-label">Type of Company: <span class="text-danger">*</span></label>
                            <select class="form-select" id="typeOfCompany" required>
                                <option value="" disabled selected>Select Type of Company</option>
                                <option value="Resident Company">Resident Company</option>
                                <option value="Non-Resident Company">Non-Resident Company</option>
                                <option value="Special Rates">Special Rates</option>
                                <option value="Repatriated Income">Repatriated Income</option>
                                <option value="Turnover Tax">Turnover Tax</option>
                            </select>
                        </div>
                    </div>


                    <!-- Special Rates Details (Visible Only if Special Rates is Selected) -->
                    <div class="mb-4" id="specialRatesSection" style="display: none;">
                        <h5>Type of Special Rates</h5>
                        <div class="mb-3">
                            <label for="specialRatesType" class="form-label">Special Rates Type: <span class="text-danger">*</span></label>
                            <select class="form-select" id="specialRatesType">
                                <option value="" disabled selected>Select Special Rates Type</option>
                                <option value="EPZ Enterprises">Export Processing Zone (EPZ) Enterprises</option>
                                <option value="SEZ Enterprises">Special Economic Zone (SEZ) Enterprises</option>
                                <option value="SEZ Developers">SEZ Developers and Operators</option>
                                <option value="Listed Companies">Companies Listed on Securities Exchange</option>
                                <option value="Vehicle Assembly">Local Motor Vehicle Assembly Companies</option>
                            </select>
                        </div>
                    </div>

                    <!-- Yearly Profit -->
                    <div class="mb-4">
                        <h5>Yearly Profit</h5>
                        <div class="mb-3">
                            <label for="yearlyProfit" class="form-label">Yearly Profit (Ksh): <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="yearlyProfit" required>
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
                        <button type="submit" id="calculate-corporate" class="btn btn-primary">Calculate Corporate Tax</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include_once site . "/region/kenya/Corporate/form.handler.php";
    ?>