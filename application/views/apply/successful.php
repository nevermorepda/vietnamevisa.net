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
		<div class="tab-step clearfix">
			<h1 class="note">Vietnam Visa Application Form</h1>
			<ul class="style-step d-none d-sm-none d-md-block">
				<li class="active"><font class="number">1.</font> Visa Options</li>
				<li class="active"><font class="number">2.</font> Applicant Details</li>
				<li class="active"><font class="number">3.</font> Review &amp; Payment</li>
				<li class="active"><font class="number">4.</font> Successful</li>
			</ul>
		</div>
		<div>
			<h2 class="page-title">Thank You for Your Application</h2>
			<div>
				<p>Dear <b><?=strtoupper($client_name)?></b>,</p>
				<p>Your Vietnam visa application is successful, and we will process the visa based on your request.</p>
				<p>Please check your mail "<b>Inbox</b>" by signing in your registered email or <a title="log in" href="<?=site_url("member/login")?>">log in here</a> to check your Vietnam visa application information and status to make sure that you send us correct information.</p>
				<p>Some time this email come to your "<b>Spam</b>" or "<b>Junk Mail</b>", so please make sure you get our email confirmation in your mail box.<br/>If not, please contact us via email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or hotline: <span class="red"><?=HOTLINE?></span> for supporting in time!</p>
			</div>
			<div>
				<p>
					To improve our services, would you please help us to spend a few minutes for sharing your experience about our services. We highly appreciate for your time and your ideas.<br>
					Your feedback is greatly appreciated, and will be used to better inform and assist future <?=SITE_NAME?> customers.
				</p>
			</div>
			<!-- <div id="review-audio" class="d-block d-sm-block d-md-none">
				<h3 class="text-center title">REVIEW AUDIO</h3>
				<div id="controls">
					<button class="btn-control" id="recordButton">Record</button>
					<button style="display: none;" class="btn-control" id="pauseButton" disabled>Pause</button>
					<button class="btn-control" id="stopButton" disabled>Stop</button>
				</div>
				<div id="formats">Format: start recording to see sample rate</div>
				<h4>Recordings</h4>
				<ol id="recordingsList"></ol>
				<script src="<?//=JS_URL?>recorder.js"></script>
				<script src="<?//=JS_URL?>app-recorder.js"></script>
			</div> -->
			<div id="outer_shopper_approved"></div> <script type="text/javascript"> var sa_values = { "site":24798, "token":"59dDMC9b", 'name':'John Doe', 'email':'john.doe@gmail.com', 'country':'United States', 'forcecomments':1 }; function saLoadScript(src) { var js = window.document.createElement("script"); js.src = src; js.type = "text/javascript"; document.getElementsByTagName("head")[0].appendChild(js); } var d = new Date(); if (d.getTime() - 172800000 > 1477399567000) saLoadScript("//www.shopperapproved.com/thankyou/inline/24798.js"); else saLoadScript("//direct.shopperapproved.com/thankyou/inline/24798.js?d=" + d.getTime()); </script>
			<style>
				#outer_shopper_approved {
					background-color: #F8F8F8;
				}
				#sa_header_img {
					display: none;
				}
				#sa_header_text {
					display: none;
				}
				#shopper_approved #sa_outer {
					width: 100% !important;
					max-width: 100% !important;
				}
			</style>
			<div>
				<h3 class="red">Have a nice trip !</h3>
				Vietnam Visa Organization<br />
				Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
				Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
				Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
			</div>
		</div>
	</div>
</div>
