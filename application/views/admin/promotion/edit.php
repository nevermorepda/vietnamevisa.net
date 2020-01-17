<?
	if (empty($item->start_date)) {
		$item->start_date = date("Y-m-d");
	}
	if (empty($item->end_date)) {
		$item->end_date = date("Y-m-d", strtotime("+1 month"));
	}
?>
<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Promotion Codes</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="start_date" name="start_date" value="<?=$item->start_date?>" />
			<input type="hidden" id="end_date" name="end_date" value="<?=$item->end_date?>" />
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Code</td>
					<td><input type="text" id="code" name="code" class="form-control" value="<?=$item->code?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Discount</td>
					<td>
						<div class="input-group" style="max-width: 200px;">
							<input type="text" id="discount" name="discount" class="form-control" value="<?=$item->discount?>" style="text-align: right;">
							<div class="input-group-btn">
								<select id="discount_unit" name="discount_unit" class="form-control" style="width: 80px;">
									<option value="%">%</option>
									<option value="USD">USD</option>
								</select>
								<script type="text/javascript">
									$("#discount_unit").val("<?=$item->discount_unit?>");
								</script>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Duration</td>
					<td><input type="text" class="form-control daterange"></td>
				</tr>
				<tr>
					<td class="table-head text-right"></td>
					<td>
						<select id="active" name="active" class="form-control">
							<option value="1">Enable</option>
							<option value="0">Disable</option>
						</select>
						<script type="text/javascript">
							$("#active").val("<?=$item->active?>");
						</script>
					</td>
				</tr>
			</table>
			<div>
				<button class="btn btn-sm btn-primary btn-save">Save</button>
				<button class="btn btn-sm btn-default btn-cancel">Cancel</button>
			</div>
		</form>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".btn-save").click(function(){
		$("#start_date").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
		$("#end_date").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
		submitButton("save");
	});
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
	$(".daterange").daterangepicker({
		startDate: "<?=date('m/d/Y', strtotime($item->start_date))?>",
		endDate: "<?=date('m/d/Y', strtotime($item->end_date))?>"
	});
});
</script>