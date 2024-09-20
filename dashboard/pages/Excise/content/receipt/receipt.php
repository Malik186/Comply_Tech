<div class="row">
            <div class="col-12">
                <div class="bb-1 clearFix">
                    <div class="text-end pb-3">
                        <button id="fetchData" class="btn btn-success" type="button">
                            <span><i class="fa fa-sync"></i> Save Data</span>
                        </button>
                        <button id="print" class="btn btn-warning" type="button">
                            <span><i class="fa fa-print"></i> Print</span>
                        </button>
                    </div>    
                </div>
            </div>
            <div class="col-12">
                <div class="page-header">
                    <h2 class="d-inline"><span class="fs-30">Excise Receipt</span></h2>
                    <div class="float-end text-end">
                        <strong class="text-blue fs-24" id="timestamp"></strong>
                    </div>    
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <strong>Importer/Manufacturer Details</strong>    
                <address>
                    <strong class="text-blue fs-24" id="importerManufacturer"></strong><br>
                    Contact: <span id="contactInfo"></span><br>
                    Type of Goods: <span id="typeOfGoods"></span><br>
                    Description: <span id="goodsDescription"></span><br>
                    Origin: <span id="goodsOrigin"></span>
                </address>
            </div>
            <div class="col-md-6" id="productDetails">
                <!-- Product-specific details will be inserted here -->
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
                            <td>CIF Cost</td>
                            <td class="text-end" id="cif_cost"></td>
                        </tr>
                        <tr>
                            <td>CIF Insurance</td>
                            <td class="text-end" id="cif_insurance"></td>
                        </tr>
                        <tr>
                            <td>CIF Freight</td>
                            <td class="text-end" id="cif_freight"></td>
                        </tr>
                        <tr>
                            <td><strong>Custom Duty</strong></td>
                            <td class="text-end"><strong id="Custom_Duty"></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Excise Duty</strong></td>
                            <td class="text-end"><strong id="Excise_Duty"></strong></td>
                        </tr>
                        <tr>
                            <td>VAT</td>
                            <td class="text-end" id="VAT"></td>
                        </tr>
                        <tr>
                            <td>IDF</td>
                            <td class="text-end" id="IDF"></td>
                        </tr>
                        <tr>
                            <td>RDL</td>
                            <td class="text-end" id="RDL"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       
        <?php
        include_once site . "/dashboard/pages/Excise/content/receipt/receipt.js.php";
        ?>