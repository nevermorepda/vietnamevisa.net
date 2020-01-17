<?
	$nation_types = $this->m_nation_type->items();
?>
<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Nations</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Name</td>
					<td><input type="text" id="name" name="name" class="form-control" value="<?=$item->name?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">URL alias</td>
					<td><input type="text" id="alias" name="alias" class="form-control" value="<?=$item->alias?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Country code</td>
					<td><input type="text" id="code" name="code" class="form-control" value="<?=$item->code?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Region</td>
					<td><input type="text" id="region" name="region" class="form-control" value="<?=$item->region?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right">Type</td>
					<td>
						<select id="type" name="type" class="form-control">
							<? foreach ($nation_types as $nation_type) { ?>
							<option value="<?=$nation_type->id?>"><?=$nation_type->name?></option>
							<? } ?>
						</select>
						<script type="text/javascript">
							$("#type").val("<?=$item->type?>");
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
		submitButton("save");
	});
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
});
</script>