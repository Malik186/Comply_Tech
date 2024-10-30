<div class="box" id="egypt-cit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-danger">
                <h4 class="card-title">Egypt Corporate Income Tax</h4>
            </div>
            <div class="card-body">
                <form id="EG-CORPORATE-TAX-CALC">
                    <!-- Company Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Company Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name (Arabic): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="companyName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="taxRegistrationNumber" class="form-label">Tax Registration Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="taxRegistrationNumber" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxYear" class="form-label">Tax Year: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxYear" required>
                                        <option value="" disabled selected>Select Tax Year</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="yearEnd" class="form-label">Financial Year End: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="yearEnd" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Classification -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Company Classification</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyType" class="form-label">Type of Company: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="companyType" required>
                                        <option value="" disabled selected>Select Company Type</option>
                                        <option value="standard">Standard Company (22.5% Rate)</option>
                                        <option value="suez">Suez Canal Zone Company (15%)</option>
                                        <option value="petroleum">Oil & Gas Exploration (40.55%)</option>
                                        <option value="bank">Bank (25%)</option>
                                        <option value="microfinance">Microfinance Company (20%)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="economicZone" class="form-label">Economic Zone:</label>
                                    <select class="form-select" id="economicZone">
                                        <option value="" disabled selected>Select Economic Zone</option>
                                        <option value="none">None</option>
                                        <option value="sez">Special Economic Zone</option>
                                        <option value="sczone">Suez Canal Economic Zone</option>
                                        <option value="fz">Free Zone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="residencyStatus" class="form-label">Residency Status: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="residencyStatus" required>
                                        <option value="" disabled selected>Select Residency Status</option>
                                        <option value="resident">Egyptian Resident Company</option>
                                        <option value="nonResident">Non-Resident Company</option>
                                        <option value="pe">Permanent Establishment</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="smeStatus" class="form-label">SME Status:</label>
                                    <select class="form-select" id="smeStatus">
                                        <option value="no">Not an SME</option>
                                        <option value="small">Small Enterprise</option>
                                        <option value="medium">Medium Enterprise</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Financial Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="annualRevenue" class="form-label">Annual Revenue (EGP): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="annualRevenue" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="totalIncome" class="form-label">Total Taxable Income (EGP): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="totalIncome" required min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deductibleExpenses" class="form-label">Deductible Expenses (EGP): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="deductibleExpenses" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="depreciation" class="form-label">Depreciation (EGP):</label>
                                    <input type="number" class="form-control" id="depreciation" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Incentives and Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Incentives and Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="investmentIncentives" class="form-label">Investment Law Incentives (EGP):</label>
                                    <input type="number" class="form-control" id="investmentIncentives" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="exportIncentives" class="form-label">Export Activity Incentives (EGP):</label>
                                    <input type="number" class="form-control" id="exportIncentives" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="donations" class="form-label">Approved Charitable Donations (EGP):</label>
                                    <input type="number" class="form-control" id="donations" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="carryForwardLosses" class="form-label">Carry Forward Losses (EGP):</label>
                                    <input type="number" class="form-control" id="carryForwardLosses" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- International Operations -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">International Operations</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foreignIncome" class="form-label">Foreign Source Income (EGP):</label>
                                    <input type="number" class="form-control" id="foreignIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="foreignTaxCredit" class="form-label">Foreign Tax Credit (EGP):</label>
                                    <input type="number" class="form-control" id="foreignTaxCredit" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="withholdingTax" class="form-label">Withholding Tax Paid (EGP):</label>
                                    <input type="number" class="form-control" id="withholdingTax" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="transferPricing" class="form-label">Transfer Pricing Adjustments (EGP):</label>
                                    <input type="number" class="form-control" id="transferPricing" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Declaration -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
                            <label class="form-check-label" for="confirmAccuracy">I declare that the information provided is true and accurate according to Egyptian Tax Law</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" id="reset-form">Reset Form</button>
                        <button type="submit" id="calculate-corporate" class="btn btn-primary">Calculate Tax</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the handler -->
<?php
    include_once site . "/region/egypt/CIT/form.handler.php";
?>