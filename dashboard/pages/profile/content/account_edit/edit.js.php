<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

// Function to handle form submission
async function handleSubmit(formId) {
  const form = document.getElementById(formId);
  const formData = new FormData(form);
  const jsonData = {};

  for (let [key, value] of formData.entries()) {
    if (key === 'avatar' && value instanceof File) {
      try {
        jsonData[key] = await fileToBase64(value);
      } catch (error) {
        console.error('Error converting file to base64:', error);
        return;
      }
    } else {
      jsonData[key] = value;
    }
  }

  // AJAX submission
  $.ajax({
    url: 'https://complytech.mdskenya.co.ke/endpoint/update/update.user.php',
    type: 'POST',
    data: JSON.stringify(jsonData),
    contentType: 'application/json',
    success: function(response) {
      console.log('Success:', response);
      alert('Data updated successfully!');
    },
    error: function(xhr, status, error) {
      console.error('Error:', error);
      alert('An error occurred while updating the data.');
    }
  });
}

// Event listeners for form submissions
document.getElementById('account-details').addEventListener('click', function() {
  handleSubmit('account-form');
});

document.getElementById('user-address').addEventListener('click', function() {
  handleSubmit('address-form');
});

// Initialize the forms
document.addEventListener('DOMContentLoaded', function() {
  const accountForm = document.createElement('form');
  accountForm.id = 'account-form';
  accountForm.appendChild(document.getElementById('username').parentNode.parentNode);
  accountForm.appendChild(document.getElementById('email').parentNode.parentNode);
  accountForm.appendChild(document.getElementById('phone').parentNode.parentNode);
  accountForm.appendChild(document.getElementById('avatar').parentNode.parentNode);
  document.querySelector('.box-body').appendChild(accountForm);

  const addressForm = document.createElement('form');
  addressForm.id = 'address-form';
  addressForm.appendChild(document.getElementById('street').parentNode.parentNode);
  addressForm.appendChild(document.getElementById('city').parentNode.parentNode);
  addressForm.appendChild(document.getElementById('state').parentNode.parentNode);
  addressForm.appendChild(document.getElementById('post_code').parentNode.parentNode);
  document.querySelectorAll('.box-body')[1].appendChild(addressForm);
});
</script>