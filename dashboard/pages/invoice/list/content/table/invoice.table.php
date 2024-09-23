<div class="col-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Invoice List</h4>
            <div class="box-controls pull-right">
                <div class="lookup lookup-circle lookup-right">
                    <input type="text" name="s" id="searchInput">
                </div>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-hover" id="invoiceTable">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Customer Name</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <?php
    include_once site . "/dashboard/pages/invoice/list/content/table/invoice.js.php";
    ?>