<?
	$text_phone = "";
	if (!empty(HOTLINE)) {
		$text_phone = "<a href='tel:".HOTLINE."' class='text-danger'>".HOTLINE."</a>";
	}
	if (!empty(TOLL_FREE)) {
		$text_phone = (!empty($text_phone)?$text_phone." or ":"")."<a href='tel:".TOLL_FREE."' class='text-danger'>".TOLL_FREE."</a>";
	}
?>
<section class="cluster-payment">
	<? require_once APPPATH."views/module/breadcrumb.php"?>
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-12 col-md-7">
				<h1 class="title font-weight-semibold font-size-24px">Submitted Successfully</h1>
				<div class="tripbee-box">
					<div class="mb-3">Thank you for your booking! Please check your <b>Inbox</b> or <b>Spam</b> or <b>Junk Mail</b>, as a confirming information email is on its way, and double check the booking information.</div>
					<div>Since you have chosen Bank Transfer payment method. Please pay us via the Bank Accounts below: </div>
					<ul>
						<li><b>The One Vietnam Co., Ltd.</b></li>
						<li><b>Asia Commercial Bank, Bac Hai Branch, Ho Chi Minh City, Vietnam.</b></li>
						<li><b>Bank Account 1: 255791509 (USD)</b></li>
						<li><b>Bank Account 2: 255780759 (VND)</b></li>
						<li><b>Swift Code ASCBVNVX</b></li>
					</ul>
					<div class="mb-2">If you have not received any confirmation email from us, please contact us via email: <a class="font-weight-bold" href="mailto:<?=MAIL_INFO?>" style="color: #2a2726"><?=MAIL_INFO?></a></div>
					<div class="mb-4">Hotline: <?=$text_phone?> for further support</div>
				</div>
				<a class="btn btn-primary" href="<?=site_url("tours")?>">CONTINUE BOOKING</a>
			</div>
		</div>
	</div>
</section>