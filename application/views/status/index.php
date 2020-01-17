<?
	$data 		= $this->session->flashdata('check_status');
	$email		= (!empty($data->email) ? $data->email : "");
	$fullname	= (!empty($data->fullname) ? $data->fullname : "");
	$passport	= (!empty($data->passport) ? $data->passport : "");
	$message	= (!empty($data->message) ? $data->message : "");
?>

<div class="check-visa-status" style="margin-bottom: 40px;">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8">
				<h1 class="page-title">Check Visa Status</h1>
				<div class="clearfix">
					<p>Please fill the form online to check your visa status with our live agent via email or email to <a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> if you want to make sure your request will come to us. We will reply you shortly via email.</p>
					<h3>Why you cannot check online with us?</h3>
					<p>Due to protecting your personal data & your confidential with us, we do not store your data on our website. No once can guarantee 100% that a website is uncheckable & of course we not guarantee 100% that our site is uncheckable. Therefore, to protect your privacy, please contact us via email <a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> or fill the form online as bellow to check your visa status with our live person.</p>
					<div class="form" style="margin-top: 20px; margin-bottom: 40px;">
						<? if ($this->session->flashdata('status')) {?>
						<div class="b-error" style="margin: 20px 0px 10px 0px">
							<div class='marker'><?=$this->session->flashdata('status')?></div>
						</div>
						<? } ?>
						<div>
							<form id="frm-check-status" class="form-horizontal" role="form" action="<?=site_url("check-visa-status/check")?>" method="POST">
								<div class="form-group">
									<label class="col-sm-3 form-label">YOUR NAME <span class="required">*</span></label>
									<div class="col-sm-6">
										<input type="text" value="<?=$fullname?>" id="fullname" name="fullname" required="" class="form-control">
										<p class="help-block">(the same as in your passport)</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 form-label">EMAIL <span class="required">*</span></label> 
									<div class="col-sm-6">
										<input type="email" value="<?=$email?>" id="email" name="email" required="" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 form-label">PASSPORT NUMBER <span class="required">*</span></label>
									<div class="col-sm-6">
										<input type="text" value="<?=$passport?>" id="passport" name="passport" required="" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 form-label">MESSAGE <span class="required">*</span></label> 
									<div class="col-sm-6">
										<textarea id="message" name="message" required="" class="form-control" style="height: 108px;"><?=$message?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 form-label">CAPTCHA <span class="required">*</span></label>
									<div class="col-sm-6 clearfix">
										<div class="left">
											<input type="text" style="width: 100px" value="" id="security_code" name="security_code" required="" class="form-control">
										</div>
										<div class="left" style="margin-left: 10px; line-height: 30px;">
											<label class="security-code"><?=$this->util->createSecurityCode()?></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3"></label>
									<div class="col-sm-6">
										<input type="submit" class="btn btn-danger btn-submit" name="submit" value="SEND MESSAGE">
									</div>
								</div>
							</form>
						</div>
					</div>
					<h3>Why we don't accept call for your visa?</h3>
					<p>Getting visa to enter a country is very important and you will lose much money if problem with your visa. We don't want any problem with your visa. Therefore, we would like your visa request must be confirmed via email to make sure we all understand correctly regarding your visa request & we will responsible for what we confirm you via email.</p>
					<p>Don't worry if you want to get your via on Sat or Sun or public holiday. We know how.</p>
				</div>
			</div>
			<div class="col-lg-3 col-sm-4 d-none d-sm-none d-md-block">
				<? require_once(APPPATH."views/module/support.php"); ?>
				<? require_once(APPPATH."views/module/confidence.php"); ?>
				<? require_once(APPPATH."views/module/services.php"); ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".btn-submit").click(function() {
		var err = 0;
		var msg = new Array();
		if ($("#fullname").val() == "") {
			$("#fullname").addClass("error");
			msg.push("Your name is required.");
			err++;
		} else {
			$("#fullname").removeClass("error");
		}
		
		if ($("#email").val() == "") {
			$("#email").addClass("error");
			msg.push("Your email is required.");
			err++;
		} else {
			$("#email").removeClass("error");
		}
		
		if ($("#passport").val() == "") {
			$("#passport").addClass("error");
			msg.push("Passport number is required.");
			err++;
		} else {
			$("#passport").removeClass("error");
		}

		if ($("#message").val() == "") {
			$("#message").addClass("error");
			msg.push("Please give us your message.");
			err++;
		} else {
			$("#message").removeClass("error");
		}
		
		if ($("#security_code").val() == "" || $("#security_code").val().toUpperCase() != $(".security-code").html().toUpperCase()) {
			$("#security_code").addClass("error");
			msg.push("Captcha code does not matched.");
			err++;
		} else {
			$("#security_code").removeClass("error");
		}
		
		if (err == 0) {
			return true;
		}
		else {
			showErrorMessage(msg);
			return false;
		}
	});
});
</script>