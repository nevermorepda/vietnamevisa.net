<div id="myModal" class="modal fade" role="dialog" style="z-index: 99999;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload photo</h4>
			</div>
			<div class="modal-body">
				<div class="image-list">
					<? $fileList = glob(PATH_CKFINDER);
					$files = $this->util->sort_date_file($fileList);
					foreach($files as $file) {
						$temp = explode('files', $file);
						$file_url = str_replace($temp[0],BASE_URL.'/', $file); ?>
					<div class="item">
						<i class="fa fa-times" aria-hidden="true"></i>
						<img class="select-img" src="<?=$file_url?>">
					</div>
					<? } ?>
				</div>
			</div>
			<div class="modal-footer">
				<label class="upload-file-ck">
					<input id="file-upload" class="select-file" type="file"/>
					Upload
				</label>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click",".mce-combobox .mce-textbox",function() {
		$('#myModal').modal('show');
		var stt = $(this).attr('aria-labelledby');
		var stt1 = stt.replace("mceu_","");
		var stt2 = stt1.replace("-l","");
		$('.modal-title').attr('stt',stt2);
	});
	$(document).on('change', '.select-file', function(event) {
		var formData = new FormData();
		formData.append('file', $(this)[0].files[0]);
		var d = new Date();
		var t = d.getTime();
		$('.image-list').prepend('<div id="'+t+'" class="item"><i class="fa fa-spinner" aria-hidden="true"></i></div>');
		$.ajax({
			url : '<?php echo site_url('syslog/upload-file')?>',
			type : 'POST',
			data : formData,
			processData: false,
			contentType: false,
			success : function(data) {
				if (data) {
					var src = '<?=BASE_URL.'/files/upload/image/vietnam-visa/'?>'+data;
					var plus_data = data.split('.');
					$('#'+t).html('<i class="fa fa-times" aria-hidden="true"></i><img id="'+plus_data[0]+'" class="select-img" src="'+src+'">');
				}
			}
		});
	});
	$(document).on('dblclick', '.select-img', function(event) {
		event.preventDefault();
		var cl = $('.modal-title').attr('stt');
		$('#mceu_'+cl+'-inp').val($(this).attr('src'));
		$('#myModal').modal('hide');
	});
	// $(document).on("click",".fa-times",function() {
	// 	$(this).parent('.item').remove();
	// 	var p = {};
	// 	p['link'] = $(this).next('.select-img').attr('src');
	// 	$.ajax({
	// 		url : '<?php // echo site_url('syslog/delete-file')?>',
	// 		type : 'POST',
	// 		data : p,
	// 		dataType:'html',
	// 	});
	// });
</script>