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
                    // Get the base64 image data
                    var base64Image = response.data.avatar;

                    // Determine the correct image type
                    var imageType = '';
                    if (base64Image.includes('data:image/jpeg')) {
                        imageType = 'jpeg';
                    } else if (base64Image.includes('data:image/jpg')) {
                        imageType = 'jpg';
                    } else if (base64Image.includes('data:image/webp')) {
                        imageType = 'webp';
                    } else {
                        // Fallback to PNG if no type detected
                        imageType = 'png';
                    }

                    // Format the base64 image with the correct image type
                    var avatarImage = 'data:image/' + imageType + ';base64,' + base64Image.split(',')[1];

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