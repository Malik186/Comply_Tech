<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function formatCurrency(amount) {
                return 'Ksh ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
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
                    url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/custom.recent.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#timestamp').text(formatDate(data.timestamp));
                            $('#nameOfGoods').text(data.nameOfGoods);
                            $('#typeOfGoods').text(data.typeOfGoods);
                            $('#cost').text(formatCurrency(data.cost));
                            $('#insurance').text(formatCurrency(data.insurance));
                            $('#freight').text(formatCurrency(data.freight));
                            $('#cif').text(formatCurrency(data.cif));
                            $('#customDuty').text(formatCurrency(data.Custom_Duty));
                        } else {
                            alert('Failed to fetch customs data. Please try again.');
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