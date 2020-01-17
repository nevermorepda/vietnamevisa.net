<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Fast Check-in Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
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
					$fc_fees = $this->m_fast_checkin_fee->items();
					$fc_fee_instance = $this->m_fast_checkin_fee->instance();
				?>
				<div role="tabpanel" class="tab-pane <?=(!$i?"active":"")?>" id="<?=$port_categories[$i]->alias?>">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<th rowspan="2">Types</th>
							<th colspan="<?=sizeof($ports)?>" class="text-center">Airport</th>
						</tr>
						<tr>
							<? foreach ($ports as $port) { ?>
							<th class="text-center" width="80"><?=$port->short_name?></th>
							<? } ?>
						</tr>
						<tr>
							<td>Airport Fast Track</td>
							<?
								$idx = 0;
								foreach ($ports as $port) {
									$fee = $fc_fee_instance;
									foreach ($fc_fees as $fc_fee) {
										if ($fc_fee->airport == $port->id) {
											$fee = $fc_fee;
											break;
										}
									}
							?>
							<td>
								<input type="text" class="fee" value="<?=($fee->fc?$fee->fc:"")?>" fc-type="fc" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_fc?$fee->capital_fc:"")?>" fc-type="capital_fc" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none; margin-top: 2px;">
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
									$fee = $fc_fee_instance;
									foreach ($fc_fees as $fc_fee) {
										if ($fc_fee->airport == $port->id) {
											$fee = $fc_fee;
											break;
										}
									}
							?>
							<td>
								<input type="text" class="fee" value="<?=($fee->vip_fc?$fee->vip_fc:"")?>" fc-type="vip_fc" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_vip_fc?$fee->capital_vip_fc:"")?>" fc-type="capital_vip_fc" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 80px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<?
									$idx++;
								}
							?>
						</tr>
					</table>
				</div>
				<? } ?>
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
		var fc_type = $(this).attr("fc-type");
		var airport = $(this).attr("airport");
		var val = $(this).val();
		
		var p = {};
		p["fc_type"] = fc_type;
		p["airport"] = airport;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-fast-checkin-fee")?>",
			data: p
		});
	});
});
</script>