<style>
.btn-timeline {
	border-radius: 0px;
	padding: 0px;
	font-size: 11px;
	line-height: 1;
}
.table-scheduler .col-current-hour,
.table-scheduler tr:hover > .col-current-hour {
	position: relative;
	background-color: #5bc0de;
	color: #fff;
}
.table-scheduler .col-current-hour .arrow-down {
	position: absolute;
	left: calc(50% - 5px);
	bottom: -5px;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #5bc0de;
}
</style>
<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Time Table
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a class="pointer btn-add"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<div class="statement-bar clearfix">
			<div class="pull-right clearfix">
				<div class="pull-left hidden" style="margin-right: 5px;">
					<div class="input-group input-group-sm">
						<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for user">
					</div>
				</div>
				<div class="pull-left" style="max-width: 220px;">
					<div class="input-group input-group-sm">
						<input type="text" class="form-control daterange">
						<span class="input-group-btn">
							<button class="btn btn-default btn-report" type="button">Search</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<input type="hidden" id="fromdate" name="fromdate" value="<?=$fromdate?>" />
			<input type="hidden" id="todate" name="todate" value="<?=$todate?>" />
			<table class="table table-scheduler table-bordered table-striped table-hover">
				<tr>
					<th rowspan="2">Name</th>
					<th colspan="24"><?=date('D, m/d/Y', strtotime($fromdate))?></th>
					<th colspan="24"><?=date('D, m/d/Y', strtotime($fromdate." +1 day"))?></th>
				</tr>
				<tr>
					<? for ($h=0; $h<24; $h++) { ?>
					<td class="text-center <?=(($h==date("H"))?"col-current-hour":"")?>"><?=substr('0'.$h, -2)?><div class="<?=(($h==date("H"))?"arrow-down":"")?>"></div></td>
					<? } ?>
					<? for ($h=0; $h<24; $h++) { ?>
					<td class="text-center"><?=substr('0'.$h, -2)?></td>
					<? } ?>
				</tr>
				<?
					$info = new stdClass();
					$info->fromdate = date("Y-m-d", strtotime($fromdate));
					$info->todate = date("Y-m-d", strtotime($fromdate));
					$today_schedules = $this->m_work_schedule->items($info);
					
					$info = new stdClass();
					$info->fromdate = date("Y-m-d", strtotime($fromdate." +1 day"));
					$info->todate = date("Y-m-d", strtotime($fromdate." +1 day"));
					$tomorrow_schedules = $this->m_work_schedule->items($info);
					
					foreach ($users as $user) {
				?>
				<tr>
					<td><?=$user->user_fullname?></td>
					<? for ($h=0; $h<24; $h++) {
						$shift = false;
						foreach ($today_schedules as $schedule) {
							if ($schedule->user_id == $user->id) {
								$sh_start = date('H', strtotime($schedule->start_date));
								$sh = min(array(24-$h, round((strtotime($schedule->end_date) - strtotime(date('Y-m-d H:00:00', strtotime($schedule->start_date))))/(60*60))));
								if ($sh_start == $h && $sh) {
									?>
									<td colspan="<?=($sh)?>" class="text-center">
										<div class="btn-group full-width">
											<button type="button" class="btn btn-xs btn-<?=($h<8?"danger":($h<19?"success":"warning"))?> dropdown-toggle btn-timeline full-width" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&nbsp;</button>
											<ul class="dropdown-menu">
												<li><a href="#" class="btn-edit" item-id="<?=$schedule->id?>">Edit</a></li>
												<li><a href="#" class="btn-delete" item-id="<?=$schedule->id?>">Delete</a></li>
											</ul>
										</div>
									</td>
									<?
									$h += ($sh-1);
									$shift = true;
									break;
								}
							}
						}
						if (!$shift) {
							?>
							<td class="text-center"></td>
							<?
						}
					} ?>
					<? for ($h=0; $h<24; $h++) {
						$shift = false;
						foreach ($tomorrow_schedules as $schedule) {
							if ($schedule->user_id == $user->id) {
								$sh_start = date('H', strtotime($schedule->start_date));
								$sh = min(array(24-$h, round((strtotime($schedule->end_date) - strtotime(date('Y-m-d H:00:00', strtotime($schedule->start_date))))/(60*60))));
								if ($sh_start == $h && $sh) {
									?>
									<td colspan="<?=($sh)?>" class="text-center">
										<div class="btn-group full-width">
											<button type="button" class="btn btn-xs btn-<?=($h<8?"danger":($h<19?"success":"warning"))?> dropdown-toggle btn-timeline full-width" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&nbsp;</button>
											<ul class="dropdown-menu">
												<li><a href="#" class="btn-edit" item-id="<?=$schedule->id?>">Edit</a></li>
												<li><a href="#" class="btn-delete" item-id="<?=$schedule->id?>">Delete</a></li>
											</ul>
										</div>
									</td>
									<?
									$h += ($sh-1);
									$shift = true;
									break;
								}
							}
						}
						if (!$shift) {
							?>
							<td class="text-center"></td>
							<?
						}
					} ?>
				</tr>
				<?
					}
				?>
			</table>
		</form>
	</div>
</div>

<div id="dialog-add-schedule" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New Schedule</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">User</label>
						</td>
						<td>
							<select id="user_id" name="user_id" class="form-control">
							<? foreach ($users as $user) { ?>
								<option value="<?=$user->id?>"><?=$user->user_fullname?></option>
							<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">From</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="start_date" name="start_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy h:m">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">To</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="end_date" name="end_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy h:m">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-add-schedule">Add</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-edit-schedule" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Schedule</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">From</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="start_date" name="start_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy h:m">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">To</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="end_date" name="end_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy h:m">
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<input type="hidden" id="item_id" name="item_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-update-schedule">Update</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	if ($(".daterange").length) {
		$(".daterange").daterangepicker({
			singleDatePicker: true,
			startDate: "<?=date('m/d/Y', strtotime((!empty($fromdate)?$fromdate:"now")))?>",
			endDate: "<?=date('m/d/Y', strtotime((!empty($todate)?$todate:"now")))?>"
		});
	}
	
	$(".btn-report").click(function(){
		$("#search_text").val($("#report_text").val());
		if ($(".daterange").length) {
			$("#fromdate").val($(".daterange").data("daterangepicker").startDate.format('YYYY-MM-DD'));
			$("#todate").val($(".daterange").data("daterangepicker").endDate.format('YYYY-MM-DD'));
		}
		submitButton("search");
	});
	
	$(".datepicker").daterangepicker({
		singleDatePicker: true,
		timePicker: true,
		timePickerIncrement: 30,
		locale: {
			format: 'MM/DD/YYYY h:mm A'
        }
    });
	
	$(".btn-add").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-add-schedule");
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-scheduler/add")?>",
			data: {},
			dataType: "json",
			success: function(data) {
				dialog.find("#start_date").val(data[0]);
				dialog.find("#end_date").val(data[1]);
				dialog.find("#start_date").data("daterangepicker").setStartDate(data[0]);
				dialog.find("#start_date").data("daterangepicker").setEndDate(data[0]);
				dialog.find("#end_date").data("daterangepicker").setStartDate(data[1]);
				dialog.find("#end_date").data("daterangepicker").setEndDate(data[1]);
				dialog.modal();
			}
		});
	});
	
	$(".btn-add-schedule").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-add-schedule");
		var p = {};
		p["user_id"] = dialog.find("#user_id").val();
		p["start_date"] = dialog.find("#start_date").val();
		p["end_date"] = dialog.find("#end_date").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-scheduler/save")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
				submitButton("search");
			}
		});
	});
	
	$(".btn-edit").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-schedule");
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-scheduler/edit")?>",
			data: p,
			dataType: "json",
			success: function(data) {
				dialog.find("#item_id").val(item_id);
				dialog.find("#start_date").val(data[0]);
				dialog.find("#end_date").val(data[1]);
				dialog.find("#start_date").data("daterangepicker").setStartDate(data[0]);
				dialog.find("#start_date").data("daterangepicker").setEndDate(data[0]);
				dialog.find("#end_date").data("daterangepicker").setStartDate(data[1]);
				dialog.find("#end_date").data("daterangepicker").setEndDate(data[1]);
				dialog.modal();
			}
		});
	});
	
	$(".btn-update-schedule").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-schedule");
		var p = {};
		p["id"] = dialog.find("#item_id").val();
		p["start_date"] = dialog.find("#start_date").val();
		p["end_date"] = dialog.find("#end_date").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-scheduler/update")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
				submitButton("search");
			}
		});
	});
	
	$(".btn-delete").click(function(e) {
		e.preventDefault();
		var p = {};
		p["id"] = $(this).attr("item-id");
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-scheduler/delete")?>",
			data: p,
			success: function(data) {
				submitButton("search");
			}
		});
	});
});
</script>