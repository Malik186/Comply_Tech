<div class="box" id="kenya-paye-form" style="display: none;">
    <div class="box-header with-border">
        <h4 class="box-title">Update Kenya's PAYE Tax Rule</h4>
    </div>
    <div class="box-body wizard-content">
        <form action="#" class="tab-wizard wizard-circle">
            <!-- Step 1: PAYE Tax Bands and Rates -->
            <h6>PAYE Tax Bands and Rates</h6>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payeBand1" class="form-label">Up to KES 24,000 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payeBand1" value="10" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payeBand2" class="form-label">KES 24,001 - 32,333 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payeBand2" value="25" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payeBand3" class="form-label">KES 32,334 - 500,000 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payeBand3" value="30" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payeBand4" class="form-label">KES 500,001 - 800,000 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payeBand4" value="32.5" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payeBand5" class="form-label">Above KES 800,000 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payeBand5" value="35" required>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 2: Housing Levy -->
            <h6>Housing Levy</h6>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="housingLevyPercentage" class="form-label">Housing Levy Percentage (%) : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="housingLevyPercentage" value="1.5" required>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 3: NSSF Contributions -->
            <h6>NSSF Contributions</h6>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nssfTierI" class="form-label">NSSF Tier I Contribution (%) : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nssfTierI" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nssfTierII" class="form-label">NSSF Tier II Contribution (%) : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nssfTierII" required>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Step 4: NHIF Contributions -->
            <h6>NHIF Contributions</h6>
            <section>
                <div class="row">
                    <!-- Loop to input different NHIF contribution ranges -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nhif0to5999" class="form-label">KES 0 – 5,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif0to5999" value="150" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif6000to7999" class="form-label">KES 6,000 – 7,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif6000to7999" value="300" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif8000to11999" class="form-label">KES 8,000 – 11,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif8000to11999" value="400" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif12000to14999" class="form-label">KES 12,000 – 14,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif12000to14999" value="500" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif15000to19999" class="form-label">KES 15,000 – 19,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif15000to19999" value="600" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nhif20000to24999" class="form-label">KES 20,000 – 24,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif20000to24999" value="750" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif25000to29999" class="form-label">KES 25,000 – 29,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif25000to29999" value="850" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif30000to34999" class="form-label">KES 30,000 – 34,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif30000to34999" value="900" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif35000to39999" class="form-label">KES 35,000 – 39,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif35000to39999" value="950" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif40000to44999" class="form-label">KES 40,000 – 44,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif40000to44999" value="1,000" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nhif45000to49999" class="form-label">KES 45,000 – 49,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif45000to49999" value="1,100" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif50000to59999" class="form-label">KES 50,000 – 59,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif50000to59999" value="1,200" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif60000to69999" class="form-label">KES 60,000 – 69,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif60000to69999" value="1,300" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif70000to79999" class="form-label">KES 70,000 – 79,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif70000to79999" value="1,400" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif80000to89999" class="form-label">KES 80,000 – 89,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif80000to89999" value="1,500" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif90000to99999" class="form-label">KES 90,000 – 99,999 : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif90000to99999" value="1,600" required>
                        </div>
                        <div class="form-group">
                            <label for="nhif100000Above" class="form-label">KES 100,000 and above : <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nhif100000Above" value="1,700" required>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Form Submission -->
            <div class="form-group">
                <button type="submit" id="update-paye" class="btn btn-primary">Update Tax Rules</button>
                <button type="button" class="btn btn-secondary" onclick="cancelUpdate()">Cancel</button>
            </div>
        </form>
    </div>
</div>

    <?php
    include_once site . "/region/kenya/PAYE/form.handler.php";
    ?>