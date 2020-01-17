<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Visit Purposes
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
						<li><a href="<?=site_url("syslog/visit-purposes/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
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
					<th>Visit Purpose</th>
					<th class="text-center" width="50px">Code</th>
					<th>Visa Types</th>
					<th class="hidden" width="180px">Updated</th>
				</tr>
				<?
					$visa_types = $this->m_visa_type->items();
					
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr class="row<?=$item->active?>">
					<td class="text-center"><?=($i+1)?></td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<a href="<?=site_url("syslog/visit-purposes/edit/{$item->id}")?>"><?=$item->name?></a>
						<ul class="action-icon-list">
							<li><a href="<?=site_url("syslog/visit-purposes/edit/{$item->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($item->active) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
							<? } else { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
							<? } ?>
						</ul>
					</td>
					<td class="text-center">
						<?=$item->code?>
					</td>
					<td class="text-center clearfix">
						<?
							foreach ($visa_types as $visa_type) {
								$purpose_type = $this->m_visit_purpose_types->search($item->id, $visa_type->id);
								if (!empty($purpose_type)) {
						?>
								<div class="pull-left" style="margin-right: 20px;"><div class="checkbox" style="margin-top: 0px;"><label><input type="checkbox" class="visit-purpose-type" visit-purpose="<?=$item->id?>" visa-type="<?=$visa_type->id?>" checked="checked"><?=$visa_type->code?></label></div></div>
						<?
								} else {
						?>
								<div class="pull-left" style="margin-right: 20px;"><div class="checkbox" style="margin-top: 0px;"><label><input type="checkbox" class="visit-purpose-type" visit-purpose="<?=$item->id?>" visa-type="<?=$visa_type->id?>"><?=$visa_type->code?></label></div></div>
						<?
								}
							}
						?>
					</td>
					<td class="hidden">
						<?
						/*
							$updated_by = $this->m_user->load($item->updated_by);
							if (!empty($updated_by)) {
						?>
						<strong><?=$updated_by->fullname?></strong>
						<div class="action-icon-list"><span class="text-color-grey"><?=date($this->config->item("log_date_format"), strtotime($item->updated_date))?></span></div>
						<?
							}
						*/
						?>
					</td>
				</tr>
				<?
						$i++;
					}
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
	$(".visit-purpose-type").change(function() {
		var visit_purpose = $(this).attr("visit-purpose");
		var visa_type = $(this).attr("visa-type");
		var val = ($(this).is(":checked")?1:0);
		
		var p = {};
		p["visit_purpose"] = visit_purpose;
		p["visa_type"] = visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visit-purpose-type")?>",
			data: p
		});
	});
});
</script>