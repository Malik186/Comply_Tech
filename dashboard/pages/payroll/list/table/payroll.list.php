<div class="col-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Payroll List</h4>
            <div class="box-controls pull-right">
                <div class="lookup lookup-circle lookup-right">
                    <input type="text" name="s" id="searchInput">
                </div>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-hover" id="payrollTable">
                    <thead>
                        <tr>
                            <th>Employee No</th>
                            <th>Date Generated</th>
                            <th>Job Title</th>
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
    include_once site . "/dashboard/pages/payroll/list/table/payrolls.js.php";
    ?>