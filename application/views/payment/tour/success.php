<section class="cluster-payment">
	<div class="container">
		<? require_once APPPATH."views/module/breadcrumb.php"?>
	</div>
	<div class="container">
		<div class="justify-content-md-center">
			<h1 class="title font-size-24px font-weight-bold mb-0">Successful Payment</h1>
			<div class="tripbee-box pt-3 pb-4">
				<div class="mb-4">Thank you for your application! Please check your <b>Inbox</b> or <b>Spam</b> or <b>Junk Mail</b>, as a confirming information email is on its way, and double the applicant’s information.</div>
				<div class="mb-4">You can also <a target="_blank" href="<?=site_url("member")?>" title="Log in">log in</a> here to check your booking information and status to ensure that you have given us the correct information. </div>
				<div>Full Name: <b><?=$booking->contact_fullname?></b></div>
				<div>Email: <b><?=$booking->contact_email?></b></div>
				<div>Phone numbers: <b><?=$booking->contact_phone?></b></div>
			</div>
			<a class="btn btn-primary py-2" href="<?=site_url("tours")?>">CONTINUE BOOKING</a>
		</div>
	</div>
</section>

