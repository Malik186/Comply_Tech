<head>
    <style>
        .centered-box {
            display: flex;
            justify-content: center;
            margin-top: 50px; /* Adjust this value to control how far down the box is positioned */
        }
    </style>
</head>
<div class="container">
    <div class="row centered-box">
        <div class="col-12 col-lg-6">
            <div class="box">
                <div class="box-body text-center">
                    <h4 class="box-title d-block">Power On</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectRegionModal">
                        Select Region
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectRegionModal" tabindex="-1" aria-labelledby="selectRegionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selectRegionLabel">Select Your Region</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="regionForm">
          <div class="form-group">
            <label for="countrySelect">Country</label>
            <select class="form-control" id="countrySelect">
              <option value="Kenya" selected>Kenya</option>
              <option value="Uganda">Uganda</option>
              <option value="Tanzania">Tanzania</option>
              <option value="Rwanda">Rwanda</option>
              <option value="Burundi">Burundi</option>
              <!-- Add more countries as needed -->
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitRegion">Submit</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#submitRegion').click(function(){
            var selectedCountry = $('#countrySelect').val();

            $.ajax({
                url: 'https://complytech.mdskenya.co.ke/endpoint/country/country.php',
                type: 'POST',
                data: JSON.stringify({ country: selectedCountry }),
                contentType: 'application/json',
                success: function(response) {
                    // Assuming the response contains HTML for the new modal
                    $('body').append(response);
                    $('#newModal').modal('show');
                },
                error: function(error) {
                    alert('An error occurred: ' + error.responseText);
                }
            });

            $('#selectRegionModal').modal('hide');
        });
    });
</script>