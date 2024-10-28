<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('SA-CGT-CALC');
    const resetButton = document.getElementById('reset-form');
    const calculateButton = document.getElementById('calculate-cgt');

    // Reset form handler
    resetButton.addEventListener('click', function() {
        form.reset();
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form before submission
        if (!validateForm()) {
            return;
        }

        // Collect form data
        const formData = {
            // Taxpayer Details
            taxpayer: {
                name: document.getElementById('taxpayerName').value,
                taxNumber: document.getElementById('taxNumber').value,
                taxYear: document.getElementById('taxYear').value,
                type: document.getElementById('taxpayerType').value
            },
            
            // Asset Details
            asset: {
                type: document.getElementById('assetType').value,
                acquisitionDate: document.getElementById('acquisitionDate').value,
                disposalDate: document.getElementById('disposalDate').value,
                isPrimaryResidence: document.getElementById('primaryResidence').value === 'yes'
            },
            
            // Financial Information
            financial: {
                acquisitionCost: parseFloat(document.getElementById('acquisitionCost').value),
                disposalProceeds: parseFloat(document.getElementById('disposalProceeds').value),
                improvementCosts: parseFloat(document.getElementById('improvementCosts').value) || 0,
                sellingCosts: parseFloat(document.getElementById('sellingCosts').value) || 0
            },
            
            // Pre-Valuation Date Details
            preValuation: {
                method: document.getElementById('valuationMethod').value,
                valuationDateValue: parseFloat(document.getElementById('valuationDate').value) || 0
            },
            
            // Exemptions
            exemptions: {
                annualExclusion: parseFloat(document.getElementById('annualExclusion').value) || 0,
                otherExemptions: parseFloat(document.getElementById('otherExemptions').value) || 0
            }
        };

        // Show loading state
        calculateButton.disabled = true;
        calculateButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

        // Send data to backend
        fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/southafrica/cgt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response
            displayResults(data);
        })
        .catch(error => {
            // Handle errors
            displayError('An error occurred while calculating CGT. Please try again.');
            console.error('Error:', error);
        })
        .finally(() => {
            // Reset button state
            calculateButton.disabled = false;
            calculateButton.innerHTML = 'Calculate CGT';
        });
    });

    // Form validation function
    function validateForm() {
        // Required fields validation
        const requiredFields = [
            'taxpayerName',
            'taxNumber',
            'taxYear',
            'taxpayerType',
            'assetType',
            'acquisitionDate',
            'disposalDate',
            'acquisitionCost',
            'disposalProceeds'
        ];

        let isValid = true;
        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (!element.value) {
                markFieldAsInvalid(element);
                isValid = false;
            } else {
                markFieldAsValid(element);
            }
        });

        // Date validation
        if (isValid) {
            const acquisitionDate = new Date(document.getElementById('acquisitionDate').value);
            const disposalDate = new Date(document.getElementById('disposalDate').value);
            
            if (disposalDate <= acquisitionDate) {
                displayError('Disposal date must be after acquisition date');
                isValid = false;
            }
        }

        // Financial values validation
        if (isValid) {
            const disposalProceeds = parseFloat(document.getElementById('disposalProceeds').value);
            const acquisitionCost = parseFloat(document.getElementById('acquisitionCost').value);
            
            if (disposalProceeds < 0 || acquisitionCost < 0) {
                displayError('Financial values cannot be negative');
                isValid = false;
            }
        }

        return isValid;
    }

    // Helper function to mark invalid fields
    function markFieldAsInvalid(element) {
        element.classList.add('is-invalid');
        const feedbackDiv = element.nextElementSibling || document.createElement('div');
        feedbackDiv.className = 'invalid-feedback';
        feedbackDiv.textContent = 'This field is required';
        if (!element.nextElementSibling) {
            element.parentNode.appendChild(feedbackDiv);
        }
    }

    // Helper function to mark valid fields
    function markFieldAsValid(element) {
        element.classList.remove('is-invalid');
        element.classList.add('is-valid');
    }

    // Function to display calculation results
    function displayResults(data) {
        // Create or get results container
        let resultsContainer = document.getElementById('cgt-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.id = 'cgt-results';
            resultsContainer.className = 'mt-4 p-3 border rounded bg-light';
            form.parentNode.insertBefore(resultsContainer, form.nextSibling);
        }

        // Display results
        resultsContainer.innerHTML = `
            <h5>CGT Calculation Results</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Capital Gain/Loss:</td>
                            <td>R ${data.capitalGain?.toLocaleString() ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td>Annual Exclusion Applied:</td>
                            <td>R ${data.annualExclusionApplied?.toLocaleString() ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td>Taxable Capital Gain:</td>
                            <td>R ${data.taxableCapitalGain?.toLocaleString() ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td>CGT Payable:</td>
                            <td>R ${data.cgtPayable?.toLocaleString() ?? 'N/A'}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;
    }

    // Function to display errors
    function displayError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = form.parentNode;
        container.insertBefore(alertDiv, form);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>