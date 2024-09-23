<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('submit-custom-tax').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent any default action

    // Gather form data
    var data = {
        nameOfGoods: document.getElementById('goodsName').value,
        typeOfGoods: document.getElementById('goodsType').value,
        cif: {
            cost: parseFloat(document.getElementById('cost').value),
            insurance: parseFloat(document.getElementById('insurance').value),
            freight: parseFloat(document.getElementById('freight').value)
        }
    };

    
    // Log the data to the console
    console.log('Data being sent:', data);

    // Send data via AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/custom.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (result) {
                // SweetAlert2 success message with redirect
                Swal.fire({
                    title: "Good job!",
                    text: "Now let's go and see the analysis.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the analytics page
                        window.location.href = 'custom.php';
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                // SweetAlert2 error message
                Swal.fire({
                    title: "Oops",
                    text: "Failed to submit data. Try again later.",
                    icon: "error",
                    confirmButtonText: "Close"
                });
            }
    });
});
</script>
