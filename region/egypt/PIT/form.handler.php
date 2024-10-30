<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('EG-PERSONAL-TAX-CALC');
    const calculateButton = document.getElementById('calculate-pit');
    const resetButton = document.getElementById('reset-form');

    // Function to format numbers to 2 decimal places
    const formatNumber = (num) => {
        return parseFloat(num || 0).toFixed(2);
    };

    // Function to show error messages
    const showError = (message) => {
        alert(message); // You can replace this with a more sophisticated error display
    };

    // Function to show success messages
    const showSuccess = (message) => {
        alert(message); // You can replace this with a more sophisticated success display
    };

    // Function to validate form data
    const validateForm = (data) => {
        if (!data.fullName || !data.nationalId || !data.taxYear || !data.residencyStatus) {
            throw new Error('Please fill in all required personal details');
        }
        if (!data.basicSalary) {
            throw new Error('Basic salary is required');
        }
        if (!document.getElementById('confirmAccuracy').checked) {
            throw new Error('Please confirm the accuracy of the information');
        }
    };

    // Function to collect form data
    const collectFormData = () => {
        return {
            // Personal Details
            fullName: document.getElementById('fullName').value,
            nationalId: document.getElementById('nationalId').value,
            taxYear: document.getElementById('taxYear').value,
            residencyStatus: document.getElementById('residencyStatus').value,

            // Employment Income
            basicSalary: formatNumber(document.getElementById('basicSalary').value),
            bonuses: formatNumber(document.getElementById('bonuses').value),
            allowances: formatNumber(document.getElementById('allowances').value),
            overtime: formatNumber(document.getElementById('overtime').value),

            // Additional Income Sources
            professionalIncome: formatNumber(document.getElementById('professionalIncome').value),
            rentalIncome: formatNumber(document.getElementById('rentalIncome').value),
            investmentIncome: formatNumber(document.getElementById('investmentIncome').value),
            foreignIncome: formatNumber(document.getElementById('foreignIncome').value),

            // Deductions and Exemptions
            socialInsurance: formatNumber(document.getElementById('socialInsurance').value),
            medicalExpenses: formatNumber(document.getElementById('medicalExpenses').value),
            personalExemption: formatNumber(document.getElementById('personalExemption').value),
            dependentExemptions: formatNumber(document.getElementById('dependentExemptions').value),

            // Tax Credits
            foreignTaxCredit: formatNumber(document.getElementById('foreignTaxCredit').value),
            otherCredits: formatNumber(document.getElementById('otherCredits').value)
        };
    };

    // Function to handle form submission
    const handleSubmit = async (event) => {
        event.preventDefault();
        
        try {
            const formData = collectFormData();
            validateForm(formData);

            // Show loading state
            calculateButton.disabled = true;
            calculateButton.innerHTML = 'Calculating...';

            // Make API call
            const response = await fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/egypt/pit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Parse response
            const result = await response.json();
            
            // Handle success
            showSuccess('Tax calculation completed successfully!');
            
            // You can handle the response data here
            console.log('Calculation Result:', result);
            
            // Optional: Display the results on the page
            // displayResults(result);

        } catch (error) {
            console.error('Error:', error);
            showError(error.message || 'An error occurred while calculating tax');
        } finally {
            // Reset button state
            calculateButton.disabled = false;
            calculateButton.innerHTML = 'Calculate Tax';
        }
    };

    // Function to handle form reset
    const handleReset = () => {
        form.reset();
        // Optional: Clear any displayed results
        // clearResults();
    };

    // Event Listeners
    form.addEventListener('submit', handleSubmit);
    resetButton.addEventListener('click', handleReset);

    // Optional: Add input validation on change
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', (e) => {
            if (e.target.value < 0) {
                e.target.value = 0;
                showError('Negative values are not allowed');
            }
        });
    });
});
</script>