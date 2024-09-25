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