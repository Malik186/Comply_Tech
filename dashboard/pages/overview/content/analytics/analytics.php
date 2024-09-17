<div class="col-xl-3 col-lg-6 col-12">
    <div class="box">
        <div class="box-header no-border pb-0">
            <h4 class="box-title">Requests Success</h4>
        </div>
        <div class="box-body">					
            <div id="analytic_chart"></div>																
            <div>
                <div class="d-flex gap-5 mt-30 justify-content-between">
                    <h4 id="booked-percent">
                        <span class="fs-12"> Success</span> <br>60.01%
                    </h4>
                    <h4 id="cancelled-percent">
                        <span class="fs-12"> Cancelled</span> <br>30.01%
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
	<?php
    include_once site . "/dashboard/pages/overview/content/analytics/analytics.js.php";
    ?>