<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch data from the API using AJAX
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var tableBody = $('.table tbody');
                tableBody.empty();

                if (response.status === "success" && response.data && response.data.length > 0) {
                    var data = response.data;
                    // Sort the data by timestamp in descending order
                    data.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
                    // Get only the first 4 items
                    var recentData = data.slice(0, 4);
                    
                    // Define the country flags
                    const countryFlags = {
                        'Kenya': '/dashboard/img/flag/kenya.png',
                        'South_Africa': '/dashboard/img/flag/south-africa.png',
                        // Add more countries here as needed
                    };

                    // Helper function to get the flag based on the country name in taxType
                    function getFlagImage(taxType) {
                        for (let country in countryFlags) {
                            if (taxType.includes(country)) {
                                return countryFlags[country];
                            }
                        }
                        return '/dashboard/img/gallery/default-flag.png'; // Default flag if no match
                    }

                    // Loop through the recent data to create table rows dynamically
                    recentData.forEach(function(item) {
                        var taxType = item.Tax_Type;  // e.g., "Kenya Custom", "South Africa VAT"
                        var timestamp = item.timestamp;  // e.g., "2024-09-16 14:30:00"
                        var status = item.Status;  // 1 or 0
                        // Extract just the type (e.g., "Custom", "VAT")
                        var taxTypeWithoutCountry = taxType.split(' ')[1];
                        // Get the flag image based on the country in taxType
                        var flagImg = getFlagImage(taxType);
                        // Format the timestamp to show only the date
                        var formattedDate = timestamp.split(' ')[0];
                        // Set badge for status
                        var statusBadge = status === "1" ? '<span class="badge bg-success">Success</span>' : '<span class="badge bg-danger">Cancelled</span>';
                        // Create the row with the formatted data
                        var row = `
                            <tr>
                                <td class="w-50">
                                    <div class="bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
                                        <img src="${flagImg}" class="h-50 align-self-end" alt="">
                                    </div>
                                </td>
                                <td>
                                    <span class="text-fade d-block">${taxTypeWithoutCountry}</span>
                                </td>
                                <td>
                                    ${formattedDate}
                                </td>
                                <td>
                                    <div class="px-25 py-10 w-100">${statusBadge}</div>
                                </td>
                            </tr>
                        `;
                        // Append the row to the table body
                        tableBody.append(row);
                    });
                } else {
                    // Display "No Recent Records Found" message
                    var noDataRow = `
                        <tr>
                            <td colspan="4" class="text-center">
                                <span class="text-fade">No Recent Records Found</span>
                            </td>
                        </tr>
                    `;
                    tableBody.append(noDataRow);
                }
            },
            error: function(error) {
                console.log("Error:", error);
                // Display "No Recent Records Found" message in case of error
                var tableBody = $('.table tbody');
                tableBody.empty();
                var errorRow = `
                    <tr>
                        <td colspan="4" class="text-center">
                            <span class="text-fade">No Recent Records Found</span>
                        </td>
                    </tr>
                `;
                tableBody.append(errorRow);
            }
        });
    });
</script>
