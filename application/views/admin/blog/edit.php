<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title"><?=$category->name?></h1>
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
					<td class="table-head text-right" width="10%">URL alias</td>
					<td><input type="text" id="alias" name="alias" class="form-control" value="<?=$item->alias?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Category</td>
					<td>
						<select id="category_id" name="category_id" class="form-control">
						<?
							function level_indent($level) {
								for ($i=0; $i<$level; $i++) {
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; // 6 spaces
								}
							}
							function print_categories($obj, $categories, $curr_category_id, $level) {
								foreach ($categories as $category) {
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
							$("#category_id").val("<?=$category->id?>");
						</script>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Thumbnail</td>
					<td><input type="text" id="thumbnail" name="thumbnail" class="form-control" value="<?=$item->thumbnail?>" onclick="openKCFinder4Textbox(this)" value="Click here and select a file double clicking on it"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Description</td>
					<td><textarea id="description" name="description" class="tinymce form-control" rows="5"><?=$item->description?></textarea></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Tags</td>
					<td><input type="text" id="tags" name="tags" class="form-control" value="<?=$item->tags?>" maxlength="255" placeholder="Post tags..."></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">SEO</td>
					<td>
						<div class="seo-panel">
							<p class="title"><input type="text" id="meta_title" name="meta_title" class="form-control seo-control" maxlength="70" value="<?=$item->meta_title?>" placeholder="Title..."></p>
							<p class="url"><?=BASE_URL?>/.../<?=$item->alias?>.html</p>
							<p class="keywords"><input type="text" id="meta_key" name="meta_key" class="form-control seo-control" maxlength="255" value="<?=$item->meta_key?>" placeholder="Keywords..."></p>
							<p class="description"><input type="text" id="meta_desc" name="meta_desc" class="form-control seo-control" maxlength="160" value="<?=$item->meta_desc?>" placeholder="Description..."></p>
						</div>
					</td>
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