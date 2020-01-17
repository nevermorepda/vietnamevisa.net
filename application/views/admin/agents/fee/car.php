<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Car Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<ul class="nav nav-tabs tab-agent" role="tablist">
				<? foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($agents_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/agents-car-fees/{$agent->id}")?>">
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
					?>
					<div role="tabpanel" class="tab-pane <?=(!$i?"active":"")?>" id="<?=$port_categories[$i]->alias?>">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th rowspan="2">Types</th>
								<? foreach ($ports as $port) { ?>
								<th colspan="4" class="text-center"><?=$port->short_name?></th>
								<? } ?>
							</tr>
							<tr>
								<? foreach ($ports as $port) { ?>
								<th class="text-center" width="40">4 seats</th>
								<th class="text-center" width="40">7 seats</th>
								<th class="text-center" width="40">16 seats</th>
								<th class="text-center" width="40">24 seats</th>
								<? } ?>
							</tr>
							<tr>
								<td>Economic</td>
								<?
									$idx = 0;
									$check = 0;
									foreach ($ports as $port) {
										$info = new stdClass();
										$info->airport = $port->id;
										$info->agents_id = $agents_id;
										$fee = $this->m_agent_car_fee->items($info);
								?>
								<? if (!empty($fee)) { ?>
								<td>
									<input type="text" class="fee" value="<?=($fee[0]->seat_4?$fee[0]->seat_4:"")?>" car-type="seat_4" item-id = "<?=$fee[0]->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" value="<?=($fee[0]->seat_7?$fee[0]->seat_7:"")?>" car-type="seat_7" item-id = "<?=$fee[0]->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" value="<?=($fee[0]->seat_16?$fee[0]->seat_16:"")?>" car-type="seat_16" item-id = "<?=$fee[0]->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" value="<?=($fee[0]->seat_24?$fee[0]->seat_24:"")?>" car-type="seat_24" item-id = "<?=$fee[0]->id?>" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;">
								</td>
								<? } else { $check += 4; } ?>
								<?
										$idx++;
									}
								?>
								<? if (!empty($check)) { ?>
								<td colspan="<?=$check?>"><a style="color: red;" href="<?=site_url("syslog/agents-car-fees/{$agents_id}/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add fees</a></td>
								<? } ?>
							</tr>
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
		var visa_type = $(this).attr("car-type");
		var val = $(this).val();

		var p = {};
		p["item_id"] 	= item_id;
		p["visa_type"] 	= visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-car-fee")?>",
			data: p
		});
	});
});
</script>