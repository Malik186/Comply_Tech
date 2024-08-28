<div class="col-12">
    <div class="row justify-content-center g-0">
        <div class="col-lg-5 col-md-5 col-12">
            <div class="bg-white rounded10 shadow-lg">
                <!-- Content Title -->
                <div class="content-top-agile p-20 pb-0">
                    <h2 class="text-primary" id="form-title">Let's Get Started</h2>
                    <p class="mb-0" id="form-subtitle">Sign in to continue to Comply Tech.</p>
                </div>

                <!-- Sign-In Form -->
                <div class="p-40" id="sign-in" style="display: block;">
                    <form action="index.html">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                <input type="text" id="email-number" class="form-control ps-15 bg-transparent" placeholder="Email or Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                <input type="password" id="password-signin" class="form-control ps-15 bg-transparent" placeholder="Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="checkbox">
                                    <input type="checkbox" id="basic_checkbox_1">
                                    <label for="basic_checkbox_1">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fog-pwd text-end">
                                    <a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" id="submit-sign-in" class="btn btn-danger mt-10">SIGN IN</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="mt-15 mb-0">Don't have an account? <a href="javascript:void(0);" class="text-warning ms-5 toggle-form">Sign Up</a></p>
                    </div>
                </div>

                <!-- Sign-Up Form -->
                <div class="p-40" id="sign-up" style="display: none;">
                    <form>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                <input type="text" id="name-signup" class="form-control ps-15 bg-transparent" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                <input type="email" id="email-signup" class="form-control ps-15 bg-transparent" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-mobile"></i></span>
                                <input type="password" id="number-signup" class="form-control ps-15 bg-transparent" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                <input type="password" id="password-signup" class="form-control ps-15 bg-transparent" placeholder="Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="checkbox">
                                    <input type="checkbox" id="basic_checkbox_2">
                                    <label for="basic_checkbox_2">I agree to the <a href="#" class="text-warning"><b>Terms</b></a></label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-info margin-top-10" id="submit-sign-up">SIGN UP</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="mt-15 mb-0">Already have an account?<a href="javascript:void(0);" class="text-danger ms-5 toggle-form"> Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Social Sign-In/Sign-Up -->
                <div class="text-center">
                    <p class="mt-20 text-white" id="social-text">- Sign With -</p>
                    <p class="gap-items-2 mb-20">
                        <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa-brands fa-x-twitter"></i></a>
                        <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>
                    </p>
                </div>
            <?php
            include_once site . "/dashboard/pages/welcome/content/sign_in_up_form/toggle.form.php";
            ?>

            <?php
            include_once site . "/dashboard/pages/welcome/content/sign_in_up_form/form.handler.php";
            ?>