<?
	$regions = array("Default", "Asia", "Australasia", "Europe", "North America", "South America", "Middle East", "Caribbean", "Africa");
	
	$nation = new stdClass();
	$nation->region = "Default";
	$nation->name = "Default";
	$nation->id = 0;
	
	$nations[] = $nation;
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
			<ul class="nav nav-tabs" role="tablist">
				<? for ($r=0; $r<sizeof($regions); $r++) { ?>
				<li role="presentation" class="<?=(!$r?"active":"")?>"><a href="<?="#".$this->util->slug($regions[$r])?>" aria-controls="<?=$this->util->slug($regions[$r])?>" role="tab" data-toggle="tab"><?=$regions[$r]?></a></li>
				<? } ?>
			</ul>
			<div class="tab-content">
				<? for ($r=0; $r<sizeof($regions); $r++) { ?>
				<div role="tabpanel" class="tab-pane <?=(!$r?"active":"")?>" id="<?=$this->util->slug($regions[$r])?>">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<th colspan="<?=($r) ? 4 : 3 ?>"></th>
							<th colspan="12" class="text-center">Visa on Arrival</th>
							<th colspan="2" class="text-center">E-Visa</th>
						</tr>
						<tr>
							<th rowspan="2" class="text-center" width="30px">#</th>
							<th rowspan="2" >Nationality <? if ($r) { ?><div class="pull-right">Document Required?</div><? } ?></th>
							<? if ($r) { ?><th rowspan="2" class="text-center" width="100px"><div class="pull-right">Fee Default</div></th><? } ?>
							<th rowspan="2" class="text-center" width="100px">Group Discount</th>
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
								if (empty($fee)) {
									$fee = $default;
								}
						?>
						<tr>
							<td class="text-center"><?=($i+1)?></td>
							<td><?=$nation->name?> <? if ($r) { ?><div class="pull-right"><label class="switch"><input type="checkbox" class="change-option" name="<?=$fee->document_required?>" visa-type="document_required" nation-id="<?=$nation->id?>" <?=($fee->document_required?"checked":"")?>><div class="sw-slider round"></div></label></div><? } ?></td>
							<? if ($r) { ?><td><div class="pull-right"><label class="switch"><input type="checkbox" class="change-option" name="<?=$fee->get_fee_default?>" visa-type="get_fee_default" nation-id="<?=$nation->id?>" <?=($fee->get_fee_default?"checked":"")?>><div class="sw-slider round"></div></label></div></td><? } ?>
							<td class="text-center" ><div class=""><label class="switch"><input type="checkbox" class="change-option" name="<?=$fee->group_discount?>" visa-type="group_discount" nation-id="<?=$nation->id?>" <?=($fee->group_discount?"checked":"")?>><div class="sw-slider round"></div></label></div></td>
							<td>
								<input type="text" class="fee tourist_1ms" name="<?=$fee->tourist_1ms?>" value="<?=($fee->tourist_1ms?$fee->tourist_1ms:"")?>" visa-type="tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_1ms" name="<?=$fee->capital_tourist_1ms?>" value="<?=($fee->capital_tourist_1ms?$fee->capital_tourist_1ms:"")?>" visa-type="capital_tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee tourist_1mm" name="<?=$fee->tourist_1mm?>" value="<?=($fee->tourist_1mm?$fee->tourist_1mm:"")?>" visa-type="tourist_1mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_1mm" name="<?=$fee->capital_tourist_1mm?>" value="<?=($fee->capital_tourist_1mm?$fee->capital_tourist_1mm:"")?>" visa-type="capital_tourist_1mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee tourist_3ms" name="<?=$fee->tourist_3ms?>" value="<?=($fee->tourist_3ms?$fee->tourist_3ms:"")?>" visa-type="tourist_3ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_3ms" name="<?=$fee->capital_tourist_3ms?>" value="<?=($fee->capital_tourist_3ms?$fee->capital_tourist_3ms:"")?>" visa-type="capital_tourist_3ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee tourist_3mm" name="<?=$fee->tourist_3mm?>" value="<?=($fee->tourist_3mm?$fee->tourist_3mm:"")?>" visa-type="tourist_3mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_3mm" name="<?=$fee->capital_tourist_3mm?>" value="<?=($fee->capital_tourist_3mm?$fee->capital_tourist_3mm:"")?>" visa-type="capital_tourist_3mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee tourist_6mm" name="<?=$fee->tourist_6mm?>" value="<?=($fee->tourist_6mm?$fee->tourist_6mm:"")?>" visa-type="tourist_6mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_6mm" name="<?=$fee->capital_tourist_6mm?>" value="<?=($fee->capital_tourist_6mm?$fee->capital_tourist_6mm:"")?>" visa-type="capital_tourist_6mm" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee tourist_1ym" name="<?=$fee->tourist_1ym?>" value="<?=($fee->tourist_1ym?$fee->tourist_1ym:"")?>" visa-type="tourist_1ym" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_tourist_1ym" name="<?=$fee->capital_tourist_1ym?>" value="<?=($fee->capital_tourist_1ym?$fee->capital_tourist_1ym:"")?>" visa-type="capital_tourist_1ym" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_1ms" name="<?=$fee->business_1ms?>" value="<?=($fee->business_1ms?$fee->business_1ms:"")?>" visa-type="business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_1ms" name="<?=$fee->capital_business_1ms?>" value="<?=($fee->capital_business_1ms?$fee->capital_business_1ms:"")?>" visa-type="capital_business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_1mm" name="<?=$fee->business_1mm?>" value="<?=($fee->business_1mm?$fee->business_1mm:"")?>" visa-type="business_1mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_1mm" name="<?=$fee->capital_business_1mm?>" value="<?=($fee->capital_business_1mm?$fee->capital_business_1mm:"")?>" visa-type="capital_business_1mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_3ms" name="<?=$fee->business_3ms?>" value="<?=($fee->business_3ms?$fee->business_3ms:"")?>" visa-type="business_3ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_3ms" name="<?=$fee->capital_business_3ms?>" value="<?=($fee->capital_business_3ms?$fee->capital_business_3ms:"")?>" visa-type="capital_business_3ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_3mm" name="<?=$fee->business_3mm?>" value="<?=($fee->business_3mm?$fee->business_3mm:"")?>" visa-type="business_3mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_3mm" name="<?=$fee->capital_business_3mm?>" value="<?=($fee->capital_business_3mm?$fee->capital_business_3mm:"")?>" visa-type="capital_business_3mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_6mm" name="<?=$fee->business_6mm?>" value="<?=($fee->business_6mm?$fee->business_6mm:"")?>" visa-type="business_6mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_6mm" name="<?=$fee->capital_business_6mm?>" value="<?=($fee->capital_business_6mm?$fee->capital_business_6mm:"")?>" visa-type="capital_business_6mm" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee business_1ym" name="<?=$fee->business_1ym?>" value="<?=($fee->business_1ym?$fee->business_1ym:"")?>" visa-type="business_1ym" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_business_1ym" name="<?=$fee->capital_business_1ym?>" value="<?=($fee->capital_business_1ym?$fee->capital_business_1ym:"")?>" visa-type="capital_business_1ym" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee evisa_tourist_1ms" name="<?=$fee->evisa_tourist_1ms?>" value="<?=($fee->evisa_tourist_1ms?$fee->evisa_tourist_1ms:"")?>" visa-type="evisa_tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_evisa_tourist_1ms" name="<?=$fee->capital_evisa_tourist_1ms?>" value="<?=($fee->capital_evisa_tourist_1ms?$fee->capital_evisa_tourist_1ms:"")?>" visa-type="capital_evisa_tourist_1ms" nation-id="<?=$nation->id?>" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
							</td>
							<td>
								<input type="text" class="fee evisa_business_1ms" name="<?=$fee->evisa_business_1ms?>" value="<?=($fee->evisa_business_1ms?$fee->evisa_business_1ms:"")?>" visa-type="evisa_business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
								<input type="text" class="fee capital_evisa_business_1ms" name="<?=$fee->capital_evisa_business_1ms?>" value="<?=($fee->capital_evisa_business_1ms?$fee->capital_evisa_business_1ms:"")?>" visa-type="capital_evisa_business_1ms" nation-id="<?=$nation->id?>" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
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
		var nation_id = $(this).attr("nation-id");
		var visa_type = $(this).attr("visa-type");
		var val = $(this).val();
		
		var p = {};
		p["nation_id"] = nation_id;
		p["visa_type"] = visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-fee")?>",
			data: p
		});
	});

	$(".change-option").change(function() {
		var nation_id = $(this).attr("nation-id");
		var visa_type = $(this).attr("visa-type");
		var val = ($(this).is(':checked')?1:0);
		
		var p = {};
		p["nation_id"] = nation_id;
		p["visa_type"] = visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-visa-fee")?>",
			data: p
		});
	});
});
</script>