<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get form element
    const form = document.getElementById('NG-PERSONAL-TAX-CALC');
    // Get calculate button
    const calculateButton = document.getElementById('calculate-pit');

    // Handle form submission
    calculateButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Check if form is valid
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Get all form values and create JSON object
        const formData = {
            // Personal Details
            personalDetails: {
                fullName: document.getElementById('fullName').value,
                tin: document.getElementById('tin').value,
                taxState: document.getElementById('taxState').value,
                taxYear: document.getElementById('taxYear').value
            },
            // Employment Income
            employmentIncome: {
                basicSalary: parseFloat(document.getElementById('basicSalary').value) || 0,
                housingAllowance: parseFloat(document.getElementById('housing').value) || 0,
                transportAllowance: parseFloat(document.getElementById('transport').value) || 0,
                utilityAllowance: parseFloat(document.getElementById('utilityAllowance').value) || 0,
                mealAllowance: parseFloat(document.getElementById('mealAllowance').value) || 0,
                otherAllowances: parseFloat(document.getElementById('otherAllowances').value) || 0
            },
            // Other Income
            otherIncome: {
                businessIncome: parseFloat(document.getElementById('businessIncome').value) || 0,
                investmentIncome: parseFloat(document.getElementById('investmentIncome').value) || 0,
                rentalIncome: parseFloat(document.getElementById('rentalIncome').value) || 0,
                otherIncome: parseFloat(document.getElementById('otherIncome').value) || 0
            },
            // Deductions
            deductions: {
                nhf: parseFloat(document.getElementById('nhf').value) || 0,
                pension: parseFloat(document.getElementById('pension').value) || 0,
                nhis: parseFloat(document.getElementById('nhis').value) || 0,
                lifeInsurance: parseFloat(document.getElementById('lifeInsurance').value) || 0
            },
            // Tax Relief Information
            reliefInfo: {
                numberOfDependents: parseInt(document.getElementById('dependents').value) || 0,
                disabilityStatus: document.getElementById('disability').value
            }
        };

        // Disable submit button and show loading state
        calculateButton.disabled = true;
        calculateButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

        // Make AJAX POST request
        fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/nigeria/pit.php', {
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
            console.log('Tax calculation successful:', data);
            
            // You can add code here to display the results on the page
            // For example, showing a success message or tax calculation results
            alert('Tax calculation completed successfully!');
        })
        .catch(error => {
            // Handle errors
            console.error('Error calculating tax:', error);
            alert('Error calculating tax. Please try again.');
        })
        .finally(() => {
            // Re-enable submit button and restore original text
            calculateButton.disabled = false;
            calculateButton.innerHTML = 'Calculate Tax';
        });
    });

    // Handle form reset
    document.getElementById('reset-form').addEventListener('click', function() {
        form.reset();
    });
});
</script>