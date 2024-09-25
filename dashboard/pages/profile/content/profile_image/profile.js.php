<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // AJAX call to fetch the avatar
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/uploads/avatar.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data && response.data.avatar) {
                    // Get the base64 image data (no need to split as the data is not prefixed with `data:image/...`)
                    var base64Image = response.data.avatar;

                    // Assume the image is PNG by default, but you can add logic to detect other formats if needed.
                    var avatarImage = 'data:image/png;base64,' + base64Image;

                    // Set the avatar image source to the fetched avatar
                    $('#profile-avatar').attr('src', avatarImage);
                } else {
                    // If there's no data or error, show the default avatar
                    $('#profile-avatar').attr('src', '/dashboard/img/avatar/avatar-1.png');
                }
            },
            error: function() {
                // On error, show the default avatar
                $('#profile-avatar').attr('src', '/dashboard/img/avatar/avatar-1.png');
            }
        });
    });
</script>