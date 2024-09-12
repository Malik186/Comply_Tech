<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.getElementById('submit-excise-tax').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    // Gather CIF data
    var cif = {
        cost: parseFloat(document.getElementById('cost').value),
        insurance: parseFloat(document.getElementById('insurance').value),
        freight: parseFloat(document.getElementById('freight').value)
    };

    // Gather basic data
    var data = {
        importerManufacturer: document.getElementById('importerManufacturer').value,
        contactInfo: document.getElementById('contactInfo').value,
        typeOfGoods: document.getElementById('goodsType').value,
        goodsDescription: document.getElementById('goodsDescription').value,
        cif: cif,
        goodsOrigin: document.querySelector('input[name="goodsOrigin"]:checked').value
    };

    // Add additional fields based on goods type
    var goodsType = data.typeOfGoods;
    if (goodsType === 'Alcoholic Beverages') {
        data.additional = {
            alcoholType: document.getElementById('alcoholType').value,
            alcoholQuantity: parseFloat(document.getElementById('alcoholQuantity').value)
        };
    } else if (goodsType === 'Tobacco Products') {
        data.additional = {
            tobaccoType: document.getElementById('tobaccoType').value,
            tobaccoQuantity: parseFloat(document.getElementById('tobaccoQuantity').value)
        };
    } else if (goodsType === 'Petroleum Products') {
        data.additional = {
            petroleumType: document.getElementById('petroleumType').value,
            petroleumQuantity: parseFloat(document.getElementById('petroleumQuantity').value)
        };
    } else if (goodsType === 'Motor Vehicles') {
        data.additional = {
            vehicleType: document.getElementById('vehicleType').value,
            vehicleQuantity: parseFloat(document.getElementById('vehicleQuantity').value)
        };
    }

    // Log the data to the console for debugging
    console.log('Data being sent:', data);

    // Send the data via AJAX
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/excise.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (result) {
            console.log('Excise Calculation Result:', result);
            // Display success message
            alert('Excise tax calculated successfully');
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while calculating excise tax. Please try again.');
        }
    });
});
</script>