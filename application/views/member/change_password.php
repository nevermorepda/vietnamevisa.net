<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>member.css" />

<div class="container">
	<div class="info-bar">
		<h1><span class="glyphicon glyphicon-user"></span> <?=$this->session->userdata('user')->user_fullname?> <span class="right-panel"><a href="<?=site_url("member/logout")?>"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></span></h1>
	</div>
	<div class="myaccount">
		<? require_once(APPPATH."views/member/nav_bar.php"); ?>
		<div class="panel-account">
			<div class="detail">
				<form method="post" action="<?=site_url("member/change-password")?>">
					<? if ($this->session->flashdata("status")) {?>
					<div class="alert alert-danger" role="alert"><?=$this->session->flashdata("status")?></div>
					<? } ?>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Current Password <span class="required">*</span></label>
							<input type="password" class="form-control" value="" name="current_pwd" required/>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>New Password <span class="required">*</span></label>
							<input type="password" class="form-control" value="" name="new_pwd" required/>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Confirm New Password <span class="required">*</span></label>
							<input type="password" class="form-control" value="" name="re_new_pwd" required/>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<button class="btn btn-danger" type="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
