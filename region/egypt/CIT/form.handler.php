<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get form element
    const form = document.getElementById('EG-CORPORATE-TAX-CALC');
    const calculateButton = document.getElementById('calculate-corporate');
    const resetButton = document.getElementById('reset-form');

    // Handle form submission
    calculateButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Show loading state
        calculateButton.disabled = true;
        calculateButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

        // Collect form data
        const formData = {
            // Company Details
            companyName: document.getElementById('companyName').value,
            taxRegistrationNumber: document.getElementById('taxRegistrationNumber').value,
            taxYear: document.getElementById('taxYear').value,
            yearEnd: document.getElementById('yearEnd').value,

            // Company Classification
            companyType: document.getElementById('companyType').value,
            economicZone: document.getElementById('economicZone').value,
            residencyStatus: document.getElementById('residencyStatus').value,
            smeStatus: document.getElementById('smeStatus').value,

            // Financial Information
            annualRevenue: parseFloat(document.getElementById('annualRevenue').value) || 0,
            totalIncome: parseFloat(document.getElementById('totalIncome').value) || 0,
            deductibleExpenses: parseFloat(document.getElementById('deductibleExpenses').value) || 0,
            depreciation: parseFloat(document.getElementById('depreciation').value) || 0,

            // Tax Incentives and Deductions
            investmentIncentives: parseFloat(document.getElementById('investmentIncentives').value) || 0,
            exportIncentives: parseFloat(document.getElementById('exportIncentives').value) || 0,
            donations: parseFloat(document.getElementById('donations').value) || 0,
            carryForwardLosses: parseFloat(document.getElementById('carryForwardLosses').value) || 0,

            // International Operations
            foreignIncome: parseFloat(document.getElementById('foreignIncome').value) || 0,
            foreignTaxCredit: parseFloat(document.getElementById('foreignTaxCredit').value) || 0,
            withholdingTax: parseFloat(document.getElementById('withholdingTax').value) || 0,
            transferPricing: parseFloat(document.getElementById('transferPricing').value) || 0
        };

        // Send data to backend
        fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/egypt/cit.php', {
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
            console.log('Success:', data);
            // You can add code here to display the calculation results
            showResults(data);
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
            showError('An error occurred while calculating tax. Please try again.');
        })
        .finally(() => {
            // Reset button state
            calculateButton.disabled = false;
            calculateButton.innerHTML = 'Calculate Tax';
        });
    });

    // Handle form reset
    resetButton.addEventListener('click', function() {
        form.reset();
        // Clear any existing results or error messages
        clearResults();
    });

    // Function to display calculation results
    function showResults(data) {
        // Create results container if it doesn't exist
        let resultsContainer = document.getElementById('tax-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.id = 'tax-results';
            resultsContainer.className = 'mt-4 p-3 border rounded bg-light';
            form.after(resultsContainer);
        }

        // Clear previous results
        resultsContainer.innerHTML = '';

        // Display results
        if (data.success) {
            resultsContainer.innerHTML = `
                <h5 class="text-success mb-3">Tax Calculation Results</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Taxable Income:</strong> EGP ${formatNumber(data.taxableIncome)}</p>
                        <p><strong>Tax Rate Applied:</strong> ${data.taxRate}%</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Tax Due:</strong> EGP ${formatNumber(data.taxDue)}</p>
                        <p><strong>Effective Tax Rate:</strong> ${data.effectiveRate}%</p>
                    </div>
                </div>
            `;
        } else {
            showError(data.message || 'Unable to calculate tax. Please check your inputs.');
        }
    }

    // Function to display errors
    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger mt-3';
        errorDiv.role = 'alert';
        errorDiv.textContent = message;
        form.after(errorDiv);

        // Remove error message after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    // Function to clear results
    function clearResults() {
        const resultsContainer = document.getElementById('tax-results');
        if (resultsContainer) {
            resultsContainer.remove();
        }
    }

    // Helper function to format numbers
    function formatNumber(number) {
        return new Intl.NumberFormat('en-EG').format(number);
    }
});
</script>