<head>
<?php
    include_once site . "/dashboard/pages/admin/content/modal_form/css/select.rule.css.php";
    ?>
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
                                <option value="Rwanda">Rwanda</option>
                                <option value="Burundi">Burundi</option>
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
                Kenya: ["PAYE", "VAT", "Payroll", "Custom", "Excise"],
                Uganda: ["Income Tax", "VAT", "Excise", "Custom", "Property"],
                Tanzania: ["Income", "VAT", "Custom", "Excise"]
            };

            function resetModal(modalId) {
                $(modalId).modal('hide');
                $(modalId + ' form')[0].reset();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }

            function createTaxTypeModal(country) {
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
                                    <form id="taxTypeForm" action="update.rule.php" method="POST">
                                        <input type="hidden" name="country" value="${country}">
                                        <div class="form-group">
                                            <label for="taxTypeSelect">Tax Type</label>
                                            <select class="form-control" id="taxTypeSelect" name="taxType">
                                                ${taxTypes[country].map(type => `<option value="${type}">${type}</option>`).join('')}
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" form="taxTypeForm" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(modalHtml);

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