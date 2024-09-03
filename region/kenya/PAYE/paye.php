<div class="box" id="kenya-paye-form" style="display: none;">
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Kenya PAYE Tax Calculation Input</h4>
        </div>
        <div class="card-body">
            <form id="PAYE-CALC">
                <!-- Income Details -->
                <div class="mb-4">
                    <h5>Income Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="grossSalary" class="form-label">Gross Salary: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="grossSalary" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="calculationPeriod" class="form-label">Calculation Period: <span class="text-danger">*</span></label>
                                <select class="form-select" id="calculationPeriod" required>
                                    <option value="">Select Period</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deductions -->
                <div class="mb-4">
                    <h5>Deductions</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NSSF Tier:</label>
                                <select class="form-select" id="nssfTier" required>
                                    <option value="tier_1">Tier 1</option>
                                    <option value="tier_2">Tier 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="housingLevy">
                                <label class="form-check-label" for="housingLevy">Include Housing Levy (1.5%)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Mortgage -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Do you have a Mortgage?</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="mortgageYes" name="mortgage" value="yes" onclick="toggleMortgageField(true)">
                                    <label class="form-check-label" for="mortgageYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="mortgageNo" name="mortgage" value="no" onclick="toggleMortgageField(false)">
                                    <label class="form-check-label" for="mortgageNo">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="mortgageInterestField" style="display: none;">
                            <div class="mb-3">
                                <label for="mortgageInterest" class="form-label">Mortgage Interest:</label>
                                <input type="number" class="form-control" id="mortgageInterest">
                            </div>
                        </div>
                    </div>

                    <!-- Life Insurance -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Do you have a Life Insurance Policy?</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="insuranceYes" name="insurance" value="yes" onclick="toggleInsuranceField(true)">
                                    <label class="form-check-label" for="insuranceYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="insuranceNo" name="insurance" value="no" onclick="toggleInsuranceField(false)">
                                    <label class="form-check-label" for="insuranceNo">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="insurancePremiumField" style="display: none;">
                            <div class="mb-3">
                                <label for="insurancePremium" class="form-label">Insurance Premium:</label>
                                <input type="number" class="form-control" id="insurancePremium">
                            </div>
                        </div>
                    </div>

                    <!-- Home Ownership Savings Plan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Do you have a Home Ownership Savings Plan?</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="savingsYes" name="savings" value="yes" onclick="toggleSavingsField(true)">
                                    <label class="form-check-label" for="savingsYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="savingsNo" name="savings" value="no" onclick="toggleSavingsField(false)">
                                    <label class="form-check-label" for="savingsNo">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="savingsDepositField" style="display: none;">
                            <div class="mb-3">
                                <label for="savingsDeposit" class="form-label">Home Ownership Total Deposit:</label>
                                <input type="number" class="form-control" id="savingsDeposit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="otherDeductions" class="form-label">Other Deductions:</label>
                                <input type="number" class="form-control" id="otherDeductions">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <h5>Confirmation</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="confirmAccuracy">
                        <label class="form-check-label" for="confirmAccuracy">I confirm that the information provided is accurate and complete.</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" id="calculate-paye" class="btn btn-primary">Calculate PAYE</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

    <?php
    include_once site . "/region/kenya/PAYE/paye.form.handler.php";
    ?>