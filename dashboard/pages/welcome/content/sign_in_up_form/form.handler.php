<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission for both Sign In and Sign Up
    $('#submit-sign-in, #submit-sign-up').on('click', function(event) {
        event.preventDefault();

        var isSignUp = $(this).attr('id') === 'submit-sign-up';

        var data = {};
        if (isSignUp) {
            // Capture data for Sign Up
            var username = $('#name-signup').val();
            var email = $('#email-signup').val();
            var phone = $('#number-signup').val();
            var password = $('#password-signup').val();

            if (username && email && phone && password) {
                data = {
                    "username": username,
                    "email": email,
                    "phone": phone,
                    "password": password
                };
            } else {
                showPopup('Error', 'Please fill all required fields for sign-up.');
                return;
            }
        } else {
            // Capture data for Sign In
            var identifier = $('#email-number').val();  // This field accepts either email or phone
            var password = $('#password-signin').val();

            if (identifier && password) {
                if (validateEmail(identifier)) {
                    data = {
                        "email": identifier,
                        "password": password
                    };
                } else {
                    data = {
                        "phone": identifier,
                        "password": password
                    };
                }
            } else {
                showPopup('Error', 'Please fill both the email/phone and password fields for sign-in.');
                return;
            }
        }

        // Send data via AJAX
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/auth/sign.in.up.php',
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: JSON.stringify(data),
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    if (isSignUp) {
                        showPopup('Success', 'User registered successfully. Please sign in.');
                        $('#sign-in').show();
                        $('#sign-up').hide();
                        $('#name-signup, #email-signup, #number-signup, #password-signup').val('');  // Clear sign-up form fields
                    } else {
                        showPopup('Success', 'Sign-in successful. Redirecting to dashboard...');
                        setTimeout(function() {
                            window.location.href = '/dashboard.php';
                        }, 2000);  // Redirect to dashboard.php
                    }
                } else {
                    // Show error message
                    showPopup('Error', result.message || 'An error occurred. Please try again.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus + ' : ' + errorThrown);
                console.log("Response Text: " + jqXHR.responseText);
                showPopup('Error', 'An error occurred. Please try again later.');
            }
        });
    });

    // Function to validate if the input is an email
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Function to show popup
    function showPopup(title, message) {
        alert(title + ': ' + message);
    }
});
</script>
