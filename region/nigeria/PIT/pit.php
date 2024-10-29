<div class="box" id="nigeria-pit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-danger">
                <h4 class="card-title">Nigeria Personal Income Tax</h4>
            </div>
            <div class="card-body">
                <form id="NG-PERSONAL-TAX-CALC">
                    <!-- Personal Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Personal Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tin" class="form-label">Tax Identification Number (TIN): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tin" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxState" class="form-label">State of Residence: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxState" required>
                                        <option value="" disabled selected>Select State</option>
                                        <option value="lagos">Lagos</option>
                                        <option value="abuja">FCT Abuja</option>
                                        <option value="other">Other States</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="taxYear" class="form-label">Tax Year: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxYear" required>
                                        <option value="" disabled selected>Select Tax Year</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Income -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Employment Income</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="basicSalary" class="form-label">Basic Salary (₦): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="basicSalary" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="housing" class="form-label">Housing Allowance (₦):</label>
                                    <input type="number" class="form-control" id="housing" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="transport" class="form-label">Transport Allowance (₦):</label>
                                    <input type="number" class="form-control" id="transport" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="utilityAllowance" class="form-label">Utility Allowance (₦):</label>
                                    <input type="number" class="form-control" id="utilityAllowance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="mealAllowance" class="form-label">Meal Allowance (₦):</label>
                                    <input type="number" class="form-control" id="mealAllowance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherAllowances" class="form-label">Other Allowances (₦):</label>
                                    <input type="number" class="form-control" id="otherAllowances" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Income -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Other Income</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="businessIncome" class="form-label">Business Income (₦):</label>
                                    <input type="number" class="form-control" id="businessIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="investmentIncome" class="form-label">Investment Income (₦):</label>
                                    <input type="number" class="form-control" id="investmentIncome" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rentalIncome" class="form-label">Rental Income (₦):</label>
                                    <input type="number" class="form-control" id="rentalIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherIncome" class="form-label">Other Income (₦):</label>
                                    <input type="number" class="form-control" id="otherIncome" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nhf" class="form-label">National Housing Fund (NHF):</label>
                                    <input type="number" class="form-control" id="nhf" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="pension" class="form-label">Pension Contribution:</label>
                                    <input type="number" class="form-control" id="pension" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nhis" class="form-label">National Health Insurance (NHIS):</label>
                                    <input type="number" class="form-control" id="nhis" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="lifeInsurance" class="form-label">Life Insurance Premium:</label>
                                    <input type="number" class="form-control" id="lifeInsurance" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Relief -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Relief Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dependents" class="form-label">Number of Dependents:</label>
                                    <input type="number" class="form-control" id="dependents" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="disability" class="form-label">Disability Status:</label>
                                    <select class="form-select" id="disability">
                                        <option value="no">No Disability</option>
                                        <option value="yes">Has Disability</option>
                                    </select>
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
                        <button type="submit" id="calculate-pit" class="btn btn-primary">Calculate Tax</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the handler -->
<?php
    include_once site . "/region/nigeria/PIT/form.handler.php";
?>