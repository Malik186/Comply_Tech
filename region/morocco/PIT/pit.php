<div class="box" id="morocco-pit-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h4 class="card-title">Morocco Personal Income Tax (PIT) - High-Level Scenario-Based Form</h4>
            </div>
            <div class="card-body">
                <form id="MA-HIGH-LEVEL-PIT-CALC">

                    <!-- Personal and Residency Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Personal and Residency Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nationalID" class="form-label">National ID: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nationalID" required>
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
                                    <label for="dateOfBirth" class="form-label">Date of Birth: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dateOfBirth" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dependents" class="form-label">Number of Dependents:</label>
                                    <input type="number" class="form-control" id="dependents" min="0" step="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Income Sources -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Income Sources</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salaryIncome" class="form-label">Annual Salary Income (MAD): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="salaryIncome" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="businessIncome" class="form-label">Business Income (MAD):</label>
                                    <input type="number" class="form-control" id="businessIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="rentalIncome" class="form-label">Rental Income (MAD):</label>
                                    <input type="number" class="form-control" id="rentalIncome" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="investmentIncome" class="form-label">Investment Income (MAD):</label>
                                    <input type="number" class="form-control" id="investmentIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="foreignIncome" class="form-label">Foreign Income (MAD):</label>
                                    <input type="number" class="form-control" id="foreignIncome" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherIncome" class="form-label">Other Income (MAD):</label>
                                    <input type="number" class="form-control" id="otherIncome" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Allowable Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Allowable Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="healthInsurance" class="form-label">Health Insurance Contributions (MAD):</label>
                                    <input type="number" class="form-control" id="healthInsurance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="retirementContributions" class="form-label">Retirement Contributions (MAD):</label>
                                    <input type="number" class="form-control" id="retirementContributions" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="educationExpenses" class="form-label">Education Expenses (MAD):</label>
                                    <input type="number" class="form-control" id="educationExpenses" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mortgageInterest" class="form-label">Mortgage Interest (MAD):</label>
                                    <input type="number" class="form-control" id="mortgageInterest" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="charitableDonations" class="form-label">Charitable Donations (MAD):</label>
                                    <input type="number" class="form-control" id="charitableDonations" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="dependentCareExpenses" class="form-label">Dependent Care Expenses (MAD):</label>
                                    <input type="number" class="form-control" id="dependentCareExpenses" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Reliefs and Credits -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Tax Reliefs and Credits</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foreignTaxCredits" class="form-label">Foreign Tax Credits (MAD):</label>
                                    <input type="number" class="form-control" id="foreignTaxCredits" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="taxReliefForDisabled" class="form-label">Tax Relief for Disabled (MAD):</label>
                                    <input type="number" class="form-control" id="taxReliefForDisabled" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxCreditChildren" class="form-label">Tax Credit for Children (MAD):</label>
                                    <input type="number" class="form-control" id="taxCreditChildren" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="specialExemptions" class="form-label">Other Exemptions (MAD):</label>
                                    <input type="number" class="form-control" id="specialExemptions" min="0" step="0.01">
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
    include_once site . "/region/morocco/PIT/form.handler.php";
?>