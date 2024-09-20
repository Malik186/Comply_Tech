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
                    <h2 class="d-inline"><span class="fs-30">Customs Receipt</span></h2>
                    <div class="float-end text-end">
                        <strong class="text-blue fs-24" id="timestamp"></strong>
                    </div>    
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <strong>Goods Details</strong>    
                <address>
                    <strong class="text-blue fs-24" id="nameOfGoods"></strong><br>
                    Type: <span id="typeOfGoods"></span>
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
                            <td>Cost</td>
                            <td class="text-end" id="cost"></td>
                        </tr>
                        <tr>
                            <td>Insurance</td>
                            <td class="text-end" id="insurance"></td>
                        </tr>
                        <tr>
                            <td>Freight</td>
                            <td class="text-end" id="freight"></td>
                        </tr>
                        <tr>
                            <td><strong>CIF (Cost, Insurance, Freight)</strong></td>
                            <td class="text-end"><strong id="cif"></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Custom Duty</strong></td>
                            <td class="text-end"><strong id="customDuty"></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        include_once site . "/dashboard/pages/custom/content/receipt/receipt.js.php";
        ?>