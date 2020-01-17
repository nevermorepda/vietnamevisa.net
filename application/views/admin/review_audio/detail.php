<div class="cluster">
	<div class="container-fluid">
		<h1 class="page-title">Mail</h1>
		<? if (empty($item) || !sizeof($item)) { ?>
		<p class="help-block">Item not found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">File name</td>
					<td><?=$item->name?></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Review Audio</td>
					<td>
						<audio controls>
							<source src="<?=BASE_URL?>/files/upload/review_audio/<?=$item->name?>.wav" type="audio/wav">
						</audio>
					</td>
				</tr>
			</table>
			<div>
				<button class="btn btn-sm btn-default btn-cancel">Back</button>
			</div>
		</form>
		<? } ?>
	</div>
</div>

<style>
body {
	padding: inherit !important;
}
</style>
<script>
$(document).ready(function() {
	$(".btn-cancel").click(function(){
		submitButton("cancel");
	});
});
</script>
