<div class="col-xl-7 col-lg-7">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Account Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-12">
          <div class="form-group row" style="display: none">
            <label class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input id="username" class="form-control" type="text" placeholder="<?php 
              if (isset($_SESSION['user']['username'])) {
                  echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
              } else {
                  echo 'Guest'; 
              } ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email Address</label>
            <div class="col-sm-10">
              <input id="email" class="form-control" type="email" placeholder="<?php 
              if (isset($_SESSION['user']['email'])) {
                  echo htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8');
              } else {
                  echo 'example@email.com'; 
              } ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Phone Number</label>
            <div class="col-sm-10">
              <input id="phone" class="form-control" type="tel" placeholder="<?php 
              if (isset($_SESSION['user']['phone'])) {
                  echo htmlspecialchars($_SESSION['user']['phone'], ENT_QUOTES, 'UTF-8');
              } else {
                  echo '0712345678'; 
              } ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Profile Avatar (PNG File)</label>
            <div class="col-sm-10">
              <input id="avatar" class="form-control" type="file" accept="image/png">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
              <button type="button" id="account-details" class="btn btn-warning">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Address Form -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Personal Address</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-12">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Street</label>
            <div class="col-sm-10">
              <input id="street" class="form-control" type="text" placeholder="A-458, Simple text, city">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">City</label>
            <div class="col-sm-10">
              <input id="city" class="form-control" type="text" placeholder="Your City">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">State</label>
            <div class="col-sm-10">
              <input id="state" class="form-control" type="text" placeholder="Your State">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Post Code</label>
            <div class="col-sm-10">
              <input id="post_code" class="form-control" type="number" placeholder="123456">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
              <button type="submit" id="user-address" class="btn btn-warning">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	<?php
    include_once site . "/dashboard/pages/profile/content/account_edit/edit.js.php";
    ?>