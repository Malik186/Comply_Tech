<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Capture form submission for PIT calculation
        $('#calculate-pit').on('click', function (event) {
            event.preventDefault();  // Prevent default form submission

            // Gather form data (only Annual Income for PIT)
            const data = {
                annual_income: $('#annualIncome').val()
            };

            // Log the data for debugging
            console.log('Data sent to the endpoint:', data);

            // Send data to the South Africa PIT endpoint using AJAX
            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/southafrica/pit.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (result) {
                    // SweetAlert2 success message with redirect
                    Swal.fire({
                        title: "Submission Successful!",
                        text: "Your PIT calculation is complete!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the recent PIT report or results page
                            window.location.href = 'pit.recent.php';
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    // SweetAlert2 error message
                    Swal.fire({
                        title: "Oops!",
                        text: "Failed to submit data. Please try again.",
                        icon: "error",
                        confirmButtonText: "Close"
                    });
                }
            });
        });
    });
</script>
