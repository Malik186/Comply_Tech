<div class="crancy-wc__form-inner">
              <div class="crancy-wc__logo">
                <a href="/"><img src="/dashboard/img/ST-logo.png" alt="#" /></a>
              </div>
              <div class="crancy-wc__form-inside">
                <div class="crancy-wc__form-middle">
                  <div class="crancy-wc__form-top">
                    <div class="crancy-wc__heading pd-btm-20">
                      <h3
                        class="crancy-wc__form-title crancy-wc__form-title__one m-0"
                        id="header-form"
                      >
                        Create your account
                      </h3>
                    </div>
                    <!-- Sign in Form -->
                    <form class="crancy-wc__form-main">
                        <div class="row">
                            <div class="col-12">
                            <!-- Form Group -->
                            <div class="form-group">
                                <div class="form-group__input">
                                <input
                                    class="crancy-wc__form-input"
                                    type="text"
                                    id="nameField"
                                    name="Name"
                                    placeholder="Your Name"
                                />
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                            <!-- Form Group -->
                            <div class="form-group">
                                <div class="form-group__input">
                                <input
                                    class="crancy-wc__form-input"
                                    type="email"
                                    id="emailField"
                                    name="Email"
                                    placeholder="Your Email"
                                />
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                            <!-- Form Group -->
                            <div class="form-group">
                                <div class="form-group__input">
                                <input
                                    class="crancy-wc__form-input"
                                    type="text"
                                    name="Phone"
                                    id="phoneField"
                                    placeholder="Phone Number"
                                />
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                            <!-- Form Group -->
                            <div class="form-group">
                                <div class="form-group__input">
                                <input
                                    class="crancy-wc__form-input"
                                    placeholder="Password"
                                    id="passwordField"
                                    type="password"
                                    name="password"
                                    maxlength="20"
                                />
                                <span class="crancy-wc__toggle">
                                    <i class="fas fa-eye" id="toggle-icon"></i>
                                </span>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group" id="termsGroup">
                            <div class="crancy-wc__check-inline">
                            <div class="crancy-wc__checkbox">
                                <input
                                class="crancy-wc__form-check"
                                id="checkbox"
                                name="checkbox"
                                type="checkbox"
                                />
                                <label for="checkbox">
                                By proceeding, you agree to the
                                <a href="#">Terms and Conditions</a>
                                </label>
                            </div>
                            </div>
                        </div>
                        <!-- Form Group -->
                        <div class="form-group mg-top-30">
                            <div class="crancy-wc__button">
                            <button class="ntfmax-wc__btn" id="submitButton" type="submit">
                                Sign Up with email
                            </button>
                            </div>
                            <div class="crancy-wc__form-login--label">
                            <span id="authToggleLabel">Or sign up with</span>
                            </div>
                            <div class="crancy-wc__button--group">
                            <button class="ntfmax-wc__btn ntfmax-wc__btn--two" type="submit">
                                <div class="ntfmax-wc__btn-icon">
                                <img src="/dashboard/img/google-logo.png" />
                                </div>
                                Google
                            </button>
                            <button class="ntfmax-wc__btn ntfmax-wc__btn--two" type="submit">
                                <div class="ntfmax-wc__btn-icon">
                                <img src="/dashboard/img/apple-logo.png" />
                                </div>
                                Apple
                            </button>
                            </div>
                        </div>
                        <!-- Form Group -->
                        <div class="form-group form-mg-top30">
                            <div class="crancy-wc__bottom">
                            <p class="crancy-wc__text">
                                <span id="toggleText">Already have an account ?</span>
                                <a href="javascript:void(0);" id="toggleLink">Sign in</a>
                            </p>
                            </div>
                        </div>
                        </form>

                    <!-- End Sign in Form -->
                  </div>
                  <!-- Footer Top -->
                  <div class="crancy-wc__footer--top">
                    <div class="crancy-wc__footer">
                      <ul class="crancy-wc__footer--list list-none">
                        <li><a href="#">Terms & Condition</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Help</a></li>
                      </ul>
                      <div class="crancy-wc__footer--languages">
                        <select class="crancy-wc__footer--language">
                          <option data-display="English">English</option>
                          <option value="2">English(UK)</option>
                        </select>
                      </div>
                    </div>
                    <p class="crancy-wc__footer--copyright">
                      @ 2024 <a href="https://socialtransact.com">Social Transact.</a> All Right Reserved.
                    </p>
                  </div>
                  <!-- End Footer Top -->
                </div>
              </div>
            </div>
            <?php
            include_once site . "/dashboard/pages/welcome/content/sign_in_up_form/toggle.form.php";
            ?>

            <?php
            include_once site . "/dashboard/pages/welcome/content/sign_in_up_form/form.handler.php";
            ?>