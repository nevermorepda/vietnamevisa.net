<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Visa Approval Letter
				<div class="pull-right">
					<ul class="action-icon-list">
						<li  data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Send letter</li>
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
			<table class="table table-bordered table-hover">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th>List book</th>
					<th  width="110px">Attachment</th>
					<th  width="180px">Sent date</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr class="row0">
					<td class="text-center"><?=($i+1)?></td>
					<td>
						<a><?=$item->book_id_list?></a>
					</td>
					<td>
						<?
							$files_name = explode(',',$item->file_name);
							foreach ($files_name as $file_name) {
								if (!empty($file_name)) {
									$fm = explode('.',$file_name);
									if ($fm[1] == 'pdf' || $fm[1] == 'PDF') {
										echo '<img src="'.IMG_URL.'pdf.png" style="width: 110px;height: 80px;object-fit: cover;margin-bottom: 2px;">';
									} else {
										echo '<img src="'.BASE_URL.'/files/upload/image/visa_letter/'.$file_name.'" style="width: 110px;height: 70px;object-fit: cover;margin-bottom: 2px;">';
									}
								}
								
							}
						?>
					</td>
					<td >
						<?
						
							$user = $this->m_user->load($item->user_id);
							if (!empty($user)) {
						?>
						<strong><?=$user->user_fullname?></strong>
						<div class="action-icon-list"><span class="text-color-grey"><?=date($this->config->item("log_date_format"), strtotime($item->created_date))?></span></div>
						<?
							}
						?>
					</td>
				</tr>
				<?
						$i++;
					}
				?>
			</table>
		</form>
		<? } ?>
	</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
	<form action="" method="POST" accept-charset="utf-8">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Send visa letter</h4>
				</div>
				<div class="modal-body">
					<input type="text" name="book_id" id="book_id" class="form-control" value="">
					<input type="hidden" name="file_name" id="file_name" class="form-control" value="">
					<div class="attach-file-list"></div>
					<br>
					<div class="text-center">
						<label class="attach-file">
							<a class="btn btn-success">Attach file</a>
							<input type="file" id="attach_file" pax_id="" name="attach_file[]" multiple="multiple"/>
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-send" >Send</button>
					<a class="btn btn-default btn-cancel" data-dismiss="modal">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).on('change', '#attach_file', function(event) {
		var form_data = new FormData();
		var ins = document.getElementById('attach_file').files.length;
		var str = '';
		for (var x = 0; x < ins; x++) {
			form_data.append("attach_file[]", document.getElementById('attach_file').files[x]);
			str += '<img src="<?=IMG_URL?>giphy.gif" alt="" class="item">';
		}
		var ul = '<?=BASE_URL.'/syslog/ajax-attach-file-urg/'?>';
		var pax_id = $(this).attr('pax_id');
		if (ins > 0) {
			$('.attach-file-list').html(str);
			$.ajax({
				url : '<?=site_url('syslog/ajax-visa-approval-letter')?>',
				type : 'POST',
				data : form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success : function(data) {
					if (data) {
						var c = data.length
						var str = '';
						var file_name = '';
						for (var i = 0; i < c; i++) {
							var src = '<?=BASE_URL?>/files/upload/image/visa_letter/'+data[i];
							var format = data[i].split('.');
							if (format[1] == 'pdf' || format[1] == 'PDF') {
								str += '<img src="<?=IMG_URL?>pdf.png" alt="" class="item">';
							} else {
								str += '<img src="'+src+'" alt="" class="item">';
							}
							file_name += data[i]+',';
						}
						$('#file_name').val(file_name);
						$('.attach-file-list').html(str);
					}
				}
			});
		}
	});
</script>
<script>
$(document).ready(function() {
	$(".btn-publish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("publish");
		}
	});
	$(".btn-unpublish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unpublish");
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
});
</script>