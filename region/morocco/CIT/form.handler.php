<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get form and button elements
        const form = document.getElementById('MA-HIGH-LEVEL-CIT-CALC');
        const calculateButton = document.getElementById('calculate-cit');

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
                companyInfo: {
                    companyName: document.getElementById('companyName').value,
                    corporateID: document.getElementById('corporateID').value,
                    industry: document.getElementById('industry').value,
                    taxYear: document.getElementById('taxYear').value,
                    residencyStatus: document.getElementById('residencyStatus').value,
                    employees: parseInt(document.getElementById('employees').value) || 0
                },
                revenueSources: {
                    domesticRevenue: parseFloat(document.getElementById('domesticRevenue').value) || 0,
                    foreignRevenue: parseFloat(document.getElementById('foreignRevenue').value) || 0,
                    interestIncome: parseFloat(document.getElementById('interestIncome').value) || 0,
                    dividendsReceived: parseFloat(document.getElementById('dividendsReceived').value) || 0,
                    capitalGains: parseFloat(document.getElementById('capitalGains').value) || 0,
                    otherIncome: parseFloat(document.getElementById('otherIncome').value) || 0
                },
                operationalExpenses: {
                    salaries: parseFloat(document.getElementById('salaries').value) || 0,
                    rentalExpenses: parseFloat(document.getElementById('rentalExpenses').value) || 0,
                    marketingExpenses: parseFloat(document.getElementById('marketingExpenses').value) || 0,
                    interestOnLoans: parseFloat(document.getElementById('interestOnLoans').value) || 0,
                    depreciation: parseFloat(document.getElementById('depreciation').value) || 0,
                    otherExpenses: parseFloat(document.getElementById('otherExpenses').value) || 0
                },
                taxDeductionsAndCredits: {
                    investmentDeductions: parseFloat(document.getElementById('investmentDeductions').value) || 0,
                    employmentCredits: parseFloat(document.getElementById('employmentCredits').value) || 0,
                    energyEfficiencyCredits: parseFloat(document.getElementById('energyEfficiencyCredits').value) || 0,
                    otherTaxCredits: parseFloat(document.getElementById('otherTaxCredits').value) || 0
                }
            };

            // Disable button and show loading spinner
            calculateButton.disabled = true;
            calculateButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';

            // Make AJAX POST request
            fetch('https://complytech.mdskenya.co.ke/endpoint/engine/region/morocco/cit.php', {
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
                console.log('CIT calculation successful:', data);
                alert('CIT calculation completed successfully!');
                // You could display data dynamically on the page here if needed
            })
            .catch(error => {
                // Error: log and notify user
                console.error('Error calculating CIT:', error);
                alert('Error calculating CIT. Please try again.');
            })
            .finally(() => {
                // Re-enable button and restore original text
                calculateButton.disabled = false;
                calculateButton.innerHTML = 'Calculate CIT';
            });
        });
    });
</script>