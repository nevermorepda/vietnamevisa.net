<?
	$data = null;
	if ($this->session->flashdata('login')) {	
		$data = $this->session->flashdata('login');
	}
	$email					= (!empty($data->email) ? $data->email : "");
	$new_title				= (!empty($data->new_title) ? $data->new_title : "Mr");
	$new_fullname			= (!empty($data->new_fullname) ? $data->new_fullname : "");
	$new_email				= (!empty($data->new_email) ? $data->new_email : "");
	$new_password			= (!empty($data->new_password) ? $data->new_password : "");
	$new_confirm_password	= (!empty($data->new_confirm_password) ? $data->new_confirm_password : "");
	$new_phone				= (!empty($data->new_phone) ? $data->new_phone : "");
?>
<div class="container">
	<!-- breadcrumb -->
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	<!-- end breadcrumb -->
	
	<? if (!empty($agent) && (strtoupper($agent) == "SAFARI")) { ?>
	<div class="alert alert-success d-none d-sm-none d-md-block" role="alert">Please try with Google Chrome or Mozilla Firefox if you are using Safari browser and cannot Sign In / Sign Up with us.</div>
	<? } ?>
	
	<div class="">
		<div class="login-form">
			<form id="frmSignUp" name="frmSignUp" class="form-horizontal" role="form" action="<?=site_url("member/dologin")?>" method="POST">
				<div class="row">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div>
							<h4 class="text-left">I am a returning customer</h4>
							<div class="">
								<div class="row form-group">
									<div class="col-md-4"></div>
									<div class="col-md-8">
										<h1 class="text-left">Sign In</h1>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label" for="email">Registered email <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" name="email" id="email" class="form-control" value="<?=$email?>" placeholder="Enter email"/>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label" for="password">Password <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4"></div>
									<div class="col-md-8 clearfix">
										<a href="<?=site_url('member/lostpass')?>">Forgot your password?</a>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4"></div>
									<div class="col-md-8 clearfix">
										<!-- <button type="button" id="btn-login" class="btn btn-danger">LOG IN & CONTINUE <i class="icon-double-angle-right icon-large"></i></button> -->
										<div class="show-button">
											<button type="button" id="btn-login" class="btn btn-general" href="">LOG IN & CONTINUE <i class="icon-double-angle-right icon-large"></i></button>
											<div class="bg-btn transition" style="width: 100%;"></div>
										</div>
									</div>
								</div>
							</div>
							<!--/#sign-in -->
							<!-- <div class="" style="margin-top: 60px;">
								<div class="form-group">
									<div class="col-md-4">
										<label class="control-label">OR Signin with</label>
									</div>
									<div class="col-md-8">
										<div class="">
											<a class="btn btn-block btn-social btn-facebook" onclick="facebookLogin('<?=site_url("auth/socialLogin")?>','<?=site_url("member")?>')">
												<i class="icon-facebook"></i> Sign in with Facebook
											</a>
										</div>
										<div class="hidden" style="margin-top: 10px">
											<a id="google-login" class="btn btn-block btn-social btn-google-plus">
												<i class="icon-google-plus"></i> Sign in with Google+
											</a>
										</div>
									</div>
								</div>
							</div> -->
						</div>
					</div>
					<div class="switcher col-md-2 col-sm-2 d-none d-sm-block">
						<div class="switch-line"></div>
						<div class="switch-icon"></div>
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div>
							<h4 class="text-left">I am a new customer</h4>
							<div class="">
								<div class="row form-group">
									<div class="col-md-4"></div>
									<div class="col-md-8">
										<h1 class="text-left">Sign Up</h1>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label">Full name <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-xs-4 col-sm-4 col-md-4">
												<select class="form-control" id="new_title" name="new_title">
													<option value="Mr">Mr</option>
													<option value="Ms">Ms</option>
													<option value="Mrs">Mrs</option>
												</select>
												<script> $("#new_title").val('<?=$new_title?>'); </script>
											</div>
											<div class="col-xs-8 col-sm-8 col-md-8" style="padding-left: 0">
												<input type="text" class="form-control" id="new_fullname" name="new_fullname" value="<?=$new_fullname?>" placeholder="Full name" />
											</div>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label">Email <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="new_email" name="new_email" value="<?=$new_email?>" placeholder="Email" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label">Phone <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="new_phone" name="new_phone" class="form-control" value="<?=$new_phone?>" placeholder="Phone number" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label class="control-label">Password <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="password" class="form-control" id="new_password" name="new_password" value="<?=$new_password?>" placeholder="Password" />
										<span class="help-block">
											<i>Password must be at least 6 characters in long.</i>
										</span>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4" style="padding-right: 0">
										<label class="control-label">Confirm password <span class="red">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="password" class="form-control" id="new_confirm_password" name="new_confirm_password" value="<?=$new_confirm_password?>" placeholder="Enter your password again"/>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4"></div>
									<div class="col-md-8">
										<!-- <button type="button" class="btn btn-danger" id="btn-signup" value="CONTINUE">CREATE ACCOUNT <i class="icon-double-angle-right icon-large"></i></button> -->
										<div class="show-button">
											<button type="button" id="btn-signup" class="btn btn-general" value="CONTINUE">CREATE ACCOUNT <i class="icon-double-angle-right icon-large"></i></button>
											<div class="bg-btn transition" style="width: 100%;"></div>
										</div>
									</div>
								</div>
							</div><!--/#sign-up -->
						</div>
					</div>
				</div>
				<input type="hidden" id="task" name="task" value="" />
			</form>
		</div>
	</div>
</div>

<div id="fb-root"></div>

<script type="text/javascript" src="<?=JS_URL?>facebook.js"></script>
<script type="text/javascript" src="<?=JS_URL?>google-plus.js"></script>

<? if ($this->session->flashdata("status")) { ?>
<script>
$(document).ready(function() {
	messageBox("ERROR", "Error", "<?=$this->session->flashdata("status")?>");
});
</script>
<? } ?>

<script>
$(document).ready(function() {
	$("#btn-login").click(function() {
		var err = 0;
		var msg = [];

		clearFormError();

		if ($("#email").val() == "") {
			$("#email").addClass("error");
			err++;
			msg.push("Please input your email.");
		} else {
			$("#email").removeClass("error");
		}

		if ($("#password").val() == "") {
			$("#password").addClass("error");
			err++;
			msg.push("Please input your password.");
		} else {
			$("#password").removeClass("error");
		}

		if (!err) {
			$("#task").val("login");
			$("#frmSignUp").submit();
		} else {
			var errmsg = "<p>Your information containning errors. Please review and correct the field(s) marked in red.</p>";
			errmsg += "<ul>";
			for (var i=0; i<msg.length; i++) {
				errmsg += "<li>"+msg[i]+"</li>";
			}
			errmsg += "</ul>";
			messageBox("ERROR", "Error", errmsg);
		}
	});
	
	$('#btn-signup').click(function() {
		var err = 0;
		var msg = [];

		clearFormError();
		
		if ($("#new_fullname").val() == "") {
			$("#new_fullname").addClass("error");
			err++;
			msg.push("Your name is required.");
		} else {
			$("#new_fullname").removeClass("error");
		}

		if ($("#new_email").val() == "") {
			$("#new_email").addClass("error");
			err++;
			msg.push("Your email is required.");
		} else if (checkEmailExisted($("#new_email").val())) {
			$("#new_email").addClass("error");
			err++;
			msg.push("Your email already in used. Please use another email.");
		} else {
			$("#new_email").removeClass("error");
		}

		if ($("#new_phone").val() == "") {
			$("#new_phone").addClass("error");
			err++;
			msg.push("Phone number is required.");
		} else {
			$("#new_phone").removeClass("error");
		}

		if ($("#new_password").val() == "") {
			$("#new_password").addClass("error");
			err++;
			msg.push("Password is required.");
		} else if ($("#new_password").val().length < 6) {
			$("#new_password").addClass("error");
			err++;
			msg.push("Password must be at least 6 characters in long.");
		} else {
			$("#new_password").removeClass("error");
		}

		if ($("#new_confirm_password").val() == "") {
			$("#new_confirm_password").addClass("error");
			err++;
			msg.push("Password confirmation is required.");
		} else if ($("#new_confirm_password").val() != $("#new_password").val()) {
			$("#new_confirm_password").addClass("error");
			err++;
			msg.push("Password confirmation is not matched.");
		} else {
			$("#new_confirm_password").removeClass("error");
		}
		
		if (!err) {
			$("#task").val("register");
			$("#frmSignUp").submit();
		} else {
			var errmsg = "<p>Your information containning errors. Please review and correct the field(s) marked in red.</p>";
			errmsg += "<ul>";
			for (var i=0; i<msg.length; i++) {
				errmsg += "<li>"+msg[i]+"</li>";
			}
			errmsg += "</ul>";
			messageBox("ERROR", "Error", errmsg);
		}
	});
});

function checkEmailExisted(email)
{
	var result = false;
	$.ajax({
		type : 'POST',
		data : { email: email },
		url : "<?=site_url('member/check_email_existed')?>",
		success : function(data){
			result = data;
		},
		async:false
	});
	return result;
}

</script>
<script>
	$(document).ready(function() {
		$('.btn').mouseenter(function() {
			$(this).parent().find('.bg-btn').css({'top':'0px','left':'0px'});
		});
		$('.btn').mouseleave(function() {
			$(this).parent().find('.bg-btn').css({'top':'10px','left':'10px'});
		});
	});
</script>
