<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Answer</h1>
		
		<div class="media">
			<div class="media-left">
				<img class="media-object" src="<?=IMG_URL?>no-avatar.gif" width="40px">
			</div>
			<div class="media-body">
				<h5 class="media-heading"><?=$item->author?></h5>
				<p class="help-block"><?=$item->nationality?></p>
				<blockquote style="font-size: 12px; background-color: #F8F8F8;">
					<h5><?=$item->title?></h5>
					<p class="help-block"><?=date("Y-m-d H:i:s", strtotime($item->created_date))?></p>
					<p><?=$item->content?></p>
				</blockquote>
				
				<? 
				$answer_info = new stdClass();
				$answer_info->parent_id = $item->id;
				$answers = $this->m_question->items($answer_info);
				if (!empty($answers)) {
					foreach ($answers as $answer) {
				?>
				<div class="media">
					<div class="media-left">
						<? if ($answer->email == MAIL_INFO) { ?>
						<img class="media-object" src="<?=IMG_URL?>support.png" width="40px">
						<? } else { ?>
						<img class="media-object" src="<?=IMG_URL?>no-avatar.gif" width="40px">
						<? } ?>
					</div>
					<div class="media-body">
						<h5><?=$answer->author?></h5>
						<blockquote style="font-size: 12px; background-color: #F8F8F8;">
							<h5><?=$answer->title?></h5>
							<p class="help-block"><?=date("Y-m-d H:i:s", strtotime($answer->created_date))?></p>
							<p><?=$answer->content?></p>
						</blockquote>
					</div>
				</div>
				<?
					}
				}
				?>
			</div>
		</div>
		
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Author</td>
					<td><label><?=$this->session->userdata("admin")->user_fullname?></label></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Answer</td>
					<td><textarea id="content" name="content" class="tinymce form-control" rows="20"></textarea></td>
				</tr>
			</table>
			<div>
				<button class="btn btn-sm btn-primary btn-save">Save</button>
				<button class="btn btn-sm btn-default btn-cancel">Cancel</button>
			</div>
		</form>
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