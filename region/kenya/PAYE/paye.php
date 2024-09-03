<div class="box" id="kenya-paye-form" style="display: none;">
    <div class="box-header with-border">
        <h4 class="box-title">Kenya PAYE Tax Calculation Input</h4>
    </div>
    <div class="box-body wizard-content">
    <form id="taxForm" class="tab-wizard wizard-circle">
    <!-- Step 1 -->
    <h6>Income Details</h6>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="grossSalary" class="form-label">Gross Salary : <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="grossSalary" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="calculationPeriod" class="form-label">Calculation Period : <span class="text-danger">*</span></label>
                    <select class="form-select" id="calculationPeriod" required>
                        <option value="">Select Period</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Step 2 -->
    <h6>Deductions</h6>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">NSSF Tier:</label>
                    <select class="form-select" id="nssfTier" required>
                        <option value="tier_1">Tier 1</option>
                        <option value="tier_2">Tier 2</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Include Housing Levy (1.5%) :</label>
                    <div class="c-inputs-stacked">
                        <input type="checkbox" id="housingLevy">
                        <label for="housingLevy">Yes, include 1.5% Housing Levy</label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mortgage -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Do you have a Mortgage?</label>
                    <div class="c-inputs-stacked">
                        <input type="radio" id="mortgageYes" name="mortgage" value="yes" onclick="toggleMortgageField(true)">
                        <label for="mortgageYes">Yes</label>
                        <input type="radio" id="mortgageNo" name="mortgage" value="no" onclick="toggleMortgageField(false)">
                        <label for="mortgageNo">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="mortgageInterestField" style="display: none;">
                <div class="form-group">
                    <label for="mortgageInterest" class="form-label">Mortgage Interest:</label>
                    <input type="number" class="form-control" id="mortgageInterest">
                </div>
            </div>
        </div>

        <!-- Life Insurance -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Do you have a Life Insurance Policy?</label>
                    <div class="c-inputs-stacked">
                        <input type="radio" id="insuranceYes" name="insurance" value="yes" onclick="toggleInsuranceField(true)">
                        <label for="insuranceYes">Yes</label>
                        <input type="radio" id="insuranceNo" name="insurance" value="no" onclick="toggleInsuranceField(false)">
                        <label for="insuranceNo">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="insurancePremiumField" style="display: none;">
                <div class="form-group">
                    <label for="insurancePremium" class="form-label">Insurance Premium:</label>
                    <input type="number" class="form-control" id="insurancePremium">
                </div>
            </div>
        </div>

        <!-- Home Ownership Savings Plan -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Do you have a Home Ownership Savings Plan?</label>
                    <div class="c-inputs-stacked">
                        <input type="radio" id="savingsYes" name="savings" value="yes" onclick="toggleSavingsField(true)">
                        <label for="savingsYes">Yes</label>
                        <input type="radio" id="savingsNo" name="savings" value="no" onclick="toggleSavingsField(false)">
                        <label for="savingsNo">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="savingsDepositField" style="display: none;">
                <div class="form-group">
                    <label for="savingsDeposit" class="form-label">Home Ownership Total Deposit:</label>
                    <input type="number" class="form-control" id="savingsDeposit">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="otherDeductions" class="form-label">Other Deductions :</label>
                    <input type="number" class="form-control" id="otherDeductions">
                </div>
            </div>
        </div>
    </section>

    <!-- Step 3 -->
    <h6>Confirmation</h6>
    <section>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="c-inputs-stacked">
                        <input type="checkbox" id="confirmAccuracy" required>
                        <label for="confirmAccuracy" class="d-block">I confirm that the information provided is accurate and complete.</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Submit Button -->
    <div class="row">
        <div class="col-12">
            <button type="button" id="submitForm" class="btn btn-primary">Calculate PAYE</button>
        </div>
    </div>
</form>

    </div>
</div>

<script>
// Toggle visibility of mortgage, insurance, and savings fields based on user input
function toggleMortgageField(show) {
    document.getElementById('mortgageInterestField').style.display = show ? 'block' : 'none';
}

function toggleInsuranceField(show) {
    document.getElementById('insurancePremiumField').style.display = show ? 'block' : 'none';
}

function toggleSavingsField(show) {
    document.getElementById('savingsDepositField').style.display = show ? 'block' : 'none';
}

// Capture form data and send to the endpoint
document.getElementById('submitForm').addEventListener('click', function () {
    const grossSalary = document.getElementById('grossSalary').value;
    const calculationPeriod = document.getElementById('calculationPeriod').value;
    const nssfTier = document.getElementById('nssfTier').value;
    const housingLevy = document.getElementById('housingLevy').checked ? 1 : 0;
    const mortgageInterest = document.getElementById('mortgageInterest').value || 0;
    const insurancePremium = document.getElementById('insurancePremium').value || 0;
    const savingsDeposit = document.getElementById('savingsDeposit').value || 0;
    const otherDeductions = document.getElementById('otherDeductions').value || 0;

    const data = {
        gross_salary: grossSalary,
        calculation_period: calculationPeriod,
        nssf_tier: nssfTier,
        housing_levy: housingLevy,
        mortgage_interest: mortgageInterest,
        insurance_premium: insurancePremium,
        savings_deposit: savingsDeposit,
        other_deductions: otherDeductions
    };

    fetch('https://complytech.mdskenya.co.ke/endpoint/engine/kenya/kenya.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('PAYE Calculation Result:', result);
        // Handle the result here, e.g., display it to the user
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle the error here, e.g., display an error message
    });
});
</script>