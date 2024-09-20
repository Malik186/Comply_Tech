<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function formatCurrency(amount) {
                return 'Ksh ' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }).replace(/\//g, '/');
            }
                $.ajax({
                    url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/corporate.recent.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#timestamp').text(formatDate(data.timestamp));
                            $('#companyName').text(data.companyName);
                            $('#yearsOfOperation').text(data.yearsOfOperation);
                            $('#typeOfCompany').text(data.typeOfCompany);
                            
                            if (data.specialRatesType && data.specialRatesType !== "null") {
                                $('#specialRatesType').text(data.specialRatesType);
                                $('#specialRatesTypeContainer').show();
                            } else {
                                $('#specialRatesTypeContainer').hide();
                            }
                            
                            $('#yearlyProfit').text(formatCurrency(data.yearlyProfit));
                            $('#corporateTax').text(formatCurrency(data.corporate_tax));
                            $('#netProfit').text(formatCurrency(data.net_profit));
                        } else {
                            alert('Failed to fetch corporate data. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the data. Please try again.');
                    }
                });

            $('#print').click(function() {
                window.print();
            });
        });
    </script>