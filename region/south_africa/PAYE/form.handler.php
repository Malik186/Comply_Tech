<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get form element
    const form = document.getElementById('SA-PAYE-TAX-CALC');
    const calculateBtn = document.getElementById('calculate-paye');
    const resetBtn = document.getElementById('reset-form');

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitPAYEData();
    });

    // Reset form
    resetBtn.addEventListener('click', function() {
        form.reset();
    });

    function submitPAYEData() {
        // Show loading state
        calculateBtn.disabled = true;
        calculateBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

        // Collect form data
        const formData = {
            // Employee Details
            employeeDetails: {
                name: document.getElementById('employeeName').value,
                idNumber: document.getElementById('idNumber').value,
                taxYear: document.getElementById('taxYear').value,
                age: parseInt(document.getElementById('age').value)
            },
            // Salary Information
            salaryInfo: {
                frequency: document.getElementById('salaryFrequency').value,
                basicSalary: parseFloat(document.getElementById('basicSalary').value),
                annualBonus: parseFloat(document.getElementById('bonus13th').value) || 0,
                commission: parseFloat(document.getElementById('commission').value) || 0
            },
            // Benefits and Allowances
            benefits: {
                carAllowance: parseFloat(document.getElementById('carAllowance').value) || 0,
                travelAllowance: parseFloat(document.getElementById('travelAllowance').value) || 0,
                housingAllowance: parseFloat(document.getElementById('housingAllowance').value) || 0,
                otherAllowances: parseFloat(document.getElementById('otherAllowances').value) || 0
            },
            // Deductions
            deductions: {
                retirementFunding: parseFloat(document.getElementById('retirementFunding').value) || 0,
                medicalAidContributions: parseFloat(document.getElementById('medicalAidContributions').value) || 0,
                medicalDependents: parseInt(document.getElementById('medicalDependents').value) || 0,
                otherDeductions: parseFloat(document.getElementById('otherDeductions').value) || 0
            },
            // Foreign Employment
            foreignEmployment: {
                hasForeignIncome: document.getElementById('hasForeignIncome').checked,
                daysOutsideSA: parseInt(document.getElementById('foreignDays').value) || 0
            }
        };

        // AJAX request
        fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/southafrica/paye.php', {
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
            showError('An error occurred while calculating PAYE. Please try again.');
            console.error('Error:', error);
        })
        .finally(() => {
            // Reset button state
            calculateBtn.disabled = false;
            calculateBtn.innerHTML = 'Calculate PAYE';
        });
    }

    function displayResults(data) {
        // Create or get results container
        let resultsContainer = document.getElementById('paye-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.id = 'paye-results';
            resultsContainer.className = 'mt-4 card';
            form.insertAdjacentElement('afterend', resultsContainer);
        }

        // Format results
        resultsContainer.innerHTML = `
            <div class="card-header">
                <h5>PAYE Calculation Results</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Monthly PAYE:</strong> R${data.monthlyPAYE?.toFixed(2) || 'N/A'}</p>
                        <p><strong>Annual PAYE:</strong> R${data.annualPAYE?.toFixed(2) || 'N/A'}</p>
                        <p><strong>Tax Credits:</strong> R${data.taxCredits?.toFixed(2) || 'N/A'}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>UIF Contribution:</strong> R${data.uifContribution?.toFixed(2) || 'N/A'}</p>
                        <p><strong>Net Take-Home:</strong> R${data.netTakeHome?.toFixed(2) || 'N/A'}</p>
                        <p><strong>Effective Tax Rate:</strong> ${data.effectiveTaxRate?.toFixed(2) || 'N/A'}%</p>
                    </div>
                </div>
            </div>
        `;
    }

    function showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        form.insertAdjacentElement('beforebegin', alertDiv);

        // Auto-remove alert after 5 seconds
        setTimeout(() => alertDiv.remove(), 5000);
    }
});
</script>