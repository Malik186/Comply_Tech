<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        fetchLogs();
    });

    // Fetch activity logs using AJAX
    function fetchLogs() {
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/logs/fetch.activity.logs.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    populateActivityLog(data.logs);
                } else {
                    alert(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching activity logs:', textStatus, errorThrown);
                alert('Failed to fetch activity logs. Please try again.');
            }
        });
    }

    // Populate activity logs into the table
    function populateActivityLog(logs) {
        const tbody = $('tbody');
        tbody.empty(); // Clear existing logs

        logs.forEach(log => {
            const simplifiedBrowserInfo = simplifyBrowserInfo(log.browser_info);
            const tr = `
                <tr>
                    <th scope="row">${simplifiedBrowserInfo}</th>
                    <td>${log.ip_address}</td>
                    <td>${new Date(log.login_time).toLocaleString()}</td>
                    <td><a href="#" class="text-danger" onclick="deleteLog(${log.id}, '${log.session_id}')"><i class="fa fa-trash"></i></a></td>
                </tr>
            `;
            tbody.append(tr);
        });
    }

    // Function to simplify the browser information
    function simplifyBrowserInfo(userAgent) {
        let browser = 'Unknown Browser';
        let os = 'Unknown OS';

        // Detect the browser
        if (userAgent.includes('Chrome') && !userAgent.includes('Edg')) {
            browser = 'Chrome';
        } else if (userAgent.includes('Firefox')) {
            browser = 'Firefox';
        } else if (userAgent.includes('Safari') && !userAgent.includes('Chrome')) {
            browser = 'Safari';
        } else if (userAgent.includes('Edg')) {
            browser = 'Edge';
        } else if (userAgent.includes('OPR') || userAgent.includes('Opera')) {
            browser = 'Opera';
        } else if (userAgent.includes('MSIE') || userAgent.includes('Trident')) {
            browser = 'Internet Explorer';
        }

        // Detect the OS
        if (userAgent.includes('Windows NT')) {
            os = 'Windows';
        } else if (userAgent.includes('Mac OS X')) {
            os = 'MacOS';
        } else if (userAgent.includes('Linux')) {
            os = 'Linux';
        } else if (userAgent.includes('Android')) {
            os = 'Android';
        } else if (userAgent.includes('iPhone') || userAgent.includes('iPad')) {
            os = 'iOS';
        }

        return `${browser} on ${os}`;
    }

    
    // Delete a specific log using AJAX
    function deleteLog(logId, sessionId) {
    // SweetAlert2 confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this log!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
        // If confirmed, proceed with the deletion via AJAX
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/logs/delete.activity.log.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ log_id: logId, session_id: sessionId }),
            dataType: 'json',
            success: function (data) {
            if (data.status === 'success') {
                Swal.fire({
                title: "Deleted!",
                text: "The log has been deleted successfully.",
                icon: "success",
                }).then(() => {
                fetchLogs(); // Refresh the logs after deletion
                });
            } else {
                Swal.fire({
                title: "Error!",
                text: data.message,
                icon: "error",
                });
            }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error deleting log:', textStatus, errorThrown);
            Swal.fire({
                title: "Failed!",
                text: "Failed to delete the log. Please try again.",
                icon: "error",
            });
            },
        });
        } else {
        // If cancelled, show the cancellation message
        Swal.fire({
            title: "Cancelled",
            text: "Your log is safe :)",
            icon: "error",
        });
        }
    });
    }

</script>