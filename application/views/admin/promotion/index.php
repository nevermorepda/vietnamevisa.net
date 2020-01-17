<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Promotion Codes
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="margin-right: 5px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for promotion code">
							</div>
						</div>
						<div class="pull-left" style="max-width: 180px;">
							<div class="input-group input-group-sm">
								<select id="report_status" name="report_status" class="form-control">
									<option value="">All promotion</option>
									<option value="-1">Expired</option>
								</select>
								<script>$("#report_status").val("<?=$search_status?>");</script>
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Search</button>
								</span>
							</div>
						</div>
						<ul class="action-icon-list">
							<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Disable</a></li>
							<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Enable</a></li>
							<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<li><a href="<?=site_url("syslog/promotion-codes/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
						</ul>
					</div>
				</div>
			</h1>
		</div>
		<? if (empty($items) || !sizeof($items)) { ?>
		<p class="help-block">No item found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="<?=site_url("syslog/promotion-codes")?>" method="POST">
			<input type="hidden" id="task" name="task" value="<?=$task?>">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<input type="hidden" id="search_status" name="search_status" value="<?=$search_status?>" />
			<table class="table table-bordered table-hover">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th>Code</th>
					<th class="text-right" width="70">Discount</th>
					<th width="90">Start date</th>
					<th width="90">End date</th>
					<th class="hidden" width="180px">Updated</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
				<tr class="row<?=$item->active?> <?=((strtotime($item->end_date) < strtotime("now"))?"date-expired":"")?>">
					<td class="text-center">
						<?=($i + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
					</td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->code?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<a href="<?=site_url("syslog/promotion-codes/edit/{$item->code}")?>"><?=$item->code?></a>
						<ul class="action-icon-list">
							<li><a href="<?=site_url("syslog/promotion-codes/edit/{$item->code}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($item->active) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Disable</a></li>
							<? } else { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Enable</a></li>
							<? } ?>
						</ul>
					</td>
					<td class="text-right">
						<?=("-".$item->discount."".$item->discount_unit)?>
					</td>
					<td>
						<?=date("M d, Y", strtotime($item->start_date))?>
					</td>
					<td>
						<?=date("M d, Y", strtotime($item->end_date))?>
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
			<div><?=$pagination?></div>
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
	$(".btn-report").click(function(){
		$("#search_text").val($("#report_text").val());
		$("#search_status").val($("#report_status :selected").val());
		submitButton("search");
	});
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
});
</script>