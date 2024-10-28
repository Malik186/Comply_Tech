<div class="box" id="southafrica-cgt-form">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-danger">
                <h4 class="card-title">South Africa Capital Gains</h4>
            </div>
            <div class="card-body">
                <form id="SA-CGT-CALC">
                    <!-- Taxpayer Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Taxpayer Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxpayerName" class="form-label">Taxpayer Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="taxpayerName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="taxNumber" class="form-label">Tax Reference Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="taxNumber" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taxYear" class="form-label">Tax Year: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxYear" required>
                                        <option value="" disabled selected>Select Tax Year</option>
                                        <option value="2024">2024/2025</option>
                                        <option value="2023">2023/2024</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="taxpayerType" class="form-label">Taxpayer Type: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="taxpayerType" required>
                                        <option value="" disabled selected>Select Taxpayer Type</option>
                                        <option value="individual">Individual (40% inclusion rate)</option>
                                        <option value="company">Company (80% inclusion rate)</option>
                                        <option value="trust">Trust (80% inclusion rate)</option>
                                        <option value="specialTrust">Special Trust (40% inclusion rate)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Asset Details -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Asset Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assetType" class="form-label">Type of Asset: <span class="text-danger">*</span></label>
                                    <select class="form-select" id="assetType" required>
                                        <option value="" disabled selected>Select Asset Type</option>
                                        <option value="property">Property</option>
                                        <option value="shares">Shares</option>
                                        <option value="business">Business Assets</option>
                                        <option value="personalUse">Personal-Use Assets</option>
                                        <option value="cryptocurrency">Cryptocurrency</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="acquisitionDate" class="form-label">Date of Acquisition: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="acquisitionDate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="disposalDate" class="form-label">Date of Disposal: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="disposalDate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="primaryResidence" class="form-label">Is this a Primary Residence?</label>
                                    <select class="form-select" id="primaryResidence">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Financial Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="acquisitionCost" class="form-label">Acquisition Cost (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="acquisitionCost" required min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="disposalProceeds" class="form-label">Disposal Proceeds (R): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="disposalProceeds" required min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="improvementCosts" class="form-label">Improvement Costs (R):</label>
                                    <input type="number" class="form-control" id="improvementCosts" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="sellingCosts" class="form-label">Selling Costs (R):</label>
                                    <input type="number" class="form-control" id="sellingCosts" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pre-Valuation Date Assets -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Pre-1 October 2001 Assets</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valuationMethod" class="form-label">Valuation Method:</label>
                                    <select class="form-select" id="valuationMethod">
                                        <option value="" disabled selected>Select Method (if applicable)</option>
                                        <option value="marketValue">Market Value (1 Oct 2001)</option>
                                        <option value="timeApportionment">Time Apportionment</option>
                                        <option value="20percent">20% of Proceeds</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valuationDate" class="form-label">Valuation Date Value (R):</label>
                                    <input type="number" class="form-control" id="valuationDate" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exemptions and Exclusions -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Exemptions and Exclusions</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="annualExclusion" class="form-label">Annual Exclusion Used (R):</label>
                                    <input type="number" class="form-control" id="annualExclusion" min="0" max="40000" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="otherExemptions" class="form-label">Other Exemptions (R):</label>
                                    <input type="number" class="form-control" id="otherExemptions" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
                            <label class="form-check-label" for="confirmAccuracy">I declare that the information provided is true and accurate</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" id="reset-form">Reset Form</button>
                        <button type="submit" id="calculate-cgt" class="btn btn-primary">Calculate CGT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    include_once site . "/region/south_africa/CGT/form.handler.php";
    ?>