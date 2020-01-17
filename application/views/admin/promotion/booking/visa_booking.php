<?
	$admin = $this->session->userdata("admin");
	
	if ($sum_vs < 10) {
		$ratio = 0;
	} else {
		$ratio = 5/100;
	}
	
	$captital = $sum_cp;
	if ($captital) {
		$captital += round(($sum_op+$sum_pp+$sum_gs) * $ratio);
	}
	
	$countries = array();
	foreach ($items as $item) {
		if (!empty($item->client_ip)) {
			if ($item->status) {
				if (array_key_exists($item->country_name, $countries)) {
					$countries[$item->country_name] = $countries[$item->country_name] + 1;
				} else {
					$countries[$item->country_name] = 1;
				}
			}
		}
	}
	ksort($countries);
?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Visa Bookings with Codes
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for application ID">
							</div>
						</div>
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
						<div class="pull-left" style="max-width: 220px;">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control daterange">
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Report</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</h1>
		</div>
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
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/promotion-booking")?>" method="POST">
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
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<tr>
						<th class="text-center" width="5">
							#
						</th>
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
						<th class="sortby" sortby="primary_email">
							Email
						</th>
						<th class="text-center sortby" sortby="visa_type">
							Type
						</th>
						<th class="text-center sortby" sortby="payment_method">
							Payment
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
							Paid
						</th>
						<th class="text-center">
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
										<a class="collapsed" data-toggle="collapse" href="<?="#".$item->id?>" aria-expanded="false" aria-controls="collapse<?=$item->id?>"><?=BOOKING_PREFIX.$item->id?></a>
									</td>
									<td>
										<?=$item->primary_email?>
									</td>
									<td width="4%" class="text-center">
										<?=strtoupper($this->m_visa_type->search_by_name($item->visa_type)->code)?>
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
													if ($pax->book_id == $item->id) {
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
													$trl_lines .= '<tr><td class="text-center" '.$style.'>'.($i+1).'</td><td '.$style.'>'.$travelers[$i]->fullname.'</td><td class="text-center" '.$style.'>'.$travelers[$i]->gender.'</td><td class="text-center" '.$style.'>'.date("M/d/Y", strtotime($travelers[$i]->birthday)).'</td><td class="text-center" '.$style.'>'.$travelers[$i]->nationality.'</td><td class="text-center" '.$style.'>'.$travelers[$i]->passport.'</td></tr>';
												}
												
												$visa_type = '<tr><td>Type of visa</td><td>'.$item->visa_type.'</td></tr>';
												
												$serviceFee = "";
												if ($item->booking_type_id == 2) {
													$serviceFee .= '<tr><td>Visa stamping fee</td><td> : </td><td>'.$item->stamp_fee.' USD/pax</td></tr>';
													foreach ($nationalities as $key => $val) {
														$serviceFee .= '<tr><td>Visa service fee for '.$key.'</td><td>'.$item->visa_fee.' USD/pax</td></tr>';
													}
												} else {
													foreach ($nationalities as $key => $val) {
														$serviceFee .= '<tr><td>Visa service fee for '.$key.'</td><td>'.$item->visa_fee.' USD/pax</td></tr>';
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
												
												echo '<div class="panel panel-default">
															<div class="panel-heading"><strong>Visa Information Details</strong></div>
															<div class="panel-body">
																<div>
																	<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																		A. Visa Options
																	</div>
																	<div style="padding: 0 0 10px 40px;">
																		<table class="table table-bordered table-striped">
																			'.$visa_type.'
																			<tr><td width="20%">Purpose of visit</td><td>'.$item->visit_purpose.'</td></tr>
																			<tr><td>Entry date</td><td>'.date("M/d/Y",strtotime($item->arrival_date)).'</td></tr>
																			<tr><td>Exit date</td><td>'.date("M/d/Y",strtotime($item->exit_date)).'</td></tr>
																			<tr><td>Entry through checkpoint</td><td>'.$item->arrival_port.'</td></tr>
																			<tr><td>Exit through checkpoint</td><td>'.$item->exit_port.'</td></tr>
																			'.$flightNumber.$arrivalTime.'
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
																				<th class="text-center">No.</th>
																				<th class="text-left">Full name</th>
																				<th class="text-center">Gender</th>
																				<th class="text-center">Date of birth</th>
																				<th class="text-center">Nationality</th>
																				<th class="text-center">Passport number</th>
																			</tr>
																			'.$trl_lines.'
																		</table>
																	</div>
																</div>
																<div>
																	<div style="font-weight: bold; padding: 10px 0 10px 20px;">
																		C. Contact Information
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
									        					$nfile = 0;
																$path = "./files/upload/user/{$item->user_id}/approval/{$item->id}/";
	
																if (file_exists($path)) {
																	// Get array of all source files
																	$files = scandir($path);
																	
																	// Cycle through all source files
																	foreach ($files as $file) {
																		if (in_array($file, array(".",".."))) continue;
																		$filename 	= pathinfo($file);
																		$extension  = array("psb","bmp","rle","dib","gif","eps","iff","tdi","jpg","jpeg","jpe","jpf","jpx","jp2","j2c","j2k","jpc","jps","mpo","pcx","raw","pxr","png","pns","pbm"); 
																	?>
																		<a class="file select" target="_blank" href="<?=BASE_URL?>/files/upload/user/<?=$item->user_id?>/approval/<?=$item->id?>/<?=$file?>" title="<?=$file?>">	
																	<?	if (in_array($filename['extension'],$extension)) { ?>
																			<div class="thumb" style="background-image: url('<?=BASE_URL?>/files/upload/user/<?=$item->user_id?>/approval/<?=$item->id?>/<?=$file?>')"></div>	
																	<?  } else { ?>	
																			<div class="thumb" style="background-image: url('<?=BASE_URL?>/files/themes/default/img/files/big/<?=$filename['extension']?>.png')"></div>
																	<?  } ?>
																			<div class="name"><?=$file?></div></a>	
																	<?
																		$nfile++;
																	}
																}
																
																if (!$nfile) {
																	echo "<p>No file exist.</p>";
																}
																else {
																	?>
																	<script>$(".fa-attachment-<?=$item->id?>").show();</script>
																	<?
																}
									        				?>
								        				</div>
								        				<div class="file-upload">
								        					<button type="button" class="btn btn-xs btn-primary btn-browse" user-id="<?=$item->user_id?>" item-id="<?=$item->id?>">Browse...</button>
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
		</form>
	</div>
</div>

<script>
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
				openKCFinderBrowse('user', user_path, user_id, item_id);
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
		p["status_id"] = status_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-payment-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-payment-status-" + booking_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
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
});
</script>