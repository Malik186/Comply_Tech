<div class="box" id="egypt-pit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-danger">
                <h4 class="card-title">Egypt Personal Income Tax</h4>
            </div>
            <div class="card-body">
                <form id="EG-PERSONAL-TAX-CALC">
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
                                    <label for="nationalId" class="form-label">National ID Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nationalId" required>
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
                                    <label for="residencyStatus" class="form-label">Residency Status: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="residencyStatus" required>
                                        <option value="" disabled selected>Select Residency Status</option>
                                        <option value="resident">Resident</option>
                                        <option value="nonResident">Non-Resident</option>
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
                                    <label for="basicSalary" class="form-label">Basic Salary (EGP): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="basicSalary" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="bonuses" class="form-label">Bonuses & Incentives (EGP):</label>
                                    <input type="number" class="form-control" id="bonuses" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="allowances" class="form-label">Allowances (EGP):</label>
                                    <input type="number" class="form-control" id="allowances" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="overtime" class="form-label">Overtime Pay (EGP):</label>
                                    <input type="number" class="form-control" id="overtime" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Income Sources -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Additional Income Sources</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="professionalIncome" class="form-label">Professional/Self-Employment Income (EGP):</label>
                                    <input type="number" class="form-control" id="professionalIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="rentalIncome" class="form-label">Rental Income (EGP):</label>
                                    <input type="number" class="form-control" id="rentalIncome" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="investmentIncome" class="form-label">Investment Income (EGP):</label>
                                    <input type="number" class="form-control" id="investmentIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="foreignIncome" class="form-label">Foreign Source Income (EGP):</label>
                                    <input type="number" class="form-control" id="foreignIncome" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions and Exemptions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Deductions and Exemptions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="socialInsurance" class="form-label">Social Insurance Contributions (EGP):</label>
                                    <input type="number" class="form-control" id="socialInsurance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="medicalExpenses" class="form-label">Medical Expenses (EGP):</label>
                                    <input type="number" class="form-control" id="medicalExpenses" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personalExemption" class="form-label">Personal Exemption (EGP):</label>
                                    <input type="number" class="form-control" id="personalExemption" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="dependentExemptions" class="form-label">Dependent Exemptions (EGP):</label>
                                    <input type="number" class="form-control" id="dependentExemptions" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Credits -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Credits</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foreignTaxCredit" class="form-label">Foreign Tax Credits (EGP):</label>
                                    <input type="number" class="form-control" id="foreignTaxCredit" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="otherCredits" class="form-label">Other Tax Credits (EGP):</label>
                                    <input type="number" class="form-control" id="otherCredits" min="0" step="0.01">
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
    include_once site . "/region/egypt/PIT/form.handler.php";
?>