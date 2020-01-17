<div class="container">
	<form id="frmSignUp" name="frmSignUp" class="form-horizontal" role="form" action="<?=site_url("member/dologin")?>" method="POST">
		<div class="col-sm-8 col-md-8" style="padding-left: 0px !important;">
			<div style="margin: 0px auto">
				<h2>Forgotten Password</h2>
				<p>If you have forgotten the username and password to your account, simply enter a email you have registered with us and click the "Get Password" button. We will send an email to your mail inbox that contains information on how to change the password.</p>
			</div>
			<div style="margin: 20px auto">
				<h4>Please enter your email</h4>
				<div class="form-group">
					<div class="col-xs-7 col-sm-8 col-md-8">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" />
					</div>
					<div class="col-xs-5 col-sm-4 col-md-4">
						<button type="button" class="btn btn-danger" id="btn-getpass">Get Password</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4" style="padding: 15px; border: 1px solid #DDDDDD; border-radius: 4px;">
			<div style="margin: auto">
				<h4>Lost Password Tutorial</h4>
				<p>Please follow by these steps to get your password again...</p>
				<ul style="list-style: decimal">
					<li>Enter your email in the form and click "Get Password" button.</li>
					<li>Check your mail inbox, remember our email can sent to your junk or spam mail. Click on the verification link.</li>
					<li>Input a new password for your account.</li>
					<li>Login again with your new password. Enjoy!</li>
				</ul>
			</div>
		</div>
		<input type="hidden" id="task" name="task" value="" />
	</form><!-- end frmSignUp -->
</div><!-- end .container -->

<div class="clr"></div>

<script>
$(document).ready(function() {
	<? if ($this->session->flashdata("status")) { ?>
		messageBox("ERROR", "Error", '<?=$this->session->flashdata("status")?>');
	<? } ?>
	$("#btn-getpass").click(function() {
		var err = 0;
		var msg = [];

		if ($("#email").val() == "") {
			$("#email").addClass("error");
			err++;
			msg.push("Email is required.");
		} else {
			$("#email").removeClass("error");
		}

		if (!err) {
			$("#task").val("getpass");
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
</script>