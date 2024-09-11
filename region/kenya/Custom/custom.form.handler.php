<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            console.log('Custom Calculation Result:', result);
            // Display the result to the user
            alert('Custom Calculated Successfully');
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while calculating Custom. Please try again.');
        }
    });
});
</script>
