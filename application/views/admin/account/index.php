<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);
?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Users
				<div class="pull-right hidden">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Block</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Unblock</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
					</ul>
				</div>
				<div class="pull-right" style="max-width: 250px;">
					<div class="input-group input-group-sm">
						<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for user">
						<span class="input-group-btn">
							<button class="btn btn-default btn-search" type="button">Search</button>
						</span>
					</div>
				</div>
				<div class="pull-right" style="margin-right: 5px;">
					<div class="input-group input-group-sm">
						<select id="user_level" name="user_level" class="form-control">
							<option value="<?=site_url('syslog/users')?>">All level</option>
							<option value="<?=site_url('syslog/users')?>?level=vip">Vip</option>
							<option value="<?=site_url('syslog/users')?>?level=diamond">Diamond</option>
							<option value="<?=site_url('syslog/users')?>?level=gold">Gold</option>
							<option value="<?=site_url('syslog/users')?>?level=silver">Silver</option>
						</select>
						<script type="text/javascript">
							$('#user_level').change(function(event) {
								window.location.href = $(this).val();
							});
						</script>
						<script>$("#user_level").val('<?=($_GET['level']) ? site_url('syslog/users').'?level='.$_GET['level'] : site_url('syslog/users')?>');</script>
					</div>
				</div>
			</h1>
			<?
				$info = new stdClass();
				$info->level = array(1999);
				$count_vip = $this->m_user->count($info);

				$info = new stdClass();
				$info->level = array(499, 2000);
				$count_diamond = $this->m_user->count($info);

				$info = new stdClass();
				$info->level = array(199, 500);
				$count_gold = $this->m_user->count($info);

				$info = new stdClass();
				$info->level = array(99, 200);
				$count_silver = $this->m_user->count($info);

				$info = new stdClass();
				$info->level = array(-1, 100);
				$count_normal = $this->m_user->count($info);
			?>
			<div class="statement-bar clearfix">
			<div class="payment-statement pull-left">
				<div class="title">VIP</div>
				<div class="number"><?=$count_vip?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Diamond</div>
				<div class="number"><?=$count_diamond?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Gold</div>
				<div class="number"><?=$count_gold?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Silver</div>
				<div class="number"><?=$count_silver?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Normal</div>
				<div class="number"><?=$count_normal?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">&nbsp;</div>
				<div class="number">=</div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Total users</div>
				<div class="number"><?=($count_vip + $count_diamond + $count_gold + $count_silver + $count_normal)?></div>
			</div>
		</div>
		</div>
		<? if (empty($users) || !sizeof($users)) { ?>
		<p class="help-block">No user found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<table class="table table-bordered table-hover">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($users)?>');" />
					</th>
					<th class="text-center" width="30px">IP</th>
					<th class="text-center" width="30px"></th>
					<th class="text-center" width="30px"></th>
					<th>Full name</th>
					<th class="text-center">Level</th>
					<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
					<th>Email</th>
					<? } ?>
					<th class="text-right" width="80px">Join date</th>
				</tr>
				<?
					$i = 0;
					foreach ($users as $user) {
				?>
				<tr class="row<?=$user->active?>">
					<td class="text-center">
						<?=($i + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
					</td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$user->id?>" onclick="isChecked(this.checked);">
					</td>
					<td class="text-center">
						<? if (!empty($user->client_ip)) {
							$pieces = explode(",", $user->client_ip);
							$user->client_ip = trim($pieces[0]);
							if (!empty($pieces[1])) {
								$user->client_ip = trim($pieces[1]);
							}
							$country_code = $loc->lookup($user->client_ip, IP2Location::COUNTRY_CODE);
							$country_name = $loc->lookup($user->client_ip, IP2Location::COUNTRY_NAME);
							$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
							if ($country_code == '-') {
								$country_flag = ADMIN_IMG_URL.'flags/default.png';
							}
						?>
						<a target="_blank" href="http://whatismyipaddress.com/ip/<?=$user->client_ip?>">
							<img src="<?=$country_flag?>" alt="<?=$country_name?>" title="<?=$country_name?>" />
						</a>
						<? } ?>
					</td>
					<td class="text-center"><span class="icon-account-type icon-<?=$user->provider?>"></span></td>
					<td class="text-center"><span class="icon-account-type icon-type-<?=$user->user_type?>"></span></td>
					<td>
						<a target="_blank" href="<?=site_url("syslog/users/signin/{$user->id}")?>"><?=$user->user_fullname?></a>
						<? if (!($user->user_type == USR_SUPPER_ADMIN && $this->session->userdata("admin")->user_type != USR_SUPPER_ADMIN)) { ?>
						<ul class="action-icon-list">
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($user->active) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Block</a></li>
							<? } else { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Unblock</a></li>
							<? } ?>
							<li><a target="_blank" href="<?=site_url("syslog/users/signin/{$user->id}")?>"><i class="fa fa-user" aria-hidden="true"></i> Manage</a></li>
						</ul>
						<? } ?>
					</td>
					<td class="text-center"><?=$this->util->level_account($user->id)[1]?></td>
					<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
					<td>
						<?=$user->user_email?>
					</td>
					<? } ?>
					<td class="text-right">
						<?=date("Y-m-d", strtotime($user->user_registered))?><br>
						<?=date("H:i:s", strtotime($user->user_registered))?>
					</td>
				</tr>
				<?
						$i++;
					}
				?>
			</table>
			<div><?=$pagination?></div>
		</form>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".btn-publish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("publish");
		}
	});
	$(".btn-unpublish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unpublish");
		}
	});
	$(".btn-delete").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to delete.");
		}
		else {
			confirmBox("Delete items", "Are you sure you want to delete the selected items?", "submitButton", "delete");
		}
	});
	$(".btn-search").click(function(){
		$("#search_text").val($("#report_text").val());
		submitButton("search");
	});
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
});
</script>