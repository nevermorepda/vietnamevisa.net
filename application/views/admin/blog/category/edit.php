<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Blog Category</h1>
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
					<td class="table-head text-right">Parent category</td>
					<td>
						<select id="parent_id" name="parent_id" class="form-control">
							<option value="0">Root</option>
							<?
								function level_indent($level) {
									for ($i=0; $i<$level; $i++) {
										echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // 6 spaces
									}
								}
								function print_categories($obj, $categories, $curr_category_id, $level) {
									foreach ($categories as $category) {
										if ($category->id == $curr_category_id) {
											continue;
										}
										?>
										<option value="<?=$category->id?>"><?=level_indent($level).($level?"|&rarr; ":"")?><?=$category->name?></option>
										<?
										$child_category_info = new stdClass();
										$child_category_info->parent_id = $category->id;
										$child_categories = $obj->m_blog_category->items($child_category_info);
										print_categories($obj, $child_categories, $curr_category_id, $level+1);
									}
								}
								$category_info = new stdClass();
								$category_info->parent_id = 0;
								$categories = $this->m_blog_category->items($category_info);
								print_categories($this, $categories, $item->id, 0);
							?>
						</select>
						<script type="text/javascript">
							$("#parent_id").val("<?=$item->parent_id?>");
						</script>
					</td>
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