<?
	$cate_airports = $this->m_arrival_port_category->items();
	$arr_port = array();
	$arr_port_pickup = array();
	if (!empty($item)) {
		$arr_port = explode(',',$item->arr_port);
		$arr_port_pickup = explode(',',$item->arr_port_pickup);
	}
?>
<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title"><?=!empty($item->name) ? $item->name : 'Agents' ?></h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="arr_port" name="arr_port" value="<?=$item->arr_port?>">
			<input type="hidden" id="arr_port_pickup" name="arr_port_pickup" value="<?=$item->arr_port_pickup?>">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Name</td>
					<td><input type="text" id="name" name="name" class="form-control" value="<?=!empty($item->name) ? $item->name : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Email</td>
					<td><input type="text" id="email" name="email" class="form-control" value="<?=!empty($item->email) ? $item->email : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Phone</td>
					<td><input type="text" id="phone" name="phone" class="form-control" value="<?=!empty($item->phone) ? $item->phone : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Company</td>
					<td><input type="text" id="company" name="company" class="form-control" value="<?=!empty($item->company) ? $item->company : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Address</td>
					<td><input type="text" id="address" name="address" class="form-control" value="<?=!empty($item->address) ? $item->address : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Qty visa</td>
					<td><input type="text" id="qty" name="qty" class="form-control" value="<?=!empty($item->qty) ? $item->qty : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Port</td>
					<td class="agents">
						<ul class="list-group">
							<? foreach ($cate_airports as $cate_airport) { ?>
							<li class="list-group-item" style="font-weight: bold;font-size: 14px;background: #e4f5ff;"><?=$cate_airport->name?></li>
							<?
								$info = new stdClass();
								$info->category_id = $cate_airport->id;
								$airports = $this->m_arrival_port->items($info);
								foreach ($airports as $airport) {
							?>
							<li class="list-group-item" val="<?=$airport->short_name?>" port-type="arr_port" stt=<?=(in_array($airport->short_name, $arr_port)) ? 1 : 0 ?>><?=$airport->airport?> <?=(in_array($airport->short_name, $arr_port)) ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '' ?></li>
							<? } ?>
							<? } ?>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Qty fast-checkin</td>
					<td><input type="text" id="qty_fc" name="qty_fc" class="form-control" value="<?=!empty($item->qty_fc) ? $item->qty_fc : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Port fast-checkin</td>
					<td class="agents">
						<ul class="list-group">
							<? foreach ($cate_airports as $cate_airport) { ?>
							<li class="list-group-item" style="font-weight: bold;font-size: 14px;background: #e4f5ff;"><?=$cate_airport->name?></li>
							<?
								$info = new stdClass();
								$info->category_id = $cate_airport->id;
								$airports = $this->m_arrival_port->items($info);
								foreach ($airports as $airport) {
							?>
							<li class="list-group-item" val="<?=$airport->short_name?>" port-type="arr_port_pickup" stt=<?=(in_array($airport->short_name, $arr_port_pickup)) ? 1 : 0 ?>><?=$airport->airport?> <?=(in_array($airport->short_name, $arr_port_pickup)) ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '' ?></li>
							<? } ?>
							<? } ?>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right"></td>
					<td>
						<select id="active" name="active" class="form-control">
							<option value="1">Show</option>
							<option value="0">Hide</option>
						</select>
						<script type="text/javascript">
							$("#active").val("<?=!empty($item->active) ? $item->active : 1 ?>");
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
<? require_once(APPPATH."views/module/admin/upload_ckfinder.php"); ?>
<script type="text/javascript">
	$('.list-group-item').click(function(event) {
		var port_type = $(this).attr('port-type');
		var stt = parseInt($(this).attr('stt'));
		var val = $(this).attr('val');
		var str = $('#'+port_type).val();
		if (stt == 1) {
			$(this).children('.fa-check-circle').remove();
			$(this).attr('stt',0);
			var temp = str.split(',');
			str = '';
			for (var i = 0; i < temp.length; i++) {
				if (val != temp[i] && temp[i] != ""){
					str += temp[i]+',';
				}
			}
		} else {
			$(this).append('<i class="fa fa-check-circle" aria-hidden="true"></i>');
			$(this).attr('stt',1);
			str += val+',';
		}
		$('#'+port_type).val(str);
	});
</script>
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