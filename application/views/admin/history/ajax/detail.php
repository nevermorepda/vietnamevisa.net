<?
	if (strtoupper($item->action) == "ADD") {
		$new_data = unserialize($item->new_data);
?>
<div class="row">
	<div class="col-sm-12">
		<div class="">
			<h4><strong><?=$item->user_name?></strong> added</h4>
			<table class="table table-bordered">
				<tr>
					<td class="table-head">table_name</td>
					<td><?=$item->table_name?></td>
				</tr>
				<? foreach ($new_data as $key => $val) { ?>
					<tr>
						<td class="table-head"><?=$key?></td>
						<td><?=$val?></td>
					</tr>
				<? } ?>
			</table>
		</div>
	</div>
</div>
<?
	} else if (strtoupper($item->action) == "UPDATE") {
		$old_data = unserialize($item->old_data);
		$new_data = unserialize($item->new_data);
?>
<div class="row">
	<div class="col-sm-6">
		<div class="">
			<h4>Last updated</h4>
			<table class="table table-bordered">
				<tr>
					<td class="table-head">table_name</td>
					<td><?=$item->table_name?></td>
				</tr>
				<tr>
					<td class="table-head">item_id</td>
					<td><?=$item->item_id?></td>
				</tr>
				<? foreach ($new_data as $key => $val) { ?>
					<tr>
						<td class="table-head"><?=$key?></td>
						<td><?=$old_data->{$key}?></td>
					</tr>
				<? } ?>
			</table>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="">
			<h4><strong><?=$item->user_name?></strong> updated</h4>
			<table class="table table-bordered">
				<tr>
					<td class="table-head">table_name</td>
					<td><?=$item->table_name?></td>
				</tr>
				<tr>
					<td class="table-head">item_id</td>
					<td><?=$item->item_id?></td>
				</tr>
				<? foreach ($new_data as $key => $val) { ?>
					<tr>
						<td class="table-head"><?=$key?></td>
						<td><?=$val?></td>
					</tr>
				<? } ?>
			</table>
		</div>
	</div>
</div>
<?
	} else if (strtoupper($item->action) == "DELETE") {
		$old_data = unserialize($item->old_data);
?>
<div class="row">
	<div class="col-sm-12">
		<div class="">
			<h4><strong><?=$item->user_name?></strong> deleted</h4>
			<table class="table table-bordered">
				<tr>
					<td class="table-head">table_name</td>
					<td><?=$item->table_name?></td>
				</tr>
				<tr>
					<td class="table-head">item_id</td>
					<td><?=$item->item_id?></td>
				</tr>
				<? foreach ($old_data as $key => $val) { ?>
					<tr>
						<td class="table-head"><?=$key?></td>
						<td><?=$val?></td>
					</tr>
				<? } ?>
			</table>
		</div>
	</div>
</div>
<?
	}
?>