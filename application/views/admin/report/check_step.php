<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);

	$admin = $this->session->userdata("admin");

	if ($sum_vs < 10) {
		$ratio = 5/100;
	} else {
		$ratio = 5/100;
	}
	
	$captital = $sum_cp;
	if ($captital) {
		$captital += ($sum_op+$sum_pp+$sum_gs) * $ratio;
	}
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);
?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Check step apply
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="search" name="search" class="form-control" value="<?=$search_text?>" placeholder="Search for email">
							</div>
						</div>
						<? if ($admin->user_type == USR_SUPPER_ADMIN || $admin->user_email == "T25121995@gmail.com") { ?>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="slt_check_paid" name="slt_check_paid" class="form-control">
									<option value="">All</option>
									<option value="paid">Paid</option>
									<option value="unpaid">Unpaid</option>
								</select>
								<script>$("#slt_check_paid").val("<?=$check_paid?>");</script>
							</div>
						</div>
						<div class="pull-left" style="max-width: 220px; margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control daterange">
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Report</button>
								</span>
							</div>
						</div>
						<div class="pull-left">
							<button class="btn btn-sm btn-success btn-download" type="button"><i class="fa fa-download"></i> Download</button>
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
		<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
		<div class="statement-bar clearfix">
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Success</div>
				<div class="number"><?=number_format($sum_vs)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Pax</div>
				<div class="number"><?=number_format($sum_px)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">PR</div>
				<div class="number"><?=number_format($sum_pr)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Full</div>
				<div class="number"><?=number_format($sum_fp)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">FC</div>
				<div class="number"><?=number_format($sum_fc)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Car</div>
				<div class="number"><?=number_format($sum_cr)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">OnePay</div>
				<div class="number">$<?=round($sum_op,2)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Paypal</div>
				<div class="number">$<?=round($sum_pp,2)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">G2S</div>
				<div class="number">$<?=round($sum_gs,2)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">&nbsp;</div>
				<div class="number">=</div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Total</div>
				<div class="number">$<?=round(($sum_op+$sum_pp+$sum_gs),2)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Capital</div>
				<div class="number text-color-red">- $<?=round($captital,2)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Stamping</div>
				<div class="number text-color-red">- $<?=number_format($sum_st)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">VAT</div>
				<div class="number text-color-red">- $<?=number_format($sum_vt)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Refund</div>
				<div class="number text-color-red">- $<?=number_format($sum_rf)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Profit</div>
				<div class="number text-color-green"><?=(((round($captital)+round($sum_rf)) > ($sum_op+$sum_pp+$sum_gs))?"-":"")?> $<?=round(abs(round(($sum_op+$sum_pp+$sum_gs),2)-$captital-round($sum_rf,2)-round($sum_vt)),2)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Desktop : <?=$sum_pc?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_pc+$sum_pp_pc+$sum_gs_pc)-round($captital_pc)-round($sum_rf_pc)-round($sum_vt_pc))?></span></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Mobile : <?=$sum_mb?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_mb+$sum_pp_mb+$sum_gs_mb)-round($captital_mb)-round($sum_rf_mb)-round($sum_vt_mb))?></span></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Orther Devices : <?=$sum_oth?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_oth+$sum_pp_oth+$sum_gs_oth)-round($captital_oth)-round($sum_rf_oth)-round($sum_vt_oth))?></span></div>
			</div>
		</div>
		<? } ?>
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/check-step")?>" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<input type="hidden" id="check_paid" name="check_paid" value="<?=$check_paid?>" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>" />
			<? if (empty($items) || !sizeof($items)) { ?>
			<p class="help-block">No booking found.</p>
			<? } else { ?>
			<p></p>
			<? if ($admin->user_type == USR_SUPPER_ADMIN || $admin->user_email == "T25121995@gmail.com" || ($task == "search" && $edited_search_text != "")) { ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<thead>
					<tr>
						<th class="text-center" width="5">
							No.
						</th>
						<th class="text-center">
							IP			
						</th>
						<th class="text-center">
							Name
						</th>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<th class="text-center">
							Email
						</th>
						<? } ?>
						<th class="text-center">
							Type
						</th>
						<th class="text-center">
							Step 1
						</th>
						<th class="text-center">
							Step 2
						</th>
						<th class="text-center">
							Step 3
						</th>
						<th class="text-center">
							Step 4
						</th>
						<th class="text-center">
							Status
						</th>
						<th class="text-center">
							Price
						</th>
						<th class="text-center">
							Send
						</th>
						<th class="text-center">
							Created date
						</th>
					</tr>
					</thead>
					<tbody class="table-content">
						<? $i=1; foreach ($items as $item) { ?>
						<tr>
							<td class="text-center"><?=$i?></td>
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
							<td class="text-center"><?=$item->fullname?></td>
							<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
							<td class="text-center"><?=$item->email?></td>
							<? } 
								$check_po = ($item->check_po == 2) ? 'PO - ' : '';
							?>
							<td class="text-center"><?=($item->type == 1) ? '<span style="color:blue;">'.$check_po.'VOA</span>' : '<span style="color:orange;">'.$check_po.'VEV</span>';?></td>
							<td class="text-center"><?=!empty($item->step1) ? '<span style="color:green;">OK</span>' : '<span style="color:red"> NO</span>'?></td>
							<td class="text-center"><?=!empty($item->step2) ? '<span style="color:green;">OK</span>' : '<span style="color:red"> NO</span>'?></td>
							<td class="text-center"><?=!empty($item->step3) ? '<span style="color:green;">OK</span>' : '<span style="color:red"> NO</span>'?></td>
							<td class="text-center"><?=!empty($item->step4) ? '<span style="color:green;">OK</span>' : '<span style="color:red"> NO</span>'?></td>
							<td class="text-center"><?=($item->status == 'paid') ? '<span style="color:green;">Paid</span>' : '<span style="color:red"> Unpaid</span>'?></td>
							<td class="text-center"><strong><?=$item->price?></strong></td>
							<td class="text-center">
								<div class="btn-group btn-processing-status">
									<? if($item->send_mail == 2) { ?>
									<a class="btn btn-xs dropdown-toggle dropdown-toggle-payment-status-<?=$item->id?>" data-toggle="dropdown"><span class="label label-danger">No</span> <i class="fa fa-caret-down"></i></a>
									<? } else { ?>
									<a class="btn btn-xs dropdown-toggle dropdown-toggle-payment-status-<?=$item->id?>" data-toggle="dropdown"><span class="label label-success">Yes</span> <i class="fa fa-caret-down"></i></a>
									<? } ?>
									<ul class="dropdown-menu">
										<li>
											<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="1"><span class="label label-success">Yes</span></a>
											<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="2"><span class="label label-danger">No</span></a>
										</li>
									</ul>
								</div>
							</td>
							<td class="text-center"><?=date('Y-m-d H:i:s',strtotime($item->created_date))?></td>
						</tr>
						<? $i++;} ?>
					</tbody>
				</table>
			</div>
			<? } ?>
			<? } ?>
		</form>
	</div>
</div>

<script>
	$(".payment-status").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = status_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-sendmail-check-step")?>",
			data: p,
			success: function(result) { console.log(result);
				$(".dropdown-toggle-payment-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});
$(document).ready(function() {
	if ($(".daterange").length) {
		$(".daterange").daterangepicker({
			startDate: "<?=date('m/d/Y', strtotime((!empty($fromdate)?$fromdate:"now")))?>",
			endDate: "<?=date('m/d/Y', strtotime((!empty($todate)?$todate:"now")))?>"
		});
	}
	
	$(".btn-report").click(function(){
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
			$('#check_paid').val($('#slt_check_paid').val());
			$('#search_text').val($('#search').val());
		}
		submitButton("report");
	});

	$(".btn-download").click(function(){
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
			$('#check_paid').val($('#slt_check_paid').val());
		}
		submitButton("export");
	});
	
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});

	// setInterval(function(){
	// 	var p = {};

	// 	p['fromdate'] = $('#fromdate').val();
	// 	p['todate'] = $('#todate').val();
	// 	$.ajax({
	// 		url: '<?=site_url('syslog/real-time-check-step')?>',
	// 		type: 'post',
	// 		dataType: 'html',
	// 		data: p,
	// 		success:function(result){
	// 			$('.table-content').html(result);
	// 		}
	// 	});
	// },30000);
});
</script>