<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Company Details</h1>
		<table class="table table-bordered">
			<tr>
				<td class="table-head text-right" width="10%">Name</td>
				<td><?=$setting->company_name?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Address</td>
				<td><?=$setting->company_address?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Email</td>
				<td><?=$setting->company_email?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Hotline [VN]</td>
				<td><?=$setting->company_hotline_vn?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Hotline [AU]</td>
				<td><?=$setting->company_hotline_au?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Hotline [US]</td>
				<td><?=$setting->company_hotline_us?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Tollfree</td>
				<td><?=$setting->company_tollfree?></td>
			</tr>
		</table>
		<h1 class="page-title">Social Links</h1>
		<table class="table table-bordered">
			<tr>
				<td class="table-head text-right" width="10%">Facebook</td>
				<td><?=$setting->facebook_url?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Google+</td>
				<td><?=$setting->googleplus_url?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Twitter</td>
				<td><?=$setting->twitter_url?></td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Youtube</td>
				<td><?=$setting->youtube_url?></td>
			</tr>
		</table>
		<h1 class="page-title">Ban List</h1>
		<table class="table table-bordered ban-list">
			<tr>
				<td class="table-head text-right" width="10%">IP</td>
				<td>
					<?
						$ip_list = explode(',',$setting->ban_ip);
						foreach ($ip_list as $value) {
							echo '<span class="item">'.$value.'</span>';
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Name</td>
				<td>
					<?
						$name_list = explode(',',$setting->ban_name);
						foreach ($name_list as $value) {
							echo '<span class="item">'.$value.'</span>';
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Email</td>
				<td>
					<?
						$email_list = explode(',',$setting->ban_email);
						foreach ($email_list as $value) {
							echo '<span class="item">'.$value.'</span>';
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="table-head text-right" width="10%">Passport</td>
				<td>
					<?
						$passport_list = explode(',',$setting->ban_passport);
						foreach ($passport_list as $value) {
							echo '<span class="item">'.$value.'</span>';
						}
					?>
				</td>
			</tr>
		</table>
		<div>
			<a class="btn btn-sm btn-primary btn-edit" href="<?=site_url("syslog/settings/edit")?>">Edit</a>
		</div>
	</div>
</div>
