<?
	$admin = $this->session->userdata("admin");
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
</style>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Check List
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
						<div class="pull-left">
							<button class="btn btn-sm btn-success btn-download" type="button"><i class="fa fa-download"></i> Download</button>
						</div>
					</div>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<? if (empty($items) || !sizeof($items)) { ?>
			<p class="help-block">No payment found.</p>
			<? } else { ?>
			<p></p>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<tr>
						<th class="text-center" width="5">
							#
						</th>
						<th width="100">
							App No
						</th>
						<th>
							Fullname
						</th>
						<th class="text-center">
							Gender
						</th>
						<th class="text-center">
							Birth Date
						</th>
						<th>
							Nationality
						</th>
						<th>
							Passport No
						</th>
						<th class="text-center">
							Arrival Date
						</th>
						<th class="text-center">
							Arrival Port
						</th>
						<th class="text-center">
							Type
						</th>
						<th class="text-center">
							Code
						</th>
						<th class="text-center">
							Private
						</th>
						<th class="text-center">
							Full
						</th>
						<th class="text-center">
							FC
						</th>
						<th>
							Car
						</th>
						<th>
							Flight
						</th>
						<th class="text-center">
							Status
						</th>
						<th class="text-center">
							Price
						</th>
					</tr>
					<?
						$idx = 1;
						if (!empty($items) && sizeof($items)) {
							foreach ($items as $item) {
								if ($item->booking_type == BOOKING_PREFIX) {
									foreach ($paxs as $pax) {
										if ($pax->book_id == $item->order_id) {
									?>
										<tr class="row1 prss<?=$item->rush_type?> <?=$item->booking_type?>">
											<td width="2%" class="text-center">
												<?=$idx+(($pageidx-1)*$limit)?>
											</td>
											<td>
												<?=$item->booking_type.$item->order_id?>
											</td>
											<td>
												<?=$pax->fullname?>
											</td>
											<td class="text-center">
												<?=$pax->gender?>
											</td>
											<td class="text-right">
												<?=date('M/d/Y', strtotime($pax->birthday))?>
											</td>
											<td>
												<?=$pax->nationality?>
											</td>
											<td>
												<?=$pax->passport?>
											</td>
											<td class="text-right">
												<?=date('M/d/Y', strtotime($item->arrival_date))?>
											</td>
											<td class="text-center">
												<?
													switch ($item->arrival_port) {
														case 'Ho Chi Minh': echo 'HCM'; break;
														case 'Ha Noi': echo 'HN'; break;
														case 'Da Nang': echo 'DN'; break;
														case 'Cam Ranh': echo 'CR'; break;
														default: echo ''; break;
													}
												?>
											</td>
											<td class="text-center">
												<?
													switch ($item->visa_type) {
														case '1 month single': echo '1T1L'; break;
														case '3 months single': echo '3T1L'; break;
														case '6 months single': echo '6T1L'; break;
														case '1 month multiple': echo '1TNL'; break;
														case '3 months multiple': echo '3TNL'; break;
														case '6 months multiple': echo '6TNL'; break;
														case '1 year multiple': echo '1NNL'; break;
														default: echo ''; break;
													}
												?>
											</td>
											<td class="text-center">
												<?=$item->promotion_code?>
											</td>
											<td class="text-center" width="30px">
											<? if ($item->private_visa) { ?>
												<img border="0" alt="" src="<?=IMG_URL?>checkmark.png" />
											<? } ?>
											</td>
											<td class="text-center" width="30px">
											<? if ($item->full_package) { ?>
												<img border="0" alt="" src="<?=IMG_URL?>checkmark.png" />
											<? } ?>
											</td>
											<td class="text-center">
												<?
													if ($item->full_package) {
														echo 'NOR';
													} else {
														switch ($item->fast_checkin) {
															case '1': echo 'NOR'; break;
															case '2': echo 'VIP'; break;
															default: echo ''; break;
														}
													}
												?>
											</td>
											<td>
												<?
													if ($item->car_pickup) {
														echo $item->car_type." (".$item->seats." seats)";
													}
												?>
											</td>
											<td>
												<?=((!empty($item->flight_number))?$item->flight_number:"")?>
												<?=((!empty($item->arrival_time))?" (".$item->arrival_time.")":"")?>
											</td>
											<td class="text-center">
												<?
													switch ($item->rush_type) {
														case '1': echo 'URG'; break;
														case '2': echo 'EME'; break;
														case '3': echo 'HOL'; break;
														default: echo 'NOR'; break;
													}
												?>
											</td>
											<td>
											</td>
										</tr>
									<?
										$idx++;
										}
									}
								}
								else if ($item->booking_type == BOOKING_PREFIX_EX) {
									?>
										<tr class="row1 prss<?=$item->rush_type?> <?=$item->booking_type?>">
											<td width="2%" class="text-center">
												<?=$idx+(($pageidx-1)*$limit)?>
											</td>
											<td>
												<?=$item->booking_type.$item->order_id?>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td class="text-right">
												<?=$item->arrival_date?>
											</td>
											<td class="text-center">
												<?
													switch ($item->arrival_port) {
														case 'Ho Chi Minh': echo 'HCM'; break;
														case 'Ha Noi': echo 'HN'; break;
														case 'Da Nang': echo 'DN'; break;
														case 'Cam Ranh': echo 'CR'; break;
														default: echo ''; break;
													}
												?>
											</td>
											<td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											</td>
											<td class="text-center">
												<?
													switch ($item->fast_checkin) {
														case '1': echo 'NOR'; break;
														case '2': echo 'VIP'; break;
														default: echo ''; break;
													}
												?>
											</td>
											<td class="text-center">
												<?
													if ($item->car_pickup) {
														echo $item->car_type." (".$item->seats." seats)";
													}
												?>
											</td>
											<td class="text-center">
												<?=((!empty($item->flight_number))?$item->flight_number:"")?>
												<?=((!empty($item->arrival_time))?" (".$item->arrival_time.")":"")?>
											</td>
											<td class="text-center">
												<?
													switch ($item->rush_type) {
														case '1': echo 'URG'; break;
														case '2': echo 'EME'; break;
														case '3': echo 'HOL'; break;
														default: echo 'NOR'; break;
													}
												?>
											</td>
											<td>
											</td>
										</tr>
									<?
									$idx++;
								}
								else if ($item->booking_type == BOOKING_PREFIX_PO) {
									?>
										<tr class="row1 prss<?=$item->rush_type?> <?=$item->booking_type?>">
											<td width="2%" class="text-center">
												<?=$idx+(($pageidx-1)*$limit)?>
											</td>
											<td>
												<?=$item->booking_type.$item->order_id?>
											</td>
											<td>
												<?=$item->fullname?>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td>
											<td>
											</td>
											<td>
											</td>
											</td>
											<td>
											</td>
											<td>
											</td>
											<td class="text-right">
												<?=$item->amount?>
											</td>
										</tr>
									<?
									$idx++;
								}
							}
						}
					?>
				</table>
			</div>
			<? } ?>
		</form>
	</div>
</div>

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
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD h:mm A'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD h:mm A'));
		}
		submitButton("search");
	});
	
	$(".btn-download").click(function(){
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD h:mm A'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD h:mm A'));
		}
		submitButton("download");
	});
});
</script>