<?
	$regions = array("Asia", "Australasia", "Europe", "North America", "South America", "Middle East", "Caribbean", "Africa");
?>
<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Vietnam Visa Fees
			</h1>
		</div>
		<? if (empty($nations) || !sizeof($nations)) { ?>
		<p class="help-block">No user found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<ul class="nav nav-tabs tab-agent" role="tablist">
				<? foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($agents_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/agents-visa-fees/{$agent->id}")?>">
						<h5><?=$agent->name?></h5>
						<p>(<?=$agent->company?>)</p>
					</a>
				</li>
				<? } ?>
			</ul>
			<div class="tbl-visa-fee">
				<ul class="nav nav-tabs" role="tablist">
					<? for ($r=0; $r<sizeof($regions); $r++) { ?>
					<li role="presentation" class="<?=(!$r?"active":"")?>"><a href="<?="#".$this->util->slug($regions[$r])?>" aria-controls="<?=$this->util->slug($regions[$r])?>" role="tab" data-toggle="tab"><?=$regions[$r]?></a></li>
					<? } ?>
				</ul>
				<? if(!empty($items)) { ?>
				<div class="tab-content">
					<? for ($r=0; $r<sizeof($regions); $r++) { ?>
					<div role="tabpanel" class="tab-pane <?=(!$r?"active":"")?>" id="<?=$this->util->slug($regions[$r])?>">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th colspan="2"></th>
								<th colspan="12" class="text-center">Visa on Arrival</th>
								<th colspan="2" class="text-center">E-Visa</th>
							</tr>
							<tr>
								<th rowspan="2" class="text-center" width="30px">#</th>
								<th rowspan="2" >Nationality</th>
								<th colspan="6">For Tourist</th>
								<th colspan="6">For Business</th>
								<th>For Tourist</th>
								<th>For Business</th>
							</tr>
							<tr>
								<th class="text-center" width="50">1MS</th>
								<th class="text-center" width="50">1MM</th>
								<th class="text-center" width="50">3MS</th>
								<th class="text-center" width="50">3MM</th>
								<th class="text-center" width="50">6MM</th>
								<th class="text-center" width="50">1YM</th>
								<th class="text-center" width="50">1MS</th>
								<th class="text-center" width="50">1MM</th>
								<th class="text-center" width="50">3MS</th>
								<th class="text-center" width="50">3MM</th>
								<th class="text-center" width="50">6MM</th>
								<th class="text-center" width="50">1YM</th>
								<th class="text-center" width="50">1MS</th>
								<th class="text-center" width="50">1MS</th>
							</tr>
							<?
								$i = 0;
								foreach ($nations as $nation) {
									if ($nation->region != $regions[$r]) {
										continue;
									}
									foreach ($items as $item) {
										if ($item->nation_id == $nation->id) {
											$fee = $item;
											break;
										}
									}
							?>
							<tr>
								<td class="text-center"><?=($i+1)?></td>
								<td><?=$nation->name?></td>
								<td>
									<input type="text" class="fee tourist_1ms" name="<?=$fee->tourist_1ms?>" value="<?=($fee->tourist_1ms?$fee->tourist_1ms:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee tourist_1mm" name="<?=$fee->tourist_1mm?>" value="<?=($fee->tourist_1mm?$fee->tourist_1mm:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_1mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee tourist_3ms" name="<?=$fee->tourist_3ms?>" value="<?=($fee->tourist_3ms?$fee->tourist_3ms:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_3ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee tourist_3mm" name="<?=$fee->tourist_3mm?>" value="<?=($fee->tourist_3mm?$fee->tourist_3mm:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_3mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee tourist_6mm" name="<?=$fee->tourist_6mm?>" value="<?=($fee->tourist_6mm?$fee->tourist_6mm:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_6mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee tourist_1ym" name="<?=$fee->tourist_1ym?>" value="<?=($fee->tourist_1ym?$fee->tourist_1ym:"")?>" item-id="<?=$fee->id?>" visa-type="tourist_1ym" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_1ms" name="<?=$fee->business_1ms?>" value="<?=($fee->business_1ms?$fee->business_1ms:"")?>" item-id="<?=$fee->id?>" visa-type="business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_1mm" name="<?=$fee->business_1mm?>" value="<?=($fee->business_1mm?$fee->business_1mm:"")?>" item-id="<?=$fee->id?>" visa-type="business_1mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_3ms" name="<?=$fee->business_3ms?>" value="<?=($fee->business_3ms?$fee->business_3ms:"")?>" item-id="<?=$fee->id?>" visa-type="business_3ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_3mm" name="<?=$fee->business_3mm?>" value="<?=($fee->business_3mm?$fee->business_3mm:"")?>" item-id="<?=$fee->id?>" visa-type="business_3mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_6mm" name="<?=$fee->business_6mm?>" value="<?=($fee->business_6mm?$fee->business_6mm:"")?>" item-id="<?=$fee->id?>" visa-type="business_6mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee business_1ym" name="<?=$fee->business_1ym?>" value="<?=($fee->business_1ym?$fee->business_1ym:"")?>" item-id="<?=$fee->id?>" visa-type="business_1ym" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee evisa_tourist_1ms" name="<?=$fee->evisa_tourist_1ms?>" value="<?=($fee->evisa_tourist_1ms?$fee->evisa_tourist_1ms:"")?>" item-id="<?=$fee->id?>" visa-type="evisa_tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee evisa_business_1ms" name="<?=$fee->evisa_business_1ms?>" value="<?=($fee->evisa_business_1ms?$fee->evisa_business_1ms:"")?>" item-id="<?=$fee->id?>" visa-type="evisa_business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<?
									$i++;
								}
							?>
						</table>
					</div>
					<? } ?>
				</div>
				<? } else { ?>
				<div><a style="color: red;" href="<?=site_url("syslog/agents-visa-fees/{$agents_id}/add")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add fees</a></div>
				<? } ?>
			</div>
		</form>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".fee").click(function() {
		$(this).select();
	});
	
	$(".fee").blur(function() {
		var item_id = $(this).attr("item-id");
		var visa_type = $(this).attr("visa-type");
		var val = $(this).val();

		var p = {};
		p["item_id"] 	= item_id;
		p["visa_type"] 	= visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-visa-fee")?>",
			data: p
		});
	});
});
</script>