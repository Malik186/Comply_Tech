<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
  $('.crancy-wc__form-main').on('submit', function(event) {
    event.preventDefault();

    var email = $('#emailField').val();
    var phone = $('#phoneField').val();
    var password = $('#passwordField').val();

    var data = {};
    if (email && password && phone) {
      // Sign-up request
      data = {
        "email": email,
        "phone": phone,
        "password": password
      };
    } else if (email && password) {
      // Sign-in request with email
      data = {
        "email": email,
        "password": password
      };
    } else if (phone && password) {
      // Sign-in request with phone
      data = {
        "phone": phone,
        "password": password
      };
    }

    $.ajax({
      url: 'https://mdskenya.co.ke/endpoint/auth/sign.in.up.php',
      type: 'POST',
      contentType: 'application/json',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      data: JSON.stringify(data),
      success: function(response) {
        var result = JSON.parse(response);
        if (result.status === 'success') {
          if (email && phone) {
            // Sign-up success
            showPopup('Success', 'User registered successfully. Please sign in.');
            // Reset form or switch to sign-in view here
          } else {
            // Sign-in success
            showPopup('Success', 'Sign-in successful. Redirecting to dashboard...');
            setTimeout(function() {
              window.location.href = '/dashboard.php';
            }, 2000);
          }
        } else {
          // Error
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

  // Function to show popup
  function showPopup(title, message) {
    alert(title + ': ' + message);
  }
});
</script>