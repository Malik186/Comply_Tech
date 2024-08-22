<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row">
        <div class="col-xxl-8 col-12 crancy-main__column">
              <div class="crancy-body">
                <!-- Dashboard Inner -->
                <div class="crancy-dsinner">
                    <!-- top_section -->
                    <?php
                    include_once site . "/dashboard/pages/transaction/content/top_section/transactions.table.php";
                    ?>
                  
                </div>
                <!-- End Dashboard Inner -->
              </div>
            </div>
            <!--Lower_section-->
            <div class="col-xxl-3 col-12 crancy-main__sidebar">
                <div class="crancy-sidebar mg-top-30">
                    <div class="row">
                    <!-- transaction -->
                    <?php
                    include_once site . "/dashboard/pages/transaction/content/lower_section/wallet.php";
                    ?>

                    <!-- Performance -->
                    <?php
                    include_once site . "/dashboard/pages/transaction/content/lower_section/withdraw.php";
                    ?>

                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>