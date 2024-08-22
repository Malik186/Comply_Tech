<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row">
        <div class="col-xxl-8 col-12 crancy-main__column">
              <div class="crancy-body">
                <!-- Dashboard Inner -->
                <div class="crancy-dsinner">
                    <!-- top_section -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/top_section/hero.content.php";
                    ?>
                  
                  <!-- Cardlets -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/top_section/cardlets.php";
                    ?>

                  <!-- Chart -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/top_section/statistics.chart.php";
                    ?>

                    <!-- Table -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/top_section/activity.table.php";
                    ?>
                  
                </div>
                <!-- End Dashboard Inner -->
              </div>
            </div>
            <!--Lower_section-->
            <div class="col-xxl-4 col-12 crancy-main__sidebar">
                <div class="crancy-sidebar mg-top-30">
                    <div class="row">
                    <!-- transaction -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/lower_section/transaction.php";
                    ?>

                    <!-- Performance -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/lower_section/performance.php";
                    ?>

                    <!-- Platforms -->
                    <?php
                    include_once site . "/dashboard/pages/overview/content/lower_section/platforms.php";
                    ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>