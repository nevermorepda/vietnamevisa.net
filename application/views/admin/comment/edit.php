<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title"><?=$category->name?></h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST" enctype="multipart/form-data">
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
						<select id="catid" name="catid" class="form-control">
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
									$child_categories = $obj->m_category->items($child_category_info);
									print_categories($obj, $child_categories, $curr_category_id, $level+1);
								}
							}
							$category_info = new stdClass();
							$category_info->parent_id = 0;
							$categories = $this->m_category->items($category_info);
							print_categories($this, $categories, $item->id, 0);
						?>
						</select>
						<script type="text/javascript">
							$("#catid").val("<?=$category->id?>");
						</script>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Thumbnail</td>
					<td>
						<label class="wrap-upload-thumb" style="background: url('<?=BASE_URL?><?=!empty($item->thumbnail) ? $item->thumbnail : ''?>') no-repeat">
							<input type="file" name="thumbnail" id="file-upload" value="<?=!empty($item->name) ? $item->name : ''?>">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
						</label>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Description</td>
					<td><textarea id="summary" name="summary" class="tinymce form-control" rows="5"><?=$item->summary?></textarea></td>
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
					<td>

						<textarea id="content" name="content" class="tinymce form-control" rows="20"><?=$item->content?></textarea>
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
<? require_once(APPPATH."views/module/admin/upload_ckfinder.php"); ?>
<script>
$(document).ready(function() {
	$("#file-upload").change(function() {
		readURL(this);
	});
	
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('.wrap-upload-thumb').css({
					"background-image": "url('"+e.target.result+"')"
				});
				$('.wrap-upload-thumb > i').css({
					"color": "rgba(52, 73, 94, 0.38)"
				});
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	$(".btn-save").click(function(){
		submitButton("save");
	});
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
});
</script>