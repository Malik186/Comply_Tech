<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    // AJAX request to fetch the data
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/activity.overview.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let activityTotal = 0;
                let reportTotal = 0;
                let payrollTotal = 0;
                let invoiceTotal = 0;

                // Loop through the data to sum the values
                response.data.forEach(function (item) {
                    activityTotal += parseInt(item.Activity);
                    reportTotal += parseInt(item.Report);
                    payrollTotal += parseInt(item.Payroll);
                    invoiceTotal += parseInt(item.Invoice);
                });

                // Update the values in the UI
                $('#requests-made').text(activityTotal);
                $('#reports-generated').text(reportTotal);
                $('#payrolls').text(payrollTotal);
                $('#invoices').text(invoiceTotal);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });

    // Greeting based on the time of the day
    function updateGreeting() {
        let today = new Date();
        let currentHour = today.getHours();
        let greetingText = "Good Morning";

        if (currentHour >= 12 && currentHour < 18) {
            greetingText = "Good Afternoon";
        } else if (currentHour >= 18) {
            greetingText = "Good Evening";
        }

        // Update greeting text
        let username = "<?php echo isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') : 'Guest'; ?>";
        $('#greeting').text(greetingText + " " + username);
    }

    // Call the function to update the greeting
    updateGreeting();
});

</script>