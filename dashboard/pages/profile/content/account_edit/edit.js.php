<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
  // Handle form submission for account details
  $('#account-details').on('click', function() {
    var formData = new FormData();
    
    // Capture text inputs
    formData.append('username', $('#username').val());
    formData.append('email', $('#email').val());
    formData.append('phone', $('#phone').val());
    
    // Capture avatar image if selected
    var avatarFile = $('#avatar')[0].files[0];
    if (avatarFile) {
      formData.append('avatar', avatarFile);
    }

    // Send data via AJAX
    $.ajax({
      url: 'https://complytech.mdskenya.co.ke/endpoint/update/update.user.php',
      type: 'POST',
      data: formData,
      processData: false, // Important for handling FormData
      contentType: false, // Important for handling FormData
      success: function(response) {
        alert('Account details updated successfully!');
        console.log(response);
      },
      error: function(xhr, status, error) {
        alert('Failed to update account details!');
        console.log(xhr.responseText);
      }
    });
  });

  // Handle form submission for personal address
  $('#user-address').on('click', function() {
    var addressData = {
      street: $('#street').val(),
      city: $('#city').val(),
      state: $('#state').val(),
      post_code: $('#post_code').val()
    };

    // Send address data via AJAX
    $.ajax({
      url: 'https://complytech.mdskenya.co.ke/endpoint/update/update.user.php',
      type: 'POST',
      data: JSON.stringify(addressData),
      contentType: 'application/json',
      success: function(response) {
        alert('Address updated successfully!');
        console.log(response);
      },
      error: function(xhr, status, error) {
        alert('Failed to update address!');
        console.log(xhr.responseText);
      }
    });
  });
});

</script>