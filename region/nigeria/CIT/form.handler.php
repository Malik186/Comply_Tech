<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const form = document.getElementById('NG-CORPORATE-TAX-CALC');
    
    // Add event listener for form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateTax();
    });

    // Add event listener for reset button
    document.getElementById('reset-form').addEventListener('click', function() {
        form.reset();
    });

    function calculateTax() {
        // Show loading state
        const submitButton = document.getElementById('calculate-corporate');
        const originalButtonText = submitButton.innerHTML;
        submitButton.innerHTML = 'Calculating...';
        submitButton.disabled = true;

        // Collect form data
        const formData = {
            // Company Details
            companyDetails: {
                companyName: document.getElementById('companyName').value,
                rcNumber: document.getElementById('rcNumber').value,
                taxYear: document.getElementById('taxYear').value,
                yearEnd: document.getElementById('yearEnd').value
            },
            
            // Company Classification
            classification: {
                companyType: document.getElementById('companyType').value,
                businessSector: document.getElementById('businessSector').value
            },
            
            // Revenue Information
            revenue: {
                totalRevenue: parseFloat(document.getElementById('totalRevenue').value) || 0,
                exportRevenue: parseFloat(document.getElementById('exportRevenue').value) || 0,
                localRevenue: parseFloat(document.getElementById('localRevenue').value) || 0,
                otherIncome: parseFloat(document.getElementById('otherIncome').value) || 0
            },
            
            // Expenses and Deductions
            expenses: {
                operatingExpenses: parseFloat(document.getElementById('operatingExpenses').value) || 0,
                capitalAllowances: parseFloat(document.getElementById('capitalAllowances').value) || 0,
                pioneerStatus: parseFloat(document.getElementById('pioneerStatus').value) || 0,
                investmentAllowance: parseFloat(document.getElementById('investmentAllowance').value) || 0
            },
            
            // Tax Incentives
            incentives: {
                ruralInvestment: parseFloat(document.getElementById('ruralInvestment').value) || 0,
                exportIncentives: parseFloat(document.getElementById('exportIncentives').value) || 0,
                infrastructureCredit: parseFloat(document.getElementById('infrastructureCredit').value) || 0,
                previousLosses: parseFloat(document.getElementById('previousLosses').value) || 0
            },
            
            // Minimum Tax
            minimumTax: {
                isApplicable: document.getElementById('minimumTaxApplicable').checked,
                baseAmount: parseFloat(document.getElementById('minimumTaxBase').value) || 0
            }
        };

        // Validation before sending
        if (!validateFormData(formData)) {
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
            return;
        }

        // Send data to backend
        fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/nigeria/cit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response
            displayResults(data);
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
            displayError('An error occurred while calculating tax. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
        });
    }

    function validateFormData(formData) {
        // Basic validation rules
        if (formData.revenue.totalRevenue <= 0) {
            displayError('Total revenue must be greater than 0');
            return false;
        }

        // Validate revenue consistency
        const calculatedRevenue = formData.revenue.exportRevenue + 
                                formData.revenue.localRevenue + 
                                formData.revenue.otherIncome;
        
        if (Math.abs(calculatedRevenue - formData.revenue.totalRevenue) > 0.01) {
            displayError('The sum of export revenue, local revenue, and other income must equal total revenue');
            return false;
        }

        // Validate company type matches revenue
        const totalRevenue = formData.revenue.totalRevenue;
        const companyType = formData.classification.companyType;

        if (companyType === 'small' && totalRevenue >= 25000000) {
            displayError('Small companies must have revenue less than ₦25 million');
            return false;
        }

        if (companyType === 'medium' && (totalRevenue < 25000000 || totalRevenue >= 100000000)) {
            displayError('Medium companies must have revenue between ₦25 million and ₦100 million');
            return false;
        }

        if (companyType === 'large' && totalRevenue < 100000000) {
            displayError('Large companies must have revenue of ₦100 million or more');
            return false;
        }

        return true;
    }

    function displayResults(data) {
        // Create or get results container
        let resultsContainer = document.getElementById('tax-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.id = 'tax-results';
            resultsContainer.className = 'mt-4 card';
            form.appendChild(resultsContainer);
        }

        // Display results
        resultsContainer.innerHTML = `
            <div class="card-header">
                <h5>Tax Calculation Results</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Taxable Income:</strong> ₦${formatNumber(data.taxableIncome)}</p>
                        <p><strong>Tax Rate Applied:</strong> ${data.taxRate}%</p>
                        <p><strong>Calculated Tax:</strong> ₦${formatNumber(data.calculatedTax)}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Deductions:</strong> ₦${formatNumber(data.totalDeductions)}</p>
                        <p><strong>Total Credits:</strong> ₦${formatNumber(data.totalCredits)}</p>
                        <p><strong>Final Tax Payable:</strong> ₦${formatNumber(data.finalTaxPayable)}</p>
                    </div>
                </div>
            </div>
        `;
    }

    function displayError(message) {
        // Create or get error container
        let errorContainer = document.getElementById('error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.id = 'error-message';
            errorContainer.className = 'alert alert-danger mt-3';
            form.insertBefore(errorContainer, document.getElementById('tax-results'));
        }

        errorContainer.innerHTML = message;

        // Auto-hide error after 5 seconds
        setTimeout(() => {
            errorContainer.remove();
        }, 5000);
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('en-NG').format(number);
    }
});
</script>