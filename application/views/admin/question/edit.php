<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Edit</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Title</td>
					<td><input type="text" id="title" name="title" class="form-control" value="<?=$item->title?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Author</td>
					<td><input type="text" id="author" name="author" class="form-control" value="<?=$item->author?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Email</td>
					<td><input type="text" id="email" name="email" class="form-control" value="<?=$item->email?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Nationality</td>
					<td><input type="text" id="email" name="email" class="form-control" value="<?=$item->nationality?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Content</td>
					<td><textarea id="content" name="content" class="tinymce form-control" rows="20"><?=$item->content?></textarea></td>
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