.
<?
	$admin = $this->session->userdata("admin");
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
?>

<style>
.<?=BOOKING_PREFIX?> {
}
.<?=BOOKING_PREFIX_PO?>, .<?=BOOKING_PREFIX_PO?> td {
	background-color: #FFFFDD !important;
}
.<?=BOOKING_PREFIX_EX?>, .<?=BOOKING_PREFIX_EX?> td {
	background-color: #FF9900 !important;
}
#export-list th {
	border-right: 1px solid #E5E5E5 !important;
	background: #F5F5F5 !important;
}
#export-list td {
	border-right: 1px solid #E5E5E5 !important;
}
</style>
<?
	$arr_type = array(
		'1 month single' => '',
		'1 month multiple' => '1TNL',
		'3 months single' => '3T1L',
		'3 months multiple' => '3TNL',
		'6 months multiple' => '6TNL',
		'1 year multiple' => '1NNL',
	);
?>
<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar ">
			<h1 class="page-title clearfix">
				Visa FC List
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="max-width: 320px; margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control daterange">
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Report</button>
								</span>
							</div>
						</div>
						<!-- <? if(!empty($items)) { ?>
						<div class="pull-left">
							<button onclick="tableToExcel('export-list', 'List')" class="btn btn-sm btn-success btn-download" type="button"><i class="fa fa-download"></i> Download</button>
						</div>
						<? } else { ?>
						<div class="pull-left" style="cursor: no-drop">
							<button disabled class="btn btn-sm btn-default" type="button"><i class="fa fa-download"></i> Download</button>
						</div>
						<? } ?> -->
					</div>
				</div>
			</h1>
		</div>
		<script type="text/javascript">
			$('#visa_purpose')
		</script>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<ul class="nav nav-tabs tab-agent" role="tablist">
				<? foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($agents_fc_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/visa-fc-list/{$agent->id}")?>">
						<h5><?=$agent->name?></h5>
						<p>(<?=$agent->company?>)</p>
					</a>
				</li>
				<? } ?>
			</ul>
			<div class="tbl-visa-fee">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#for-tourist" aria-controls="for-tourist" role="tab" data-toggle="tab">For tourist</a></li>
					<li role="presentation" class=""><a href="#for-business" aria-controls="for-business" role="tab" data-toggle="tab">For business</a></li>
				</ul>
				<div class="table-responsive" style="font-size: 12px;">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="for-tourist">
							<table id="export-list" class="table table-bordered table-hover">
								<tr>
									<th style="border-right: thin solid #999;background: #009e00;" width="20px">
										No.
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" width="100px">
										Booking ID
									</th>
									<th style="border-right: thin solid #999;background: #009e00;width: 150px;">
										Fullname
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Gender
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Birth Date
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Nationality
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Passport No
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Arrival Date
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Arrival Port
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Type
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Purpose
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Private
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Process
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										FC
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Flight
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Note
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Fc fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Stamp fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Car fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Fee+
									</th>
								</tr>
								<? $j=0;
								$total_fc_fee = 0;
								$total_stamp_fee = 0;
								$total_car_fee = 0;
								$total_plus_fc_fee = 0;
								foreach ($items as $item) { 
									if ($item->visit_purpose == 'For tourist' && ($item->send_pickup == 2)  && (!empty($item->fast_checkin) || !empty($item->car_pickup) || !empty($item->full_package))) {
								?>
								<tr class="row1 prss0">
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=$j+1?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=BOOKING_PREFIX.$item->book_id?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<?=$item->fullname?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->gender?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=date('M/d/Y',strtotime($item->birthday))?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->nationality?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->passport?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=date('M/d/Y',strtotime($item->arrival_date))?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->arrival_port?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center"><?=$arr_type[$item->visa_type]?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->visit_purpose?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="80px"><?=!empty($item->private_visa) ? 'CV riêng' : ''?></td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<? if(empty($item->note_process)) {
											if ($item->visit_purpose == 'For tourist'){
												switch ($item->rush_type) {
													case 1:
														echo 'URG4H';
														break;
													case 2:
														echo 'URG1H';
														break;
													case 3:
														echo 'DNG';
														break;
												}
											} else {
												switch ($item->rush_type) {
													case 1:
														echo 'URG8H';
														break;
													case 2:
														echo 'URG4H';
														break;
													case 3:
														echo 'DNG';
														break;
												}
											}
										} else {
											echo $item->note_process;
										}?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?
											if ($item->note_fc == null || $item->note_fc == 0) {
												echo $this->util->fc($item->full_package,$item->fast_checkin,$item->car_pickup)[1];
											} else {
												echo $this->util->note_fc($item->note_fc);
											}
										?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?=!empty($item->flight_number) ? $item->flight_number : '';?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?=!empty($item->note) ? $item->note : ''; ?>
									</td>
									<?
										$fc_fee = 0;
										$stamp_fee = 0;
										$car_fee = 0;
										$type='';
										$type .= 'tourist_';
										switch ($item->visa_type) {
											case '1 month single':
												$type .= '1ms';
												$stamping_fee = 25;
												break;
											case '1 month multiple':
												$type .= '1mm';
												$stamping_fee = 50;
												break;
											case '3 months single':
												$type .= '3ms';
												$stamping_fee = 25;
												break;
											case '3 months multiple':
												$type .= '3mm';
												$stamping_fee = 50;
												break;
											case '6 months multiple':
												$type .= '6mm';
												$stamping_fee = 95;
												break;
											case '1 year multiple':
												$type .= '1ym';
												$stamping_fee = 135;
												break;
										}

										$processing = '';
										if(empty($item->note_process)) {
											switch ($item->rush_type) {
												case 1:
													$processing = $type.'_8h';
													break;
												case 2:
													$processing = $type.'_1h';
													break;
												case 3:
													$processing = $type.'_dng';
													break;
											}
										} else {
											switch (strtoupper(trim($item->note_process))) {
												case 'URG8H':
													$processing = $type.'_8h';
													break;
												case 'URG4H':
													$processing = $type.'_4h';
													break;
												case 'URG1H':
													$processing = $type.'_1h';
													break;
												case 'DNG':
													$processing = $type.'_dng';
													break;
												case 'BLSB':
													$processing = $type.'_blsb';
													break;
											}
										}

										$info = new stdClass();
										$info->airport = $item->airport_id;
										$info->agents_id = $item->agents_id;
										$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
										if (!empty($item->full_package)) {
											$fc_fee += $agent_fast_checkin_fee[0]->fc;

											$stamp_fee += $stamping_fee;

										} else {
											if (!empty($item->fast_checkin)) {
												$fc_fee += $agent_fast_checkin_fee[0]->fc;
											}
											
										}
										if (!empty($item->car_pickup)) {
											$seats = "seat_{$item->seats}";
											$info = new stdClass();
											$info->airport = $item->airport_id;
											$info->agents_id = $item->agents_id;
											$agent_car_fee = $this->m_agent_car_fee->items($info);
											$car_fee += $agent_car_fee[0]->{$seats};
										}
										$total_fc_fee += $fc_fee;
										$total_stamp_fee += $stamp_fee;
										$total_car_fee += $car_fee;
										$total_plus_fc_fee += $item->plus_fc_fee;
									?>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$fc_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$stamp_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$car_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="plus_fc_fee" value="<?=$item->plus_fc_fee?>" pro-type="plus_fc_fee" typ="t" old-val="<?=$item->plus_fc_fee?>" item-id="<?=$item->id?>" style="border:none;text-align: center;width: 40px;">
									</td>
								</tr>
								<? $j++; } } ?>
								<tr>
									<td colspan="16" style="text-align: center;"><strong>Total: $</strong><strong class="t-total-fee"><?=($total_fc_fee + $total_stamp_fee + $total_car_fee + $total_plus_fc_fee)?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_fc_fee?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_stamp_fee?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_car_fee?></strong></td>
									<td style="text-align: center;"><strong>$</strong><strong class="t-total-plus-fee"><?=$total_plus_fc_fee?></strong></td>
								</tr>
							</table>
						</div>
						<div role="tabpanel" class="tab-pane" id="for-business">
							<table id="export-list" class="table table-bordered table-hover">
								<tr>
									<th style="border-right: thin solid #999;background: #009e00;" width="20px">
										No.
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" width="100px">
										Booking ID
									</th>
									<th style="border-right: thin solid #999;background: #009e00;width: 150px;">
										Fullname
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Gender
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Birth Date
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Nationality
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Passport No
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Arrival Date
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Arrival Port
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Type
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Purpose
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Private
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Process
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										FC
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Flight
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Note
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Fc fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Stamp fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Car fee
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Fee+
									</th>
								</tr>
								<? $j=0;
								$total_fc_fee = 0;
								$total_stamp_fee = 0;
								$total_car_fee = 0;
								$total_plus_fc_fee = 0;
								foreach ($items as $item) { 
									if ($item->visit_purpose == 'For business' && ($item->send_pickup == 2) && (!empty($item->fast_checkin) || !empty($item->car_pickup) || !empty($item->full_package))) {
								?>
								<tr class="row1 prss0">
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=$j+1?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=BOOKING_PREFIX.$item->book_id?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<?=$item->fullname?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->gender?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=date('M/d/Y',strtotime($item->birthday))?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->nationality?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->passport?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=date('M/d/Y',strtotime($item->arrival_date))?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->arrival_port?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center"><?=$arr_type[$item->visa_type]?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$item->visit_purpose?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="80px"><?=!empty($item->private_visa) ? 'CV riêng' : ''?></td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<? if(empty($item->note_process)) {
											if ($item->visit_purpose == 'For tourist'){
												switch ($item->rush_type) {
													case 1:
														echo 'URG4H';
														break;
													case 2:
														echo 'URG1H';
														break;
													case 3:
														echo 'DNG';
														break;
												}
											} else {
												switch ($item->rush_type) {
													case 1:
														echo 'URG8H';
														break;
													case 2:
														echo 'URG4H';
														break;
													case 3:
														echo 'DNG';
														break;
												}
											}
										} else {
											echo $item->note_process;
										}?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?
											if ($item->note_fc == null || $item->note_fc == 0) {
												echo $this->util->fc($item->full_package,$item->fast_checkin,$item->car_pickup)[1];
											} else {
												echo $this->util->note_fc($item->note_fc);
											}
										?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?=!empty($item->flight_number) ? $item->flight_number : '';?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<?=!empty($item->note) ? $item->note : ''; ?>
									</td>
									<?
										$visa_fee = 0;
										$fc_fee = 0;
										$stamp_fee = 0;
										$car_fee = 0;
										$type='';
										$type .= 'business_';
										switch ($item->visa_type) {
											case '1 month single':
												$type .= '1ms';
												$stamping_fee = 25;
												break;
											case '1 month multiple':
												$type .= '1mm';
												$stamping_fee = 50;
												break;
											case '3 months single':
												$type .= '3ms';
												$stamping_fee = 25;
												break;
											case '3 months multiple':
												$type .= '3mm';
												$stamping_fee = 50;
												break;
											case '6 months multiple':
												$type .= '6mm';
												$stamping_fee = 95;
												break;
											case '1 year multiple':
												$type .= '1ym';
												$stamping_fee = 135;
												break;
										}

										$processing = '';
										if(empty($item->note_process)) {
											switch ($item->rush_type) {
												case 1:
													$processing = $type.'_8h';
													break;
												case 2:
													$processing = $type.'_1h';
													break;
												case 3:
													$processing = $type.'_dng';
													break;
											}
										} else {
											switch (strtoupper(trim($item->note_process))) {
												case 'URG8H':
													$processing = $type.'_8h';
													break;
												case 'URG4H':
													$processing = $type.'_4h';
													break;
												case 'URG1H':
													$processing = $type.'_1h';
													break;
												case 'DNG':
													$processing = $type.'_dng';
													break;
												case 'BLSB':
													$processing = $type.'_blsb';
													break;
											}
										}

										$info = new stdClass();
										$info->airport = $item->airport_id;
										$info->agents_id = $item->agents_id;
										$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
										if (!empty($item->full_package)) {
											$fc_fee += $agent_fast_checkin_fee[0]->fc;

											$stamp_fee += $stamping_fee;

										} else {
											if (!empty($item->fast_checkin)) {
												$fc_fee += $agent_fast_checkin_fee[0]->fc;
											}
											
										}
										if (!empty($item->car_pickup)) {
											$seats = "seat_{$item->seats}";
											$info = new stdClass();
											$info->airport = $item->airport_id;
											$info->agents_id = $item->agents_id;
											$agent_car_fee = $this->m_agent_car_fee->items($info);
											$car_fee += $agent_car_fee[0]->{$seats};
										}
										$total_fc_fee += $fc_fee;
										$total_stamp_fee += $stamp_fee;
										$total_car_fee += $car_fee;
										$total_plus_fc_fee += $item->plus_fc_fee;
									?>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$fc_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$stamp_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<?=$car_fee;?>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="plus_fc_fee" value="<?=$item->plus_fc_fee?>" pro-type="plus_fc_fee" typ="b" old-val="<?=$item->plus_fc_fee?>" item-id="<?=$item->id?>" style="border:none;text-align: center;width: 40px;">
									</td>
								</tr>
								<? $j++; } } ?>
								<tr>
									<td colspan="16" style="text-align: center;"><strong>Total: $</strong><strong class="b-total-fee"><?=($total_fc_fee + $total_stamp_fee + $total_car_fee + $total_plus_fc_fee)?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_fc_fee?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_stamp_fee?></strong></td>
									<td style="text-align: center;"><strong>$<?=$total_car_fee?></strong></td>
									<td style="text-align: center;"><strong>$</strong><strong class="b-total-plus-fee"><?=$total_plus_fc_fee?></strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(".note-input").click(function() {
		$(this).select();
	});
	$(document).on('change', '.note-input', function(event) {
		event.preventDefault();
		var item_id = $(this).attr("item-id");
		var pro_type = $(this).attr("pro-type");
		var typ = $(this).attr("typ");
		var old_val = parseFloat($(this).attr("old-val"));
		var val = parseFloat($(this).val());
		var result = val - old_val;

		var tpf = parseFloat($('.'+typ+'-total-plus-fee').html());
		var tf = parseFloat($('.'+typ+'-total-fee').html());
		$('.'+typ+'-total-plus-fee').html(Math.abs(tpf+result));
		$('.'+typ+'-total-fee').html(Math.abs(tf+result));
		$(this).attr('old-val',val);
		
		var p = {};
		p["item_id"] = item_id;
		p["pro_type"] = pro_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-pax")?>",
			data: p
		});
	});
	$(".payment-pax").click(function() {
		var item_id = $(this).attr("item-id");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["item_id"] = item_id;
		p["status_id"] = parseInt(status_id);
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-pax-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-payment-pax-" + item_id).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});
	$(".agents-pax").click(function() {
		var item_id = $(this).attr("item-id");
		var agents_fc_id = $(this).attr("agents-id");
		var agents_label = $(this).html();
		
		var p = {};
		p["item_id"] = item_id;
		p["agents_fc_id"] = parseInt(agents_fc_id);
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-fc-pax-status")?>",
			data: p,
			success: function(result) {
				location.reload();
			}
		});
	});
$(document).ready(function() {
	
	$(".btn-send").click(function(){
		$('#task').val('send-visa');
		submitButton();
	});
});
</script>
<script>
$(document).ready(function() {
	if ($(".daterange").length) {
		$(".daterange").daterangepicker({
			startDate: "<?=date('m/d/Y H:i', strtotime((!empty($fromdate)?$fromdate:date('m/d/Y H:i', mktime(0, 0, 0, date('m'), date('d'), date('Y'))))))?>",
			endDate: "<?=date('m/d/Y H:i', strtotime((!empty($todate)?$todate:"now")))?>",
			timePicker: true,
			timePicker24Hour: true,
			locale: {
				format: 'MM/DD/YYYY h:mm A'
			}
		});
	}
	
	$(".btn-report").click(function(){
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD HH:mm:ss'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD HH:mm:ss'));
		}
		submitButton("search");
	});
});
</script>
<script type="text/javascript">
	// var tableToExcel = (function() {
	// 	var uri = 'data:application/vnd.ms-excel;base64,',
	// 	template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
	// 	base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
	// 	format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	// 	return function(table, name) {
	// 		if (!table.nodeType) table = document.getElementById(table)
	// 		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
	// 		var link = document.createElement("a");
	// 		link.download = "List <?//=date('M-d-Y',strtotime($fromdate))?> to <?//=date('M-d-Y',strtotime($todate))?>.xls";
	// 		link.href = uri + base64(format(template, ctx));
	// 		link.click();
	// 	}
	// })()
</script>