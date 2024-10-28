<div class="container-full">
  <section class="content">
    <div class="row">
    <?php
    // TAX Input Forms

    // Kenya
    include_once site . "/region/south_africa/CGT/cgt.php";
    ?>

<script>
    // Function to show the appropriate form based on the selected country and tax type
    function showTaxForm(country, taxType) {
        console.log("Showing form for country:", country, "and tax type:", taxType);

        // Hide all forms first
        document.querySelectorAll('.box').forEach(form => {
            form.style.display = 'none';
        });

        // Construct the form ID based on country and tax type
        const formId = country.toLowerCase() + '-' + taxType.toLowerCase().replace(/\s+/g, '-') + '-form';
        const selectedForm = document.getElementById(formId);

        if (selectedForm) {
            selectedForm.style.display = 'block';
        } else {
            console.error('Form not found for country:', country, 'and tax type:', taxType);
            alert('Form for the selected country and tax type is not available.');
        }
    }

    // Call the function with the selected country and tax type
    showTaxForm('<?php echo addslashes($country); ?>', '<?php echo addslashes($taxType); ?>');
</script>





  </section>
</div>