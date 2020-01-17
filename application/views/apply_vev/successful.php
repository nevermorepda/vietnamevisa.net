<div class="apply-visa">
	<div class="slide-bar hidden">
		<div class="slide-wrap">
			<div class="slide-content">
				<div class="container">
					<div class="slide-text">
						<h1>APPLY VIETNAM <span class="text-color-red">E-VISA</span> ONLINE</h1>
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
						<h3 class="group-heading">Payment Completed!!!</h3>
						<div class="group-content">
							<p>Dear <b><?=strtoupper($client_name)?></b>,</p>
							<p>Thank you for your application at <?=SITE_NAME?>.</p>
							<p>Your Visa Application has been sent successfully to our Visa Department, and we will process the visa based on your request.</p>
							<p>Please check your mail <b>Inbox</b> by signing in your registered email or <a title="log in" href="<?=site_url("member/login")?>">log in here</a> to check your Vietnam visa application information and its status to make sure you sent us correct information.</p>
							<p>If you entered the correct email details in application form, please don't forget to check your <b>Spam</b>/<b>Junk</b>/<b>Bulk</b> mail folder, if you don't find our email in your <b>Inbox</b>.</p>
							<p>Should you have any further questions, please do not hesitate to contact us via <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to be supported promptly.</p>
							<p>
								To improve our services, would you please help us to spend a few minutes for sharing your experience about our services. We highly appreciate for your time and your ideas.<br>
								Your feedback is greatly appreciated, and will be used to better inform and assist future <?=SITE_NAME?> customers.
							</p>
							<div id="outer_shopper_approved"></div> <script type="text/javascript"> var sa_values = { "site":24093, "token":"e856", 'name':'John Doe', 'email':'john.doe@gmail.com', 'country':'United States', 'forcecomments':1 }; function saLoadScript(src) { var js = window.document.createElement("script"); js.src = src; js.type = "text/javascript"; document.getElementsByTagName("head")[0].appendChild(js); } var d = new Date(); if (d.getTime() - 172800000 > 1477399567000) saLoadScript("//www.shopperapproved.com/thankyou/inline/24093.js"); else saLoadScript("//direct.shopperapproved.com/thankyou/inline/24093.js?d=" + d.getTime()); </script>
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
<script>
	dataLayer = [{
		'transactionId': '<?=$transaction_id?>',
		'transactionTotal': <?=$transaction_fee?>,
		'transactionProducts': [{
			'sku': '<?=$transaction_sku?>',
			'name': '<?=$transaction_name?>',
			'category': '<?=$transaction_category?>',
			'quantity': <?=$transaction_quantity?>
			}]
		}];
</script>
