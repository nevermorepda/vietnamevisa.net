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
<div class="container">
	<!-- breadcrumb -->
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	<!-- end breadcrumb -->
</div>
<div class="">
	<div class="container">
		<div class="tab-step clearfix">
			<h1 class="note">Vietnam Visa Application Form</h1>
			<ul class="style-step d-none d-sm-none d-md-block">
				<li class="active"><font class="number">1.</font> Visa Options</li>
				<li class="active"><font class="number">2.</font> Applicant Details</li>
				<li class="active"><font class="number">3.</font> Review &amp; Payment</li>
				<li class="active"><font class="number">4.</font> Completed</li>
			</ul>
		</div>
		<div class="detailvisa">
			<div class="detailstep4">
				<div class="thanksucc">
					<p>Dear <b><?=strtoupper($client_name)?></b>,</p>
					<p>Thanks for your choosing our service!</p>
					<p>Your Vietnam visa application is successful, and we will process the visa based on your request.</p>
					<p>Please check your mail "<b>Inbox</b>" by signing in your registered email or <a title="log in" href="<?=site_url("member/login")?>">log in here</a> to check your Vietnam visa application information and status to make sure that you send us correct information.</p>
					<p>Some time this email come to your "<b>Spam</b>" or "<b>Junk Mail</b>", so please make sure you get our email confirmation in your mail box.<br/>If not, please contact us via email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or hotline: <span class="red"><?=HOTLINE?></span> for supporting in time!</p>
				</div>
				<div class="nicetrip">
					<h3 class="red">Have a nice Trip !</h3>
					Vietnam Visa Organization<br />
					Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
					Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
					Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
			<div class="text-center">
				<a class="btn btn-danger" href="<?=BASE_URL?>"/>FINISH</a>
			</div>
		</div>
		<!-- <div id="review-audio">
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
	</div>
</div>
<!-- About us -->
<!-- <div class="d-none d-sm-none d-md-block">
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
</div> -->
<!-- End about us -->