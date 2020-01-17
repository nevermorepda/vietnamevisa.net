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
					<td class="table-head text-right" width="10%">Sender</td>
					<td><?=$item->sender?></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Receivers</td>
					<td><?=$item->receiver?></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Subject</td>
					<td><?=$item->title?></td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Message</td>
					<td style="background-color: #F1F1F1;"><?=$item->message?></td>
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
