<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Function to convert file to base64
function fileToBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

// Function to collect data from input fields
async function collectData(inputIds) {
  const data = {};
  for (let id of inputIds) {
    const element = document.getElementById(id);
    if (id === 'avatar' && element.files.length > 0) {
      try {
        data[id] = await fileToBase64(element.files[0]);
      } catch (error) {
        console.error('Error converting file to base64:', error);
        return null;
      }
    } else {
      data[id] = element.value;
    }
  }
  return data;
}

// Function to handle data submission
function submitData(data) {
  $.ajax({
    url: 'https://complytech.mdskenya.co.ke/endpoint/update/update.user.php',
    type: 'POST',
    data: JSON.stringify(data),
    contentType: 'application/json',
    success: function (result) {
      // SweetAlert2 success message with redirect
      Swal.fire({
        title: "Success!",
        text: "Your Details Were Successfully Edited",
        icon: "success",
        confirmButtonText: "OK",
      });
    },
    error: function (xhr, status, error) {
      console.error('Error:', error);

      // Check for specific database error message
      if (
        xhr.responseText.includes(
          "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry"
        )
      ) {
        // SweetAlert2 specific error message
        Swal.fire({
          title: "Oops",
          text: "The Email or Phone number already exists!",
          icon: "error",
          confirmButtonText: "Close",
        });
      } else {
        // SweetAlert2 generic error message
        Swal.fire({
          title: "Oops",
          text: "Failed to Edit your details, please try again!",
          icon: "error",
          confirmButtonText: "Close",
        });
      }
    },
  });
}

// Event listener for account details submission
document.getElementById('account-details').addEventListener('click', async function() {
  const accountData = await collectData(['username', 'email', 'phone', 'avatar']);
  if (accountData) {
    submitData(accountData);
  }
});

// Event listener for address submission
document.getElementById('user-address').addEventListener('click', async function() {
  const addressData = await collectData(['street', 'city', 'state', 'post_code']);
  if (addressData) {
    submitData(addressData);
  }
});
</script>