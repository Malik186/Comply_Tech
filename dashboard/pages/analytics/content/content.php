<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row">
        <div class="col-xxl-8 col-12 crancy-main__column">
              <div class="crancy-body">
                <!-- Dashboard Inner -->
                <div class="crancy-dsinner">
                    <!-- top_section -->
                    <?php
                    include_once site . "/dashboard/pages/analytics/content/top_section/analytics.chart.php";
                    ?>
                  
                  <!-- Table -->
                    <?php
                    include_once site . "/dashboard/pages/analytics/content/top_section/analytics.table.php";
                    ?>
                  
                </div>
                <!-- End Dashboard Inner -->
              </div>
            </div>
            <!--Lower_section-->
            <div class="col-xxl-4 col-12 crancy-main__sidebar">
                <div class="crancy-sidebar mg-top-30">
                    <div class="row">
                    <!-- Spending -->
                    <?php
                    include_once site . "/dashboard/pages/analytics/content/lower_section/spending.php";
                    ?>

                    <!-- Performance -->
                    <?php
                    include_once site . "/dashboard/pages/analytics/content/lower_section/performance.php";
                    ?>

                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>