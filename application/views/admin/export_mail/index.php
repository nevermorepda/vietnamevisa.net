<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Export list mail
				<br><br>
				<form id="frm-admin" name="adminForm" action="" method="POST">
					<input type="hidden" id="task" name="task" value="">
					<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
					<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
					<div class="pull-left">
						<div class="input-group input-group-sm">
							<select id="status" name="status" class="form-control">
								<option value="3">All</option>
								<option value="2">Arrival date</option>
								<option value="1">Paid</option>
								<option value="0">Unpaid</option>
							</select>
							<script>$("#status").val();</script>
						</div>
					</div>
					<div class="pull-left" style="max-width: 220px;">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control daterange">
							<span class="input-group-btn">
								<button class="btn btn-default btn-save" type="submit">Export</button>
							</span>
						</div>
					</div>
				</form>
			</h1>
		</div>
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
	$(".btn-save").click(function(){
		$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
		$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
		submitButton("save");
	});
});
</script>