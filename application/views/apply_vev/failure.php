<div class="banner-top faqs-banner d-none d-sm-none d-md-block" style="background: url('<?=IMG_URL?>new-template/banner-faqs.png') no-repeat scroll top center transparent;">
	<img src="<?=IMG_URL?>new-template/flag-faqs.png" class="img-responsive flag-faqs" alt="flag-faqs">
	<div class="container">
		<div class="text-content">
			<h1>
				<span class="" style="">APPLY VISA</span>
				<div class="bd-right d-none d-lg-block d-md-block"></div>
			</h1>
			<ul>
				<li>Safety and reliable procedure </li>
				<li>Professional staffs</li>
			</ul>
		</div>
	</div>
</div>
<div class="slide-wrap d-none d-sm-none d-md-block">
	<div class="slide-ex-contact">
		<div class="container">
			<ul>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-vn.png"><a href="" title="Contact hotline"><?=HOTLINE?></a></li>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-usa.png"><a href="" title="Contact hotline"><?=HOTLINE_US?></a></li>
				<li><a href="" title="Contact hotline"><i class="fa fa-envelope-o" aria-hidden="true"></i><?=MAIL_INFO?></a></li>
			</ul>
		</div>
	</div>
</div>
<div class="<?=$this->util->slug($this->router->fetch_class())?>">
	<div class="slide-bar hidden">
		<div class="slide-wrap">
			<div class="slide-content">
				<div class="container">
					<div class="slide-text">
						<h1>APPLY VIETNAM VISA ONLINE</h1>
						<h4>Just a few steps fill in online form, you are confident to have Vietnam visa approval on your hand.</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="visa-form">
		<div class="cluster">
			<div class="container">
				<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
				<div class="tab-step clearfix">
					<h1 class="note">Vietnam E-Visa Application Form</h1>
					<ul class="style-step d-none d-sm-none d-md-block">
						<li class="active"><font class="number">1.</font> Visa Options</li>
						<li class="active"><font class="number">2.</font> Account Login</li>
						<li class="active"><font class="number">3.</font> Applicant Details</li>
						<li class="active"><font class="number">4.</font> Review & Payment</li>
					</ul>
				</div>
				
				<div class="form-apply">
					<div class="group">
						<h3 class="group-heading heading-danger">Submit Failure!!!</h3>
						<div class="group-content">
							<p>Dear <b><?=strtoupper($client_name)?></b>,</p>
							<p>Thank you for your application at <?=SITE_NAME?>.</p>
							<p>Unfortunately, your payment was NOT completed successfully because of some reasons:
								<ul>
									<li>You cancelled the payment.</li>
									<li>Your bank did not approved your payment.</li>
									<li>You stopped the payment while it was processing.</li>
									<li>The credit card information that you filled is incorrect.</li>
								</ul>
							</p>
							<p>Please try to <a title="procces the payment" href="<?=site_url("apply-e-visa/step3")."?key=".$key?>">settle the payment again</a> or <a title="Apply Vietnam visa online" href="<?=site_url("apply-visa")?>">click here</a> to re-apply the Vietnam visa on arrival then try with other cards or choose another method of payment.</p>
							<p>Should you have any further questions, please do not hesitate to contact us via <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to be supported promptly.</p>
							<p>
								Best Regards,<br />
								<?=COMPANY?><br />
								Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
								Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
								Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
							</p>
							<div class="text-center">
								<a class="btn btn-danger btn-radius" title="Apply Vietnam visa online" href="<?=site_url("apply-e-visa/step3")."?key=".$key?>">TRY AGAIN</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
