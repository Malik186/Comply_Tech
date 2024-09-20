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

            function displayProductDetails(data) {
                let detailsHTML = '<strong>Product Details</strong><br>';
                if (data.alcoholType && data.alcoholQuantity) {
                    detailsHTML += `Alcohol Type: ${data.alcoholType}<br>`;
                    detailsHTML += `Quantity: ${data.alcoholQuantity} units<br>`;
                }
                if (data.tobaccoType && data.tobaccoQuantity) {
                    detailsHTML += `Tobacco Type: ${data.tobaccoType}<br>`;
                    detailsHTML += `Quantity: ${data.tobaccoQuantity} units<br>`;
                }
                if (data.petroleumType && data.petroleumQuantity) {
                    detailsHTML += `Petroleum Type: ${data.petroleumType}<br>`;
                    detailsHTML += `Quantity: ${data.petroleumQuantity} units<br>`;
                }
                if (data.vehicleType && data.vehicleEngine) {
                    detailsHTML += `Vehicle Type: ${data.vehicleType}<br>`;
                    detailsHTML += `Engine Capacity: ${data.vehicleEngine} cc<br>`;
                }
                $('#productDetails').html(detailsHTML);
            }

                $.ajax({
                    url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/excise.recent.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#timestamp').text(formatDate(data.timestamp));
                            $('#importerManufacturer').text(data.importerManufacturer);
                            $('#contactInfo').text(data.contactInfo);
                            $('#typeOfGoods').text(data.typeOfGoods);
                            $('#goodsDescription').text(data.goodsDescription);
                            $('#goodsOrigin').text(data.goodsOrigin);
                            $('#cif_cost').text(formatCurrency(data.cif_cost));
                            $('#cif_insurance').text(formatCurrency(data.cif_insurance));
                            $('#cif_freight').text(formatCurrency(data.cif_freight));
                            $('#Custom_Duty').text(formatCurrency(data.Custom_Duty));
                            $('#Excise_Duty').text(formatCurrency(data.Excise_Duty));
                            $('#VAT').text(formatCurrency(data.VAT));
                            $('#IDF').text(formatCurrency(data.IDF));
                            $('#RDL').text(formatCurrency(data.RDL));
                            displayProductDetails(data);
                        } else {
                            alert('Failed to fetch excise data. Please try again.');
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