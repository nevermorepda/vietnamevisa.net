<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				History
				<div class="pull-right">
					<ul class="action-icon-list">
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
			<table class="table table-bordered table-hover">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th width="150px">Date</th>
					<th>Fullname</th>
					<th class="text-center" width="80px">Action</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr class="row1 row-history pointer <?=((strtoupper($item->action)=="ADD")?"success":((strtoupper($item->action)=="UPDATE")?"warning":"danger"))?>" item-id="<?=$item->id?>">
					<td class="text-center">
						<?=($i + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
					</td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<div class="action-icon-list"><span class="text-color-grey"><?=date($this->config->item("log_date_format"), strtotime($item->created_date))?></span></div>
					</td>
					<td>
						<?=$item->user_name?>
					</td>
					<td class="text-center">
						<?=strtoupper($item->action)?>
					</td>
				</tr>
				<?
						$i++;
					}
				?>
			</table>
			<div><?=$pagination?></div>
		</form>
		<div class="history-detail"></div>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function() {
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
		confirmBox("Delete all items", "Are you sure you want to delete all the history?", "submitButton", "delete-all");
	});
	$(".row-history").click(function(e){
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$(".history-detail").html("Loading...");
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-history")?>",
			data: p,
			success: function(result) {
				$(".history-detail").html(result);
			}
		});
	});
});
</script>