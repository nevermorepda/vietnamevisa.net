<?
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
				Payment Report
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for Email">
							</div>
						</div>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="report_payment_method" name="report_payment_method" class="form-control">
									<option value="">All payment method</option>
									<option value="OnePay">OnePay</option>
									<option value="Paypal">Paypal</option>
									<option value="Credit Card">Gate2Shop</option>
									<option value="Western Union">Western Union</option>
									<option value="Bank Transfer">Bank Transfer</option>
								</select>
								<script>$("#report_payment_method").val("<?=$search_payment_method?>");</script>
							</div>
						</div>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="report_country" name="report_country" class="form-control">
									<option value="">All country</option>
									<? foreach ($countries as $country => $val) { ?>
									<option value="<?=$country?>"><?=$country .' ('. $val .')'?></option>
									<? } ?>
								</select>
								<script>$("#report_country").val("<?=$search_country?>");</script>
							</div>
						</div>
						<? } ?>
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
			<div class="payment-statement pull-left">
				<div class="title">VOA</div>
				<div class="number"><?=number_format($sum_voa)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">VEV</div>
				<div class="number"><?=number_format($sum_vev)?></div>
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
				<div class="number text-color-green"><?=(((round($captital)+round($sum_rf)) > ($sum_op+$sum_pp+$sum_gs))?"-":"")?> $<?=round(abs(round(($sum_op+$sum_pp+$sum_gs),2)-$captital-round($sum_rf,2)-round($sum_vt,2)),2)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Desktop : <?=$sum_pc?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_pc+$sum_pp_pc+$sum_gs_pc)-round($captital_pc)-round($sum_rf_pc))?></span></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Mobile : <?=$sum_mb?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_mb+$sum_pp_mb+$sum_gs_mb)-round($captital_mb)-round($sum_rf_mb))?></span></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Orther Devices : <?=$sum_oth?></div>
				<div class="number"><span style="font-size: 12px;">Profit</span> : <span style="color: #5cb85c;">$<?=number_format(($sum_op_oth+$sum_pp_oth+$sum_gs_oth)-round($captital_oth)-round($sum_rf_oth))?></span></div>
			</div>
		</div>
		<? } ?>
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/payment-report")?>" method="POST">
			<input type="hidden" id="task" name="task" value="<?=$task?>">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="sortby" name="sortby" value="<?=$sortby?>" />
			<input type="hidden" id="orderby" name="orderby" value="<?=$orderby?>" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<input type="hidden" id="search_country" name="search_country" value="<?=$search_country?>" />
			<input type="hidden" id="search_payment_method" name="search_payment_method" value="<?=$search_payment_method?>" />
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
						<th class="text-center" width="80"></th>
						<th class="text-center">
							IP
						</th>
						<th class="text-center" width="20">
						</th>
						<th class="text-center" width="80">
							Date
						</th>
						<th class="text-center">
							Status
						</th>
						<th class="text-center">
							Type
						</th>
						<th class="text-center sortby" sortby="id">
							ID
						</th>
						<th class="text-center">
							Payment
						</th>
						<th>
							Arrival date
						</th>
						<th>
							Fullname
						</th>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<th>
							Email
						</th>
						<? } ?>
						<th class="text-center" width="80">
							Promotion code
						</th>
						<th class="text-center" width="80">
							Capital
						</th>
						<th class="text-center" width="80">
							Refund
						</th>
						<th class="text-center" width="80">
							Amount
						</th>
						<th class="text-center" width="100">
							Payment ID
						</th>
					</tr>
					<?
						if (!empty($items) && sizeof($items)) {
							for ($idx = (($page - 1) * ADMIN_ROW_PER_PAGE); $idx < sizeof($items) && $idx < ($page * ADMIN_ROW_PER_PAGE); $idx++) {
								$item = $items[$idx];
							?>
								<tr>
									<td width="2%" class="text-center">
										<?=$idx+1?>
									</td>
									<td class="text-center">
										<?
											$devices_pc = explode('|',DEVICES_PC);
											$devices_mb = explode('|',DEVICES_MB);
											if (in_array($item->platform, $devices_pc)) {
												echo '<i class="fa fa-desktop" aria-hidden="true"></i>';
											} else if (in_array($item->platform, $devices_mb)) {
												echo '<i style="font-size: 18px;color:#4cd137;" class="fa fa-mobile" aria-hidden="true"></i>';
											} else {
												echo '<span style="color:#e74c3c;">'.$item->platform.'</span>';
											}
										?>
									</td>
									<td width="2%" class="text-center">
										<? if (!empty($item->client_ip)) { ?>
										<a target="_blank" href="http://whatismyipaddress.com/ip/<?=$item->client_ip?>">
											<img src="<?=$item->country_flag?>" alt="<?=$item->country_name?>" title="<?=$item->country_name?>" />
										</a>
										<? } ?>
									</td>
									<td>
										<?
											if ($item->rush_type == 1) {
												echo '<span class="icon-visa-type icon-urgent"></span>';
											}
											else if ($item->rush_type == 2) {
												echo '<span class="icon-visa-type icon-emergency"></span>';
											}
											else if ($item->rush_type == 3) {
												echo '<span class="icon-visa-type icon-holiday"></span>';
											}
											if ($item->private_visa) {
												echo '<span class="icon-visa-type icon-private-visa"></span>';
											}
											if ($item->full_package) {
												echo '<span class="icon-visa-type icon-full-package"></span>';
											}
											if ($item->fast_checkin) {
												echo '<span class="icon-visa-type icon-fast-checkin"></span>';
											}
											if ($item->car_pickup) {
												echo '<span class="icon-visa-type icon-car-pickup"></span>';
											}
										?>
									</td>
									<td class="text-right">
										<?=date("Y-m-d", strtotime($item->payment_date))?><br>
										<?=date("H:i:s", strtotime($item->payment_date))?>
									</td>
									<td width="3%" class="text-center">
										<? if ($item->status) { ?>
										<span class="label label-success">Paid</span>
										<? } else { ?>
										<span class="label label-danger">UnPaid</span>
										<? } ?>
									</td>
									<td width="3%" class="text-center">
										<?
											if ($item->booking_type_id == 2) {
												echo '<span style="color:red">'.BOOKING_E_PREFIX.'</span>';
											} else {
												if ($item->payment_type == BOOKING_PREFIX) {
													echo BOOKING_PREFIX;
												} else if ($item->payment_type == BOOKING_PREFIX_EX) {
													echo "EX";
												} else {
													echo "PO";
												}
											}
											
										?>
									</td>
									<td width="80px">
										<a class="collapsed" data-toggle="collapse" href="<?="".$item->order_id?>" aria-expanded="false" aria-controls="collapse<?=$item->order_id?>">
											<?
												if ($item->booking_type_id == 1)
												echo BOOKING_PREFIX.$item->order_id;
												else
												echo '<span style="color:red">'.BOOKING_E_PREFIX.$item->order_id.'</span>';
											?>
										</a>
									</td>

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
									<td>
										<?=date("M/d/Y", strtotime($item->arrival_date))?>
									</td>
									<td>
										<?=$item->fullname?>
									</td>
									<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
									<td>
										<?=$item->primary_email?>
									</td>
									<? } ?>
									<td width="3%" class="text-right">
										<?=($item->promotion_code ? $item->promotion_code : "")?>
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="capital" name="capital" value="<?=($item->capital ? $item->capital : "")?>" booking-id="<?=$item->order_id?>" typ="<?=$item->payment_type?>" style="background-color: #F0F0F0; width: 30px; text-align: right; border: none;">
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="refund" name="refund" value="<?=($item->refund ? $item->refund : "")?>" booking-id="<?=$item->order_id?>" typ="<?=$item->payment_type?>" style="background-color: #F0F0F0; width: 30px; text-align: right; border: none;">
									</td>
									<td width="3%" class="text-right">
										$<?=$item->amount?>
									</td>
									<td class="text-left"  >
										<?
										if ($item->payment_type == BOOKING_PREFIX) {
											echo BOOKING_PREFIX.$item->order_id;
										} else if ($item->payment_type == BOOKING_PREFIX_EX) {
											echo BOOKING_PREFIX_EX.$item->order_id;
										} else {
											echo BOOKING_PREFIX_PO.$item->order_id;
										}
										?>
									</td>
								</tr>
								<tr class="collapse" id="detail<?=$item->order_id?>" set-val="0">
									<td colspan="30">
										<div class="row">
											<div class="col-sm-7">
												<?
												$info = new stdClass();
												$info->book_id = $item->order_id;
												$paxs = $this->m_visa_pax->items($info);
												?>
												<div class="panel panel-default">
													<div class="panel-heading"><strong>Visa Information Details</strong></div>
													<div class="panel-body">
														<div>
															<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																A. Visa Options
															</div>
															<div style="padding: 0 0 10px 40px;">
																<table class="table table-bordered table-striped">
																	<tr><td>Type of visa</td><td><?=$item->visa_type;?></td></tr>
																	<tr><td width="20%">Purpose of visit</td><td><?=$item->visit_purpose;?></td></tr>
																	<tr><td>Entry date</td><td><?=date("M/d/Y", strtotime($item->arrival_date))?></td></tr>
																	<tr><td>Exit date</td><td><?=date("M/d/Y", strtotime($item->exit_date))?></td></tr>
																	<tr><td>Entry through checkpoint</td><td><?=$item->arrival_port;?></td></tr>
																	<tr><td>Exit port</td><td><?=$item->exit_port;?></td></tr>
																	<tr><td>Number of applicants</td><td><?=$item->group_size;?></td></tr>
																	<tr><td><b>Total fee</b></td><td><b><?=$item->amount;?> USD</b></td></tr>
																</table>
															</div>
														</div>
														<div>
															<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																B. Passport Detail
															</div>
															<div style="padding: 0 0 10px 40px;">
																<table class="table table-bordered">
																	<tr>
																		<th class="text-center" width="40">No.</th>
																		<th class="text-left">Full name</th>
																		<th class="text-center">Gender</th>
																		<th class="text-center">Date of birth</th>
																		<th class="text-center">Nationality</th>
																		<th class="text-center">Passport number</th>
																		<th class="text-center">Passport type</th>
																		<th class="text-center">Expiry date</th>
																		<th class="text-center">Religion</th>
																		<th class="text-center">Passport photo</th>
																		<th class="text-center">Passport data</th>
																		<th class="text-center" width="60"></th>
																	</tr>
																<?
																foreach ($paxs as $pax) { ?>
																<tr>
																	<td class="text-center" width="40">No.</td>
																	<td class="text-left"><?=$pax->fullname?></td>
																	<td class="text-center"><?=$pax->gender?></td>
																	<td class="text-center"><?=$pax->birthday?></td>
																	<td class="text-center"><?=$pax->nationality?></td>
																	<td class="text-center"><?=$pax->passport?></td>
																	<td class="text-center"><?=$pax->passport_type?></td>
																	<td class="text-center"><?=$pax->expiry_date?></td>
																	<td class="text-center"><?=$pax->religion?></td>
																	<td class="text-center" ><a href="<?=BASE_URL.$pax->passport_photo?>">Download</a></td>
																	<td class="text-center" ><a href="<?=BASE_URL.$pax->passport_data?>">Download</a></td>
																	<td class="text-center" width="60"></td>
																</tr>
																<? } ?>
																</table>
															</div>
														</div>
														<div>
															<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																C. Contact Information
															</div>
															<div style="padding: 0 0 10px 40px;">
																<table class="table table-bordered table-striped">
																	<tr><td width="20%">Full Name</td><td><?=$item->contact_title.'. '.$item->fullname?></td></tr>
																	<tr><td>Email</td><td><a href=""><?=$item->primary_email?></a></td></tr>
																	<tr><td>Alternate Email</td><td><a href=""><?=$item->secondary_email?></a></td></tr>
																	<tr><td>Phone Number</td><td><a href=""><?=$item->contact_phone?></a></td></tr>
																	<tr><td>Special Request</td><td><?=$item->special_request?></td></tr>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-5">
												<div class="panel panel-default">
													<div class="panel-heading">
														<strong>Upload</strong>
													</div>
													<div class="panel-body">
														<div class="file-path file-path- clearfix">
															
														</div>
														<div class="file-upload">
															<button type="button" class="btn btn-xs btn-default btn-browse" user-id="" item-id="">Browse...</button>
															<button type="button" class="btn btn-xs btn-primary btn-create-pdf" user-id="" item-id="">Make letter</button>
															<button type="button" class="btn btn-xs btn-primary btn-sendmail" user-id="" item-id="">Send letter</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<?
							}
						}
					?>
				</table>
			</div>
			<div><?=$pagination?></div>
			<? } ?>
			<? } ?>
		</form>
		<script>
			$('.collapsed').click(function(event) {
				var result = parseFloat($(this).attr('href'));
				$('#detail' + result).toggle();
			});
		</script>
	</div>
</div>

<script>
$(document).ready(function() {
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
		$("#search_country").val($("#report_country :selected").val());
		$("#search_payment_method").val($("#report_payment_method :selected").val());
		submitButton("search");
	});
	
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
	
	$(".capital").click(function() {
		$(this).select();
	});
	
	$(".capital").blur(function() {
		var booking_id = $(this).attr("booking-id");
		var capital = $(this).val();
		var payment_type = $(this).attr("typ");
		
		var p = {};
		p["booking_id"] = booking_id;
		p["capital"] = capital;
		p["typ"] = payment_type;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-payment-report-capital")?>",
			data: p,
			dataType: 'json',
			success: function(result) {
			}
		});
	});

	$(".refund").click(function() {
		$(this).select();
	});
	
	$(".refund").blur(function() {
		var booking_id = $(this).attr("booking-id");
		var refund = $(this).val();
		var payment_type = $(this).attr("typ");
		
		var p = {};
		p["booking_id"] = booking_id;
		p["refund"] = refund;
		p["typ"] = payment_type;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-payment-report-refund")?>",
			data: p,
			dataType: 'json',
			success: function(result) {
			}
		});
	});
});
</script>