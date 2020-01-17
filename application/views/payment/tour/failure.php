<div class="cluster-payment bg-white">
	<div class="container">
		<? require_once APPPATH."views/module/breadcrumb.php"?>
	</div>
	<section>
		<div class="container">
			<div class="justify-content-md-center">
				<h1 class="title font-size-24px font-weight-bold mb-3">Declined Payment</h1>
				<div class="tripbee-box">
					<div class="mb-3">Unfortunately, your payment has <b>NOT</b> been made due to the following :</div>
					<ul class="mb-4">
						<li>You cancelled the payment</li>
						<li>Your bank did not approve the payment</li>
						<li>You stopped the payment while it was processing</li>
						<li>Your credit card information was incorrect</li>
					</ul>
					<a class="btn btn-primary px-4 py-2" href="<?=site_url("tours/review")?>">TRY AGAIN</a>
				</div>
			</div>
		</div>
	</section>
</div>