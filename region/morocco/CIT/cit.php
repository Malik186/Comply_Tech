<div class="box" id="morocco-cit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-danger">
                <h4 class="card-title">Morocco Corporate Income Tax (CIT)</h4>
            </div>
            <div class="card-body">
                <form id="MA-HIGH-LEVEL-CIT-CALC">

                    <!-- Company Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Company Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="companyName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="corporateID" class="form-label">Corporate Identification Number (CIN): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="corporateID" required>
                                </div>
                                <div class="mb-3">
                                    <label for="industry" class="form-label">Industry/Business Sector: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="industry" required>
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
                                    <label for="residencyStatus" class="form-label">Tax Residency Status: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="residencyStatus" required>
                                        <option value="" disabled selected>Select Residency Status</option>
                                        <option value="resident">Resident</option>
                                        <option value="nonResident">Non-Resident</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employees" class="form-label">Number of Employees:</label>
                                    <input type="number" class="form-control" id="employees" min="1" step="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue and Income Sources -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Revenue and Income Sources</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domesticRevenue" class="form-label">Domestic Revenue (MAD): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="domesticRevenue" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="foreignRevenue" class="form-label">Foreign Revenue (MAD):</label>
                                    <input type="number" class="form-control" id="foreignRevenue" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="interestIncome" class="form-label">Interest Income (MAD):</label>
                                    <input type="number" class="form-control" id="interestIncome" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dividendsReceived" class="form-label">Dividends Received (MAD):</label>
                                    <input type="number" class="form-control" id="dividendsReceived" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="capitalGains" class="form-label">Capital Gains (MAD):</label>
                                    <input type="number" class="form-control" id="capitalGains" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherIncome" class="form-label">Other Income (MAD):</label>
                                    <input type="number" class="form-control" id="otherIncome" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operational Expenses and Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Operational Expenses and Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salaries" class="form-label">Employee Salaries and Benefits (MAD):</label>
                                    <input type="number" class="form-control" id="salaries" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="rentalExpenses" class="form-label">Rental Expenses (MAD):</label>
                                    <input type="number" class="form-control" id="rentalExpenses" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="marketingExpenses" class="form-label">Marketing and Advertising Expenses (MAD):</label>
                                    <input type="number" class="form-control" id="marketingExpenses" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="interestOnLoans" class="form-label">Interest on Loans (MAD):</label>
                                    <input type="number" class="form-control" id="interestOnLoans" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="depreciation" class="form-label">Depreciation and Amortization (MAD):</label>
                                    <input type="number" class="form-control" id="depreciation" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherExpenses" class="form-label">Other Operational Expenses (MAD):</label>
                                    <input type="number" class="form-control" id="otherExpenses" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Deductions and Credits -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Deductions and Credits</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="investmentDeductions" class="form-label">Investment Deductions (MAD):</label>
                                    <input type="number" class="form-control" id="investmentDeductions" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="employmentCredits" class="form-label">Employment Credits (MAD):</label>
                                    <input type="number" class="form-control" id="employmentCredits" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="energyEfficiencyCredits" class="form-label">Energy Efficiency Credits (MAD):</label>
                                    <input type="number" class="form-control" id="energyEfficiencyCredits" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherTaxCredits" class="form-label">Other Tax Credits (MAD):</label>
                                    <input type="number" class="form-control" id="otherTaxCredits" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
                            <label class="form-check-label" for="confirmAccuracy">I declare that the information provided is true and accurate</label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" id="resetForm">Reset</button>
                        <button type="submit" class="btn btn-primary">Calculate CIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Include the handler -->
<?php
    include_once site . "/region/morocco/CIT/form.handler.php";
?>