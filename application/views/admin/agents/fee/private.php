<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Private Letter Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<ul class="nav nav-tabs" role="tablist">
				<? $i=0; foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($i == 0) ? 'active' : ''?>"><a href="#<?=$agent->id?>" aria-controls="<?=$agent->id?>" role="tab" data-toggle="tab"><?=$agent->name?></a></li>
				<? $i++; } ?>
			</ul>
			<div class="tab-content">
				<? $i=0; foreach ($agents as $agent) { 
					$info = new stdClass();
					$info->agents_id = $agent->id;
					$fee = $this->m_agent_private_letter_fee->items($info);
				?>
				<div role="tabpanel" class="tab-pane <?=($i == 0) ? 'active' : ''?>" id="<?=$agent->id?>">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<th rowspan="2"></th>
							<th colspan="6">For Tourist</th>
							<th colspan="6">For Business</th>
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
						</tr>
						<? if (!empty($fee)) { ?>
						<tr>
							<td>Private letter</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_1ms?>" value="<?=($fee[0]->tourist_1ms?$fee[0]->tourist_1ms:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_1ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_1mm?>" value="<?=($fee[0]->tourist_1mm?$fee[0]->tourist_1mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_1mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_3ms?>" value="<?=($fee[0]->tourist_3ms?$fee[0]->tourist_3ms:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_3ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_3mm?>" value="<?=($fee[0]->tourist_3mm?$fee[0]->tourist_3mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_3mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_6mm?>" value="<?=($fee[0]->tourist_6mm?$fee[0]->tourist_6mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_6mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->tourist_1ym?>" value="<?=($fee[0]->tourist_1ym?$fee[0]->tourist_1ym:"")?>" item-id="<?=$fee[0]->id?>" visa-type="tourist_1ym" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_1ms?>" value="<?=($fee[0]->business_1ms?$fee[0]->business_1ms:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_1ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_1mm?>" value="<?=($fee[0]->business_1mm?$fee[0]->business_1mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_1mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_3ms?>" value="<?=($fee[0]->business_3ms?$fee[0]->business_3ms:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_3ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_3mm?>" value="<?=($fee[0]->business_3mm?$fee[0]->business_3mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_3mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_6mm?>" value="<?=($fee[0]->business_6mm?$fee[0]->business_6mm:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_6mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
							<td>
								<input type="text" class="fee" name="<?=$fee[0]->business_1ym?>" value="<?=($fee[0]->business_1ym?$fee[0]->business_1ym:"")?>" item-id="<?=$fee[0]->id?>" visa-type="business_1ym" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
							</td>
						</tr>
						<? } else { ?>
						<tr>
							<td colspan="13">
								<a style="color: red;" href="<?=site_url("syslog/agents-private-letter-fees/{$agent->id}")?>"><i class="fa fa-plus" aria-hidden="true"></i> Add fees</a>
							</td>
						</tr>
						<? } ?>
					</table>
				</div>
				<? $i++; } ?>
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
		var visa_type = $(this).attr("visa-type");
		var val = $(this).val();

		var p = {};
		p["item_id"] 	= item_id;
		p["visa_type"] 	= visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-private-letter-fees")?>",
			data: p
		});
	});
});
</script>