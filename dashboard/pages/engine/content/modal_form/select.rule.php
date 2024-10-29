<div class="col-xl-6"> 
    <div class="box">
        <div class="box-body d-flex p-0">
            <div class="flex-grow-1 p-30 flex-grow-1 bg-img" style="background-color: #211f33; background-position: left bottom; background-size: auto 80%;">
                <div class="row">
                    <div class="col-12 col-xl-7"></div>
                    <div class="col-12 col-xl-5">
                        <h4 class="text-warning fw-500">Get Instant Tax Insights</h4>
                        <p class="text-white my-10 fs-16">
                        Receive accurate estimations and comprehensive summaries tailored to your region.
                        </p>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#selectRegionModal">
                        Choose Your Region
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Country Selection Modal -->
<div class="modal fade modal-fill" id="selectRegionModal" tabindex="-1" aria-labelledby="selectRegionLabel" aria-hidden="true">
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
                            <option value="Kenya">Kenya</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="SouthAfrica">South Africa</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Egypt">Egypt</option>
                            <option value="Morocco">Morocco</option>
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
    $(document).ready(function() {
        const taxTypes = {
            Kenya: ["PAYE", "VAT", "Payroll", "Custom", "Excise", "Corporate"],
            Uganda: ["Income Tax", "VAT", "Excise", "Custom", "Property"],
            Tanzania: ["Income", "VAT", "Custom", "Excise"],
            SouthAfrica: ["PIT", "VAT", "CGT", "CIT", "PAYE"],
            Nigeria: ["PIT", "VAT", "CIT"]
        };

        function resetModal(modalId) {
            $(modalId).modal('hide');
            $(modalId + ' form')[0].reset();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        function createTaxTypeModal(country) {
            // Remove any existing modal to ensure a fresh one is created
            $('#selectTaxTypeModal').remove();

            const modalHtml = `
                <div class="modal fade modal-fill" id="selectTaxTypeModal" tabindex="-1" aria-labelledby="selectTaxTypeLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="selectTaxTypeLabel">Select Tax Type for ${country}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="taxTypeForm" method="POST">
                                    <input type="hidden" name="country" value="${country}">
                                    <div class="form-group">
                                        <label for="taxTypeSelect">Tax Type</label>
                                        <select class="form-control" id="taxTypeSelect" name="taxType">
                                            ${taxTypes[country].map(type => `<option value="${type.toLowerCase()}">${type}</option>`).join('')}
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" form="taxTypeForm" class="btn btn-primary" id="submitTaxType">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalHtml);

            // Event handler for form submission to prevent redirect issues
            $('#taxTypeForm').on('submit', function(event) {
                event.preventDefault();
                const selectedCountry = country.toLowerCase(); // Use lowercase for URL consistency
                const selectedTaxType = $('#taxTypeSelect').val();
                const actionUrl = `${selectedCountry}.${selectedTaxType}.php`;

                // Update action attribute and submit form
                $('#taxTypeForm').attr('action', actionUrl);
                this.submit();
            });

            // Reset and remove modal on close
            $('.modal .btn-secondary, .modal .close').click(function() {
                resetModal('#selectTaxTypeModal');
                $('#selectTaxTypeModal').remove();
            });
        }

        $('#submitRegion').click(function() {
            var selectedCountry = $('#countrySelect').val();
            resetModal('#selectRegionModal');
            
            if (taxTypes.hasOwnProperty(selectedCountry)) {
                setTimeout(function() {
                    createTaxTypeModal(selectedCountry);
                    $('#selectTaxTypeModal').modal('show');
                }, 500);
            }
        });

        // Ensure the select region button can always open the modal
        $('[data-toggle="modal"]').click(function() {
            var targetModal = $(this).data('target');
            $(targetModal).modal('show');
        });
    });
</script>
