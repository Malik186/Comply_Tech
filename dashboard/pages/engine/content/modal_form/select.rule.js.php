<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        const taxTypeOptions = taxTypes[country] || [];
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
                            <form id="taxTypeForm">
                                <div class="form-group">
                                    <label for="taxTypeSelect">Tax Type</label>
                                    <select class="form-control" id="taxTypeSelect">
                                        ${taxTypeOptions.map(type => `<option value="${type}">${type}</option>`).join('')}
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="submitTaxType">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modalHtml);

        $('#submitTaxType').click(function() {
            const selectedTaxType = $('#taxTypeSelect').val();
            resetModal('#selectTaxTypeModal');
            $('#selectTaxTypeModal').remove();

            // Redirect to the appropriate PHP page with selected country and tax type as query parameters
            window.location.href = `/kenya.php?country=${country}&taxType=${selectedTaxType}`;
        });

        $('.modal .btn-secondary, .modal .close').click(function() {
            resetModal('#selectTaxTypeModal');
            $('#selectTaxTypeModal').remove();
        });
    }

    $('#submitRegion').click(function() {
        const selectedCountry = $('#countrySelect').val();
        resetModal('#selectRegionModal');
        
        if (taxTypes[selectedCountry]) {
            setTimeout(function() {
                createTaxTypeModal(selectedCountry);
                $('#selectTaxTypeModal').modal('show');
            }, 500);
        }
    });
});
</script>