<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Car plus fees</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Port</td>
					<td>
						<select id="port" name="port" class="form-control port">
							<option value="" selected="selected">Please select...</option>
							<? $ports = array('Airport','Landport','Seaport'); for ($i=1; $i <= 3 ; $i++) {
									$info = new stdClass();
									$info->category_id = $i;
									$arrival_ports = $this->m_arrival_port->items($info, 1);
								?>
							<optgroup label="<?=$ports[$i-1]?>">
								<? foreach ($arrival_ports as $arrival_port) { ?>
								<option value="<?=$arrival_port->id?>"><?=$arrival_port->airport?></option>
								<? } ?>
							</optgroup>
							<? } ?>
						</select>
						<script type="text/javascript">
							$("#port").val("<?=$item->port?>");
						</script>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Fees</td>
					<td>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Distance</span>
								<input type="text" class="form-control" name="distance" value="<?=$item->distance?>">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Distance(+)</span>
								<input type="text" class="form-control" name="distance_plus" value="<?=$item->distance_plus?>">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Seat 4</span>
								<input type="text" class="form-control" name="seat_4" value="<?=$item->seat_4?>">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Seat 7</span>
								<input type="text" class="form-control" name="seat_7" value="<?=$item->seat_7?>">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Seat 16</span>
								<input type="text" class="form-control" name="seat_16" value="<?=$item->seat_16?>">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Seat 24</span>
								<input type="text" class="form-control" name="seat_24" value="<?=$item->seat_24?>">
							</div>
						</div>
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
<? require_once(APPPATH."views/module/admin/upload_ckfinder.php"); ?>
<script>
$(document).ready(function() {
	$(".btn-save").click(function(){
		submitButton("save");
	});
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
});
</script>