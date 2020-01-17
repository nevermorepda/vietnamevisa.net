<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Car Fees
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
								foreach ($ports as $port) {
									$info = new stdClass();
									$info->airport = $port->id;
									$fees = $this->m_car_fee->items($info);
									if (!empty($fees)) {
										$fee = array_shift($fees);
									} else {
										$fee = $this->m_car_fee->instance();
									}
							?>
							<td>
								<input type="text" class="fee" value="<?=($fee->seat_4?$fee->seat_4:"")?>" car-type="seat_4" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_seat_4?$fee->capital_seat_4:"")?>" car-type="capital_seat_4" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee" value="<?=($fee->seat_7?$fee->seat_7:"")?>" car-type="seat_7" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_seat_7?$fee->capital_seat_7:"")?>" car-type="capital_seat_7" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee" value="<?=($fee->seat_16?$fee->seat_16:"")?>" car-type="seat_16" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_seat_16?$fee->capital_seat_16:"")?>" car-type="capital_seat_16" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee" value="<?=($fee->seat_24?$fee->seat_24:"")?>" car-type="seat_24" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none;"><br>
								<input type="text" class="fee" value="<?=($fee->capital_seat_24?$fee->capital_seat_24:"")?>" car-type="capital_seat_24" airport="<?=$port->id?>" style="background-color: <?=(!($idx%2)?"#F0F0F0":"#D9EDF7")?>; width: 40px; text-align: right; border: none; margin-top: 2px;">
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
		var car_type = $(this).attr("car-type");
		var airport = $(this).attr("airport");
		var val = $(this).val();
		
		var p = {};
		p["car_type"] = car_type;
		p["airport"] = airport;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-car-fee")?>",
			data: p
		});
	});
});
</script>