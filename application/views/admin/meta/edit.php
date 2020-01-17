<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Page Meta Tags</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Url</td>
					<td><input type="text" id="url" name="url" class="form-control" value="<?=$item->url?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Title</td>
					<td><input type="text" id="title" name="title" class="form-control" value="<?=$item->title?>" maxlength="70"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Keywords</td>
					<td><input type="text" id="keywords" name="keywords" class="form-control" value="<?=$item->keywords?>" maxlength="255"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Description</td>
					<td><textarea id="description" name="description" class="form-control" rows="10" maxlength="160"><?=$item->description?></textarea></td>
				</tr>
				<tr>
					<td class="table-head text-right"></td>
					<td>
						<select id="active" name="active" class="form-control">
							<option value="1">Show</option>
							<option value="0">Hide</option>
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
		submitButton("save");
	});
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
});
</script>