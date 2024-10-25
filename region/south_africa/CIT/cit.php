<div class="box" id="southafrica-cit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h4 class="card-title">South Africa Corporate Income Tax Calculator</h4>
            </div>
            <div class="card-body">
                <form id="SA-CORPORATE-TAX-CALC">
                    <!-- Company Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Company Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="companyName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registrationNumber" class="form-label">Company Registration Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="registrationNumber" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxYear" class="form-label">Tax Year: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxYear" required>
                                        <option value="" disabled selected>Select Tax Year</option>
                                        <option value="2024">2024/2025</option>
                                        <option value="2023">2023/2024</option>
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
                                        <option value="standard">Standard Company (27% Rate)</option>
                                        <option value="sbc">Small Business Corporation</option>
                                        <option value="micro">Micro Business (Turnover Tax)</option>
                                        <option value="manufacturing">Manufacturing Company</option>
                                        <option value="mining">Mining Company</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="residencyStatus" class="form-label">Residency Status: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="residencyStatus" required>
                                        <option value="" disabled selected>Select Residency Status</option>
                                        <option value="resident">SA Resident Company</option>
                                        <option value="nonResident">Non-Resident Company</option>
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
                                    <label for="annualTurnover" class="form-label">Annual Turnover (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="annualTurnover" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="grossIncome" class="form-label">Gross Income (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="grossIncome" required min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="operatingExpenses" class="form-label">Operating Expenses (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="operatingExpenses" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="capitalAllowances" class="form-label">Capital Allowances (R):</label>
                                    <input type="number" class="form-control" id="capitalAllowances" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions and Allowances -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Deductions and Allowances</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rdExpenses" class="form-label">R&D Expenses (R):</label>
                                    <input type="number" class="form-control" id="rdExpenses" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="learnershipAllowances" class="form-label">Learnership Allowances (R):</label>
                                    <input type="number" class="form-control" id="learnershipAllowances" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employmentTaxIncentive" class="form-label">Employment Tax Incentive (R):</label>
                                    <input type="number" class="form-control" id="employmentTaxIncentive" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="badDebts" class="form-label">Bad Debts Written Off (R):</label>
                                    <input type="number" class="form-control" id="badDebts" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Provisions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Special Provisions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foreignIncome" class="form-label">Foreign Income (R):</label>
                                    <input type="number" class="form-control" id="foreignIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="foreignTaxCredits" class="form-label">Foreign Tax Credits (R):</label>
                                    <input type="number" class="form-control" id="foreignTaxCredits" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assessedLosses" class="form-label">Assessed Losses Brought Forward (R):</label>
                                    <input type="number" class="form-control" id="assessedLosses" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="dividendsReceived" class="form-label">Dividends Received (R):</label>
                                    <input type="number" class="form-control" id="dividendsReceived" min="0" step="0.01">
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

<?php
    include_once site . "/region/south_africa/CIT/form.handler.php";
    ?>