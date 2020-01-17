<?
	$admin = $this->session->userdata("admin");
	$admin_id = explode('|',SUPER_ADMIN_FULL_ROLE);
?>

<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Unpaid List
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
									<option value="Stripe">Stripe</option>
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
						<? if ($admin->user_type == USR_SUPPER_ADMIN || $admin->user_email == "T25121995@gmail.com") { ?>
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
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/unpaid-list")?>" method="POST">
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
			<? if ($admin->user_type == USR_SUPPER_ADMIN || $admin->user_email == "T25121995@gmail.com" || ($task == "search" && $edited_search_text != "")) { ?>
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
						<th class="text-center" width="80">
							Date
						</th>
						<th class="text-center">
							Type
						</th>
						<th class="text-center">
							Payment
						</th>
						<th class="text-center">
							Status
						</th>
						<th>
							Fullname
						</th>
						<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
						<th>
							Email
						</th>
						<? } ?>
						<th class="text-center hidden" width="80">
							Capital
						</th>
						<th class="text-center hidden" width="80">
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
										<?
										if ($item->payment_type == BOOKING_PREFIX) {
											echo BOOKING_PREFIX;
										} else if ($item->payment_type == BOOKING_PREFIX_EX) {
											echo "EX";
										} else {
											echo "PO";
										}
										?>
									</td>
									<td width="4%" class="text-center">
										<?
											switch ($item->payment_method) {
												case 'Paypal': echo 'PP'; break;
												case 'OnePay': echo 'OP'; break;
												case 'Credit Card': echo 'CC'; break;
												case 'Gate2Shop': echo 'GS'; break;
												case 'Bank Transfer': echo 'BT'; break;
												case 'Western Union': echo 'WU'; break;
												case 'Stripe': echo 'ST'; break;
												default: echo ''; break;
											}
										?>
									</td>
									<td width="3%" class="text-center">
										<? if ($item->status) { ?>
										<span class="label label-success">Paid</span>
										<? } else { ?>
										<span class="label label-danger">UnPaid</span>
										<? } ?>
									</td>
									<td>
										<?=$item->fullname?>
									</td>
									<? if (in_array($this->session->userdata('admin')->id,$admin_id)) { ?>
									<td>
										<?=$item->primary_email?>
									</td>
									<? } ?>
									<td class="text-right hidden">
										<?=($item->capital ? $item->capital : "")?>
									</td>
									<td class="text-right hidden">
										<?=($item->refund ? $item->refund : "")?>
									</td>
									<td class="text-right">
										$<?=$item->amount?>
									</td>
									<td class="text-left">
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

	$(".btn-download").click(function(){
		$("#search_text").val($("#report_text").val());
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
		}
		$("#search_country").val($("#report_country :selected").val());
		$("#search_payment_method").val($("#report_payment_method :selected").val());
		submitButton("download");
	});
	
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
});
</script>