<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/uploads/avatar.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data && response.data.avatar) {
                    // The avatar data should already include the data URI scheme
                    var avatarImage = response.data.avatar;
                    
                    // Set the avatar image source to the fetched avatar
                    $('#header-avatar').attr('src', avatarImage);
                } else {
                    // If there's no data or error, show the default avatar
                    $('#header-avatar').attr('src', '/dashboard/img/avatar/avatar-1.png');
                }
            },
            error: function() {
                // On error, show the default avatar
                $('#header-avatar').attr('src', '/dashboard/img/avatar/avatar-1.png');
            }
        });
    });
</script>