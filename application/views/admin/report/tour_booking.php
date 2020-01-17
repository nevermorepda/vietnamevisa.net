<?

	$bookings = array();
	$total_succed = 0;
	// foreach ($total_items as $value) {
	// 	if ($value->status) {
	// 		$key = date("M Y", strtotime($value->booking_date));
	// 		if (array_key_exists($key, $bookings)) {
	// 			$bookings[$key] = $bookings[$key] + 1;
	// 		}
	// 		else {
	// 			$bookings[$key] = 1;
	// 		}
	// 		$total_succed += 1;
	// 	}
	// }
	$admin = $this->session->userdata("admin");
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);

	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
?>
<section>
	<div class="container-fluid">
		<div class="tool-bar clearfix mb-3">
			<h1 class="page-title">Tour Booking
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?//=$search_text?>" placeholder="Search for application ID">
							</div>
						</div>
						<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
						<!-- <div class="pull-left" style="margin-right: 5px;">
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
								<script>$("#report_visa_type").val("<?//=$search_visa_type?>");</script>
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
								<script>$("#report_visit_purpose").val("<?//=$search_visit_purpose?>");</script>
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
								<script>$("#report_country").val("<?//=$search_country?>");</script>
							</div>
						</div> -->
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
		<?
			$total_succed = 0;
			$op = 0;
			$pp = 0;
			$sum_op = 0;
			$sum_pp = 0;
			$total_fee = 0;
			$capital = 0;
			$refund = 0;
			$profit = 0;
			foreach ($total_items as $total_item) {
				if ($total_item->status == 1) {
					$total_succed += 1;
					if ($total_item->payment_method == 'Paypal') {
						$pp += $total_item->total_fee;
						$sum_pp += 1;
					} else if ($total_item->payment_method == 'OnePay') {
						$op += $total_item->total_fee;
						$sum_op += 1;
					}
				}
			}
			$vat = 0;
			$total_fee = $op + $pp;
			$profit = $total_fee - $capital - $refund - (($total_fee*3)/100);
		?>
		<div class="statement-bar clearfix">
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Success</div>
				<div class="number"><?=number_format($total_succed)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Sum OP</div>
				<div class="number"><?=number_format($sum_op)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Sum PP</div>
				<div class="number"><?=number_format($sum_pp)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">OnePay</div>
				<div class="number">$<?=number_format($op)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">Paypal</div>
				<div class="number">$<?=number_format($pp)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">&nbsp;</div>
				<div class="number">=</div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Total</div>
				<div class="number">$<?=number_format($total_fee)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Capital</div>
				<div class="number text-color-red">- $<?=number_format($capital)?></div>
			</div>
			<div class="payment-statement pull-left hidden-xs">
				<div class="title">VAT</div>
				<div class="number text-color-red">- $<?=number_format((($total_fee*3)/100))?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Refund</div>
				<div class="number text-color-red">- $<?=number_format($refund)?></div>
			</div>
			<div class="payment-statement pull-left">
				<div class="title">Profit</div>
				<div class="number text-color-green"> $<?=number_format($profit)?></div>
			</div>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0"/>
			<input type="hidden" id="task" name="task" value="<?//=$task?>">
			<input type="hidden" id="sortby" name="sortby" value="<?//=$sortby?>" />
			<input type="hidden" id="orderby" name="orderby" value="<?//=$orderby?>" />
			<input type="hidden" id="search_text" name="search_text" value="<?//=$search_text?>">
			<input type="hidden" id="fromdate" name="fromdate" value="<?//=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?//=$todate?>" />
			<?// if (empty($items) || !sizeof($items)) { ?>
				<p class="help-block">No item found.</p>
			<?// } else { ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<tbody><tr>
							<th width="5">#</th>
							<th width="20" align="center"><input type="checkbox" name="toggle" value="" onclick="checkAll(2);"></th>
							<th>IP</th>
							<th class="sortby" sortby="booking_date">Date</th>
							<th class="sortby" sortby="id">ID</th>
							<th class="sortby" sortby="user_id">User</th>
							<th class="sortby" sortby="status">Status</th>
							<th class="sortby" sortby="email">E-mail</th>
							<th class="sortby" sortby="name">Tour Name</th>
							<th class="sortby" sortby="start">Start Date</th>
							<th class="sortby" sortby="adults">Adults</th>
							<th class="sortby" sortby="children">Children</th>
							<th class="sortby" sortby="infants">Infants</th>
							<th class="sortby" sortby="supplements">Suppl</th>
							<th class="sortby" sortby="payment_method">Method</th>
							<th class="sortby" sortby="payment_option">Option</th>
							<th class="sortby" sortby="total_fee">VAT</th>
							<th class="sortby" sortby="total_fee">Total</th>
							<th class="sortby" sortby="paid">Deposit</th>
							<th class="sortby" sortby="platform">Platform</th>
							<th class="sortby" sortby="agent">Agent</th>
						</tr>
					<?
						$i = 1;
						foreach ($items as $item) {
							if (!empty($item->client_ip)) {
								$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
								$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
								$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
								if ($country_code == '-' && $item->client_ip == '::1') {
									$country_flag = ADMIN_IMG_URL.'flags/default.png';
								}
								$item->country_name = ucwords(strtolower($country_name));
								$item->country_flag = $country_flag;
							}
					?>
						<tr>
							<td width="2%" align="center"><?=$i++;?></td>
							<td align="center"><input type="checkbox" id="cb0" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);"></td>
							<td width="20">
							<a target="_blank" href="http://whatismyipaddress.com/ip/<?//=$item->client_ip?>">
							<img src="<?=$item->country_flag?>" alt="<?=$item->country_name?>" title="<?=$item->country_name?>">
							</a>
							</td>
							<td width="80" align="center"><?= date("Y-m-d H:i:s", strtotime($item->booking_date)) ?></td>
							<td width="50" align="center"><a href="#collapse_<?=$item->id?>" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?=$item->id?>" class="collapsed">T<?=$item->id?></a></td>
							<td width="50" align="center"><a target="_blank" href=""><?= $item->user_id ?></a></td>
							<td width="3%" align="center">
								<div class="btn-group btn-group-sm btn-processing-status">
									<a class="btn dropdown-toggle dropdown-toggle-payment-status-<?=$item->id?> bg-transparent" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true" id="btnGroupStatus">
										<span class="rounded p-1 text-white <?=$item->status ? 'bg-success label-success label' : 'bg-danger label-danger label'?>"><?=$item->status ? "Paid" : "UnPaid"?></span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="1"><span class="label label-success">Paid</span></a>
											<a title="" class="payment-status" booking-id="<?=$item->id?>" status-id="0"><span class="label label-danger">UnPaid</span></a>
										</li>
									</ul>
								</div>
							</td>
							<td><?= $item->contact_email ?></td>
							<?$info_tour = $this->m_tour->load($item->tour_id);?>
							<td><?=$info_tour->title;?></td>
							<td width="6%" align="center"><?= date("M/d/Y", strtotime($item->departure_date)); ?></td>
							<td width="4%" align="center"><?= $item->adults ?></td>
							<td width="4%" align="center"><?= $item->children ?></td>
							<td width="4%" align="center"><?= $item->infants ?></td>
							<td width="4%" align="center"><?= $item->supplements ?></td>
							<td width="50" align="center"><?= $item->payment_method ?></td>
							<td width="8%"><?= $item->payment_option ?></td>
							<td width="3%"><?= $item->vat?>%</td>
							<td width="3%" align="right">$<?= number_format($item->total_fee, 2, '.', ',') ?></td>
							<td width="3%" align="right">$<?= number_format($item->paid, 2, '.', ',') ?></td>
							<td width="4%">
								<?
									if (strpos($item->platform, "Windows") !== false) {
										echo "Windows";
									}
									else if (strpos($item->platform, "Mac OS") !== false) {
										echo "Mac OS";
									}
									else if (strpos($item->platform, "Android") !== false) {
										echo "Android";
									}
									else if (strpos($item->platform, "Ubuntu") !== false) {
										echo "Ubuntu";
									}
									else {
										echo $item->platform;
									}
								?>
							</td>
							<td width="5%">
								<?
									if (strpos($item->user_agent, "iPad") !== false
										|| strpos($item->user_agent, "Tablet") !== false) {
										echo str_replace("Mobile - ", "", $item->user_agent);
									}
									else {
										echo $item->user_agent;
									}
								?>
							</td>
						</tr>
						<tr class="collapse" id="collapse_<?=$item->id?>" style="">
							<td colspan="21">
								<div class="card">
									<div class="card-header">Contact Information</div>
									<div class="card-body">
										<table class="table table-bordered w-100">
											<tbody><tr>
												<th>Fullname</th>
												<th>Email</th>
												<th>Phone</th>
												<th>Special request</th>
												<th>Booking date</th>
												<th>Pick up at</th>
												<th>Allergic</th>
												<th>&lt; 80 kg (176 lbs)</th>
												<th>&gt; 80 kg (176 lbs)</th>
												<th>Option tour</th>
												<th>Cabin Type</th>
												<th>Extra Services</th>
											</tr>
											<tr>
												<td><?= $item->contact_fullname ?></td>
												<td><?= $item->contact_email ?></td>
												<td><?= $item->contact_phone ?></td>
												<td><?= $item->contact_message ?></td>
												<td><?=date("Y-m-d H:i:s",strtotime($item->booking_date))?></td>
												<td><?= $item->pickup ?></td>
												<td></td>
												<td>0</td>
												<td>0</td>
												<td></td>
												<td>
											</td>
												<td></td>
											</tr>
										</tbody></table>
									</div>
								</div>
							</td>
						</tr>
						<!-- <tr class="d-none">
							<td colspan="18">
								<div style="padding:10mm;" id="tour-1007">
									<table style=" width:100%;">
										<tbody><tr>
											<td style="width: 50%">
												<img style="padding: 10px 20px; -webkit-print-color-adjust: exact;" src="">
												<h4>Beetrip</h4>
												2nd floor, S4-S5 Ba Vi Street, Ward 15, District 10, HCMC, Vietnam											</td>
											<td style="width: 50%; float: right">
												<h3>INVOICE</h3>
												Number : #T1007<br>
												Date : Sep 23, 2019											</td>
										</tr>
									</tbody></table>
									<br>
									<br>
									<h4>CUSTOMER DETAIL</h4>
									Name: Mr vi amor dayrit<br>
									Email: vrdayrit@up.edu.ph<br>
									Contact number: +63 9089758829<br>
									<h4>PAYMENT DETAIL</h4>
									<table class="table table-bordered" style=" width:100%;">
										<tbody><tr>
											<th>Payment method</th>
											<th>Payment option</th>
											<th>Paid</th>
										</tr>
										<tr>
											<td>Paypal</td>
											<td></td>
											<td>$0.00</td>
										</tr>
									</tbody></table>
									<h4>PURCHASE DETAIL</h4>
									<table class="table table-bordered" style=" width:100%;">
										<tbody><tr>
											<th>Tour code</th>
											<th>Tour name</th>
											<th>Adults</th>
											<th>Children</th>
											<th>Supplement</th>
											<th>Total price</th>
										</tr>
										<tr>
											<td>BEE135</td>
											<td>DA NANG CLASSIC CITY TOUR</td>
											<td>2 x $0.00</td>
											<td>0 x $0.00</td>
											<td>0 x $0.00</td>
											<td>$160.00</td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<td><b>Total</b></td>
											<td>$160.00</td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<td><b>VAT 0%<b></b></b></td>
											<td>$0.00</td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<td><b>Payment amout</b></td>
											<td>$160.00</td>
										</tr>
									</tbody></table>
									<div class="clearfix"></div>
								</div>
							</td>
						</tr> -->
						<? }  ?>
						</tbody>
					</table>
				</div>
				<div class="center"><?=$pagination?></div>
		</form>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>
<script src="//code.highcharts.com/highcharts.js"></script>
<script>
function print_bill(el) {
	$("#" + el).printThis({
		debug: false,
		loadCSS: "<?=CSS_URL?>print.css",
	});
}

$(document).ready(function () {
	$('[data-toggle="tooltip"]').tooltip();
		$(".btn-publish").click(function (e) {
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("publish");
		}
	});
	$(".btn-unpublish").click(function (e) {
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unpublish");
		}
	});
	$(".btn-delete").click(function (e) {
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to delete.");
		}
		else {
			confirmBox("Delete items", "Are you sure you want to delete the selected items?", "submitButton", "delete");
		}
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
			url: "<?=site_url("{$this->router->fetch_class()}/ajax-tour-booking-payment-status")?>",
			data: p,
			success: function(result) { console.log(result);
				$(".dropdown-toggle-payment-status-" + booking_id).html(status_label);
			},
			asyns:false
		});
	});

	$(".tour-detail").on("click",function(){
		var booking_id = $(this).attr("booking-id");
		$.get("<?=BASE_URL."/{$this->router->fetch_class()}/{$this->router->fetch_method()}/edit/"?>"+booking_id+".html", function(data) {
			$("#detail").html(data);
			$("#detail").modal('show');
		});
	})

	if ($(".daterange").length) {
		$(".daterange").daterangepicker({
			opens: 'left',
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

	if ($("#booking-colchart").length) {
		Highcharts.chart('booking-colchart', {
			chart: {
				type: 'column'
			},
			title: {
			text: 'Booking Report'
		},
		subtitle: {
			text: 'Total: <?=$total_succed." bookings "?>'
		},
		xAxis: {
			categories: [
				<? foreach ($bookings as $name => $val) {
				echo "'".addslashes($name)."',";
				} ?>
			],
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Number of Bookings'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			'<td style="padding:0"><b>{point.y:.1f} bookings</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: 'Number of Bookings',
			data: [
				<? foreach ($bookings as $name => $val) {
					echo $val.",";
				} ?>
				]
			},
			]
		});
	}
});

</script>