<div class="box" id="nigeria-cit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h4 class="card-title">Nigeria Corporate Income Tax Calculator</h4>
            </div>
            <div class="card-body">
                <form id="NG-CORPORATE-TAX-CALC">
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
                                    <label for="rcNumber" class="form-label">RC Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="rcNumber" required>
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
                                        <option value="small">Small Company (Revenue < ₦25M)</option>
                                        <option value="medium">Medium Company (Revenue ₦25M - ₦100M)</option>
                                        <option value="large">Large Company (Revenue > ₦100M)</option>
                                        <option value="manufacturing">Manufacturing Company</option>
                                        <option value="agricultural">Agricultural Company</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="businessSector" class="form-label">Business Sector: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="businessSector" required>
                                        <option value="" disabled selected>Select Business Sector</option>
                                        <option value="general">General Trading</option>
                                        <option value="manufacturing">Manufacturing</option>
                                        <option value="agriculture">Agriculture</option>
                                        <option value="mining">Mining</option>
                                        <option value="services">Services</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Revenue Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="totalRevenue" class="form-label">Total Annual Revenue (₦): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="totalRevenue" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="exportRevenue" class="form-label">Export Revenue (₦):</label>
                                    <input type="number" class="form-control" id="exportRevenue" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="localRevenue" class="form-label">Local Revenue (₦):</label>
                                    <input type="number" class="form-control" id="localRevenue" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherIncome" class="form-label">Other Income (₦):</label>
                                    <input type="number" class="form-control" id="otherIncome" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expenses and Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Expenses and Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="operatingExpenses" class="form-label">Operating Expenses (₦): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="operatingExpenses" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="capitalAllowances" class="form-label">Capital Allowances (₦):</label>
                                    <input type="number" class="form-control" id="capitalAllowances" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pioneerStatus" class="form-label">Pioneer Status Relief (₦):</label>
                                    <input type="number" class="form-control" id="pioneerStatus" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="investmentAllowance" class="form-label">Investment Allowance (₦):</label>
                                    <input type="number" class="form-control" id="investmentAllowance" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Incentives -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Incentives</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ruralInvestment" class="form-label">Rural Investment Allowance (₦):</label>
                                    <input type="number" class="form-control" id="ruralInvestment" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="exportIncentives" class="form-label">Export Incentives (₦):</label>
                                    <input type="number" class="form-control" id="exportIncentives" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="infrastructureCredit" class="form-label">Infrastructure Tax Credit (₦):</label>
                                    <input type="number" class="form-control" id="infrastructureCredit" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="previousLosses" class="form-label">Previous Years Losses (₦):</label>
                                    <input type="number" class="form-control" id="previousLosses" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Minimum Tax -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Minimum Tax Assessment</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Minimum Tax Applicable?</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="minimumTaxApplicable">
                                        <label class="form-check-label" for="minimumTaxApplicable">Company is subject to minimum tax</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minimumTaxBase" class="form-label">Minimum Tax Base Amount (₦):</label>
                                    <input type="number" class="form-control" id="minimumTaxBase" min="0" step="0.01">
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

<!-- Include the handler -->
<?php
    include_once site . "/region/nigeria/CIT/form.handler.php";
?>