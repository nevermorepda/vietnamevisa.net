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
				Visa Approved List
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
				<li role="presentation" class="<?=($agents_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/visa-approved-list/{$agent->id}")?>">
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
									<th style="border-right: thin solid #999;background: #009e00;" width="100px">
										App No
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
										Attach File
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Status
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Agents
									</th>
								</tr>
								<? $j = 0; foreach ($items as $item) { 
									if ($item->visit_purpose == 'For tourist') {
								?>
								<tr class="row1 prss0">
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=$j+1;?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" id="<?=$item->pax_id?>">
									<?
										if ($item->booking_type_id == 1)
											echo BOOKING_PREFIX.$item->book_id;
										else
											echo BOOKING_E_PREFIX.$item->book_id;
									?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<input type="text" class="note-input" name="fullname" value="<?=$item->fullname?>" pro-type="fullname" item-id="<?=$item->id?>" style="border:none;width: 150px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="gender" value="<?=$item->gender?>" pro-type="gender" item-id="<?=$item->id?>" style="border:none;width: 50px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="birthday" value="<?=date('Y-m-d',strtotime($item->birthday))?>" pro-type="birthday" item-id="<?=$item->id?>" style="border:none;width: 75px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="nationality" value="<?=$item->nationality?>" pro-type="nationality" item-id="<?=$item->id?>" style="border:none;width: 120px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="passport" value="<?=$item->passport?>" pro-type="passport" item-id="<?=$item->id?>" style="border:none;width: 75px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="date" class="note-input-arrivaldate note-input-arrivaldate-<?=$item->book_id?>" name="arrival_date" value="<?=date('Y-m-d',strtotime($item->arrival_date))?>" pro-type="arrival_date" item-id="<?=$item->book_id?>" style="border:none;width: 120px;text-align: center;height:20px;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<select name="arrival_port" class="arrival_port note-input-arrivalport note-input-arrivalport-<?=$item->book_id?>" pro-type="arrival_port" item-id="<?=$item->book_id?>" style="border:none;width: 90px;text-align: center;height:20px;">
											<? foreach ($arrival_ports as $arrival_port) {
												?>
												<option value="<?=$arrival_port->short_name?>"><?=$arrival_port->short_name?></option>
											<?	
											}
											?>
										</select>
										<script type="text/javascript">
											$('.note-input-arrivalport-<?=$item->book_id?>').val('<?=$item->arrival_port?>');
										</script>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center"><?=$arr_type[$item->visa_type]?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<select name="visit_purpose" class="visit_purpose note-input-purpose note-input-purpose-<?=$item->book_id?>" pro-type="visit_purpose" item-id="<?=$item->book_id?>" style="border:none;width: 90px;text-align: center;height:20px;">
											<option value="For tourist">For tourist</option>
											<option value="For business">For business</option>
										</select>
										<script type="text/javascript">
											$('.note-input-purpose-<?=$item->book_id?>').val('<?=$item->visit_purpose?>');
										</script>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="80px"><?=!empty($item->private_visa) ? 'CV riêng' : ''?></td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<input type="text" class="note-input note_process" name="note_process" value="<? if(empty($item->note_process)) {
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
											}?>" pro-type="note_process" item-id="<?=$item->id?>" style="border:none;width: 70px;text-align: center;">
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<select name="note_fc" class="change-services chang-services-<?=$item->book_id?>" pro-type="note_fc" item-id="<?=$item->book_id?>" style="border:none;text-align: center;width: 115px;">
											<option value="0"></option>
											<option value="1">Đón</option>
											<option value="2">Xe</option>
											<option value="3">Đón + Xe</option>
											<option value="4">Đón + Phí</option>
											<option value="5">Đón + Phí + Xe</option>
										</select>
										<script type="text/javascript">
											$('.chang-services-<?=$item->book_id?>').val('<?
												if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->booking_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->booking_date} + 2days"))) && ($item->agents_id == $item->agents_fc_id))
												{
													echo $this->util->fc($item->full_package,$item->fast_checkin,$item->car_pickup,$item->booking_type_id)[0];
												} else {
													echo 0;
												}
											?>');
										</script>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<input type="text" class="note-input flight_number" name="flight_number" value="<?
											if(!empty($item->flight_number)) { 
												echo $item->flight_number;
											} else {
												if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->booking_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->booking_date} + 2days"))) && ($item->agents_id == $item->agents_fc_id) && (!empty($item->fast_checkin) || !empty($item->car_pickup) || !empty($item->full_package))) {
													echo $item->vb_flight_number.' - '.$item->arrival_time;
												}
											}
										?>" pro-type="flight_number" item-id="<?=$item->id?>" style="border:none;text-align: center;width: 170px;">
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<textarea style="border:none;text-align: center;" class="note-input" name="note" pro-type="note" item-id="<?=$item->id?>" rows="1"><?=!empty($item->note) ? $item->note : ''; ?></textarea>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<label style="cursor: pointer;">
											<i class="fa fa-upload" data-toggle="modal" data-target="#myModal" pax_id="<?=$item->pax_id?>"></i>
										</label>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-payment-pax-<?=$item->id?>" data-toggle="dropdown">
												<? if($item->send_approved == 1) { ?>
												<span class="label label-success">Send</span> <i class="fa fa-caret-down"></i>
												<? } else { ?>
												<span class="label label-danger " style="background:#777777">Sent</span> <i class="fa fa-caret-down"></i>
												<? } ?>
											</a>
											<ul class="dropdown-menu">
												<li>
													<a title="" class="payment-pax" item-id="<?=$item->id?>" status-id="1"><span class="label label-success">Send</span></a>
													<a title="" class="payment-pax" item-id="<?=$item->id?>" status-id="0"><span class="label label-danger " style="background:#777777">Sent</span></a>
												</li>
											</ul>
										</div>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-agents-pax-<?=$item->id?>" data-toggle="dropdown">
												<? $i=1; foreach ($agents as $agent) { 
													switch ($agent->id) {
														case 1:
															$label = 'success';
															break;
														case 2:
															$label = 'primary';
															break;
														case 3:
															$label = 'info';
															break;
														case 4:
															$label = 'warning';
															break;
														case 5:
															$label = 'danger';
															break;
													}
													if ($item->agents_id == $agent->id) {
														echo '<span class="label label-'.$label.'">'.$agent->name.'</span> <i class="fa fa-caret-down"></i>';
													}
													$i++;
												}
												?>
											</a>
											<ul class="dropdown-menu">
												<? $i=1; foreach ($agents as $agent) {
													switch ($i) {
														case 1:
															$label = 'success';
															break;
														case 2:
															$label = 'primary';
															break;
														case 3:
															$label = 'info';
															break;
														case 4:
															$label = 'warning';
															break;
														case 5:
															$label = 'danger';
															break;
													}
												?>
												<li>
													<a title="" class="agents-pax" item-id="<?=$item->id?>" agents-id="<?=$agent->id?>"><span class="label label-<?=$label?>"><?=$agent->name?></span></a>
												</li>
												<? $i++;} ?>
											</ul>
										</div>
									</td>
								</tr>
								<? $j++; } } ?>
							</table>
						</div>
						<div role="tabpanel" class="tab-pane" id="for-business">
							<table id="export-list" class="table table-bordered table-hover">
								<tr>
									<th style="border-right: thin solid #999;background: #009e00;" width="100px">
										App No
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
										Attach File
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Status
									</th>
									<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
										Agents
									</th>
								</tr>
								<? $j=0; foreach ($items as $item) { 
									if ($item->visit_purpose == 'For business') {
								?>
								<tr class="row1 prss0">
									<td style="vertical-align: middle;border-right: thin solid #999;"><?=$j+1;?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" id="<?=$item->pax_id?>">
									<?
										if ($item->booking_type_id == 1)
											echo BOOKING_PREFIX.$item->book_id;
										else
											echo BOOKING_E_PREFIX.$item->book_id;
									?>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<input type="text" class="note-input" name="fullname" value="<?=$item->fullname?>" pro-type="fullname" item-id="<?=$item->id?>" style="border:none;width: 150px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="gender" value="<?=$item->gender?>" pro-type="gender" item-id="<?=$item->id?>" style="border:none;width: 50px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="birthday" value="<?=date('Y-m-d',strtotime($item->birthday))?>" pro-type="birthday" item-id="<?=$item->id?>" style="border:none;width: 75px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="nationality" value="<?=$item->nationality?>" pro-type="nationality" item-id="<?=$item->id?>" style="border:none;width: 120px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="text" class="note-input" name="passport" value="<?=$item->passport?>" pro-type="passport" item-id="<?=$item->id?>" style="border:none;width: 75px;text-align: center;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<input type="date" class="note-input-arrivaldate note-input-arrivaldate-<?=$item->book_id?>" name="arrival_date" value="<?=date('Y-m-d',strtotime($item->arrival_date))?>" pro-type="arrival_date" item-id="<?=$item->book_id?>" style="border:none;width: 120px;text-align: center;height:20px;">
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<select name="arrival_port" class="arrival_port note-input-arrivalport note-input-arrivalport-<?=$item->book_id?>" pro-type="arrival_port" item-id="<?=$item->book_id?>" style="border:none;width: 90px;text-align: center;height:20px;">
											<? foreach ($arrival_ports as $arrival_port) {
												if (in_array($arrival_port->code, array("SGN", "HAN", "DAN", "CXR"))) { ?>
												<option value="<?=$arrival_port->short_name?>"><?=$arrival_port->short_name?></option>
											<?	}
											}
											?>
										</select>
										<script type="text/javascript">
											$('.note-input-arrivalport-<?=$item->book_id?>').val('<?=$item->arrival_port?>');
										</script>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center"><?=$arr_type[$item->visa_type]?></td>
									<td style="vertical-align: middle;border-right: thin solid #999;" class="text-center">
										<select name="visit_purpose" class="visit_purpose note-input-purpose note-input-purpose-<?=$item->book_id?>" pro-type="visit_purpose" item-id="<?=$item->book_id?>" style="border:none;width: 90px;text-align: center;height:20px;">
											<option value="For tourist">For tourist</option>
											<option value="For business">For business</option>
										</select>
										<script type="text/javascript">
											$('.note-input-purpose-<?=$item->book_id?>').val('<?=$item->visit_purpose?>');
										</script>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="80px"><?=!empty($item->private_visa) ? 'CV riêng' : ''?></td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<input type="text" class="note-input note_process" name="note_process" value="<? if(empty($item->note_process)) {
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
											}?>" pro-type="note_process" item-id="<?=$item->id?>" style="border:none;width: 70px;text-align: center;">
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<select name="note_fc" class="change-services chang-services-<?=$item->book_id?>" pro-type="note_fc" item-id="<?=$item->book_id?>" style="border:none;text-align: center;width: 115px;">
											<option value="0"></option>
											<option value="1">Đón</option>
											<option value="2">Xe</option>
											<option value="3">Đón + Xe</option>
											<option value="4">Đón + Phí</option>
											<option value="5">Đón + Phí + Xe</option>
										</select>
										<script type="text/javascript">
											$('.chang-services-<?=$item->book_id?>').val('<?
												if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->booking_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->booking_date} + 2days"))) && ($item->agents_id == $item->agents_fc_id))
												{
													echo $this->util->fc($item->full_package,$item->fast_checkin,$item->car_pickup,$item->booking_type_id)[0];
												} else {
													echo 0;
												}
											?>');
										</script>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<input type="text" class="note-input flight_number" name="flight_number" value="<?
											if(!empty($item->flight_number)) { 
												echo $item->flight_number;
											} else {
												if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->booking_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->booking_date} + 2days"))) && ($item->agents_id == $item->agents_fc_id) && (!empty($item->fast_checkin) || !empty($item->car_pickup) || !empty($item->full_package))) {
													echo $item->vb_flight_number.' - '.$item->arrival_time;
												}
											}
										?>" pro-type="flight_number" item-id="<?=$item->id?>" style="border:none;text-align: center;width: 170px;">
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<textarea style="border:none;text-align: center;" class="note-input" name="note" pro-type="note" item-id="<?=$item->id?>" rows="1"><?=!empty($item->note) ? $item->note : ''; ?></textarea>
									</td>
									<td rowspan="1" style="vertical-align: middle;border-right: thin solid #999;" class="text-center" width="100px">
										<label style="cursor: pointer;">
											<i class="fa fa-upload" data-toggle="modal" data-target="#myModal" pax_id="<?=$item->pax_id?>"></i>
										</label>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-payment-pax-<?=$item->id?>" data-toggle="dropdown">
												<? if($item->send_approved == 1) { ?>
												<span class="label label-success">Send</span> <i class="fa fa-caret-down"></i>
												<? } else { ?>
												<span class="label label-danger " style="background:#777777">Sent</span> <i class="fa fa-caret-down"></i>
												<? } ?>
											</a>
											<ul class="dropdown-menu">
												<li>
													<a title="" class="payment-pax" item-id="<?=$item->id?>" status-id="1"><span class="label label-success">Send</span></a>
													<a title="" class="payment-pax" item-id="<?=$item->id?>" status-id="0"><span class="label label-danger " style="background:#777777">Sent</span></a>
												</li>
											</ul>
										</div>
									</td>
									<td style="vertical-align: middle;border-right: thin solid #999;">
										<div class="btn-group btn-processing-status">
											<a class="btn btn-xs dropdown-toggle dropdown-toggle-agents-pax-<?=$item->id?>" data-toggle="dropdown">
												<? $i=1; foreach ($agents as $agent) { 
													switch ($agent->id) {
														case 1:
															$label = 'success';
															break;
														case 2:
															$label = 'primary';
															break;
														case 3:
															$label = 'info';
															break;
														case 4:
															$label = 'warning';
															break;
														case 5:
															$label = 'danger';
															break;
													}
													if ($item->agents_id == $agent->id) {
														echo '<span class="label label-'.$label.'">'.$agent->name.'</span> <i class="fa fa-caret-down"></i>';
													}
													$i++;
												}
												?>
											</a>
											<ul class="dropdown-menu">
												<? $i=1; foreach ($agents as $agent) {
													switch ($i) {
														case 1:
															$label = 'success';
															break;
														case 2:
															$label = 'primary';
															break;
														case 3:
															$label = 'info';
															break;
														case 4:
															$label = 'warning';
															break;
														case 5:
															$label = 'danger';
															break;
													}
												?>
												<li>
													<a title="" class="agents-pax" item-id="<?=$item->id?>" agents-id="<?=$agent->id?>"><span class="label label-<?=$label?>"><?=$agent->name?></span></a>
												</li>
												<? $i++;} ?>
											</ul>
										</div>
									</td>
								</tr>
								<? $j++; } } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="text-center" id="sendding-mail">
				<button class="btn btn-primary btn-send" type="button"> Send mail</button>
			</div>
		</form>
	</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attach file (VISA1105)</h4>
      </div>
      <div class="modal-body">
        <div class="attach-file-list"><img src="<?=IMG_URL?>pdf.png" alt="" class="item"></div>
      </div>
      <div class="modal-footer">
      	<label class="attach-file">
        	<a class="btn btn-success">Upload</a>
        	<input type="file" id="attach_file" pax_id="" name="attach_file[]" multiple="multiple"/>
        </label>
        <a class="btn btn-warning btn-delete" pax_id="">Delete all</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('.change-services').change(function(event) {
		var val = $(this).val();
		var item_id = $(this).attr('item-id');
		var agents_id = <?=$agents_id?>;

		var p = {};
		p['val'] = val;
		p['item_id'] = item_id;
		p['agents_id'] = agents_id;
		$.ajax({
			url : '<?=BASE_URL.'/syslog/ajax-change-services'?>',
			type : 'POST',
			data : p,
			success : function(data) {
				location.reload();
			}
		});
	});
	$('.fa-upload').click(function(event) {
		var pax_id = $(this).attr('pax_id');
		$('.modal-title').html('Attach file ('+$('#'+pax_id).html()+')');
		$('#attach_file').attr('pax_id',pax_id);
		$('.btn-delete').attr('pax_id',pax_id);
		var p = {};
		p['id'] = pax_id;
		$.ajax({
			url : '<?=BASE_URL.'/syslog/ajax-get-attach-file'?>',
			type : 'POST',
			data : p,
			dataType: 'json',
			success : function(data) {
				if (data) {
					var c = data.length
					var str = '';
					for (var i = 0; i < c; i++) {
						var src = '<?=BASE_URL.'/files/upload/image/passport_photo/'?>'+pax_id+'/'+data[i];
						var format = data[i].split('.');
						if (format[1] == 'pdf' || format[1] == 'PDF') {
							str += '<img src="<?=IMG_URL?>pdf.png" alt="" class="item">';
						} else {
							str += '<img src="'+src+'" alt="" class="item">';
						}
					}
					$('.attach-file-list').html(str);
				}
			}
		});
	});
	$(document).on('click', '.btn-delete', function(event) {
		var pax_id = $(this).attr('pax_id');
		var p = {};
		p['id'] = pax_id;
		$('.attach-file-list').html('');
		$.ajax({
			url : '<?=BASE_URL.'/syslog/ajax-delete-attach-file'?>',
			type : 'POST',
			data : p,
			dataType: 'json',
			success : function(data) {
				
			}
		});
	});
	$(document).on('change', '#attach_file', function(event) {
		var form_data = new FormData();
		var ins = document.getElementById('attach_file').files.length;
		var str = '';
		for (var x = 0; x < ins; x++) {
			form_data.append("attach_file[]", document.getElementById('attach_file').files[x]);
			str += '<img src="<?=IMG_URL?>giphy.gif" alt="" class="item">';
		}
		var ul = '<?=BASE_URL.'/syslog/ajax-attach-file/'?>';
		var pax_id = $(this).attr('pax_id');
		if (ins > 0) {
			$('.attach-file-list').html(str);
			$.ajax({
				url : ul+pax_id+'.html',
				type : 'POST',
				data : form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success : function(data) {
					if (data) {
						var c = data.length
						var str = '';
						for (var i = 0; i < c; i++) {
							var src = '<?=BASE_URL.'/files/upload/image/passport_photo/'?>'+pax_id+'/'+data[i];
							var format = data[i].split('.');
							if (format[1] == 'pdf' || format[1] == 'PDF') {
								str += '<img src="<?=IMG_URL?>pdf.png" alt="" class="item">';
							} else {
								str += '<img src="'+src+'" alt="" class="item">';
							}
						}
						$('.attach-file-list').html(str);
					}
				}
			});
		}
	});
	$('.note-input-purpose').change(function(event) {
		var item_id = $(this).attr("item-id");
		var pro_type = $(this).attr("pro-type");
		var val = $(this).val();
		
		var p = {};
		p["item_id"] = item_id;
		p["pro_type"] = pro_type;
		p["val"] = val;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-booking")?>",
			data: p,
			success: function (result) {
				location.reload();
			}
		});
	});
	$('.note-input-arrivaldate').change(function(event) {
		var item_id = $(this).attr("item-id");
		var pro_type = $(this).attr("pro-type");
		var val = $(this).val();
		
		var p = {};
		p["item_id"] = item_id;
		p["pro_type"] = pro_type;
		p["val"] = val;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-booking")?>",
			data: p,
			success: function (result) {
				$('.note-input-arrivaldate-'+item_id).val(val)
			}
		});
	});
	$('.note-input-arrivalport').change(function(event) {
		var item_id = $(this).attr("item-id");
		var pro_type = $(this).attr("pro-type");
		var val = $(this).val();
		
		var p = {};
		p["item_id"] = item_id;
		p["pro_type"] = pro_type;
		p["val"] = val;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-booking")?>",
			data: p,
			success: function (result) { 
				$('.note-input-arrivalport-'+item_id).val(val);
			}
		});
	});
</script>
<script>
	$(".note-input").click(function() {
		$(this).select();
	});
	
	$(".note-input").change(function() {
		var item_id = $(this).attr("item-id");
		var pro_type = $(this).attr("pro-type");
		var val = $(this).val();
		
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
		var agents_id = $(this).attr("agents-id");
		var agents_label = $(this).html();
		
		var p = {};
		p["item_id"] = item_id;
		p["agents_id"] = parseInt(agents_id);
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-visa-pax-status")?>",
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
		$("#sendding-mail").html('<button class="btn btn-primary sendding" ><i class="fa fa-spinner" aria-hidden="true"></i></button>')
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