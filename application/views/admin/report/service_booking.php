<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
	
	$admin = $this->session->userdata("admin");
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);
?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Service Bookings
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for application ID">
							</div>
						</div>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<div class="pull-left" style="max-width: 220px;">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control daterange">
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Report</button>
								</span>
							</div>
						</div>
						<? } else { ?>
						<div class="pull-left">
							<button class="btn btn-sm btn-default btn-report" type="button">Report</button>
						</div>
						<? } ?>
					</div>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/service-booking")?>" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="sortby" name="sortby" value="<?=$sortby?>" />
			<input type="hidden" id="orderby" name="orderby" value="<?=$orderby?>" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<? if (empty($items) || !sizeof($items)) { ?>
			<p class="help-block">No booking found.</p>
			<? } else { ?>
			<p></p>
			<? if ($admin->user_type == USR_SUPPER_ADMIN || ($task == "search" && $edited_search_text != "")) { ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<tr>
						<th class="text-center" width="5">
							#
						</th>
						<th class="text-center">
							IP			
						</th>
						<th width="80">
							Date
						</th>
						<th>
							ID
						</th>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<th>
							Email
						</th>
						<? } ?>
						<th class="text-center">
							Payment
						</th>
						<th class="text-center">
							Capital
						</th>
						<th class="text-center">
							Refund
						</th>
						<th class="text-center">
							Total
						</th>
						<th class="text-center">
							Payment
						</th>
						<th class="text-center" nowrap>
							Other Payment
						</th>
						<th class="text-center">
							Status
						</th>
					</tr>
					<?
						if (!empty($items) && sizeof($items)) {
							$idx = 1;
							foreach ($items as $item) {
							?>
								<tr>
									<td width="2%" class="text-center">
										<?=$idx + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
									</td>
									<td width="2%" class="text-center">
										<? if (!empty($item->client_ip)) {
											$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
											$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
											$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
											if ($country_code == '-') {
												$country_flag = ADMIN_IMG_URL.'flags/default.png';
											}
										?>
										<a target="_blank" href="http://whatismyipaddress.com/ip/<?=$item->client_ip?>">
											<img src="<?=$country_flag?>" alt="<?=$country_name?>" title="<?=$country_name?>" />
										</a>
										<? } ?>
									</td>
									<td class="text-right">
										<?=date("Y-m-d", strtotime($item->booking_date))?><br>
										<?=date("H:i:s", strtotime($item->booking_date))?>
									</td>
									<td width="80px">
										<a class="collapsed" data-toggle="collapse" href="<?="#".$item->id?>" aria-expanded="false" aria-controls="collapse<?=$item->id?>"><?=BOOKING_PREFIX_EX.$item->id?></a>
									</td>
									<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
									<td>
										<?=$item->primary_email?>
									</td>
									<? } ?>
									<td width="4%" class="text-center">
										<?
											switch ($item->payment_method) {
												case 'Paypal': echo 'PP'; break;
												case 'OnePay': echo 'OP'; break;
												case 'Credit Card': echo 'CC'; break;
												case 'Bank Transfer': echo 'BT'; break;
												case 'Western Union': echo 'WU'; break;
												default: echo ''; break;
											}
										?>
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="capital" name="capital" value="<?=($item->capital ? $item->capital : "")?>" booking-id="<?=$item->id?>" style="background-color: #F0F0F0; width: 20px; text-align: right; border: none;">
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="refund" name="refund" value="<?=($item->refund ? $item->refund : "")?>" booking-id="<?=$item->id?>" style="background-color: #F0F0F0; width: 20px; text-align: right; border: none;">
									</td>
									<td width="3%" align="right">
										$<?=$item->total_fee?>
									</td>
									<td width="3%" align="right">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-payment-status-<?=$item->id?>" data-toggle="dropdown">
												<? if ($item->status) { ?>
												<span class="label label-success">Paid</span> <i class="fa fa-caret-down"></i>
												<? } else { ?>
												<span class="label label-danger">UnPaid</span> <i class="fa fa-caret-down"></i>
												<? } ?>
											</a>
											<ul class="dropdown-menu">
												<li>
													<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="1"><span class="label label-success">Paid</span></a>
													<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="0"><span class="label label-danger">UnPaid</span></a>
												</li>
											</ul>
										</div>
									</td>
									<td width="3%" align="right">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-other-payment-<?=$item->id?>" data-toggle="dropdown">
												<? if (!$item->other_payment) { ?>
												<span class="label label-default">No</span> <i class="fa fa-caret-down"></i>
												<? } else if ($item->other_payment == 1) { ?>
												<span class="label label-success">Online Paid</span> <i class="fa fa-caret-down"></i>
												<? } ?>
											</a>
											<ul class="dropdown-menu">
												<li>
													<a title="" class="other-payment" booking-id="<?=$item->id?>" status-id="0"><span class="label label-default">No</span></a>
													<a title="" class="other-payment" booking-id="<?=$item->id?>" status-id="1"><span class="label label-success">Payment Online</span></a>
												</li>
											</ul>
										</div>
									</td>
									<td width="3%" align="right">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-booking-status-<?=$item->id?>" data-toggle="dropdown">
												<? if ($item->booking_status == 1) { ?>
												<span class="label label-default">Submitted</span> <i class="fa fa-caret-down"></i>
												<? } else if ($item->booking_status == 2) { ?>
												<span class="label label-success">Approved</span> <i class="fa fa-caret-down"></i>
												<? } else if ($item->booking_status == 3) { ?>
												<span class="label label-danger">Denied</span> <i class="fa fa-caret-down"></i>
												<? } else if ($item->booking_status == 4) { ?>
												<span class="label label-warning">Refund</span> <i class="fa fa-caret-down"></i>
												<? } ?>
											</a>
											<ul class="dropdown-menu">
												<li>
													<a title="" class="booking-status" booking-id="<?=$item->id?>" status-id="1"><span class="label label-default">Submitted</span></a>
													<a title="" class="booking-status" booking-id="<?=$item->id?>" status-id="2"><span class="label label-success">Approved</span></a>
													<a title="" class="booking-status" booking-id="<?=$item->id?>" status-id="3"><span class="label label-danger">Denied</span></a>
													<a title="" class="booking-status" booking-id="<?=$item->id?>" status-id="4"><span class="label label-warning">Refund</span></a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							<?
								$idx ++;
							}
						}
					?>
				</table>
			</div>
			<div><?=$pagination?></div>
			<? } ?>
			<? } ?>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".capital").click(function() {
		$(this).select();
	});
	
	$(".capital").blur(function() {
		var booking_id = $(this).attr("booking-id");
		var capital = $(this).val();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["capital"] = capital;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-service-booking-capital")?>",
			data: p
		});
	});

	$(".refund").click(function() {
		$(this).select();
	});
	
	$(".refund").blur(function() {
		var booking_id = $(this).attr("booking-id");
		var refund = $(this).val();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["refund"] = refund;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-service-booking-refund")?>",
			data: p
		});
	});

	$(".payment-status").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = status_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-service-payment-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-payment-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});

	$(".other-payment").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = status_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-service-other-payment")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-other-payment-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});
	
	$(".booking-status").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = status_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-service-booking-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-booking-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});

	if ($(".daterange").length) {
		$(".daterange").daterangepicker({
			startDate: "<?=date('m/d/Y', strtotime((!empty($fromdate)?$fromdate:"now")))?>",
			endDate: "<?=date('m/d/Y', strtotime((!empty($todate)?$todate:"now")))?>"
		});
	}
	
	$(".btn-report").click(function(){
		$("#search_text").val($("#report_text").val());
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
		}
		submitButton("search");
	});

	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
});
</script>