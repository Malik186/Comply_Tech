<script>
    document.getElementById('toggleLink').addEventListener('click', function() {

    var headerform = document.getElementById('header-form');
  var nameField = document.getElementById('nameField');
  var phoneField = document.getElementById('phoneField');
  var submitButton = document.getElementById('submitButton');
  var authToggleLabel = document.getElementById('authToggleLabel');
  var termsGroup = document.getElementById('termsGroup');
  var toggleText = document.getElementById('toggleText');

  // Toggle form elements visibility
  if (nameField.style.display === 'none') {
    nameField.style.display = '';
    phoneField.style.display = '';
    submitButton.innerText = 'Sign Up with email';
    authToggleLabel.innerText = 'Or sign up with';
    termsGroup.style.display = '';
    headerform.innerText = 'Create your account';
    toggleText.innerText = 'Already have an account ?';
    this.innerText = 'Sign in';
  } else {
    nameField.style.display = 'none';
    phoneField.style.display = 'none';
    submitButton.innerText = 'Sign In with email';
    authToggleLabel.innerText = 'Or sign in with';
    termsGroup.style.display = 'none';
    headerform.innerText = 'Sign In';
    toggleText.innerText = 'Don\'t have an account ?';
    this.innerText = 'Sign up';
  }
});
</script>