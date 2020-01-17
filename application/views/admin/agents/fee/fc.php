<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Fast Check-in Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<ul class="nav nav-tabs tab-agent" role="tablist">
				<? foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($agents_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/agents-fast-checkin-fees/{$agent->id}")?>">
						<h5><?=$agent->name?></h5>
						<p>(<?=$agent->company?>)</p>
					</a>
				</li>
				<? } ?>
			</ul>
			<div class="tbl-visa-fee">
				<ul class="nav nav-tabs" role="tablist">
					<? for ($i=0; $i<sizeof($port_categories); $i++) { ?>
					<li role="presentation" class="<?=(!$i?"active":"")?>"><a href="<?="#".$port_categories[$i]->alias?>" aria-controls="<?=$port_categories[$i]->alias?>" role="tab" data-toggle="tab"><?=$port_categories[$i]->name?></a></li>
					<? } ?>
				</ul>
				<div class="tab-content">
					<? for ($i=0; $i<sizeof($port_categories); $i++) {
						$info = new stdClass();
						$info->category_id = $port_categories[$i]->id;
						$ports = $this->m_arrival_port->items($info);
						$info = new stdClass();
						$info->agents_id = $agents_id;
						$fc_fees = $this->m_agent_fast_checkin_fee->items($info);
					?>
					<div role="tabpanel" class="tab-pane <?=(!$i?"active":"")?>" id="<?=$port_categories[$i]->alias?>">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th rowspan="2">Types</th>
								<th colspan="<?=sizeof($ports)?>" class="text-center"><?=$port_categories[$i]->name?></th>
							</tr>
							<tr>
								<? foreach ($ports as $port) { ?>
								<th class="text-center" width="80"><?=$port->short_name?></th>
								<? } ?>
							</tr>
							<? if(!empty($fc_fees)) { ?>
							<tr>
								<td>Airport Fast Track</td>
								<?
									$idx = 0;
									foreach ($ports as $port) {
										foreach ($fc_fees as $fc_fee) {
											if ($fc_fee->airport == $port->id) {
												$fee = $fc_fee;
												break;
											}
										}
								?>
								<td>
									<input type="text" class="fee" value="<?=($fee->fc?$fee->fc:"")?>" fc-type="fc" item-id="<?=$fee->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none;"><br>
								</td>
								<?
										$idx++;
									}
								?>
							</tr>
							<tr>
								<td>Airport VIP Fast Track</td>
								<?
									$idx = 0;
									foreach ($ports as $port) {
										foreach ($fc_fees as $fc_fee) {
											if ($fc_fee->airport == $port->id) {
												$fee = $fc_fee;
												break;
											}
										}
								?>
								<td>
									<input type="text" class="fee" value="<?=($fee->vip_fc?$fee->vip_fc:"")?>" fc-type="vip_fc" item-id="<?=$fee->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none;"><br>
								</td>
								<?
										$idx++;
									}
								?>
							</tr>
							<? } else { ?>
							<tr>
								<td colspan="9"><a style="color: red;" href="<?=site_url("syslog/agents-fast-checkin-fees/{$agents_id}/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add fees</a></td>
							</tr>
							<? } ?>
						</table>
					</div>
					<? } ?>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".fee").click(function() {
		$(this).select();
	});
	
	$(".fee").blur(function() {
		var item_id = $(this).attr("item-id");
		var visa_type = $(this).attr("fc-type");
		var val = $(this).val();

		var p = {};
		p["item_id"] 	= item_id;
		p["visa_type"] 	= visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-fast-checkin-fees")?>",
			data: p
		});
	});
});
</script>