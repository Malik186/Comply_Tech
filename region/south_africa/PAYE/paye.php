<div class="box" id="southafrica-paye-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h4 class="card-title">South Africa PAYE Tax Calculator</h4>
            </div>
            <div class="card-body">
                <form id="SA-PAYE-TAX-CALC">
                    <!-- Employee Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Employee Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label">Employee Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="employeeName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="idNumber" class="form-label">ID/Passport Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="idNumber" required>
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
                                    <label for="age" class="form-label">Age (for rebate calculation): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="age" required min="16" max="100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Salary Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Basic Salary Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salaryFrequency" class="form-label">Salary Frequency: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="salaryFrequency" required>
                                        <option value="" disabled selected>Select Frequency</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="biweekly">Bi-weekly</option>
                                        <option value="annual">Annual</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="basicSalary" class="form-label">Basic Salary (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="basicSalary" required min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bonus13th" class="form-label">13th Cheque/Annual Bonus (R):</label>
                                    <input type="number" class="form-control" id="bonus13th" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="commission" class="form-label">Commission (R):</label>
                                    <input type="number" class="form-control" id="commission" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits and Allowances -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Benefits and Allowances</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="carAllowance" class="form-label">Car Allowance (R):</label>
                                    <input type="number" class="form-control" id="carAllowance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="travelAllowance" class="form-label">Travel Allowance (R):</label>
                                    <input type="number" class="form-control" id="travelAllowance" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="housingAllowance" class="form-label">Housing Allowance (R):</label>
                                    <input type="number" class="form-control" id="housingAllowance" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="otherAllowances" class="form-label">Other Allowances (R):</label>
                                    <input type="number" class="form-control" id="otherAllowances" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Deductions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="retirementFunding" class="form-label">Retirement Funding (Pension/Provident/RA) (R):</label>
                                    <input type="number" class="form-control" id="retirementFunding" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="medicalAidContributions" class="form-label">Medical Aid Contributions (R):</label>
                                    <input type="number" class="form-control" id="medicalAidContributions" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="medicalDependents" class="form-label">Number of Medical Aid Dependents:</label>
                                    <input type="number" class="form-control" id="medicalDependents" min="0" step="1">
                                </div>
                                <div class="mb-3">
                                    <label for="otherDeductions" class="form-label">Other Tax Deductible Items (R):</label>
                                    <input type="number" class="form-control" id="otherDeductions" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Credits and Rebates -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Additional Tax Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Foreign Employment Income?</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="hasForeignIncome">
                                        <label class="form-check-label" for="hasForeignIncome">Yes (Section 10(1)(o)(ii) exemption)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foreignDays" class="form-label">Days Working Outside SA:</label>
                                    <input type="number" class="form-control" id="foreignDays" min="0" max="366">
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
                        <button type="submit" id="calculate-paye" class="btn btn-primary">Calculate PAYE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include_once site . "/region/south_africa/PAYE/form.handler.php";
    ?>