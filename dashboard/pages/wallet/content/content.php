<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row">
        <div class="col-xxl-3 col-12 crancy-main__sidebar">
              <div class="crancy-sidebar mg-top-30">
                <!-- Dashboard Inner -->
                <div class="row">
                    <!-- top_section -->
                    <?php
                    include_once site . "/dashboard/pages/wallet/content/top_section/wallet.php";
                    ?>

                    <?php
                    include_once site . "/dashboard/pages/wallet/content/top_section/withdraw.php";
                    ?>
                  
                </div>
                <!-- End Dashboard Inner -->
              </div>
            </div>
            <!--Lower_section-->
            <div class="col-xxl-8 col-12 crancy-main__column">
                <div class="crancy-body">
                    <div class="crancy-dsinner">
                    <!-- transaction -->
                    <?php
                    include_once site . "/dashboard/pages/wallet/content/lower_section/transaction.trend.php";
                    ?>

                    <!-- Performance -->
                    <?php
                    include_once site . "/dashboard/pages/wallet/content/lower_section/transaction.table.php";
                    ?>

                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>