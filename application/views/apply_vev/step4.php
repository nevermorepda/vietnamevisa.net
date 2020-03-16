<img src="<?=IMG_URL?>new-template/banner/banner-apply-online.png" class="img-responsive full-width d-none d-sm-none d-lg-block d-md-none" alt="">
<h1 class="hidden"><span class="" style="">APPLY VISA</span></h1>
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
<div class="apply-visa">
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
		<div class="">
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
				
				<div class="form-apply" style="margin-top:20px;">
					<div class="group">
						<h3 class="group-heading">Application Completed!!!</h3>
						<div class="group-content">
							<p>Dear <b><?=strtoupper($client_name)?></b>,</p>
							<p>Your Vietnam visa application is successful, and we will process the visa based on your request.</p>
							<p>Please check your mail "<b>Inbox</b>" by signing in your registered email or <a title="log in" href="<?=site_url("member/login")?>">log in here</a> to check your Vietnam visa application information and status to make sure that you send us correct information.</p>
							<p>Some time this email come to your "<b>Spam</b>" or "<b>Junk Mail</b>", so please make sure you get our email confirmation in your mail box.<br/>If not, please contact us via email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or hotline: <span class="text-color-red"><?=HOTLINE?></span> for supporting in time!</p>
							<h4 class="text-color-red">Have a nice trip !</h4>
							<p>
								<?=COMPANY?><br />
								Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
								Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
								Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- About us -->
<div class="d-none d-sm-none d-md-block">
	<div class="about-us-cluster">
		<div class="container wow fadeInUp">
			<div class="row">
				<div class="col-sm-6">
					<div class="about-us-content">
						<div class="title">
							<h1 class="heading">About Us</h1>
						</div>
						<p>It is our great pleasure to assist you in obtaining Vietnam Visa and we would like to get this opportunity to say “thank you” for your interest in our site Vietnam Visa Org Vn.</p>
						<p>With 10-year-experience in Vietnam visa service and enthusiastic visa team, Vietnam Visa Org Vn is always proud of our excellent services for the clients who would like to avoid the long visa procedures at their local Vietnam's Embassies. Vietnam Visa on arrival is helpful for overseas tourists and businessmen because it is the most convenient, simple and secured way to get Vietnam visa stamp. It is legitimated and supported by the Vietnamese Immigration Department.</p>
						<p>Let’s save your money, your time in the first time to visit our country! Whatever service you need, we are happy to tailor a package reflecting your needs and budget.</p>
						<div class="showmore-button">
							<a class="btn btn-danger" href="<?=site_url('about-us')?>">SHOW MORE</a>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="about-us-images">
						<img src="<?=IMG_URL?>new-template/thumbnail/aboutus-img.png" class="img-responsive full-width" alt="About Us">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End about us -->
