<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Fetch data from the API using AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                var data = response.data;

                // Empty the table body before populating
                var tableBody = $('.table tbody');
                tableBody.empty();

                // Loop through the data to create table rows dynamically
                data.forEach(function(item) {
                    var taxType = item.Tax_Type;  // e.g., "Kenya Custom", "Kenya VAT"
                    var timestamp = item.timestamp;  // e.g., "2024-09-16 14:30:00"
                    var status = item.Status;  // 1 or 0

                    // Extract just the type (e.g., "Custom", "VAT")
                    var taxTypeWithoutCountry = taxType.split(' ')[1];

                    // Check for country in the Tax_Type to display the flag
                    var flagImg = '';
                    if (taxType.includes('Kenya')) {
                        flagImg = '/dashboard/img/flag/kenya.png';
                    } else {
                        flagImg = '/dashboard/img/gallery/default-flag.png';  // Default image if no match
                    }

                    // Format the timestamp to show only the date
                    var formattedDate = timestamp.split(' ')[0];

                    // Set badge for status
                    var statusBadge = '';
                    if (status === 1) {
                        statusBadge = '<span class="badge badge-success">Success</span>';
                    } else if (status === 0) {
                        statusBadge = '<span class="badge badge-danger">Cancelled</span>';
                    }

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
                console.log("Error fetching data from the API");
            }
        },
        error: function(error) {
            console.log("Error:", error);
        }
    });
});
</script>