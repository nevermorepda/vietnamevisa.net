<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Car plus fees
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="<?=site_url("syslog/car-plus-fees/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<table class="table table-bordered table-striped table-hover">
				<tr>
					<th rowspan="2" class="text-center" width="30px">#</th>
					<th rowspan="2" class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th rowspan="2">Port</th>
				</tr>
				<tr>
					<th class="text-center" width="70">Distance</th>
					<th class="text-center" width="70">Distance(+)</th>
					<th class="text-center" width="70">Seat 4</th>
					<th class="text-center" width="70">Seat 7</th>
					<th class="text-center" width="70">Seat 16</th>
					<th class="text-center" width="70">Seat 24</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr>
					<td><?=($i+1)?></td>
					<td><input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);"></td>
					<td>
						<a href="<?=site_url("syslog/car-plus-fees/edit/{$item->id}")?>"><?=$item->airport?></a>
						<ul class="action-icon-list">
							<li><a href="<?=site_url("syslog/car-plus-fees/edit/{$item->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
						</ul>
					</td>
					<td>
						<input type="text" class="fee" name="distance" value="<?=($item->distance?$item->distance:"")?>" id-item="<?=$item->id?>" visa-type="distance" style="background-color: #F0F0F0; width: 70px; text-align: right; border: none;">
					</td>
					<td>
						<input type="text" class="fee" name="distance_plus" value="<?=($item->distance_plus?$item->distance_plus:"")?>" id-item="<?=$item->id?>" visa-type="distance_plus" style="background-color: #F0F0F0; width: 70px; text-align: right; border: none;">
					</td>
					<td>
						<input type="text" class="fee" name="seat_4" value="<?=($item->seat_4?$item->seat_4:"")?>" id-item="<?=$item->id?>" visa-type="seat_4" style="background-color: #D9EDF7; width: 70px; text-align: right; border: none;">
					</td>
					<td>
						<input type="text" class="fee" name="seat_7" value="<?=($item->seat_7?$item->seat_7:"")?>" id-item="<?=$item->id?>" visa-type="seat_7" style="background-color: #D9EDF7; width: 70px; text-align: right; border: none;">
					</td>
					<td>
						<input type="text" class="fee" name="seat_16" value="<?=($item->seat_16?$item->seat_16:"")?>" id-item="<?=$item->id?>" visa-type="seat_16" style="background-color: #D9EDF7; width: 70px; text-align: right; border: none;">
					</td>
					<td>
						<input type="text" class="fee" name="seat_24" value="<?=($item->seat_24?$item->seat_24:"")?>" id-item="<?=$item->id?>" visa-type="seat_24" style="background-color: #D9EDF7; width: 70px; text-align: right; border: none;">
					</td>
					</td>
				</tr>
				<?
						$i++;
					}
				?>
			</table>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".fee").click(function() {
		$(this).select();
	});
	
	$(".fee").blur(function() {
		var p = {};
		p["visa_type"] = $(this).attr("visa-type");
		p["val"] = $(this).val();
		p["id"] = $(this).attr("id-item");
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-car-plus-fees")?>",
			data: p
		});
	});
	$(".btn-delete").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to delete.");
		}
		else {
			confirmBox("Delete items", "Are you sure you want to delete the selected items?", "submitButton", "delete");
		}
	});
});
</script>