<?
	$admin = $this->session->userdata("admin");
	
	if ($sum_vs < 10) {
		$ratio = 5/100;
	} else {
		$ratio = 5/100;
	}
	
	$countries = array();
	$return_user = array();
	$promotions = array();
	
	$revenue = array();
	$return_revenue = array();
	$promotion_revenue = array();
	
	$profit = array();
	$return_profit = array();
	$promotion_profit = array();
	
	$total_succed = 0;
	$total_amount = 0;
	$total_profit = 0;
	
	foreach ($items as $item) {
		if (!empty($item->client_ip)) {
			if ($item->status) {
				if (array_key_exists($item->country_name, $countries)) {
					$countries[$item->country_name] = $countries[$item->country_name] + 1;
					if (date("Y-m-d", strtotime($item->user_registered)) < date("Y-m-d", strtotime($fromdate))) {
						$return_user[$item->country_name] = $return_user[$item->country_name] + 1;
						$return_revenue[$item->country_name] = $return_revenue[$item->country_name] + $item->total_fee;
						$return_profit[$item->country_name] = $return_profit[$item->country_name] + max(array(($item->total_fee - $item->refund - $item->capital), 0));
					}
					if (!empty($item->discount)) {
						$promotions[$item->country_name] = $promotions[$item->country_name] + 1;
						$promotion_revenue[$item->country_name] = $promotion_revenue[$item->country_name] + $item->total_fee;
						$promotion_profit[$item->country_name] = $promotion_profit[$item->country_name] + max(array(($item->total_fee - $item->refund - $item->capital), 0));
					}
					$revenue[$item->country_name] = $revenue[$item->country_name] + $item->total_fee;
					$profit[$item->country_name] = $profit[$item->country_name] + max(array(($item->total_fee - $item->refund - $item->capital), 0));
				} else {
					$countries[$item->country_name] = 1;
					if (date("Y-m-d", strtotime($item->user_registered)) < date("Y-m-d", strtotime($fromdate))) {
						$return_user[$item->country_name] = 1;
						$return_revenue[$item->country_name] = $item->total_fee;
						$return_profit[$item->country_name] = max(array(($item->total_fee - $item->refund - $item->capital), 0));
					} else {
						$return_user[$item->country_name] = 0;
						$return_revenue[$item->country_name] = 0;
						$return_profit[$item->country_name] = 0;
					}
					if (!empty($item->discount)) {
						$promotions[$item->country_name] = 1;
						$promotion_revenue[$item->country_name] = $item->total_fee;
						$promotion_profit[$item->country_name] = max(array(($item->total_fee - $item->refund - $item->capital), 0));
					} else {
						$promotions[$item->country_name] = 0;
						$promotion_revenue[$item->country_name] = 0;
						$promotion_profit[$item->country_name] = 0;
					}
					$revenue[$item->country_name] = $item->total_fee;
					$profit[$item->country_name] = max(array(($item->total_fee - $item->refund - $item->capital), 0));
				}
				$total_succed ++;
				$total_amount += $item->total_fee;
				$total_profit += max(array(($item->total_fee - $item->refund - $item->capital), 0));
			}
		}
	}
	
	$captital = $sum_cp;
	if ($captital) {
		$captital += round(($sum_op+$sum_pp+$sum_gs) * $ratio);
	}
	
	ksort($countries);
	ksort($return_user);
	ksort($promotions);
	ksort($revenue);
	ksort($return_revenue);
	ksort($promotion_revenue);
	ksort($profit);
	ksort($return_profit);
	ksort($promotion_profit);

	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);

?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Visa Bookings
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for application ID">
							</div>
						</div>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="report_visa_type" name="report_visa_type" class="form-control">
									<option value="">All type</option>
									<option value="1ms">1MS</option>
									<option value="1mm">1MM</option>
									<option value="3ms">3MS</option>
									<option value="3mm">3MM</option>
									<option value="6mm">6MM</option>
									<option value="1ym">1YM</option>
								</select>
								<script>$("#report_visa_type").val("<?=$search_visa_type?>");</script>
							</div>
						</div>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="report_visit_purpose" name="report_visit_purpose" class="form-control">
									<option value="">All purpose</option>
									<option value="For tourist">Tourist</option>
									<option value="For business">Business</option>
									<option value="Family or Friend visit">Family</option>
								</select>
								<script>$("#report_visit_purpose").val("<?=$search_visit_purpose?>");</script>
							</div>
						</div>
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<select id="report_country" name="report_country" class="form-control">
									<option value="">All country</option>
									<? foreach ($all_countries as $country => $val) { ?>
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
			<div class="payment-statement pull-left">
				<div class="title">Success</div>
				<div class="number"><?=number_format($sum_vs)?></div>
			</div>
			<div class="payment-statement pull-left">
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
			<div class="payment-statement pull-left">
				<div class="title">PR</div>
				<div class="number"><?=number_format($sum_pr)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Full</div>
				<div class="number"><?=number_format($sum_fp)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">FC</div>
				<div class="number"><?=number_format($sum_fc)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Car</div>
				<div class="number"><?=number_format($sum_cr)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs hidden">
				<div class="title">OnePay</div>
				<div class="number">$<?=number_format($sum_op)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs hidden">
				<div class="title">Paypal</div>
				<div class="number">$<?=number_format($sum_pp)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs hidden">
				<div class="title">G2S</div>
				<div class="number">$<?=number_format($sum_gs)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs hidden">
				<div class="title">&nbsp;</div>
				<div class="number">=</div>
			</div>
			<div class="payment-statement pull-left hidden">
				<div class="title">Total</div>
				<div class="number">$<?=number_format($sum_op+$sum_pp+$sum_gs)?></div>
			</div>
			<div class="payment-statement pull-left hidden">
				<div class="title">Capital</div>
				<div class="number text-color-red">- $<?=number_format($captital)?></div>
			</div>
			<div class="payment-statement pull-left hidden">
				<div class="title">Refund</div>
				<div class="number text-color-red">- $<?=number_format($sum_rf)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs hidden">
				<div class="title">Stamping</div>
				<div class="number text-color-red">- $<?=number_format($sum_st)?></div>
			</div>
			<div class="payment-statement pull-left hidden">
				<div class="title">Profit</div>
				<div class="number text-color-green"><?=(((round($captital)+round($sum_rf)) > ($sum_op+$sum_pp+$sum_gs))?"-":"")?> $<?=number_format(abs(($sum_op+$sum_pp+$sum_gs)-round($captital)-round($sum_rf)))?></div>
			</div>
		</div>
		<? } ?>
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/visa-booking")?>" method="POST">
			<input type="hidden" id="task" name="task" value="<?=$task?>">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<input type="hidden" id="search_visa_type" name="search_visa_type" value="<?=$search_visa_type?>" />
			<input type="hidden" id="search_visit_purpose" name="search_visit_purpose" value="<?=$search_visit_purpose?>" />
			<input type="hidden" id="search_country" name="search_country" value="<?=$search_country?>" />
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<input type="hidden" id="sortby" name="sortby" value="<?=$sortby?>" />
			<input type="hidden" id="orderby" name="orderby" value="<?=$orderby?>" />
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
						<th class="text-center"></th>
						<th class="text-center">
							IP
						</th>
						<th class="text-center" width="20">
						</th>
						<th width="80" class="sortby" sortby="booking_date">
							Date
						</th>
						<th class="text-center" width="5">
							<i class="fa fa-paperclip"></i>
						</th>
						<th class="sortby" sortby="id">
							ID
						</th>
						<th class="text-center sortby" sortby="payment_method">
							Payment
						</th>
						<th class="sortby" sortby="oreder_ref">
							Reference
						</th>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<th class="sortby" sortby="primary_email">
							Email
						</th>
						<? } ?>
						<th class="text-center sortby" sortby="visa_type">
							Type
						</th>
						<th class="text-center sortby" sortby="arrival_date" width="80">
							Arrival
						</th>
						<th class="text-center sortby" sortby="arrival_port">
							Port
						</th>
						<th class="text-center sortby" sortby="group_size">
							Paxs
						</th>
						<th class="text-center sortby" sortby="visa_fee">
							Fee
						</th>
						<th class="text-center sortby" sortby="rush_fee">
							Rush
						</th>
						<th class="text-center sortby" sortby="private_visa">
							Private
						</th>
						<th class="text-center sortby" sortby="full_package">
							Full
						</th>
						<th class="text-center sortby" sortby="fast_checkin">
							FC
						</th>
						<th class="text-center sortby" sortby="car_pickup" nowrap="nowrap">
							Car
						</th>
						<th class="text-center sortby" sortby="discount">
							Discount
						</th>
						<th class="text-center sortby" sortby="promotion_code">
							Code
						</th>
						<th class="text-center sortby" sortby="capital">
							Capital
						</th>
						<th class="text-center sortby" sortby="refund">
							Refund
						</th>
						<th class="text-center sortby" sortby="total_fee">
							Total
						</th>
						<th class="text-center sortby" sortby="status">
							Payment
						</th>
						<th class="text-center sortby" sortby="other_payment" nowrap>
							Other Payment
						</th>
						<th class="text-center sortby" sortby="booking_status">
							Status
						</th>
					</tr>
					<?
						if (!empty($items) && sizeof($items)) {
							for ($idx = (($page - 1) * ADMIN_ROW_PER_PAGE); $idx < sizeof($items) && $idx < ($page * ADMIN_ROW_PER_PAGE); $idx++) {
								$item = $items[$idx];
							?>
								<tr class="prss<?=$item->rush_type?>">
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
										<?=date("Y-m-d", strtotime($item->booking_date))?><br>
										<?=date("H:i:s", strtotime($item->booking_date))?>
									</td>
									<td class="text-center">
										<div class="fa-attachment-<?=$item->id?> display-none">
											<i class="fa fa-paperclip"></i>
										</div>
									</td>
									<td width="80px">
										<a class="collapsed" data-toggle="collapse" href="<?="#".$item->id?>" aria-expanded="false" aria-controls="collapse<?=$item->id?>">
											<?
												if ($item->booking_type_id == 1)
												echo BOOKING_PREFIX.$item->id;
												else
												echo '<span style="color:red">'.BOOKING_E_PREFIX.$item->id.'</span>';
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
									<td width="80px">
										<?=(!empty($item->order_ref)?$item->order_ref:$item->id)?>
									</td>
									<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
									<td>
										<?=$item->primary_email?>
									</td>
									<? } ?>
									<td width="4%" class="text-center">
										<?=strtoupper($this->m_visa_type->search_by_name($item->visa_type)->code)?>
									</td>
									<td width="6%" class="text-center">
										<?=date("M/d/Y", strtotime($item->arrival_date))?>
									</td>
									<td class="text-center">
										<?=$item->arrival_port?>
									</td>
									<td width="3%" class="text-center">
										<?=$item->group_size?>
									</td>
									<td width="3%" align="right">
										$<?=$item->visa_fee?>
									</td>
									<td width="3%" align="right">
										$<?=$item->rush_fee?>
									</td>
									<td class="text-center" width="30px">
									<? if ($item->private_visa) { ?>
										<i class="fa fa-check"></i>
									<? } ?>
									</td>
									<td class="text-center" width="30px">
									<? if ($item->full_package) { ?>
										<i class="fa fa-check"></i>
									<? } ?>
									</td>
									<td width="3%" align="right">
										$<?=($item->full_package ? $item->full_package_fc_fee : $item->fast_checkin_fee)?>
									</td>
									<td width="3%" align="right">
										$<?=$item->car_fee?>
									</td>
									<td width="3%" align="right">
										<?=($item->discount ? (($item->discount_unit == "USD") ? "$".$item->discount : ($item->discount.$item->discount_unit)) : "")?>
									</td>
									<td width="3%" class="text-center">
										<?=$item->promotion_code?>
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="capital" name="capital" value="<?=($item->capital ? $item->capital : "")?>" booking-id="<?=$item->id?>" style="background-color: #F0F0F0; width: 30px; text-align: right; border: none;">
									</td>
									<td width="3%" class="text-center">
										<input type="text" class="refund" name="refund" value="<?=($item->refund ? $item->refund : "")?>" booking-id="<?=$item->id?>" style="background-color: #F0F0F0; width: 30px; text-align: right; border: none;">
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
													<a title="" class="other-payment" email="<?=$item->primary_email?>" booking-id="<?=$item->id?>" status-id="0"><span class="label label-default">No</span></a>
													<a title="" class="other-payment" email="<?=$item->primary_email?>" booking-id="<?=$item->id?>" status-id="1"><span class="label label-success">Payment Online</span></a>
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
								<tr class="collapse" id="<?=$item->id?>">
									<td colspan="30">
										<div class="row">
											<div class="col-sm-7">
												<?
												$travelers = array();
												foreach ($paxs as $pax) {
													
													if (($pax->book_id == $item->id) && ($pax->send_again == 0)) {
														$travelers[] = $pax;
													}
												}
												
												$item->processing_time = ($item->rush_type == 1) ? "Urgent" : (($item->rush_type == 2) ? "Emergency" : (($item->rush_type == 3) ? "Holiday" : "Normal"));
												
												$nationalities = array();
												
												$trl_lines = "";
												$style = 'style="border: 1px solid #DDD;"';
												for ($i=0; $i<$item->group_size; $i++) {
													$nationality = $travelers[$i]->nationality;
													if (!array_key_exists($nationality, $nationalities)) {
														$nationalities[$nationality] = 1;
													} else {
														$nationalities[$nationality] += 1;
													}
													$trl_lines .= '<tr>
														<td class="text-center" '.$style.'>'.($i+1).'</td><td '.$style.'>'.$travelers[$i]->fullname.'</td>
														<td class="text-center" '.$style.'>'.$travelers[$i]->gender.'</td>
														<td class="text-center" '.$style.'>'.date("M/d/Y", strtotime($travelers[$i]->birthday)).'</td>
														<td class="text-center" '.$style.'>'.$travelers[$i]->nationality.'</td>
														<td class="text-center" '.$style.'>'.$travelers[$i]->passport.'</td>';
													if ($item->booking_type_id == 2) {
														$trl_lines .= '<td class="text-center" '.$style.'>'.$travelers[$i]->passport_type.'</td>
																	<td class="text-center" '.$style.'>'.date("M/d/Y",strtotime($travelers[$i]->expiry_date)).'</td>
																	<td class="text-center" '.$style.'>'.$travelers[$i]->religion.'</td>
																	<td class="text-center" '.$style.'><a target="_blank" href="'.BASE_URL.$travelers[$i]->passport_photo.'">Download</a></td>
																	<td class="text-center" '.$style.'><a target="_blank" href="'.BASE_URL.$travelers[$i]->passport_data.'">Download</a></td>';
													}
													$trl_lines .= '<td class="text-center" '.$style.'><a class="pointer btn-edit-passport" item-id="'.$travelers[$i]->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></td>
													</tr>';
												}
												
												$visa_type = '<tr><td>Type of visa</td><td>'.$item->visa_type.'</td></tr>';
												
												$serviceFee = "";
												if ($item->booking_type_id == 2) {
													// $serviceFee .= '<tr><td>Visa stamping fee</td><td> : </td><td>'.$item->stamp_fee.' USD/pax</td></tr>';
													foreach ($nationalities as $key => $val) {
														$serviceFee .= '<tr><td>Visa service fee for '.$key.'</td><td>'.$item->total_visa_fee.' USD/pax</td></tr>';
													}
												} else {
													foreach ($nationalities as $key => $val) {
														$serviceFee .= '<tr><td>Visa service fee for '.$key.'</td><td>'.$item->total_visa_fee.' USD/pax</td></tr>';
													}
												}
												
												$processingTime = "";
												if ($item->processing_time != "Normal") {
													$processingTime .= '<tr><td>Processing ('.$item->processing_time.')</td><td>'.$item->rush_fee.' USD/pax</td></tr>';
												}
												
												$privateVisa = "";
												if (!empty($item->private_visa)) {
													$privateVisa = '<tr><td>Private letter</td><td>'.$item->private_visa_fee.' USD</td></tr>';
												}
												
												$carPickup = "";
												if ($item->car_pickup) {
													$carPickup = '<tr><td>Car pick-up</td><td>'.$item->car_fee.' USD</td></tr>';
												}
												
												$airportFastCheckin = "";
												if ($item->fast_checkin == 1) {
													$airportFastCheckin = '<tr><td>Airport fast check-in</td><td>'.$item->fast_checkin_fee.' USD</td></tr>';
												}
												else if ($item->fast_checkin == 2) {
													$airportFastCheckin = '<tr><td>VIP fast check-in</td><td>'.$item->fast_checkin_fee.' USD</td></tr>';
												}
												
												$discount = "";
												if ($item->vip_discount) {
													$discount .= '<tr><td>VIP discount</td><td>-'.round($item->total_visa_fee * $item->vip_discount / 100).' USD</td></tr>';
												}
												if ($item->discount) {
													$discount .= '<tr><td>Promotion discount</td><td>-'.round($item->total_visa_fee * $item->discount / 100).' USD</td></tr>';
												}
												
												$flightNumber = "";
												if (!empty($item->flight_number)) {
													$flightNumber = '<tr><td>Flight number</td><td>'.$item->flight_number.'</td></tr>';
												}
												$arrivalTime  = "";
												if (!empty($item->arrival_time)) {
													$arrivalTime  = '<tr><td>Arrival time</td><td>'.$item->arrival_time.'</td></tr>';
												}
												
												$fullPackage = "";
												if ($item->full_package) {
													$fullPackage .= '<tr><td>Visa stamping fee</td><td>'.$item->stamp_fee.' USD/pax</td></tr>';
													$fullPackage .= '<tr><td>Airport fast check-in</td><td>'.$item->full_package_fc_fee.' USD/pax</td></tr>';
												}
												if ($item->booking_type_id == 2) {
													$vev_port = '<tr><td>Exit port</td><td>'.$item->arrival_port.'</td></tr>';
												} else {
													$vev_port = '';
												}
												$result = '<div class="panel panel-default">
															<div class="panel-heading"><strong>Visa Information Details</strong></div>
															<div class="panel-body">
																<div>
																	<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																		A. Visa Options
																		<div class="pull-right"><a class="pointer btn-edit-option" item-id="'.$item->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></div>
																	</div>
																	<div style="padding: 0 0 10px 40px;">
																		<table class="table table-bordered table-striped">
																			'.$visa_type.'
																			<tr><td width="20%">Purpose of visit</td><td>'.$item->visit_purpose.'</td></tr>
																			<tr><td>Entry date</td><td>'.date("M/d/Y",strtotime($item->arrival_date)).'</td></tr>
																			<tr class="hidden"><td>Exit date</td><td>'.date("M/d/Y",strtotime($item->exit_date)).'</td></tr>
																			<tr><td>Entry through checkpoint</td><td>'.$item->arrival_port.'</td></tr>
																			'.$vev_port.$flightNumber.$arrivalTime.'
																			<tr><td>Number of applicants</td><td>'.$item->group_size.'</td></tr>
																			'.$serviceFee.'
																			'.$processingTime.'
																			'.$privateVisa.$fullPackage.$airportFastCheckin.$carPickup.$discount.'
																			<tr><td><b>Total fee</b></td><td><b>'.$item->total_fee.' USD</b></td></tr>
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
																				<th class="text-center">Passport number</th>';
																	if ($item->booking_type_id == 2) {
																	$result .= '<th class="text-center">Passport type</th>
																				<th class="text-center">Expiry date</th>
																				<th class="text-center">Religion</th>
																				<th class="text-center">Passport photo</th>
																				<th class="text-center">Passport data</th>';
																	}
																			$result .= '<th class="text-center" width="60"></th>
																			</tr>
																			'.$trl_lines.'
																		</table>
																	</div>
																</div>
																<div>
																	<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																		C. Contact Information
																		<div class="pull-right"><a class="pointer btn-edit-contact" item-id="'.$item->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></div>
																	</div>
																	<div style="padding: 0 0 10px 40px;">
																		<table class="table table-bordered table-striped">
																			<tr><td width="20%">Full Name</td><td>'.$item->contact_title.'. '.$item->contact_fullname.'</td></tr>
																			<tr><td>Email</td><td><a href="mailto:'.$item->primary_email.'">'.$item->primary_email.'</a></td></tr>
																			<tr><td>Alternate Email</td><td><a href="mailto:'.$item->secondary_email.'">'.$item->secondary_email.'</a></td></tr>
																			<tr><td>Phone Number</td><td><a href="tel:'.$item->contact_phone.'">'.$item->contact_phone.'</a></td></tr>
																			<tr><td>Special Request</td><td>'.$item->special_request.'</td></tr>
																		</table>
																	</div>
																</div>
															</div>
														</div>';
												echo $result;
												?>
											</div>
											<div class="col-sm-5">
												<div class="panel panel-default">
													<div class="panel-heading">
														<strong>Upload</strong>
													</div>
													<div class="panel-body">
														<div class="file-path file-path-<?=$item->id?> clearfix">
															<?
																$path = "./files/upload/".BOOKING_PREFIX."/user/{$item->user_id}/approval/{$item->id}/";
																$fields = array("path" => $path, "agent" => CDN_AGENT_ID);
																$curl = curl_init(CDN_URL."/cdn/browse/letter.html");
																curl_setopt($curl, CURLOPT_TIMEOUT, 30);
																curl_setopt($curl, CURLOPT_POST, true);
																curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
																curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
																$data = curl_exec($curl);
																curl_close($curl);
																
																if (!empty($data)) {
																	$files = explode(",", $data);
																	foreach ($files as $file) {
																		$path_parts = pathinfo($file);
																		$extension  = array("psb","bmp","rle","dib","gif","eps","iff","tdi","jpg","jpeg","jpe","jpf","jpx","jp2","j2c","j2k","jpc","jps","mpo","pcx","raw","pxr","png","pns","pbm"); 
																	?>
																		<a class="file select" target="_blank" href="<?=$file?>" title="<?=$path_parts["basename"]?>">	
																	<?	if (in_array($path_parts['extension'], $extension)) { ?>
																			<div class="thumb" style="background-image: url('/files/upload/user/<?=$item->user_id?>/approval/<?=$item->id?>/<?=$path_parts["basename"]?>')"></div>	
																	<?  } else { ?>	
																			<div class="thumb" style="background-image: url('/files/themes/default/img/files/big/<?=$path_parts['extension']?>.png')"></div>
																	<?  } ?>
																		<div class="name"><?=$path_parts["basename"]?></div></a>
																	<?
																	}
																	?>
																	<script>$(".fa-attachment-<?=$item->id?>").show();</script>
																	<?
																} else {
																	echo "<p>No file exist.</p>";
																}
															?>
														</div>
														<div class="file-upload">
															<button type="button" class="btn btn-xs btn-default btn-browse" user-id="<?=$item->user_id?>" item-id="<?=$item->id?>">Browse...</button>
															<button type="button" class="btn btn-xs btn-primary btn-create-pdf" user-id="<?=$item->user_id?>" item-id="<?=$item->id?>">Make letter</button>
															<button type="button" class="btn btn-xs btn-primary btn-sendmail" user-id="<?=$item->user_id?>" item-id="<?=$item->id?>">Send letter</button>
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
			<? if (sizeof($countries) && ($admin->user_type == USR_SUPPER_ADMIN)) { ?>
				<!-- <div id="profit-colchart" class="full-width" style="height: 400px;"></div>
				<div id="booking-colchart" class="full-width" style="height: 400px;"></div>
				<div id="revenue-colchart" class="full-width" style="height: 400px;"></div> -->
			<? } ?>
			<? } ?>
		</form>
	</div>
</div>

<?
	$visa_types = $this->m_visa_type->items(NULL, 1);
	$visit_purposes = $this->m_visit_purpose->items(NULL, 1);
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
	$nations = $this->m_country->items();
?>
<div id="dialog-edit-option" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Visa Options</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Type of visa</label>
						</td>
						<td>
							<select id="visa_type" name="visa_type" class="form-control">
							<? foreach ($visa_types as $visa_type) { ?>
							<option value="<?=$visa_type->name?>"><?=$visa_type->name?></option>
							<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Purpose of visit</label>
						</td>
						<td>
							<select id="visit_purpose" name="visit_purpose" class="form-control">
							<? foreach ($visit_purposes as $visit_purpose) { ?>
							<option value="<?=$visit_purpose->name?>"><?=$visit_purpose->name?></option>
							<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Entry date</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="arrival_date" name="arrival_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Exit date</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="exit_date" name="exit_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Arrival port</label>
						</td>
						<td>
							<select id="arrival_port" name="arrival_port" class="form-control">
							<? foreach ($arrival_ports as $arrival_port) { ?>
							<option value="<?=$arrival_port->short_name?>"><?=$arrival_port->airport?></option>
							<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Flight information</label>
						</td>
						<td>
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<input type="text" id="flight_number" name="flight_number" value="" class="form-control">
										<div class="input-group-addon">
											<span class="fa fa-plane"></span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<input type="text" id="arrival_time" name="arrival_time" value="" class="form-control">
										<div class="input-group-addon">
											<span class="fa fa-clock-o"></span>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Processing type</label>
						</td>
						<td>
							<select id="rush_type" name="rush_type" class="form-control">
								<option value="0">Normal</option>
								<option value="1">Urgent</option>
								<option value="2">Emergency</option>
								<option value="3">Holiday</option>
							</select>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Private letter</label>
						</td>
						<td>
							<select id="private_visa" name="private_visa" class="form-control">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Full package</label>
						</td>
						<td>
							<select id="full_package" name="full_package" class="form-control">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Fast check-in</label>
						</td>
						<td>
							<select id="fast_checkin" name="fast_checkin" class="form-control">
								<option value="0">No</option>
								<option value="1">Normal</option>
								<option value="2">VIP</option>
							</select>
						</td>
					</tr>
					<tr class="hidden">
						<td class="text-right active" width="120px">
							<label class="form-label right">Car pick-up</label>
						</td>
						<td>
							<select id="car_pickup" name="car_pickup" class="form-control">
								<option value="0">No</option>
								<option value="4">4 seats</option>
								<option value="7">7 seats</option>
								<option value="16">16 seats</option>
								<option value="24">24 seats</option>
							</select>
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-update-option">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-edit-passport" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Passport Detail</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Full name</label>
						</td>
						<td>
							<input type="text" id="fullname" name="fullname" value="" class="form-control">
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Gender</label>
						</td>
						<td>
							<select id="gender" name="gender" class="form-control">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Date of birth</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="birthday" name="birthday" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Nationality</label>
						</td>
						<td>
							<select id="nationality" name="nationality" class="form-control">
							<? foreach ($nations as $nation) { ?>
							<option value="<?=$nation->name?>"><?=$nation->name?></option>
							<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Passport number</label>
						</td>
						<td>
							<input type="text" id="passport" name="passport" value="" class="form-control">
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-update-passport">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-edit-contact" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Contact Information</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Full name</label>
						</td>
						<td>
							<div class="row">
								<div class="col-sm-2">
									<select id="contact_title" name="contact_title" class="form-control">
										<option value="Mr">Mr</option>
										<option value="Ms">Ms</option>
										<option value="Mrs">Mrs</option>
									</select>
								</div>
								<div class="col-sm-10">
									<input type="text" id="contact_fullname" name="contact_fullname" value="" class="form-control">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Email</label>
						</td>
						<td>
							<input type="text" id="primary_email" name="primary_email" value="" class="form-control">
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Alternate email</label>
						</td>
						<td>
							<input type="text" id="secondary_email" name="secondary_email" value="" class="form-control">
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Phone number</label>
						</td>
						<td>
							<input type="text" id="contact_phone" name="contact_phone" value="" class="form-control">
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-update-contact">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-make-file" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Boarding Letter</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td>
							<textarea id="pdf-content" name="pdf-content" class="form-control tinymce" rows="20" style="height: 400px;" required></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
				<input type="hidden" id="user_id" name="user_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-create">Create</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-send-mail" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Compose Email</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Subject <span class="required">*</span></label>
						</td>
						<td>
							<input type="text" id="subject" name="subject" value="" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="text-right active">
							<label class="form-label right">Message <span class="required">*</span></label>
						</td>
						<td>
							<textarea id="message" name="message" class="form-control tinymce" rows="20" style="height: 300px;" required></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-send">Send</button>
			</div>
		</div>
	</div>
</div>
<? require_once(APPPATH."views/module/admin/upload_ckfinder.php"); ?>
<script src="//code.highcharts.com/highcharts.js"></script>
<script>
function openCdnKCFinderBrowse(field, url, user_id, id) {
	window.KCFinder = {
		callBack: function(url) {
			field.value = url;
			window.KCFinder = null;
		}
	};
	var popUp = window.open('<?=CDN_URL?>/files/browse.php?type=<?=BOOKING_PREFIX?>&dir=<?=BOOKING_PREFIX?>/user/' + url, 'kcfinder_browse',
		'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
		'resizable=1, scrollbars=0, width=800, height=600'
	);
	var pollTimer = window.setInterval(function() {
		if (popUp.closed !== false) {
			window.clearInterval(pollTimer);
			
			var p = {};
			p["user_id"] = user_id;
			p["id"] = id;
			p["field"] = field;
			
			$.ajax({
				type : 'POST',
				data : p,
				url : "<?=site_url('syslog/ajax-get-booking-download-files')?>",
				success : function(data){
					$(".file-path-"+id).html(data);
				},
				async:false
			});
		}
	}, 200);
}

$(document).ready(function() {
	var sortby  = "<?=(!empty($sortby)?$sortby:'booking_date')?>";
	var orderby = "<?=(!empty($orderby)?$orderby:'DESC')?>";

	$(".sortby").each(function() {
		if ($(this).attr("sortby") == sortby) {
			$(this).addClass("selected");
			$(this).addClass(orderby);
		}
	});
	
	$(".sortby").click(function() {
		if ($(this).attr("sortby") == sortby) {
			orderby = ((orderby == "DESC")?"ASC":"DESC");				
		}
		else {
			orderby = "DESC";
		}
		$("#sortby").val($(this).attr("sortby"));
		$("#orderby").val(orderby);
		submitButton("search");
	});
	
	$(".btn-browse").click(function() {
		var user_id = $(this).attr("user-id");
		var item_id = $(this).attr("item-id");
		var user_path = user_id + "/approval/" + item_id + "/";

		var p = {};
		p["user_path"] = user_path;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-mkdir")?>",
			data: p,
			success: function(result) {
				openCdnKCFinderBrowse('user', user_path, user_id, item_id);
			},
			async:false
		});
	});

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
			url: "<?=site_url("syslog/ajax-visa-booking-capital")?>",
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
			url: "<?=site_url("syslog/ajax-visa-booking-refund")?>",
			data: p
		});
	});

	$(".payment-status").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = parseInt(status_id);
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-payment-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-payment-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});

	$(".other-payment").click(function() {
		var booking_id = $(this).attr("booking-id");
		var status_id = $(this).attr("status-id");
		var email = $(this).attr("email");
		var status_label = $(this).html();
		
		var p = {};
		p["booking_id"] = booking_id;
		p["status_id"] = status_id;
		p["email"] = email;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-other-payment")?>",
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
			url: "<?=site_url("syslog/ajax-visa-booking-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-booking-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});

	$(".datepicker").daterangepicker({
		singleDatePicker: true
    });
	
	$(".btn-edit-option").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-option");
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-options/edit")?>",
			data: p,
			dataType: "json",
			success: function(data) {
				dialog.find("#item_id").val(item_id);
				dialog.find("#visa_type").val(data[0]);
				dialog.find("#visit_purpose").val(data[1]);
				dialog.find("#arrival_date").val(data[2]);
				dialog.find("#exit_date").val(data[3]);
				dialog.find("#arrival_port").val(data[4]);
				dialog.find("#flight_number").val(data[5]);
				dialog.find("#arrival_time").val(data[6]);
				dialog.find("#rush_type").val(data[7]);
				dialog.find("#private_visa").val(data[8]);
				dialog.find("#full_package").val(data[9]);
				dialog.find("#fast_checkin").val(data[10]);
				dialog.find("#car_pickup").val(data[11]);
				$("#arrival_date").data("daterangepicker").setStartDate(data[2]);
				$("#arrival_date").data("daterangepicker").setEndDate(data[2]);
				$("#exit_date").data("daterangepicker").setStartDate(data[3]);
				$("#exit_date").data("daterangepicker").setEndDate(data[3]);
				dialog.modal();
			}
		});
	});

	$(".btn-update-option").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-option");
		var p = {};
		p["id"] = dialog.find("#item_id").val();
		p["visa_type"] = dialog.find("#visa_type").val();
		p["visit_purpose"] = dialog.find("#visit_purpose").val();
		p["arrival_date"] = dialog.find("#arrival_date").val();
		p["exit_date"] = dialog.find("#exit_date").val();
		p["arrival_port"] = dialog.find("#arrival_port").val();
		p["flight_number"] = dialog.find("#flight_number").val();
		p["arrival_time"] = dialog.find("#arrival_time").val();
		p["rush_type"] = dialog.find("#rush_type").val();
		p["private_visa"] = dialog.find("#private_visa").val();
		p["full_package"] = dialog.find("#full_package").val();
		p["fast_checkin"] = dialog.find("#fast_checkin").val();
		p["car_pickup"] = dialog.find("#car_pickup").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-options/update")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
			}
		});
	});

	$(".btn-edit-passport").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-passport");
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-passport/edit")?>",
			data: p,
			dataType: "json",
			success: function(data) {
				dialog.find("#item_id").val(item_id);
				dialog.find("#fullname").val(data[0]);
				dialog.find("#gender").val(data[1]);
				dialog.find("#birthday").val(data[2]);
				dialog.find("#nationality").val(data[3]);
				dialog.find("#passport").val(data[4]);
				$("#birthday").data("daterangepicker").setStartDate(data[2]);
				$("#birthday").data("daterangepicker").setEndDate(data[2]);
				dialog.modal();
			}
		});
	});

	$(".btn-update-passport").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-passport");
		var p = {};
		p["id"] = dialog.find("#item_id").val();
		p["fullname"] = dialog.find("#fullname").val();
		p["gender"] = dialog.find("#gender").val();
		p["birthday"] = dialog.find("#birthday").val();
		p["nationality"] = dialog.find("#nationality").val();
		p["passport"] = dialog.find("#passport").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-passport/update")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
			}
		});
	});

	$(".btn-edit-contact").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-contact");
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-contact/edit")?>",
			data: p,
			dataType: "json",
			success: function(data) {
				dialog.find("#item_id").val(item_id);
				dialog.find("#contact_title").val(data[0]);
				dialog.find("#contact_fullname").val(data[1]);
				dialog.find("#primary_email").val(data[2]);
				dialog.find("#secondary_email").val(data[3]);
				dialog.find("#contact_phone").val(data[4]);
				dialog.modal();
			}
		});
	});

	$(".btn-update-contact").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-contact");
		var p = {};
		p["id"] = dialog.find("#item_id").val();
		p["contact_title"] = dialog.find("#contact_title").val();
		p["contact_fullname"] = dialog.find("#contact_fullname").val();
		p["primary_email"] = dialog.find("#primary_email").val();
		p["secondary_email"] = dialog.find("#secondary_email").val();
		p["contact_phone"] = dialog.find("#contact_phone").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-contact/update")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
			}
		});
	});

	$(".btn-create-pdf").click(function(e) {
		e.preventDefault();
		var item_id = $(this).attr("item-id");
		var user_id = $(this).attr("user-id");
		var p = {};
		p["id"] = item_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-load-boarding-letter-pdf-content")?>",
			data: p,
			success: function(result) {
				$("#dialog-make-file").find("#item_id").val(item_id);
				$("#dialog-make-file").find("#user_id").val(user_id);
				tinymce.get('pdf-content').setContent(result);
				$("#dialog-make-file").modal();
			}
		});
	});
	
	$(".btn-create").click(function() {
		var id = $("#dialog-make-file").find("#item_id").val();
		var user_id = $("#dialog-make-file").find("#user_id").val();
		
		var p = {};
		p["id"] = id;
		p["content"] = tinymce.get('pdf-content').getContent();
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-create-boarding-letter")?>",
			data: p,
			success: function(data) {
				$("#dialog-make-file").modal("hide");
			},
			async:false
		});
		
		p["user_id"] = user_id;
		p["field"] = "user";
		
		$.ajax({
			type : 'POST',
			data : p,
			url : "<?=site_url('syslog/ajax-get-booking-download-files')?>",
			success : function(data){
				$(".file-path-"+id).html(data);
			},
			async:false
		});
	});

	$(".btn-sendmail").click(function(e) {
		e.preventDefault();
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-boarding-letter/compose")?>",
			data: p,
			dataType: "json",
			success: function(result) {
				$("#dialog-send-mail").find("#item_id").val(item_id);
				$("#dialog-send-mail").find("#subject").val(result[0]);
				tinymce.get('message').setContent(result[1]);
				$("#dialog-send-mail").modal();
			}
		});
	});
	
	$(".btn-send").click(function() {
		var p = {};
		p["id"] = $("#dialog-send-mail").find("#item_id").val();
		p["subject"] = $("#dialog-send-mail").find("#subject").val();
		p["message"] = tinymce.get('message').getContent();
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-boarding-letter/send")?>",
			data: p,
			success: function(result) {
				messageBox("INFO", "Compose Email", result);
				$("#dialog-send-mail").modal("hide");
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
		$("#search_visa_type").val($("#report_visa_type :selected").val());
		$("#search_visit_purpose").val($("#report_visit_purpose :selected").val());
		$("#search_country").val($("#report_country :selected").val());
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
	
	// if ($("#booking-colchart").length) {
	// 	Highcharts.chart('booking-colchart', {
	//         chart: {
	//             type: 'column'
	//         },
	//         title: {
	//             text: 'Location Report'
	//         },
	//         subtitle: {
	//             text: 'Total: <?//=sizeof($countries)." countries - ".number_format($total_succed)." bookings"?>'
	//         },
	//         xAxis: {
	//             categories: [
	// 			<?// foreach ($countries as $name => $val) {
	// 				echo "'".addslashes($name)."',";
	// 			} ?>
	//             ],
	//             crosshair: true
	//         },
	//         yAxis: {
	//             min: 0,
	//             title: {
	//                 text: 'Number of Bookings'
	//             }
	//         },
	//         tooltip: {
	//             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	//             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	//                 '<td style="padding:0"><b>{point.y} bookings</b></td></tr>',
	//             footerFormat: '</table>',
	//             shared: true,
	//             useHTML: true
	//         },
	//         plotOptions: {
	//             column: {
	//                 pointPadding: 0.2,
	//                 borderWidth: 0,
	//                 dataLabels: {
	// 					enabled: true,
	// 					style: {
	// 						fontWeight: 'normal',
	// 						color: '#666666',
	// 						fill: '#666666'
	// 					}
	// 				}
	//             }
	//         },
	//         series: [{
	// 			name: 'Total',
	// 			data: [
	// 			<?// foreach ($countries as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Return',
	// 			data: [
	// 			<?// foreach ($return_user as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Promotion',
	// 			data: [
	// 			<?// foreach ($promotions as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}
	//         ]
	//     });
	// }

	// if ($("#revenue-colchart").length) {
	// 	Highcharts.chart('revenue-colchart', {
	//         chart: {
	//             type: 'column'
	//         },
	//         title: {
	//             text: 'Revenue Report'
	//         },
	//         subtitle: {
	//             text: 'Total: <?//=number_format($total_succed)." bookings - ".number_format($total_amount)." USD"?>'
	//         },
	//         xAxis: {
	//             categories: [
	// 			<?// foreach ($countries as $name => $val) {
	// 				echo "'".addslashes($name)."',";
	// 			} ?>
	//             ],
	//             crosshair: true
	//         },
	//         yAxis: {
	//             min: 0,
	//             title: {
	//                 text: 'Number of Revenue'
	//             }
	//         },
	//         tooltip: {
	//             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	//             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	//                 '<td style="padding:0"><b>{point.y} USD</b></td></tr>',
	//             footerFormat: '</table>',
	//             shared: true,
	//             useHTML: true
	//         },
	//         plotOptions: {
	//             column: {
	//                 pointPadding: 0.2,
	//                 borderWidth: 0,
	//                 dataLabels: {
	// 					enabled: true,
	// 					style: {
	// 						fontWeight: 'normal',
	// 						color: '#666666',
	// 						fill: '#666666'
	// 					}
	// 				}
	//             }
	//         },
	//         series: [{
	// 			name: 'Total',
	// 			data: [
	// 			<?// foreach ($revenue as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Return',
	// 			data: [
	// 			<?// foreach ($return_revenue as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Promotion',
	// 			data: [
	// 			<?// foreach ($promotion_revenue as $name => $val) {
	// 				echo $val.",";
	// 			} ?>
	// 			]
	// 		}
	//         ]
	//     });
	// }

	// if ($("#profit-colchart").length) {
	// 	Highcharts.chart('profit-colchart', {
	//         chart: {
	//             type: 'column'
	//         },
	//         title: {
	//             text: 'Profit Report'
	//         },
	//         subtitle: {
	//             text: 'Total: <?//=number_format($total_succed)." bookings - ".number_format($total_profit - round($total_amount * $ratio))." USD"?>'
	//         },
	//         xAxis: {
	//             categories: [
	// 			<?//foreach ($countries as $name => $val) {
	// 				echo "'".addslashes($name)."',";
	// 			} ?>
	//             ],
	//             crosshair: true
	//         },
	//         yAxis: {
	//             min: 0,
	//             title: {
	//                 text: 'Number of Profit'
	//             }
	//         },
	//         tooltip: {
	//             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	//             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	//                 '<td style="padding:0"><b>{point.y} USD</b></td></tr>',
	//             footerFormat: '</table>',
	//             shared: true,
	//             useHTML: true
	//         },
	//         plotOptions: {
	//             column: {
	//                 pointPadding: 0.2,
	//                 borderWidth: 0,
	//                 dataLabels: {
	// 					enabled: true,
	// 					style: {
	// 						fontWeight: 'normal',
	// 						color: '#666666',
	// 						fill: '#666666'
	// 					}
	// 				}
	//             }
	//         },
	//         series: [{
	// 			name: 'Total',
	// 			data: [
	// 			<?// foreach ($profit as $name => $val) {
	// 				echo ($val - round($val * $ratio)).",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Return',
	// 			data: [
	// 			<?// foreach ($return_profit as $name => $val) {
	// 				echo ($val - round($val * $ratio)).",";
	// 			} ?>
	// 			]
	// 		}, {
	// 			name: 'Promotion',
	// 			data: [
	// 			<?// foreach ($promotion_profit as $name => $val) {
	// 				echo ($val - round($val * $ratio)).",";
	// 			} ?>
	// 			]
	// 		}
	//         ]
	//     });
	// }
});
</script>