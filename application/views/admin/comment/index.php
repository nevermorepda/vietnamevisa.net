<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Comments
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
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
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th>Comment</th>
					<th class="text-center" width="250px">Email</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
						$user = $this->m_user->load($item->user_id);
				?>
				<tr class="row<?=$item->active?>">
					<td class="text-center"><?=($i+1)?></td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<a><strong><?=!empty($user) ? $user->user_fullname : $item->fullname?></strong></a>
						<br>
						<i style="font-size: 11px;color: #717171;"><?=date('F d, Y',strtotime($item->created_date))?> at <?=date('h:i',strtotime($item->created_date))?> <?=(date('H',strtotime($item->created_date)) > 12) ? 'pm' : 'am'?></i>
						<div class="edit-box edit-box-<?=$item->id?>"><?=$item->comment?></div>
						<ul class="action-icon-list">
							<li><a class="btn-reply" set_id="<?=$item->id?>"><i class="fa fa-reply" aria-hidden="true"></i> Reply</a></li>
							<li><a class="btn-edit" set_id="<?=$item->id?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($item->active) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
							<? } else { ?>
							<li><a style="color:red;" href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
							<? } ?>
						</ul>
					</td>
					<td class="text-center"><?=$item->email?></td>
				</tr>
				<?
					$info = new stdClass();
					$info->parent_id = $item->id;
					$child_items = $this->m_comment->items($info,null,null,null,'created_date', 'ASC');
					 $j = $i + 1;
						foreach ($child_items as $child_item) { $user_child = $this->m_user->load($child_item->user_id); ?>
						<tr class="row<?=$child_item->active?>">
							<td style="background: #fff;" class="text-center"><?=($j+1)?></td>
							<td style="background: #fff;" class="text-center">
								<input type="checkbox" id="cb<?=$j?>" name="cid[]" value="<?=$child_item->id?>" onclick="isChecked(this.checked);">
							</td>
							<td style="padding-left: 65px;background: #fff;">
								<a><strong><?=!empty($user_child) ? $user_child->user_fullname : $child_item->fullname?></strong></a>
								<br>
								<i style="font-size: 11px;color: #717171;"><?=date('F d, Y',strtotime($child_item->created_date))?> at <?=date('h:i',strtotime($child_item->created_date))?> <?=(date('H',strtotime($child_item->created_date)) > 12) ? 'pm' : 'am'?></i>
								<div class="edit-box edit-box-<?=$child_item->id?>"><?=$child_item->comment?></div>
								<ul class="action-icon-list">
									<li><a class="btn-reply" set_id="<?=$item->id?>"><i class="fa fa-reply" aria-hidden="true"></i> Reply</a></li>
									<li><a class="btn-edit" set_id="<?=$child_item->id?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
									<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$j?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
									<? if ($child_item->active) { ?>
									<li><a href="#" onclick="return itemTask('cb<?=$j?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
									<? } else { ?>
									<li><a style="color:red;" href="#" onclick="return itemTask('cb<?=$j?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
									<? } ?>
								</ul>
							</td>
							<td style="background: #fff;" class="text-center"><?=!empty($user_child) ? $user_child->user_login : $child_item->email?></td>
						</tr>
						<? $j++; } ?>
				<tr class="box-comment box-<?=$item->id?>"></tr>
				<?
						$i = $j;
					}
				?>
			</table>
		</form>
		<? } ?>
	</div>
</div>
<script type="text/javascript">
	$('.btn-edit').click(function(event) {
		var id = $(this).attr('set_id');
		var cmt = $('.edit-box-'+id).html();
		var str = '<textarea name="comment_edit" class="form-control comment-edit" rows="2">'+cmt+'</textarea><br><div class="text-right"><a class="btn btn-primary btn-send-edit" set_id="'+id+'">Save</a></div>';
		$('.edit-box-'+id).html(str);
	});
	$(document).on('click', '.btn-send-edit', function(event) {
		event.preventDefault();
		var cmt = $(this).parents('td').find('.comment-edit').val();
		var id = $(this).attr('set_id');
		var p = {};
		p['comment'] = cmt;
		p['id'] = id;
		p['user_id'] = <?=$this->session->userdata('admin')->id?>;
		$.ajax({
			url: '<?=site_url("syslog/ajax-update-comment")?>',
			type: 'POST',
			dataType: 'html',
			data: p,
			success: function (result) {
				if (result) {
					$('.edit-box-'+id).html(result);
				}
			}
		});
	});
</script>
<script type="text/javascript">
	$('.btn-reply').click(function(event) {
		var id = $(this).attr('set_id');
		$('.box-comment').html('');
		var str = '<td></td><td></td>';
			str += '<td style="padding-left: 65px;">';
				str += '<textarea name="comment" class="form-control comment" rows="2"></textarea><br>';
				str += '<div class="text-right">';
					str += '<a class="btn btn-primary btn-send" set_id="'+id+'">Send</a>';
				str += '</div>';
			str += '</td><td></td>';
		$('.box-'+id).html(str);
	});
	$(document).on('click', '.btn-send', function(event) {
		event.preventDefault();
		var cmt = $(this).parents('td').find('.comment').val();
		var parent_id = $(this).attr('set_id');
		var p = {};
		p['comment'] = cmt;
		p['parent_id'] = parent_id;
		p['user_id'] = <?=$this->session->userdata('admin')->id?>;
		$.ajax({
			url: '<?=site_url("syslog/ajax-reply-comment")?>',
			type: 'POST',
			dataType: 'html',
			data: p,
			success: function (result) {
				if (result) {
					window.location.reload();
				}
			}
		});
	});
</script>
<script>
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
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