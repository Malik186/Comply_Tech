<div class="row">
    <div class="col-12">
        <div class="bb-1 clearFix">
            <div class="text-end pb-15">
                <button class="btn btn-success" type="button"> <span><i class="fa fa-print"></i> Save</span> </button>
                <button id="print2" class="btn btn-warning" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
            </div>    
        </div>
    </div>
    <div class="col-12">
        <div class="page-header">
            <h2 class="d-inline"><span class="fs-30">Invoice</span></h2>
            <div class="pull-right text-end" id="date-generated">
			<strong class="text-blue fs-24">
                <!-- Date generated will be inserted here -->
				 </strong>
            </div>    
        </div>
    </div>
</div>
<div class="row invoice-info">
    <div class="col-md-6 invoice-col">
        <strong>From</strong>    
        <address>
            <strong class="text-blue fs-24"><?php 
                            if (isset($_SESSION['user']['username'])) {
                                echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                            } else {
                                echo 'Guest'; // Fallback text if the user is not signed in
                            }
                        ?></strong><br>
            The Stables Karen, Nairobi, Kenya<br>
            <strong>Phone: <?php 
                            if (isset($_SESSION['user']['phone'])) {
                                echo htmlspecialchars($_SESSION['user']['phone'], ENT_QUOTES, 'UTF-8');
                            } else {
                                echo '0712345678'; // Fallback text if the user is not signed in
                            }
                        ?> &nbsp;&nbsp;&nbsp;&nbsp; Email: <?php 
						if (isset($_SESSION['user']['email'])) {
							echo htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8');
						} else {
							echo 'example@email.com'; // Fallback text if the user is not signed in
						}
					?></strong>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-md-6 invoice-col text-end">
        <strong>To</strong>
        <address id="to-address">
            <!-- Customer address will be inserted here -->
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-12 invoice-col mb-15">
        <div class="invoice-details row no-margin">
            <div class="col-md-6 col-lg-3"><b>Invoice </b><span id="invoice-number"></span></div>
            <div class="col-md-6 col-lg-3"><b>Payment Due:</b> <span id="payment-due"></span></div>
            <div class="col-md-6 col-lg-3"><b>Payment Method:</b> <span id="payment-method"></span></div>
            <div class="col-md-6 col-lg-3"><b>Account:</b> <span id="account-number"></span></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-bordered">
		<thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th class="text-end">Quantity</th>
                    <th class="text-end">Unit Cost</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody id="invoice-items">
                <!-- Invoice items will be inserted here -->
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-12 text-end">
        <p class="lead"><b>Payment Due </b><span class="text-danger" id="payment-due-2"></span></p>

        <div>
            <p>Sub - Total amount  :  <span id="sub-total">Ksh 0.00</span></p>
            <p>Tax (16%)  :  <span id="tax-amount">Ksh 0.00</span></p>
        </div>
        <div class="total-payment">
            <h3><b>Total :</b> <span id="total-amount">Ksh 0.00</span></h3>
        </div>
    </div>
</div>


	<?php
    include_once site . "/dashboard/pages/invoice/content/form/invoice.js.php";
    ?>