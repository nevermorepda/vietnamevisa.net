<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>member.css" />

<div class="container">
	<div class="info-bar">
		<h1><span class="glyphicon glyphicon-user"></span> <?=$this->session->userdata("user")->user_fullname?> <span class="right-panel"><a href="<?=site_url("member/logout")?>"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></span></h1>
	</div>
	<div class="myaccount">
		<? require_once(APPPATH."views/member/nav_bar.php"); ?>
		<div class="panel-account">
			<div class="detail">
				<div class="alert alert-info" role="alert">
					<p>Payment for Application ID: <span class="f18"><strong><?=BOOKING_PREFIX.$item->id?></strong></span></p>
					<p>Amount to pay: $<?=$item->total_fee?></p>
				</div>
				<form method="post" action="<?=site_url("member/pay")?>">
					<input type="hidden" id="booking_id" name="booking_id" value="<?=$item->id?>"/>
					<h3>Payment method</h3>
					<p>After payment is made, you will receive an email confirming your order.</p>
					<div class="row">
						<div class="col-xs-6 col-sm-6 text-center">
							<label for="payment3"><img class="img-responsive" src="<?=IMG_URL?>payment/paypal.png" alt="Paypal" /></label>
							<br />
							<div class="radio">
								<label><input id="payment3" type="radio" name="payment" value="Paypal" checked="checked" />Paypal</label>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 text-center hidden">
							<label for="payment1"><img class="img-responsive" src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" /></label>
							<br />
							<div class="radio">
								<label><input id="payment1" type="radio" name="payment" value="OnePay" />OnePay</label>
							</div>
						</div>
					</div>
					<div class="center"><button class="btn btn-danger" type="submit">PROCEED TO PAYMENT</button></div>
				</form>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
