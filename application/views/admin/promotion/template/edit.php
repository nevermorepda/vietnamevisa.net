<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Promotion Templates</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Sender name</td>
					<td><input type="text" id="sender" name="sender" class="form-control" value="<?=$item->sender?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Sender email</td>
					<td><input type="text" id="sender_email" name="sender_email" class="form-control" value="<?=$item->sender_email?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Subject</td>
					<td><input type="text" id="subject" name="subject" class="form-control" value="<?=$item->subject?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Receivers <p class="help-block">separated by ';'</p></td>
					<td><textarea id="emails" name="emails" class="form-control" rows="10"><?=$item->emails?></textarea></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Message</td>
					<td><textarea id="content" name="content" class="tinymce form-control" rows="20"><?=$item->content?></textarea></td>
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