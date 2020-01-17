<script type="text/javascript" src="<?=JS_URL?>payment_online.js"></script>

<div class="clearfix">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8 col-xs-12">
				<h1 class="page-title">PAYMENT ONLINE</h1>
				<div class="">
					<div class="b-error none"></div>
					<form id="frmFeedback" class="form-horizontal" role="form" action="<?=BASE_URL_HTTPS."/payment-online/proceed"?>" method="POST">
						<h3>Please fill in with your order information</h3>
						<div class="clearfix">
							<div class="row form-group">
								<label class="col-md-3 control-label">Fullname <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" value="" name="fullname" id="fullname" class="form-control" placeholder="Enter your fullname" />
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label">Email <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" value="" name="email" id="email" class="form-control" placeholder="Enter your email" />
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label">Application ID</label>
								<div class="col-md-7">
									<input type="text" value="" name="application_id" id="application_id" class="form-control" placeholder="Enter your application id" />
									<span class="help-block">E.g: <?=BOOKING_PREFIX?>123456</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label">Amount (USD) <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" value="" name="amount" id="amount" class="form-control" placeholder="100" onkeyup="checkNumber(this)" />
									<!-- <span class="help-block">E.g: 100</span> -->
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label">Payment Description <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" value="" name="note" id="note" class="form-control" />
									<span class="help-block">E.g: I would like to pay for...</span>
								</div>
							</div>
							<!-- <div class="row form-group">
								<label class="col-md-3 control-label">Captcha <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" id="security_code" name="security_code" class="form-control" style="width: 100px"/> <label class="security-code"><?=$this->util->createSecurityCode()?></label>
								</div>
							</div> -->
						</div>
						<h3>Payment Method</h3>
						<div class="clearfix">
							<div class="row form-group">
								<div class="col-md-12">
									<span class="help-block">After payment is made, you will receive an email confirming your order.</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label"></label>
								<div class="col-md-3 col-xs-4 text-left">
									<label for="payment2"><img class="img-responsive" src="<?=IMG_URL?>payment/paypal.png" alt="Paypal" /></label>
									<br />
									<input id="payment2" type="radio" name="payment" value="Paypal" checked="checked" />
									<label for="payment2">Paypal</label>
								</div>
								<div class="col-md-3 col-xs-4 text-left hidden">
									<label for="payment1"><img class="img-responsive" src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" /></label>
									<br />
									<input id="payment1" type="radio" name="payment" value="OnePay" />
									<label for="payment1">Credit Card by OnePay</label>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label"></label>
								<div class="col-md-7">
									<input class="btn btn-danger" type="submit" value="PROCEED TO PAYMENT" id="proceed" />
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-3 col-sm-4 d-none d-sm-none d-md-block">
				<? require_once(APPPATH."views/module/support.php"); ?>
				<? require_once(APPPATH."views/module/confidence.php"); ?>
				<? require_once(APPPATH."views/module/services.php"); ?>
			</div>
		</div>
	</div>
</div>
