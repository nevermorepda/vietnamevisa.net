<style>
.btn-timeline {
	border-radius: 0px;
	padding: 0px;
	font-size: 11px;
	line-height: 1;
}
.table-scheduler .col-current-month,
.table-scheduler tr:hover > .col-current-month {
	position: relative;
	background-color: #5bc0de;
	color: #fff;
}
.table-scheduler .col-current-month .arrow-down {
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
				Holiday
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a class="pointer btn-add"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<table class="table table-scheduler table-bordered table-striped table-hover">
				<tr>
					<th rowspan="2">Name</th>
					<th rowspan="2">On</th>
					<th colspan="12" class="text-center"><?=date('Y')?></th>
				</tr>
				<tr>
					<? for ($m=1; $m<=12; $m++) { ?>
					<td class="text-center <?=(($m==date("m"))?"col-current-month":"")?>"><?=substr('0'.$m, -2)?><div class="<?=(($m==date("m"))?"arrow-down":"")?>"></div></td>
					<? } ?>
				</tr>
				<?
					$info = new stdClass();
					$holidays = $this->m_holiday->items(NULL, 1);
					foreach ($holidays as $holiday) {
				?>
				<tr>
					<td><?=$holiday->name?></td>
					<td><?=date("m/d/Y", strtotime($holiday->start_date))?> - <?=date("m/d/Y", strtotime($holiday->end_date))?></td>
					<? for ($m=1; $m<=12; $m++) {
						$shift = false;
						$sh_start = date('m', strtotime($holiday->start_date));
						$sh = min(array(12-$m, round((strtotime($holiday->end_date) - strtotime($holiday->start_date))/(60*60*24*12))+1));
						if ($sh_start == $m && $sh) {
							?>
							<td colspan="<?=($sh)?>" class="text-center">
								<div class="btn-group full-width">
									<button type="button" class="btn btn-xs btn-danger dropdown-toggle btn-timeline full-width" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&nbsp;</button>
									<ul class="dropdown-menu">
										<li><a href="#" class="btn-edit" item-id="<?=$holiday->id?>">Edit</a></li>
										<li><a href="#" class="btn-delete" item-id="<?=$holiday->id?>">Delete</a></li>
									</ul>
								</div>
							</td>
							<?
							$m += ($sh-1);
							$shift = true;
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

<div id="dialog-add-holiday" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New Holiday</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Name</label>
						</td>
						<td>
							<input type="text" id="name" name="name" value="" class="form-control" placeholder="Holiday name">
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">From</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="start_date" name="start_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
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
								<input type="text" id="end_date" name="end_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
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
				<button type="button" class="btn btn-success btn-add-holiday">Add</button>
			</div>
		</div>
	</div>
</div>

<div id="dialog-edit-holiday" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Holiday</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">Name</label>
						</td>
						<td>
							<input type="text" id="name" name="name" value="" class="form-control" placeholder="Holiday name">
						</td>
					</tr>
					<tr>
						<td class="text-right active" width="120px">
							<label class="form-label right">From</label>
						</td>
						<td>
							<div class="input-group">
								<input type="text" id="start_date" name="start_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
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
								<input type="text" id="end_date" name="end_date" value="" class="datepicker form-control" placeholder="mm/dd/yyyy">
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
				<button type="button" class="btn btn-success btn-update-holiday">Update</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".datepicker").daterangepicker({
		singleDatePicker: true,
		locale: {
			format: 'MM/DD/YYYY'
        }
    });

	$(".btn-add").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-add-holiday");
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-holiday/add")?>",
			data: {},
			dataType: "json",
			success: function(data) {
				dialog.find("#name").val(data[0]);
				dialog.find("#start_date").val(data[1]);
				dialog.find("#end_date").val(data[2]);
				dialog.find("#start_date").data("daterangepicker").setStartDate(data[1]);
				dialog.find("#start_date").data("daterangepicker").setEndDate(data[1]);
				dialog.find("#end_date").data("daterangepicker").setStartDate(data[2]);
				dialog.find("#end_date").data("daterangepicker").setEndDate(data[2]);
				dialog.modal();
			}
		});
	});

	$(".btn-add-holiday").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-add-holiday");
		var p = {};
		p["name"] = dialog.find("#name").val();
		p["start_date"] = dialog.find("#start_date").val();
		p["end_date"] = dialog.find("#end_date").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-holiday/save")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
				submitButton("reload");
			}
		});
	});

	$(".btn-edit").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-holiday");
		var item_id = $(this).attr("item-id");
		var p = {};
		p["id"] = item_id;
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-holiday/edit")?>",
			data: p,
			dataType: "json",
			success: function(data) {
				dialog.find("#item_id").val(item_id);
				dialog.find("#name").val(data[0]);
				dialog.find("#start_date").val(data[1]);
				dialog.find("#end_date").val(data[2]);
				dialog.find("#start_date").data("daterangepicker").setStartDate(data[1]);
				dialog.find("#start_date").data("daterangepicker").setEndDate(data[1]);
				dialog.find("#end_date").data("daterangepicker").setStartDate(data[2]);
				dialog.find("#end_date").data("daterangepicker").setEndDate(data[2]);
				dialog.modal();
			}
		});
	});
	
	$(".btn-update-holiday").click(function(e) {
		e.preventDefault();
		var dialog = $("#dialog-edit-holiday");
		var p = {};
		p["id"] = dialog.find("#item_id").val();
		p["name"] = dialog.find("#name").val();
		p["start_date"] = dialog.find("#start_date").val();
		p["end_date"] = dialog.find("#end_date").val();
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-holiday/update")?>",
			data: p,
			success: function(data) {
				dialog.modal("hide");
				submitButton("reload");
			}
		});
	});
	
	$(".btn-delete").click(function(e) {
		e.preventDefault();
		var p = {};
		p["id"] = $(this).attr("item-id");
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-holiday/delete")?>",
			data: p,
			success: function(data) {
				submitButton("reload");
			}
		});
	});
});
</script>