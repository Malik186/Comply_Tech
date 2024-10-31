<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get form and button elements
        const form = document.getElementById('MA-HIGH-LEVEL-PIT-CALC');
        const calculateButton = document.getElementById('calculate-pit');

        // Handle form submission
        calculateButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Check if form is valid
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Collect form data into JSON structure
            const formData = {
                personalDetails: {
                    fullName: document.getElementById('fullName').value,
                    nationalID: document.getElementById('nationalID').value,
                    residencyStatus: document.getElementById('residencyStatus').value,
                    taxYear: document.getElementById('taxYear').value,
                    dateOfBirth: document.getElementById('dateOfBirth').value,
                    dependents: parseInt(document.getElementById('dependents').value) || 0
                },
                incomeSources: {
                    salaryIncome: parseFloat(document.getElementById('salaryIncome').value) || 0,
                    businessIncome: parseFloat(document.getElementById('businessIncome').value) || 0,
                    rentalIncome: parseFloat(document.getElementById('rentalIncome').value) || 0,
                    investmentIncome: parseFloat(document.getElementById('investmentIncome').value) || 0,
                    foreignIncome: parseFloat(document.getElementById('foreignIncome').value) || 0,
                    otherIncome: parseFloat(document.getElementById('otherIncome').value) || 0
                },
                deductions: {
                    healthInsurance: parseFloat(document.getElementById('healthInsurance').value) || 0,
                    retirementContributions: parseFloat(document.getElementById('retirementContributions').value) || 0,
                    educationExpenses: parseFloat(document.getElementById('educationExpenses').value) || 0,
                    mortgageInterest: parseFloat(document.getElementById('mortgageInterest').value) || 0,
                    charitableDonations: parseFloat(document.getElementById('charitableDonations').value) || 0,
                    dependentCareExpenses: parseFloat(document.getElementById('dependentCareExpenses').value) || 0
                },
                taxReliefsAndCredits: {
                    foreignTaxCredits: parseFloat(document.getElementById('foreignTaxCredits').value) || 0,
                    taxReliefForDisabled: parseFloat(document.getElementById('taxReliefForDisabled').value) || 0,
                    taxCreditChildren: parseFloat(document.getElementById('taxCreditChildren').value) || 0,
                    specialExemptions: parseFloat(document.getElementById('specialExemptions').value) || 0
                }
            };

            // Disable button and show loading spinner
            calculateButton.disabled = true;
            calculateButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

            // Make AJAX POST request
            fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/morocco/pit.php', {
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
                // Success: handle response data
                console.log('Tax calculation successful:', data);
                alert('Tax calculation completed successfully!');
                // You could display data dynamically on the page here if needed
            })
            .catch(error => {
                // Error: log and notify user
                console.error('Error calculating tax:', error);
                alert('Error calculating tax. Please try again.');
            })
            .finally(() => {
                // Re-enable button and restore original text
                calculateButton.disabled = false;
                calculateButton.innerHTML = 'Calculate Tax';
            });
        });
    });
</script>