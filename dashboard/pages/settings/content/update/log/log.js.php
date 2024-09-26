<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to fetch activity logs using AJAX
    $(document).ready(function() {
        fetchLogs();
    });

    function fetchLogs() {
        $.ajax({
            url: 'https://complytech.mdskenya.co.ke/endpoint/logs/fetch.activity.logs.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    populateActivityLog(data.logs);
                } else {
                    alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching activity logs:', textStatus, errorThrown);
                alert('Failed to fetch activity logs. Please try again.');
            }
        });
    }

    function populateActivityLog(logs) {
        const tbody = $('tbody');
        tbody.empty(); // Clear existing logs

        logs.forEach(log => {
            const tr = `
                <tr>
                    <th scope="row">${log.browser_info}</th>
                    <td>${log.ip_address}</td>
                    <td>${new Date(log.login_time).toLocaleString()}</td>
                    <td><a href="#" class="text-danger" onclick="deleteLog(${log.id}, '${log.session_id}')"><i class="fa fa-trash"></i></a></td>
                </tr>
            `;
            tbody.append(tr);
        });
    }

    // Function to delete a specific log using AJAX
    function deleteLog(logId, sessionId) {
        if (confirm('Are you sure you want to delete this log?')) {
            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/logs/delete.activity.log.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ log_id: logId, session_id: sessionId }),
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        alert('Log deleted successfully.');
                        fetchLogs(); // Refresh the logs after deletion
                    } else {
                        alert(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error deleting log:', textStatus, errorThrown);
                    alert('Failed to delete the log. Please try again.');
                }
            });
        }
    }
</script>
