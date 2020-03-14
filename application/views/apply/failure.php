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
	<div class="slide-contact">
		<div class="container">
			<ul>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-vn.png"><a href="" title="Contact hotline"><?=HOTLINE?></a></li>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-usa.png"><a href="" title="Contact hotline"><?=HOTLINE_US?></a></li>
				<li><a href="" title="Contact hotline"><i class="fa fa-envelope-o" aria-hidden="true"></i><?=MAIL_INFO?></a></li>
			</ul>
		</div>
	</div>
</div>
<div class="cluster-content">
	<div class="container">
		<h2 class="page-title">Submit Failure!!!</h2>
		<ul class="style-step d-none d-sm-none d-md-block">
			<li class="active"><a style="color: #fff;" href="<?=site_url('apply-visa')?>"><font class="number">1.</font> Visa Options</a></li>
			<li class="active"><font class="number">2.</font> Login Account</li>
			<li class="active"><a style="color: #fff;" href="<?=site_url('apply-visa/step2')?>"><font class="number">3.</font> Applicant Details</a></li>
			<li class="active"><font class="number">4.</font> Review & Payment</li>
		</ul>
		<div style="line-height: 18px">
			<p>
				Dear <b><?=strtoupper($client_name)?></b>,
			</p>
			<p>
				Your payment was not successful because of some reasons:
				<ul style="list-style-type: disc; margin-left: 20px">
					<li>You cancelled the payment.</li>
					<li>Your bank did not approved your payment.</li>
					<li>You stopped while it was processing.</li>
					<li>Your information is incorrect while filling the credit card information.</li>
				</ul>
			</p>
			<p>
				Please try to <a title="procces the payment" href="<?=BASE_URL_HTTPS."/apply-visa/step3.html?key=".$key?>">procces the payment again</a> or <a title="Apply Vietnam visa online" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>" class="title_faq">click here</a> to re-apply the Vietnam Visa online then try with new card or choose other method of payment.
			</p>
			<p>
				You can scan your passport & send to us by email to <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>, we will contact you immediately.<br/>
			</p>
			<p>
				Best Regards,<br />
				Vietnam Visa Organization<br />
				Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
				Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
				Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
			</p>
		</div>
		<div class="center">
			<a class="btn btn-danger" title="Apply Vietnam visa online" href="<?=BASE_URL_HTTPS."/apply-visa/step3.html?key=".$key?>">TRY AGAIN</a>
		</div>
	</div>
</div>