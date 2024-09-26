<div class="col-xl-5 col-lg-5">
    <!-- Profile Image -->
    <div class="box bg-transparent no-border">
        <div class="box-body box-profile">
            <img id="profile-avatar" class="rounded img-fluid mx-auto d-block max-w-150" src="/" alt="User profile picture">
            
            <h3 class="profile-username text-center mb-0"><?php 
                if (isset($_SESSION['user']['username'])) {
                    echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                } else {
                    echo 'Guest'; // Fallback text if the user is not signed in
                }
            ?></h3>

            <h4 class="text-center mt-0"><i class="fa fa-envelope-o me-10"></i><?php 
                if (isset($_SESSION['user']['email'])) {
                    echo htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8');
                } else {
                    echo 'example@email.com'; // Fallback text if the user is not signed in
                }
            ?></h4>

            <div class="row">
                <div class="col-12">
                    <div class="media-list media-list-hover media-list-divided w-p100 mt-30">
                        <h4 class="media media-single p-15" onclick="window.location.href='settings.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Settings</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='analytics.kenya.paye.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent PAYE</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='invoice.recent.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent Invoice</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='payroll.recent.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent Payroll</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='custom.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Custom Receipt</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='excise.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Excise Receipt</span>
                        </h4>
                        <h4 class="media media-single p-15" onclick="window.location.href='corporate.php';" style="cursor: pointer;">
                            <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Corporate Receipt</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
	<?php
    include_once site . "/dashboard/pages/profile/content/profile_image/profile.js.php";
    ?>