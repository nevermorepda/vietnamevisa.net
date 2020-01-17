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
#export-list th {
	border-right: 1px solid #E5E5E5 !important;
	background: #F5F5F5 !important;
}
#export-list td {
	border-right: 1px solid #E5E5E5 !important;
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
						<? if(!empty($items)) { ?>
						<div class="pull-left">
							<button onclick="tableToExcel('export-list', 'List')" class="btn btn-sm btn-success btn-download" type="button"><i class="fa fa-download"></i> Download</button>
						</div>
						<? } else { ?>
						<div class="pull-left" style="cursor: no-drop">
							<button disabled class="btn btn-sm btn-default" type="button"><i class="fa fa-download"></i> Download</button>
						</div>
						<? } ?>
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
				<table id="export-list" class="table table-bordered table-hover">
					<tr>
						<th style="border-right: thin solid #999;background: #009e00;" width="100px">
							App No
						</th>
						<th style="border-right: thin solid #999;background: #009e00;">
							Fullname
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Gender
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Birth Date
						</th>
						<th style="border-right: thin solid #999;background: #009e00;">
							Nationality
						</th>
						<th style="border-right: thin solid #999;background: #009e00;">
							Passport No
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Arrival Date
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Arrival Port
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Exit Port
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Type
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Code
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Purpose
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Private
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Full
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							FC
						</th>
						<th style="border-right: thin solid #999;background: #009e00;">
							Car
						</th>
						<th style="border-right: thin solid #999;background: #009e00;">
							Flight
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Status
						</th>
						<th style="border-right: thin solid #999;background: #009e00;" class="text-center">
							Price
						</th>
					</tr>
					<?
						$idx = 1;
						if (!empty($items) && sizeof($items)) {
							foreach ($items as $item) {
								$type_text_color = "style='vertical-align: middle;border-right: thin solid #999;color:";
								switch ($item->rush_type) {
									case '1': $type_text_color .= "#673AB7;'"; break;
									case '2': $type_text_color .= "red;'"; break;
									case '3': $type_text_color .= "blue;'"; break;
									default: $type_text_color = "style='vertical-align: middle;border-right: thin solid #999;'"; break;
								}
								$type_visa = ($item->booking_type_id == 2) ? '(VEV)' : '(VOA)';
								$dem = count($this->m_visa_booking->booking_travelers($item->order_id));
								if ($item->booking_type == BOOKING_PREFIX) {
									$temp = 1;
									foreach ($paxs as $pax) {
										if ($pax->book_id == $item->order_id) {

									?>
										<tr class="row1 prss<?=$item->rush_type?>">
											<td <?=$type_text_color?>>
												<?=$item->booking_type.$item->order_id.$type_visa?>
											</td>
											<td <?=$type_text_color?>>
												<?=$pax->fullname?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?=$pax->gender?>
											</td>
											<td <?=$type_text_color?> class="text-right">
												<?=date('M/d/Y', strtotime($pax->birthday))?>
											</td>
											<td <?=$type_text_color?>>
												<?=$pax->nationality?>
											</td>
											<td <?=$type_text_color?>>
												<?=$pax->passport?>
											</td>
											<td <?=$type_text_color?> class="text-right">
												<?=date('M/d/Y', strtotime($item->arrival_date))?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													// switch ($item->arrival_port) {
													// 	case 'Ho Chi Minh': echo 'HCM'; break;
													// 	case 'Ha Noi': echo 'HN'; break;
													// 	case 'Da Nang': echo 'DN'; break;
													// 	case 'Cam Ranh': echo 'CR'; break;
													// 	default: echo ''; break;
													// }
													$info = new stdClass();
													$info->short_name = $item->arrival_port;

													echo $this->m_arrival_port->items($info)[0]->code;
												?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													// switch ($item->arrival_port) {
													// 	case 'Ho Chi Minh': echo 'HCM'; break;
													// 	case 'Ha Noi': echo 'HN'; break;
													// 	case 'Da Nang': echo 'DN'; break;
													// 	case 'Cam Ranh': echo 'CR'; break;
													// 	default: echo ''; break;
													// }
													if (!empty($item->exit_port)) {
														$info = new stdClass();
														$info->short_name = $item->exit_port;
														echo $this->m_arrival_port->items($info)[0]->code;
													}
												?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													switch ($item->visa_type) {
														case '1 month single': echo ''; break;
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
											<td <?=$type_text_color?> class="text-center">
												<?=$item->promotion_code?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													$visa_booking = $this->m_visa_booking->load($item->order_id);
													if ($visa_booking->visit_purpose != 'For tourist') {
														echo $visa_booking->visit_purpose;
													}
												?>
											</td>
											<? if ($temp == 1) { ?>
											<td rowspan="<?=$dem?>" <?=$type_text_color?> class="text-center" width="80px">
											<? if ($item->private_visa) { ?>
												<span style="color: red;">CV Riêng</span>
											<? } ?>
											</td>
											<? } ?>
											<? if ($temp == 1) { ?>
											<td rowspan="<?=$dem?>" <?=$type_text_color?> class="text-center" width="100px">
											<? if ($item->full_package) { ?>
												<span style="color: red;">Đón + phí</span>
											<? } else {
												if ($item->fast_checkin) {
													echo '<span style="color: red;">Đón</span>';
												}
											} ?>
											</td>
											<? } ?>
											<td <?=$type_text_color?> class="text-center">
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
											<td <?=$type_text_color?>>
												<?
													if ($item->car_pickup) {
														echo $item->car_type." (".$item->seats." seats)";
													}
												?>
											</td>
											<td <?=$type_text_color?>>
												<?=((!empty($item->flight_number))?$item->flight_number:"")?>
												<?=((!empty($item->arrival_time))?" (".$item->arrival_time.")":"")?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													switch ($item->rush_type) {
														case '1': echo 'URG'; break;
														case '2': echo 'EME'; break;
														case '3': echo 'HOL'; break;
														default: echo 'NOR'; break;
													}
												?>
											</td>
											<td <?=$type_text_color?>>
											</td>
										</tr>
									<?
										$idx++;
										$temp++;
										}
									}
								}
								else if ($item->booking_type == BOOKING_PREFIX_EX) {
									?>
										<tr class="row1 prss<?=$item->rush_type?>" style="background-color: #FF9900 !important;">
											<td <?=$type_text_color?> width="2%" class="text-center">
												<?=$idx?>
											</td>
											<td <?=$type_text_color?>>
												<?=$item->booking_type.$item->order_id?>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?> class="text-right">
												<?=$item->arrival_date?>
											</td>
											<td <?=$type_text_color?> class="text-center">
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
											<td <?=$type_text_color?>>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													switch ($item->fast_checkin) {
														case '1': echo 'NOR'; break;
														case '2': echo 'VIP'; break;
														default: echo ''; break;
													}
												?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													if ($item->car_pickup) {
														echo $item->car_type." (".$item->seats." seats)";
													}
												?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?=((!empty($item->flight_number))?$item->flight_number:"")?>
												<?=((!empty($item->arrival_time))?" (".$item->arrival_time.")":"")?>
											</td>
											<td <?=$type_text_color?> class="text-center">
												<?
													switch ($item->rush_type) {
														case '1': echo 'URG'; break;
														case '2': echo 'EME'; break;
														case '3': echo 'HOL'; break;
														default: echo 'NOR'; break;
													}
												?>
											</td>
											<td <?=$type_text_color?>>
											</td>
										</tr>
									<?
									$idx++;
								}
								else if ($item->booking_type == BOOKING_PREFIX_PO) {
									?>
										<tr class="row1 prss<?=$item->rush_type?>" style="background-color: #FFFFDD !important;">
											<td <?=$type_text_color?> width="2%" class="text-center">
												<?=$idx?>
											</td>
											<td <?=$type_text_color?>>
												<?=$item->booking_type.$item->order_id?>
											</td>
											<td <?=$type_text_color?>>
												<?=$item->fullname?>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?>>
											</td>
											<td <?=$type_text_color?> class="text-right">
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
});
</script>
<script type="text/javascript">
	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,',
		template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
		base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
		format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			var link = document.createElement("a");
			link.download = "List <?=date('M-d-Y',strtotime($fromdate))?> to <?=date('M-d-Y',strtotime($todate))?>.xls";
			link.href = uri + base64(format(template, ctx));
			link.click();
		}
	})()
</script>