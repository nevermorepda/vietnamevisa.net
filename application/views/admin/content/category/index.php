<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Content Categories
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
						<li><a href="<?=site_url("syslog/content-categories/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
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
					<th>Name</th>
					<th class="hidden" width="180px">Updated</th>
				</tr>
				<?
					function level_indent($level) {
						for ($i=0; $i<$level; $i++) {
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // 6 spaces
						}
					}
					function print_categories($obj, $categories, $level, &$i) {
						foreach ($categories as $category) {
							?>
							<tr class="row<?=$category->active?>">
								<td class="text-center"><?=($i+1)?></td>
								<td class="text-center">
									<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$category->id?>" onclick="isChecked(this.checked);">
								</td>
								<td>
									<a href="<?=site_url("syslog/content-categories/edit/{$category->id}")?>"><?=level_indent($level).($level?"|&rarr; ":"")?><?=$category->name?></a>
									<ul class="action-icon-list">
										<li><a href="<?=site_url("syslog/content/{$category->alias}")?>"><?=number_format($category->child_num)?> Topics</a></li>
										<li><a href="<?=site_url("syslog/content-categories/edit/{$category->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
										<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
										<? if ($category->active) { ?>
										<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
										<? } else { ?>
										<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
										<? } ?>
										<li><a href="#" onclick="return itemTask('cb<?=$i?>','orderup');"><i class="fa fa-level-up" aria-hidden="true"></i> Up</a></li>
										<li><a href="#" onclick="return itemTask('cb<?=$i?>','orderdown');"><i class="fa fa-level-down" aria-hidden="true"></i> Down</a></li>
									</ul>
								</td>
								<td class="hidden">
									<?
									/*
										$updated_by = $obj->m_user->load($category->updated_by);
										if (!empty($updated_by)) {
									?>
									<strong><?=$updated_by->fullname?></strong>
									<div class="action-icon-list"><span class="text-color-grey"><?=date($this->config->item("log_date_format"), strtotime($category->updated_date))?></span></div>
									<?
										}
									*/
									?>
								</td>
							</tr>
							<?
							$i++;
							$child_category_info = new stdClass();
							$child_category_info->parent_id = $category->id;
							$child_categories = $obj->m_category->items($child_category_info);
							print_categories($obj, $child_categories, $level+1, $i);
						}
					}
					$i = 0;
					print_categories($this, $items, 0, $i);
				?>
			</table>
		</form>
		<? } ?>
	</div>
</div>

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