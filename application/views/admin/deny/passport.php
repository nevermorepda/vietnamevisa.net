<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Deny Passports
				<div class="pull-right">
					<div class="clearfix">
						<div class="pull-left" style="max-width: 250px;">
							<div class="input-group input-group-sm">
								<input type="text" id="report_text" name="report_text" class="form-control" value="<?=$search_text?>" placeholder="Search for passport number">
								<span class="input-group-btn">
									<button class="btn btn-default btn-report" type="button">Search</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="<?=$task?>">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" id="search_text" name="search_text" value="<?=$search_text?>">
			<? if (empty($items) || !sizeof($items)) { ?>
			<p class="help-block">No item found.</p>
			<? } else { ?>
			<table class="table table-bordered">
				<tr>
					<th class="text-center" width="5">#</th>
					<th>Fullname</th>
					<th class="text-center">Gender</th>
					<th>D.O.B</th>
					<th>Nationality</th>
					<th>Passport No.</th>
					<th class="text-center">Status</th>
				</tr>
				<?
					$i = 0;
					foreach ($items as $item) {
				?>
					<tr>
						<td width="2%" class="text-center">
							<?=($i + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
						</td>
						<td>
							<?=$item->fullname?>
						</td>
						<td width="2%" class="text-center">
							<?=$item->gender?>
						</td>
						<td>
							<?=date("M/d/Y", strtotime($item->birthday))?>
						</td>
						<td>
							<?=$item->nationality?>
						</td>
						<td>
							<?=$item->passport?>
						</td>
						<td width="3%" class="text-right">
							<div class="btn-group btn-processing-status">
								<a class="btn btn-xs dropdown-toggle dropdown-toggle-passport-status-<?=$item->passport?>" data-toggle="dropdown">
									<? if ($item->status == 1) { ?>
									<span class="label label-default">Submitted</span> <i class="fa fa-caret-down"></i>
									<? } else if ($item->status == 2) { ?>
									<span class="label label-success">Approved</span> <i class="fa fa-caret-down"></i>
									<? } else if ($item->status == 3) { ?>
									<span class="label label-danger">Denied</span> <i class="fa fa-caret-down"></i>
									<? } ?>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a title="" class="passport-status" passport="<?=$item->passport?>" status-id="1"><span class="label label-default">Submitted</span></a>
										<a title="" class="passport-status" passport="<?=$item->passport?>" status-id="2"><span class="label label-success">Approved</span></a>
										<a title="" class="passport-status" passport="<?=$item->passport?>" status-id="3"><span class="label label-danger">Denied</span></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				<?
						$i++;
					}
				?>
			</table>
			<div><?=$pagination?></div>
			<? } ?>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".passport-status").click(function() {
		var passport = $(this).attr("passport");
		var status_id = $(this).attr("status-id");
		var status_label = $(this).html();
		
		var p = {};
		p["passport"] = passport;
		p["status_id"] = status_id;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-passport-status")?>",
			data: p,
			success: function(result) {
				$(".dropdown-toggle-passport-status-" + passport).html(status_label + " <i class=\"fa fa-caret-down\"></i>");
			}
		});
	});
	
	$(".btn-report").click(function(){
		$("#search_text").val($("#report_text").val());
		submitButton("search");
	});
	
	$("[data-ci-pagination-page]").click(function(event){
		event.preventDefault();
		$("#frm-admin").attr("action", $(this).attr("href")).submit();
	});
});
</script>