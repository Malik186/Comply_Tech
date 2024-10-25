<div class="box" id="southafrica-pit-form" style="display: none;">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">South Africa PIT Form</h4>
            </div>
            <div class="card-body">
                <form id="PIT-CALC">
                    <!-- Annual Income Field -->
                    <div class="mb-4">
                        <h5>Annual Income</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="annualIncome" class="form-label">Enter Annual Income: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="annualIncome" name="annualIncome" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation -->
                    <div class="mb-4">
                        <h5>Confirmation</h5>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
                            <label class="form-check-label" for="confirmAccuracy">
                                I confirm that the information provided is accurate and complete.
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" id="calculate-pit" class="btn btn-primary">Calculate PIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the handler -->
<?php
    include_once site . "/region/south_africa/pit/pit.form.handler.php";
?>
