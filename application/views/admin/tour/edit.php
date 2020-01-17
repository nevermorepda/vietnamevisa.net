<?
$categories = $this->m_category_tour->items();
?>
<div class="cluster">
	<div class="container-fluid">
		<form id="frm-admin" name="adminForm" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Title</td>
					<td><input type="text" id="title" name="title" class="form-control" value="<?=!empty($item->title) ? $item->title : '' ?>"></td> 
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">URL alias</td>
					<td><input type="text" id="alias" name="alias" class="form-control" value="<?=!empty($item->alias) ? $item->alias : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Category</td>
					<td>
						<select id="catid" name="catid" class="form-control">
						<option value="0">--------</option>
						<? foreach ($categories as $category) { ?>
						<option value="<?=$category->id?>"><?=$category->name?></option>
						<? } ?>
						</select>
						<script type="text/javascript">
							$("#catid").val("<?=$item->catid?>");
						</script>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Price</td>
					<td>
						<div class="row">
							<div class="col-sm-4">
								<div class="input-group">
									<input type="number" class="form-control spinner_default" id="price" name="price" value="<?=!empty($item->price) ? $item->price : null?>">
									<span class="input-group-addon">Adults ($)</span>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="number" class="form-control spinner_default" id="child_price" name="child_price" value="<?=!empty($item->child_price) ? $item->child_price : null?>">
									<span class="input-group-addon">Childrends ($)</span>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="number" class="form-control spinner_default" id="infants_price" name="infants_price" value="<?=!empty($item->infants_price) ? $item->infants_price : null?>">
									<span class="input-group-addon">Infants ($)</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Location</td>
					<td><input type="text" id="location" name="location" class="form-control" value="<?=!empty($item->location) ? $item->location : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Duration</td>
					<td><input type="text" id="duration" name="duration" class="form-control" value="<?=!empty($item->duration) ? $item->duration : '' ?>"></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Thumbnail</td>
					<td>
						<label class="wrap-upload-thumb" style="background: url('<?=BASE_URL?><?=!empty($item->thumbnail) ? $item->thumbnail : ''?>') no-repeat;">
							<input type="file" name="thumbnail" id="file-upload" value="<?=!empty($item->name) ? $item->name : ''?>">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
						</label>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Description</td>
					<td><textarea id="description" name="description" class="tinymce form-control" rows="5"><?=!empty($item->description) ? $item->description : '' ?></textarea></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">SEO</td>
					<td>
						<div class="seo-panel">
							<p class="title"><input type="text" id="meta_title" name="meta_title" class="form-control seo-control" maxlength="70" value="<?=!empty($item->meta_title) ? $item->meta_title : '' ?>" placeholder="Title..."></p>
							<p class="url"></p>
							<p class="keywords"><input type="text" id="meta_key" name="meta_key" class="form-control seo-control" maxlength="255" value="<?=!empty($item->meta_key) ? $item->meta_key : '' ?>" placeholder="Keywords..."></p>
							<p class="description"><input type="text" id="meta_desc" name="meta_desc" class="form-control seo-control" maxlength="160" value="<?=!empty($item->meta_desc) ? $item->meta_desc : '' ?>" placeholder="Description..."></p>
						</div>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Highlights</td>
					<td>
						<textarea id="highlights" name="highlights" class="tinymce form-control" rows="10"><?=!empty($item->highlights) ? $item->highlights : '' ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Itinerary</td>
					<td>
						<textarea id="itinerary" name="itinerary" class="tinymce form-control" rows="10"><?=!empty($item->itinerary) ? $item->itinerary : '' ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Inclusion</td>
					<td><textarea id="inclusion" name="inclusion" class="tinymce form-control" rows="5"><?=!empty($item->inclusion) ? $item->inclusion : '' ?></textarea></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Exclusion</td>
					<td><textarea id="exclusion" name="exclusion" class="tinymce form-control" rows="5"><?=!empty($item->exclusion) ? $item->exclusion : '' ?></textarea></td>
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
				<a class="btn btn-sm btn-primary btn-save">Save</a>
				<a class="btn btn-sm btn-default btn-cancel">Cancel</a>
			</div>
		</form>
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