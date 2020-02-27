<?
	$admin = $this->session->userdata("admin");
	$method = $this->util->slug($this->router->fetch_method());
	
	$category_info = new stdClass();
	$category_info->parent_id = 0;
	$content_categories = $this->m_category->items($category_info);
	
	$info = new stdClass();
	$info->user_types = array(USR_SUPPER_ADMIN, USR_ADMIN);
	$user_onlines = $this->m_user->users($info);
	
	$arrival_ports = $this->m_arrival_port_category->items();
	$ports = $this->m_arrival_port->items();
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);

	$tour_categories = $this->m_category_tour->items();
?>
<div class="header">
	<div class="header-top">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse" aria-expanded="false">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<div class="clearfix">
							<div class="pull-left">
								<span class="header-sitename"><?=SITE_NAME?></span><br>
								<span class="header-title">Administration</span>
							</div>
							<div class="pull-left">
								<span class="caret"></span>
							</div>
						</div>
					</a>
					<ul class="dropdown-menu">
						<li><a target="_blank" href="https://www.vietnam-evisa.org/syslog.html">Vietnam-Evisa.Org</a></li>
						<li><a target="_blank" href="http://www.vietnamvisateam.com/syslog.html">VietnamVisaTeam.Com</a></li>
						<li><a target="_blank" href="https://www.visa-vietnam.org.vn/syslog.html">Visa-Vietnam.Org.Vn</a></li>
						<li><a target="_blank" href="http://www.vietnam-immigration.net/syslog.html">Vietnam-Immigration.Net</a></li>
						<li><a target="_blank" href="http://www.vietnam-immigration.org.vn/syslog.html">Vietnam-Immigration.Org.Vn</a></li>
					</ul>
				</div>
				<div class="collapse navbar-collapse" id="bs-navbar-collapse">
					<ul class="nav navbar-nav">
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<li class="<?=(($method=='users')?'active':'')?>"><a href="<?=site_url("syslog/users")?>">Users</a></li>
						<? } ?>
						<li class="dropdown <?=((in_array($method, array('content', 'content-categories')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content <span class="caret"></span></a>
							<ul class="dropdown-menu multi-level">
								<li><a href="<?=site_url("syslog/content-categories")?>">Content Categories</a></li>
								<li role="separator" class="divider"></li>
								<? gen_category_menu($content_categories, $this); ?>
								<li role="separator" class="divider"></li>
								<li class="clearfix"><a href="<?=site_url("syslog/questions")?>">Q&A</a></li>
								<li class="clearfix"><a href="<?=site_url("syslog/reviews")?>">Reviews</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/nations")?>">Nations</a></li>
								<li><a href="<?=site_url("syslog/provinces")?>">Provinces</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/requirements")?>">Vietnam Visa Requirements</a></li>
								<li><a href="<?=site_url("syslog/embassies")?>">Vietnam Embassy Worldwide</a></li>
								<li><a href="<?=site_url("syslog/guide")?>">Vietnam Visa Guide</a></li>
							</ul>
						</li>
						<li class="dropdown <?=((in_array($method, array('tour', 'tour-categories')))?'active':'')?>">
							<a href="<?=site_url("syslog/tour")?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tour <span class="caret"></span></a>
							<ul class="dropdown-menu multi-level">
								<li><a href="<?=site_url("syslog/tour-categories")?>">Tour Categories</a></li>
								<li role="separator" class="divider"></li>
								<? foreach($tour_categories as $tour_category) { ?>
								<li><a href="<?=site_url("syslog/tour/{$tour_category->id}")?>"><?=$tour_category->name?></a></li>
								<? } ?>
							</ul>
						</li><? if (in_array($this->session->userdata('admin')->id, $admin_id)) { ?>
						<li class="<?=(($method=='agents')?'active':'')?>">
							<a href="<?=site_url("syslog/agents")?>" class="dropdown-toggle" >Agents <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/visa-approved-list")?>">Visa approved list</a></li>
								<li><a href="<?=site_url("syslog/visa-fc-list")?>">Visa fc list</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/send-urgent-mail")?>">Send urgent mail</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/debt-approved-list")?>">Debt approved list</a></li>
								<li><a href="<?=site_url("syslog/debt-fc-list")?>">Debt fc list</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/agents-visa-fees")?>">Vietnam Visa Fees</a></li>
								<li><a href="<?=site_url("syslog/agents-processing-fees")?>">Processing Fees</a></li>
								<li><a href="<?=site_url("syslog/agents-private-letter-fees")?>">Private Letter Fees</a></li>
								<li><a href="<?=site_url("syslog/agents-fast-checkin-fees")?>">Fast Check-in Fees</a></li>
								<li><a href="<?=site_url("syslog/agents-car-fees")?>">Car Fees</a></li>
							</ul>
						</li>
						<? } ?>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<li class="dropdown <?=((in_array($method, array('arrival-ports', 'visa-types', 'visit-purposes')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/passport-types")?>">Passport Types</a></li>
								<li><a href="<?=site_url("syslog/visa-types")?>">Visa Types</a></li>
								<li><a href="<?=site_url("syslog/visit-purposes")?>">Visit Purposes</a></li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Arrival Ports</a>
									<ul class="dropdown-menu">
										<? foreach ($arrival_ports as $arrival_port) { ?>
										<li>
											<a href="<?=site_url("syslog/arrival-ports/{$arrival_port->id}")?>"><?=$arrival_port->name?></a>
										</li>
										<? } ?>
									</ul>
								</li>
							</ul>
						</li>
						<? } ?>
						<li class="dropdown <?=((in_array($method, array('visa-fees', 'processing-fees', 'private-letter-fees', 'car-fees', 'fast-checkin-fees', 'visa-extension-fees')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pricing <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/visa-fees")?>">Vietnam Visa Fees</a></li>
								<li><a href="<?=site_url("syslog/processing-fees")?>">Processing Fees</a></li>
								<li><a href="<?=site_url("syslog/private-letter-fees")?>">Private Letter Fees</a></li>
								<li><a href="<?=site_url("syslog/car-fees")?>">Car Fees</a></li>
								<li><a href="<?=site_url("syslog/fast-checkin-fees")?>">Fast Check-in Fees</a></li>
								<li><a href="<?=site_url("syslog/car-plus-fees")?>">Car Plus Fees</a></li>
							</ul>
						</li>
						<li class="dropdown <?=((in_array($method, array('visa-booking', 'service-booking', 'payment-online', 'payment-report', 'check-list')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/visa-booking")?>">Visa Booking</a></li>
								<li><a href="<?=site_url("syslog/service-booking")?>">Service Booking</a></li>
								<li><a href="<?=site_url("syslog/tour-booking")?>">Tour Booking</a></li>
								<li><a href="<?=site_url("syslog/payment-online")?>">Payment Online</a></li>
								<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
								<li><a href="<?=site_url("syslog/payment-report")?>">Payment Report</a></li>
								<? } ?>
								<? if ($admin->user_type == USR_SUPPER_ADMIN || $admin->user_email == "T25121995@gmail.com") { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/unpaid-list")?>" class="text-color-red">Unpaid List</a></li>
								<? } ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/export-list")?>">Check List</a></li>
								<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?=site_url("syslog/check-step")?>">Check step</a></li>
								<? } ?>
								<li role="separator" class="divider"></li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Deny</a>
									<ul class="dropdown-menu">
										<li><a href="<?=site_url("syslog/deny-passports")?>">Deny Passports</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class="dropdown <?=((in_array($method, array('promotion-codes', 'promotion-templates')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promotion <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/promotion-codes")?>">Promotion Codes</a></li>
								<li><a href="<?=site_url("syslog/promotion-booking")?>">Promotion Booking</a></li>
							</ul>
						</li>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<li class="dropdown <?=((in_array($method, array('page-meta-tags', 'page-redirects')))?'active':'')?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SEO <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/page-meta-tags")?>">Page Meta Tags</a></li>
								<li><a href="<?=site_url("syslog/page-redirects")?>">Page Redirects</a></li>
							</ul>
						</li>
						<? } ?>
						<li class="<?=(($method=='mail')?'active':'')?>"><a href="<?=site_url("syslog/mail")?>">Mail</a></li>
						<li class="<?=(($method=='comment')?'active':'')?>"><a href="<?=site_url("syslog/comment")?>">Comments</a></li>
						<? if ($this->session->userdata('admin')->id == 8060) { ?>
						<li class="<?=(($method=='test-camera')?'active':'')?>"><a href="<?=site_url("syslog/test-camera")?>">Test mail</a></li>
						<? } ?>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<li class="<?=(($method=='review-audio')?'active':'')?>"><a href="<?=site_url("syslog/review-audio")?>">Review Audio</a></li>
						<li class="<?=(($method=='scheduler')?'active':'')?>"><a href="<?=site_url("syslog/scheduler")?>">Scheduler</a></li>
						<li class="<?=(($method=='holiday')?'active':'')?>"><a href="<?=site_url("syslog/holiday")?>">Holiday</a></li>
						<li class="<?=(($method=='history')?'active':'')?>"><a href="<?=site_url("syslog/history")?>">History</a></li>
						<li class="<?=(($method=='export-mail-booking')?'active':'')?>"><a href="<?=site_url("syslog/export-mail-booking")?>">Export mail</a></li>
						<li class="<?=(($method=='mail-remind')?'active':'')?>"><a href="<?=site_url("syslog/mail-remind")?>">Mail remind</a></li>
						<li class="<?=(($method=='settings')?'active':'')?>"><a href="<?=site_url("syslog/settings")?>">Settings</a></li>
						<? } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" class="navbar-link" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$this->session->admin->user_fullname?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url("syslog/logout")?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
							</ul>
						</li>
						<?
							foreach ($user_onlines as $user_online) {
								if (($user_online->id != $this->session->admin->id) && (date($this->config->item("log_date_format"), strtotime($user_online->last_activity)) >= date($this->config->item("log_date_format"), strtotime("-30 minutes")))) {
						?>
						<li>
							<a href="#" title="<?=$user_online->user_fullname?>">
								<? if (!empty($user_online->avatar)) { ?>
								<img class="img-circle" src="<?=$user_online->avatar?>" width="20px">
								<? } else { ?>
								<img class="img-circle" src="<?=IMG_URL?>no-avatar.gif" width="20px">
								<? } ?>
								<? if (date($this->config->item("log_date_format"), strtotime($user_online->last_activity)) >= date($this->config->item("log_date_format"), strtotime("-10 minutes"))) { ?>
								<sup style="margin-left: -6px;"><i class="fa fa-circle" style="color: #5cb85c;"></i></sup>
								<? } else if (date($this->config->item("log_date_format"), strtotime($user_online->last_activity)) >= date($this->config->item("log_date_format"), strtotime("-20 minutes"))) { ?>
								<sup style="margin-left: -6px;"><i class="fa fa-circle" style="color: orange;"></i></sup>
								<? } else { ?>
								<sup style="margin-left: -6px;"><i class="fa fa-circle" style="color: #afafaf;"></i></sup>
								<? } ?>
							</a>
						</li>
						<?
								}
							}
						?>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</div>
<?// if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
<?
	// $info = new stdClass();
	// $info->sortby			= 'id';
	// $info->orderby			= 'DESC';
	// $notify_item = $this->m_visa_booking->bookings($info,1);
?>
<!-- <div id="get_notify_booking" val="<?//=$notify_item[0]->id?>" style="display: none"></div> -->
<script type="text/javascript">
	// setInterval(function(){
	// 	$.ajax({
	// 		url: '<?//=site_url('syslog/real-time-notify-booking')?>',
	// 		type: 'post',
	// 		dataType: 'json',
	// 		success:function(result){
	// 			var count = result.length;
	// 			for (var i = 0; i < count; i++) {
	// 				if (result[i].id > parseInt($('#get_notify_booking').attr('val'))) {
	// 					$('#get_notify_booking').attr('val',result[i].id);
	// 					notifyme('BookingID : VISA'+result[i].id);
	// 				}
	// 			}
	// 		}
	// 	});
	// },10000);
	// function notifyme(title,link=null){
	// 	if (Notification.permission !== "granted")
	// 		Notification.requestPermission();
	// 	else {
	// 		var notification = new Notification('You have new book', {
	// 			icon: '<?//=IMG_URL?>logo-120x120.jpg',
	// 			body: title,
	// 		});
	// 		if (link != null) {
	// 			notification.onclick = function () {
	// 				window.open(link);
	// 				notification.close();
	// 			};
	// 		}
	// 	}
	// }
</script>
<?// } ?>
<?
	function gen_category_menu($categories, $obj) {
		foreach ($categories as $category) {
			$child_category_info = new stdClass();
			$child_category_info->parent_id = $category->id;
			$child_categories = $obj->m_category->items($child_category_info);
			if (!empty($child_categories)) {
				echo '<li class="dropdown-submenu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$category->name.'</a>
						<ul class="dropdown-menu">';
						gen_category_menu($child_categories, $obj);
				echo '	</ul>
					</li>';
			} else {
				echo '<li><a href="'.site_url("syslog/content/{$category->alias}").'">'.$category->name.'</a></li>';
			}
		}
	}
?>
