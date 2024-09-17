<div class="col-12">
    <div class="box">
        <div class="box-header no-border pb-0">
            <h4 class="box-title">Recent History</h4>
            <ul class="box-controls pull-right">
                <li class="dropdown">
                    <a data-bs-toggle="dropdown" href="#" class="btn btn-danger-light px-10 base-font">View By</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="ti-import"></i> Hotel</a>
                        <a class="dropdown-item" href="#"><i class="ti-export"></i> Month</a>
                        <a class="dropdown-item" href="#"><i class="ti-printer"></i> Date</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="box-body pb-0">
            <div class="table-responsive">
                <table class="table no-border table-striped">
                    <tbody>
                        <!-- Rows will be inserted dynamically here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
	<?php
    include_once site . "/dashboard/pages/overview/content/table_history/recent.history.js.php";
    ?>