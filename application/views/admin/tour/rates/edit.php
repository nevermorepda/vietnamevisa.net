<section>
	<div class="container-fluid">
		<h1 class="page-title">Tour Rates</h1>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<?
				$type = "";
				$arrduration = array();
				$hassupplement = false;
				if (!empty($items)) {
					foreach ($items as $rate) {
						if ($rate->single_supplement) {
							$hassupplement = true;
							continue;
						}
						$arrduration[$rate->id] = $rate->group_size;
						$type = $rate->name;
					}
				}
			?>
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-bordered">
				<tr>
					<td class="table-head text-right" width="10%">Group Name</td>
					<td>
						<input type="text" value="<?=$type?>" maxlength="255" id="name" name="name" class="inputbox form-control" />
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Type passenger</td>
					<td>
						<select class="form-control" id="type_passenger" name="type_passenger">
							<option value="1">Adults</option>
							<option value="2">Children (5-12 age)</option>
							<option value="3">Infants</option>
						</select>
						<script type="text/javascript">
							$("#type_passenger").val("<?=$type_passenger?>");
						</script>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Group Size</td>
					<td>
						<? foreach ($arrduration as $key => $val) { ?>
							<input type="text" value="<?=$val?>" maxlength="255" name="group_size_<?=$key?>" class="inputbox" style="width: 60px; text-align: right;" />
						<? } ?>
						<? for ($i=sizeof($arrduration); $i<12; $i++) { ?>
							<input type="text" value="" maxlength="255" name="group_size_-<?=$i?>" class="inputbox" style="width: 60px; text-align: right;" />
						<? } ?>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right" width="10%">Price/pax</td>
					<td>
						<?
							foreach ($arrduration as $key => $val) {
								foreach ($items as $rate) {
									if ($rate->name == $type && $rate->group_size == $val && !$rate->single_supplement) {
										echo '<input type="text" value="'.$rate->price.'" maxlength="255" name="price_'.$key.'" class="inputbox" style="width: 60px; text-align: right;" />';
									}
								}
							}
						?>
						<? for ($i=sizeof($arrduration); $i<12; $i++) { ?>
							<input type="text" value="" maxlength="255" name="price_-<?=$i?>" class="inputbox" style="width: 60px; text-align: right;" />
						<? } ?>
					</td>
				</tr>
				<tr>
					<td class="table-head text-right">Supplement</td>
					<td>
					<?
						if ($hassupplement) {
							foreach ($items as $rate) {
								if ($rate->name == $type && $rate->single_supplement) {
									echo '<input type="text" value="'.$rate->price.'" maxlength="255" name="single_supplement" class="inputbox" style="width: 60px; text-align: right;" />';
								}
							}
						}
						else {
							echo '<input type="text" value="" maxlength="255" name="single_supplement" class="inputbox" style="width: 60px; text-align: right;" />';
						}
					?>
					</td>
				</tr>
			</table>
			<div>
				<button class="btn btn-sm btn-primary btn-save">Save</button>
				<button class="btn btn-sm btn-default btn-cancel">Cancel</button>
			</div>
		</form>
	</div>
</section>

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

