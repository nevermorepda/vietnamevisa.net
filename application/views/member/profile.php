<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>member.css" />

<div class="container">
	<div class="info-bar">
		<h1><span class="glyphicon glyphicon-user"></span> <?=$this->session->userdata("user")->user_fullname?> <span class="right-panel"><a href="<?=site_url("member/logout")?>"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></span></h1>
	</div>
	<div class="myaccount">
		<? require_once(APPPATH."views/member/nav_bar.php"); ?>
		<div class="panel-account">
			<div class="detail">
				<form method="post" action="<?=site_url("member/profile")?>">
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Full name <span class="required">*</span></label>
							<input type="text" class="form-control" value="<?=$user->user_fullname?>" name="fullname" required/>
						</div>
					</div>
					<? if (!empty($user->user_email)) { ?>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Email:</label>
							<label><b><?=$user->user_email?></b></label>
						</div>
					</div>
					<? } ?>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Phone <span class="required">*</span></label>
							<input type="text" class="form-control" value="<?=$user->phone?>" name="phone" required/>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Address</label>
							<input type="text" class="form-control" value="<?=$user->address?>" name="address" />
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<label>Country</label>
							<select class="form-control" id="country" name="country">
								<? foreach($nations as $nation) {
									echo "<option value='{$nation->name}'>{$nation->name}</option>";
								} ?>
							</select>
							<script> $('#country').val('<?=$user->country?>'); </script>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-sm-4">
							<button class="btn btn-danger" type="submit">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
