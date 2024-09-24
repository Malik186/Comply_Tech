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
                    <h2 class="d-inline"><span class="fs-30">Payroll Receipt</span></h2>
                    <div class="float-end text-end" id="date-generated">
                        <strong class="text-blue fs-24" id="timestamp"></strong>
                    </div>    
                </div>
            </div>
        </div>
        <div class="row invoice-info mt-4">
            <div class="col-md-6 invoice-col">
                <strong>Employee Details</strong>    
                <address>
                    <strong class="text-blue fs-24" id="employeeName"></strong><br>
                    ID Number: <span id="idNumber"></span><br>
                    Employee No: <span id="employeeNo"></span><br>
                    Job Title: <span id="jobTitle"></span>
                </address>
            </div>
            <div class="col-md-6 invoice-col text-end">
                <strong>Payment Details</strong>
                <address>
                    Payment Method: <span id="paymentMethod"></span><br>
                    Bank Name: <span id="bankName"></span><br>
                    Account No: <span id="accountNo"></span>
                </address>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount (Ksh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gross Salary</td>
                            <td class="text-end" id="grossSalary"></td>
                        </tr>
                        <tr>
                            <td>Allowances</td>
                            <td class="text-end" id="allowances"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Deductions</strong></td>
                        </tr>
                        <tr>
                            <td>PAYE</td>
                            <td class="text-end" id="paye"></td>
                        </tr>
                        <tr>
                            <td>Housing Levy</td>
                            <td class="text-end" id="housingLevy"></td>
                        </tr>
                        <tr>
                            <td>NHIF</td>
                            <td class="text-end" id="nhif"></td>
                        </tr>
                        <tr>
                            <td>NSSF</td>
                            <td class="text-end" id="nssf"></td>
                        </tr>
                        <tr>
                            <td>mortgage</td>
                            <td class="text-end" id="mortgage"></td>
                        </tr>
                        <tr>
                            <td>insurance</td>
                            <td class="text-end" id="insurance"></td>
                        </tr>
                        <tr>
                            <td>savings</td>
                            <td class="text-end" id="savings"></td>
                        </tr>
                        <tr>
                            <td>Other Deductions</td>
                            <td class="text-end" id="deductions"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end">
                <div>
                    <p>Total Deductions: <span id="totalDeductions"></span></p>
                </div>
                <div class="total-payment">
                    <h3><b>Net Salary:</b> <span id="netSalary"></span></h3>
                </div>
            </div>
        </div>

        <?php
        include_once site . "/dashboard/pages/payroll/recent_result/receipt/receipt.js.php";
        ?>