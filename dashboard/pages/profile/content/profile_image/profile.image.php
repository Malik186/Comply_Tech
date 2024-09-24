<div class="col-xl-5 col-lg-5">

				  <!-- Profile Image -->
				  <div class="box bg-transparent no-border">
					<div class="box-body box-profile">
					  <img class="rounded img-fluid mx-auto d-block max-w-150" src="/dashboard/img/avatar/2.jpg" alt="User profile picture">

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
								<h4 class="media media-single p-15" href="settings.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Settings</span>
								</h4>
								<h4 class="media media-single p-15" href="analytics.kenya.paye.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent PAYE</span>
								</h4>
								<h4 class="media media-single p-15" href="invoice.recent.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent Invoice</span>
								</h4>
								<h4 class="media media-single p-15" href="payroll.recent.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Recent Payroll</span>
								</h4>
								<h4 class="media media-single p-15" href="custom.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Custom Receipt</span>
								</h4>
								<h4 class="media media-single p-15" href="excise.php">
								  <i class="fa fa-arrow-circle-o-right me-10"></i><span class="title">Excise Receipt</span>
								</h4>
								<h4 class="media media-single p-15" href="corporate.php">
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