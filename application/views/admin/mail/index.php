<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Mail
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Read</a></li>
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Unread</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
						<li><a href="#" class="btn-delete-all"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete All</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<? if (empty($items) || !sizeof($items)) { ?>
		<p class="help-block">No item found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<table class="table table-bordered">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th>From</th>
					<th>Subject</th>
					<th width="150px">Received</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr class="row<?=$item->read?>">
					<td class="text-center">
						<?=($i + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
					</td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<?=$item->sender?>
					</td>
					<td>
						<a class="<?=($item->read?"text-color-grey":"")?>" href="<?=site_url("syslog/mail/detail/{$item->id}")?>"><?=$item->title?></a>
						<ul class="action-icon-list">
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($item->read) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unread');"><i class="fa fa-eye" aria-hidden="true"></i> Read</a></li>
							<? } else { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','read');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Unread</a></li>
							<? } ?>
							<li><a href="#" class="btn-forward" item-id="<?=$item->id?>"><i class="fa fa-mail-forward"></i> Forward</a></li>
						</ul>
					</td>
					<td>
						<div class="action-icon-list"><span class="text-color-grey"><?=date($this->config->item("log_date_format"), strtotime($item->created_date))?></span></div>
					</td>
				</tr>
				<?
						$i++;
					}
				?>
			</table>
			<div><?=$pagination?></div>
		</form>
		<? } ?>
	</div>
</div>

<div id="dialog-send-mail" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Compose Email</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="80px">
							<label class="form-label right">To <span class="required">*</span></label>
						</td>
						<td>
							<input type="text" id="to_receiver" name="to_receiver" value="" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="text-right active">
							<label class="form-label right">Subject <span class="required">*</span></label>
						</td>
						<td>
							<input type="text" id="subject" name="subject" value="" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="text-right active">
							<label class="form-label right">Message <span class="required">*</span></label>
						</td>
						<td>
							<textarea id="message" name="message" class="form-control tinymce" rows="20" style="height: 300px;" required></textarea>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-send">Send</button>
			</div>
		</div>
	</div>
</div>
<? require_once(APPPATH."views/module/admin/upload_ckfinder.php"); ?>
<script>
$(document).ready(function() {
	$(".btn-publish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("read");
		}
	});
	$(".btn-unpublish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unread");
		}
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
	$(".btn-delete-all").click(function(e){
		e.preventDefault();
		confirmBox("Delete all items", "Are you sure you want to delete all the e-mail in your box?", "submitButton", "delete-all");
	});
	$(".btn-forward").click(function() {
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-mail-forward/compose")?>",
			data: p,
			dataType: "json",
			success: function(result) {
				$("#dialog-send-mail").find("#to_receiver").val(result[0]);
				$("#dialog-send-mail").find("#subject").val(result[1]);
				tinymce.get('message').setContent(result[2]);
				$("#dialog-send-mail").modal();
			}
		});
	});
	
	$(".btn-send").click(function() {
		var p = {};
		p["to_receiver"] = $("#dialog-send-mail").find("#to_receiver").val();
		p["subject"] = $("#dialog-send-mail").find("#subject").val();
		p["message"] = tinymce.get('message').getContent();
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-mail-forward/send")?>",
			data: p,
			success: function(result) {
				messageBox("INFO", "Compose Email", result);
				$("#dialog-send-mail").modal("hide");
			}
		});
	});
});
</script>