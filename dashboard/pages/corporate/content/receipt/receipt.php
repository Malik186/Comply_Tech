<div class="row">
            <div class="col-12">
                <div class="bb-1 clearFix">
                    <div class="text-end pb-3">
                        <button id="fetchData" class="btn btn-success" type="button">
                            <span><i class="fa fa-sync"></i> Fetch Data</span>
                        </button>
                        <button id="print" class="btn btn-warning" type="button">
                            <span><i class="fa fa-print"></i> Print</span>
                        </button>
                    </div>    
                </div>
            </div>
            <div class="col-12">
                <div class="page-header">
                    <h2 class="d-inline"><span class="fs-30">Corporate Report</span></h2>
                    <div class="float-end text-end">
                        <strong class="text-blue fs-24" id="timestamp"></strong>
                    </div>    
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <strong>Company Details</strong>    
                <address>
                    <strong class="text-blue fs-24" id="companyName"></strong><br>
                    Years of Operation: <span id="yearsOfOperation"></span><br>
                    Type of Company: <span id="typeOfCompany"></span><br>
                    <span id="specialRatesTypeContainer" style="display: none;">
                        Special Rates Type: <span id="specialRatesType"></span>
                    </span>
                </address>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yearly Profit</td>
                            <td class="text-end" id="yearlyProfit"></td>
                        </tr>
                        <tr>
                            <td>Corporate Tax</td>
                            <td class="text-end" id="corporateTax"></td>
                        </tr>
                        <tr>
                            <td><strong>Net Profit</strong></td>
                            <td class="text-end"><strong id="netProfit"></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        include_once site . "/dashboard/pages/corporate/content/receipt/receipt.js.php";
        ?>