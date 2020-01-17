<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">Debt Comparison</h1>
		</div>
		<form id="frm" method="post" enctype="multipart/form-data" action="">
			<div class="row clearfix">
				<div class="col-sm-6">
					<input type="file" class="file-left" name="file-left">
					<? if (!empty($debt->fl)) { ?>
					<p><span class="glyphicon glyphicon-paperclip"></span> <?=$debt->fl?></p>
					<? } ?>
					<div class="row clearfix" style="margin-top: 15px;">
						<? if (!empty($fl)) { ?>
						<div class="col-sm-11">
							<div class="col-view-left" style="width: 100%; height: 500px; overflow-y: scroll; display: block; border: 1px solid #DDD;">
								<table class="table table-bordered table-hover">
									<tr>
										<th style="background-color: #F0F0F0; width: 2em;" class="text-center"><span class="glyphicon glyphicon-pushpin"></span></th>
									<? list($num_cols, $num_rows) = $fl->dimension($debt->sl+1); ?>
									<? for ($i=0; $i<$num_cols; $i++) { ?>
											<th style="background-color: #F0F0F0;" class="cl<?=$i?> <?=(in_array($i, $debt->cl)?"none":"")?>"><?=chr($i+65)?></th>
									<? } ?>
									</tr>
									<?
										$tospace = array(PHP_EOL, "\r", "\n", "\t", "\0", "  ");
										$toempty = array("\'", "\"", "=");
										$rows = $fl->rows($debt->sl+1);
										for ($r=0; $r<sizeof($rows); $r++) {
									?>
										<tr id="rl<?=$r?>" class="rl <?=(in_array($r, $duplicated_left)?"warning":"")?>">
											<td class="text-center"><span class="glyphicon glyphicon-unchecked" style="color: #ddd;"></span></td>
										<?
											for ($i=0; $i<$num_cols; $i++) {
												$val = trim(str_replace($tospace, " ", $rows[$r][$i]));
												$val = str_replace($toempty, "", $val);
										?>
											<td class="cl<?=$i?> <?=(in_array($i, $debt->cl)?"none":"")?> <?=(in_array($r.",".$i, $missed_left)?"danger":"")?>"><?=$val?></td>
										<?
											}
										?>
										</tr>
									<?
										}
									?>
								</table>
							</div>
							<div style="margin-top: 10px;">
							<? 
								$s = 0;
								foreach ($fl->sheetNames() as $name) { ?>
								<a class="btn btn-sm <?=($debt->sl == $s)?"btn-primary":"btn-default"?> btn-sheet-left" sheet="<?=$s++?>"><?=$name?></a>
							<?
								}
							?>
							</div>
						</div>
						<div class="col-sm-1">
							<? for ($i=0; $i<$num_cols; $i++) { ?>
								<div><button type="button" class="btn btn-xs btn-col-left <?=(in_array($i, $debt->cl)?"btn-default":"btn-primary")?>" col="<?=$i?>" ref-col="cl<?=$i?>"><?=chr($i+65)?></button></div>
							<? } ?>
						</div>
						<? } ?>
					</div>
				</div>
				<div class="col-sm-6">
					<input type="file" class="file-right" name="file-right">
					<? if (!empty($debt->fr)) { ?>
					<p><span class="glyphicon glyphicon-paperclip"></span> <?=$debt->fr?></p>
					<? } ?>
					<div class="row clearfix" style="margin-top: 15px;">
						<? if (!empty($fr)) { ?>
						<div class="col-sm-11">
							<div class="col-view-right" style="width: 100%; height: 500px; overflow-y: scroll; display: block; border: 1px solid #DDD;">
								<table class="table table-bordered table-hover">
									<tr>
										<th style="background-color: #F0F0F0; width: 2em;" class="text-center"><span class="glyphicon glyphicon-pushpin"></span></th>
									<? list($num_cols, $num_rows) = $fr->dimension($debt->sr+1); ?>
									<? for ($i=0; $i<$num_cols; $i++) { ?>
											<th style="background-color: #F0F0F0;" class="cr<?=$i?> <?=(in_array($i, $debt->cr)?"none":"")?>"><?=chr($i+65)?></th>
									<? } ?>
									</tr>
									<?
										$tospace = array(PHP_EOL, "\r", "\n", "\t", "\0", "  ");
										$toempty = array("\'", "\"", "=");
										$rows = $fr->rows($debt->sr+1);
										for ($r=0; $r<sizeof($rows); $r++) {
									?>
										<tr id="rr<?=$r?>" class="rr <?=(in_array($r, $duplicated_right)?"warning":"")?>">
											<td class="text-center"><span class="glyphicon glyphicon-unchecked" style="color: #ddd;"></span></td>
										<?
											for ($i=0; $i<$num_cols; $i++) {
												$val = trim(str_replace($tospace, " ", $rows[$r][$i]));
												$val = str_replace($toempty, "", $val);
										?>
											<td class="cr<?=$i?> <?=(in_array($i, $debt->cr)?"none":"")?> <?=(in_array($r.",".$i, $missed_right)?"danger":"")?>"><?=$val?></td>
										<?
											}
										?>
										</tr>
									<?
										}
									?>
								</table>
							</div>
							<div style="margin-top: 10px;">
							<? 
								$s = 0;
								foreach ($fr->sheetNames() as $name) { ?>
								<a class="btn btn-sm <?=($debt->sr == $s)?"btn-primary":"btn-default"?> btn-sheet-right" sheet="<?=$s++?>"><?=$name?></a>
							<?
								}
							?>
							</div>
						</div>
						<div class="col-sm-1">
							<? for ($i=0; $i<$num_cols; $i++) { ?>
								<div><button type="button" class="btn btn-xs btn-col-right <?=(in_array($i, $debt->cr)?"btn-default":"btn-primary")?>" col="<?=$i?>" ref-col="cr<?=$i?>"><?=chr($i+65)?></button></div>
							<? } ?>
						</div>
						<? } ?>
					</div>
				</div>
			</div>
			<div class="navbar-fixed-bottom navbar-inverse clearfix" style="background-color: #F0F0F0; padding: 10px 15px;">
				<div class="row">
					<div class="col-sm-10">
						<span class="glyphicon glyphicon-stop" style="color: orange"></span> Duplicated
						<span class="glyphicon glyphicon-stop" style="color: red"></span> Missed
					</div>
					<div class="col-sm-2 text-right">
						<a class="btn btn-sm btn-danger" href="<?=site_url("syslog/debt-reset")?>"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
						<button type="button" class="btn btn-sm btn-success btn-compare"><span class="glyphicon glyphicon-play"></span> Compare</button>
					</div>
				</div>
			</div>
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="sheet" name="sheet" value="">
		</form>
	</div>
</div>

<script type="text/javascript">
	var lridx = -1;
	var rridx = -1;
	
	function findLRowIndex(val1) {
		$(".rl").each(function() {
			var row = $(this);
			var val2 = new Array();
			var found = true;
			row.children().each(function() {
				if ($(this).css('display') != 'none') {
					val2.push($(this).html().toUpperCase());
				}
			});
			for (var v=1; v < val1.length; v++) {
				if (val1[v] != val2[v]) {
					found = false;
				}
			}
			if (found) {
				lridx = row.attr("id");
				return lridx;
			}
		});
		return lridx;
	}
	
	function findRRowIndex(val1) {
		$(".rr").each(function() {
			var row = $(this);
			var val2 = new Array();
			var found = true;
			row.children().each(function() {
				if ($(this).css('display') != 'none') {
					val2.push($(this).html().toUpperCase());
				}
			});
			for (var v=1; v < val1.length; v++) {
				if (val1[v] != val2[v]) {
					found = false;
				}
			}
			if (found) {
				rridx = row.attr("id");
				return rridx;
			}
		});
		return rridx;
	}
	
	$(document).ready(function() {
	
		var docH = $(this).height();
		$(".col-view-left").height(docH - 290);
		$(".col-view-right").height(docH - 290);
	
		<? if ($this->session->flashdata('message')) { ?>
		messageBox("INFO", "Message", '<?=$this->session->flashdata('message')?>');
		<? } ?>
	
		$(".file-left").change(function() {
			$("#task").val("change-file-left");
			$("#frm").submit();
		});
	
		$(".file-right").change(function() {
			$("#task").val("change-file-right");
			$("#frm").submit();
		});
	
		$(".btn-compare").click(function() {
			$("#task").val("compare");
			$("#frm").submit();
			messageBox("INFO", "Comparison", '<p>Comparing your data... Please wait!</p><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>');
		});
		
		$(".btn-col-left").click(function() {
			var col_left = $(this);
			var col = col_left.attr("col");
			var is_hidden = col_left.hasClass("btn-primary");
			var ref_col = col_left.attr("ref-col");
			var p = {};
			p["col"] = col;
			p["hidden"] = is_hidden;
			$.ajax({
				type: "POST",
				url: "<?=site_url("syslog/debt-cl-selection-changed")?>",
				data: p,
				dataType: 'html',
				cache: false,
				success: function(result) {
					if (is_hidden) {
						col_left.removeClass("btn-primary");
						col_left.addClass("btn-default");
						$("."+ref_col).hide();
					} else {
						col_left.removeClass("btn-default");
						col_left.addClass("btn-primary");
						$("."+ref_col).show();
					}
				},
				async:false
			});
		});
	
		$(".btn-col-right").click(function() {
			var col_right = $(this);
			var col = col_right.attr("col");
			var is_hidden = col_right.hasClass("btn-primary");
			var ref_col = col_right.attr("ref-col");
			var p = {};
			p["col"] = col;
			p["hidden"] = is_hidden;
			$.ajax({
				type: "POST",
				url: "<?=site_url("syslog/debt-cr-selection-changed")?>",
				data: p,
				dataType: 'html',
				cache: false,
				success: function(result) {
					if (is_hidden) {
						col_right.removeClass("btn-primary");
						col_right.addClass("btn-default");
						$("."+ref_col).hide();
					} else {
						col_right.removeClass("btn-default");
						col_right.addClass("btn-primary");
						$("."+ref_col).show();
					}
				},
				async:false
			});
		});
	
		$(".btn-sheet-left").click(function() {
			var sheet = $(this).attr("sheet");
			$("#task").val("change-sheet-left");
			$("#sheet").val(sheet);
			$("#frm").submit();
		});
	
		$(".btn-sheet-right").click(function() {
			var sheet = $(this).attr("sheet");
			$("#task").val("change-sheet-right");
			$("#sheet").val(sheet);
			$("#frm").submit();
		});
	
		$(".rl").click(function() {
			if (!$(".c"+lridx).is(":checked")) {
				$("#"+lridx).removeClass("success");
			}
			if (!$(".c"+rridx).is(":checked")) {
				$("#"+rridx).removeClass("success");
			}
			
			$(this).addClass("success");
			
			lridx = $(this).attr("id");
			rridx = -1;
	
			var vals = new Array();
			$(this).children().each(function() {
				if ($(this).css('display') != 'none') {
					vals.push($(this).html().toUpperCase());
				}
			});
	
			findRRowIndex(vals);
			if (rridx != -1) {
				$("#"+rridx).addClass("success");
			}
		});
	
		$(".rr").click(function() {
			if (!$(".c"+lridx).is(":checked")) {
				$("#"+lridx).removeClass("success");
			}
			if (!$(".c"+rridx).is(":checked")) {
				$("#"+rridx).removeClass("success");
			}
			
			$(this).addClass("success");
	
			rridx = $(this).attr("id");
			lridx = -1;
	
			var vals = new Array();
			$(this).children().each(function() {
				if ($(this).css('display') != 'none') {
					vals.push($(this).html().toUpperCase());
				}
			});
	
			findLRowIndex(vals);
			if (lridx != -1) {
				$("#"+lridx).addClass("success");
			}
		});
	});
</script>