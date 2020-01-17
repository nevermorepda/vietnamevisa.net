<?
	$nation_types = $this->m_nation_type->items();
?>
<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Processing Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<ul class="nav nav-tabs tab-agent" role="tablist">
				<? foreach ($agents as $agent) { ?>
				<li role="presentation" class="<?=($agents_id == $agent->id) ? 'active' : ''?>">
					<a href="<?=site_url("syslog/agents-processing-fees/{$agent->id}")?>">
						<h5><?=$agent->name?></h5>
						<p>(<?=$agent->company?>)</p>
					</a>
				</li>
				<? } ?>
			</ul>
			<div class="tbl-visa-fee">
				<ul class="nav nav-tabs" role="tablist">
					<? $i=0; foreach ($nation_types as $nation_type) { ?>
					<li role="presentation" class="<?=($i==0)?'active':''?>"><a href="#<?=$nation_type->id?>" aria-controls="<?=$nation_type->id?>" role="tab" data-toggle="tab"><?=$nation_type->name?></a></li>
					<? $i++;} ?>
				</ul>
				<div class="tab-content">
					<? $i=0; foreach ($nation_types as $nation_type) { 
						$fee = $this->m_agent_processing_fee->item($agents_id,$nation_type->id);
					?>
					<div role="tabpanel" class="tab-pane <?=($i==0)?'active':''?>" id="<?=$nation_type->id?>">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th rowspan="3">Visa Types</th>
								<th class="text-center" colspan="10">Visa on Ariival</th>
								<th class="text-center" colspan="10">E-Visa</th>
							</tr>
							<tr>
								<th class="text-center" colspan="5">For Tourist</th>
								<th class="text-center" colspan="5">For Business</th>
								<th class="text-center" colspan="5">For Tourist</th>
								<th class="text-center" colspan="5">For Business</th>
							</tr>
							<tr>
								<th class="text-center" width="50">URG8h</th>
								<th class="text-center" width="50">URG4h</th>
								<th class="text-center" width="50">URG1h</th>
								<th class="text-center" width="50">DNG</th>
								<th class="text-center" width="50">BLSB</th>
								<th class="text-center" width="50">URG8h</th>
								<th class="text-center" width="50">URG4h</th>
								<th class="text-center" width="50">URG1h</th>
								<th class="text-center" width="50">DNG</th>
								<th class="text-center" width="50">BLSB</th>
								<th class="text-center" width="50">URG8h</th>
								<th class="text-center" width="50">URG4h</th>
								<th class="text-center" width="50">URG1h</th>
								<th class="text-center" width="50">DNG</th>
								<th class="text-center" width="50">BLSB</th>
								<th class="text-center" width="50">URG8h</th>
								<th class="text-center" width="50">URG4h</th>
								<th class="text-center" width="50">URG1h</th>
								<th class="text-center" width="50">DNG</th>
								<th class="text-center" width="50">BLSB</th>
							</tr>
							<? if(!empty($fee)) { ?>
							<tr>
								<td>1 month single</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ms_8h?$fee->tourist_1ms_8h:"")?>" visa-type="tourist_1ms_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ms_4h?$fee->tourist_1ms_4h:"")?>" visa-type="tourist_1ms_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ms_1h?$fee->tourist_1ms_1h:"")?>" visa-type="tourist_1ms_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ms_dng?$fee->tourist_1ms_dng:"")?>" visa-type="tourist_1ms_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ms_blsb?$fee->tourist_1ms_blsb:"")?>" visa-type="tourist_1ms_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ms_8h?$fee->business_1ms_8h:"")?>" visa-type="business_1ms_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ms_4h?$fee->business_1ms_4h:"")?>" visa-type="business_1ms_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ms_1h?$fee->business_1ms_1h:"")?>" visa-type="business_1ms_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ms_dng?$fee->business_1ms_dng:"")?>" visa-type="business_1ms_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ms_blsb?$fee->business_1ms_blsb:"")?>" visa-type="business_1ms_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_tourist_1ms_8h?$fee->evisa_tourist_1ms_8h:"")?>" visa-type="evisa_tourist_1ms_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_tourist_1ms_4h?$fee->evisa_tourist_1ms_4h:"")?>" visa-type="evisa_tourist_1ms_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_tourist_1ms_1h?$fee->evisa_tourist_1ms_1h:"")?>" visa-type="evisa_tourist_1ms_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_tourist_1ms_dng?$fee->evisa_tourist_1ms_dng:"")?>" visa-type="evisa_tourist_1ms_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_tourist_1ms_blsb?$fee->evisa_tourist_1ms_blsb:"")?>" visa-type="evisa_tourist_1ms_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_business_1ms_8h?$fee->evisa_business_1ms_8h:"")?>" visa-type="evisa_business_1ms_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_business_1ms_4h?$fee->evisa_business_1ms_4h:"")?>" visa-type="evisa_business_1ms_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_business_1ms_1h?$fee->evisa_business_1ms_1h:"")?>" visa-type="evisa_business_1ms_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_business_1ms_dng?$fee->evisa_business_1ms_dng:"")?>" visa-type="evisa_business_1ms_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->evisa_business_1ms_blsb?$fee->evisa_business_1ms_blsb:"")?>" visa-type="evisa_business_1ms_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<tr>
								<td>1 month multiple</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1mm_8h?$fee->tourist_1mm_8h:"")?>" visa-type="tourist_1mm_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1mm_4h?$fee->tourist_1mm_4h:"")?>" visa-type="tourist_1mm_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1mm_1h?$fee->tourist_1mm_1h:"")?>" visa-type="tourist_1mm_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1mm_dng?$fee->tourist_1mm_dng:"")?>" visa-type="tourist_1mm_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1mm_blsb?$fee->tourist_1mm_blsb:"")?>" visa-type="tourist_1mm_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1mm_8h?$fee->business_1mm_8h:"")?>" visa-type="business_1mm_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1mm_4h?$fee->business_1mm_4h:"")?>" visa-type="business_1mm_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1mm_1h?$fee->business_1mm_1h:"")?>" visa-type="business_1mm_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1mm_dng?$fee->business_1mm_dng:"")?>" visa-type="business_1mm_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1mm_blsb?$fee->business_1mm_blsb:"")?>" visa-type="business_1mm_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<tr>
								<td>3 months single</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3ms_8h?$fee->tourist_3ms_8h:"")?>" visa-type="tourist_3ms_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3ms_4h?$fee->tourist_3ms_4h:"")?>" visa-type="tourist_3ms_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3ms_1h?$fee->tourist_3ms_1h:"")?>" visa-type="tourist_3ms_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3ms_dng?$fee->tourist_3ms_dng:"")?>" visa-type="tourist_3ms_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3ms_blsb?$fee->tourist_3ms_blsb:"")?>" visa-type="tourist_3ms_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3ms_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3ms_8h?$fee->business_3ms_8h:"")?>" visa-type="business_3ms_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3ms_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3ms_4h?$fee->business_3ms_4h:"")?>" visa-type="business_3ms_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3ms_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3ms_1h?$fee->business_3ms_1h:"")?>" visa-type="business_3ms_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3ms_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3ms_dng?$fee->business_3ms_dng:"")?>" visa-type="business_3ms_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3ms_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3ms_blsb?$fee->business_3ms_blsb:"")?>" visa-type="business_3ms_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<tr>
								<td>3 months multiple</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3mm_8h?$fee->tourist_3mm_8h:"")?>" visa-type="tourist_3mm_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3mm_4h?$fee->tourist_3mm_4h:"")?>" visa-type="tourist_3mm_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3mm_1h?$fee->tourist_3mm_1h:"")?>" visa-type="tourist_3mm_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3mm_dng?$fee->tourist_3mm_dng:"")?>" visa-type="tourist_3mm_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_3mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_3mm_blsb?$fee->tourist_3mm_blsb:"")?>" visa-type="tourist_3mm_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3mm_8h?$fee->business_3mm_8h:"")?>" visa-type="business_3mm_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3mm_4h?$fee->business_3mm_4h:"")?>" visa-type="business_3mm_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3mm_1h?$fee->business_3mm_1h:"")?>" visa-type="business_3mm_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3mm_dng?$fee->business_3mm_dng:"")?>" visa-type="business_3mm_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_3mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_3mm_blsb?$fee->business_3mm_blsb:"")?>" visa-type="business_3mm_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<tr>
								<td>6 months multiple</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_6mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_6mm_8h?$fee->tourist_6mm_8h:"")?>" visa-type="tourist_6mm_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_6mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_6mm_4h?$fee->tourist_6mm_4h:"")?>" visa-type="tourist_6mm_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_6mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_6mm_1h?$fee->tourist_6mm_1h:"")?>" visa-type="tourist_6mm_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_6mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_6mm_dng?$fee->tourist_6mm_dng:"")?>" visa-type="tourist_6mm_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_6mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_6mm_blsb?$fee->tourist_6mm_blsb:"")?>" visa-type="tourist_6mm_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_6mm_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_6mm_8h?$fee->business_6mm_8h:"")?>" visa-type="business_6mm_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_6mm_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_6mm_4h?$fee->business_6mm_4h:"")?>" visa-type="business_6mm_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_6mm_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_6mm_1h?$fee->business_6mm_1h:"")?>" visa-type="business_6mm_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_6mm_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_6mm_dng?$fee->business_6mm_dng:"")?>" visa-type="business_6mm_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_6mm_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_6mm_blsb?$fee->business_6mm_blsb:"")?>" visa-type="business_6mm_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<tr>
								<td>1 year multiple</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ym_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ym_8h?$fee->tourist_1ym_8h:"")?>" visa-type="tourist_1ym_8h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ym_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ym_4h?$fee->tourist_1ym_4h:"")?>" visa-type="tourist_1ym_4h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ym_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ym_1h?$fee->tourist_1ym_1h:"")?>" visa-type="tourist_1ym_1h" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ym_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ym_dng?$fee->tourist_1ym_dng:"")?>" visa-type="tourist_1ym_dng" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->tourist_1ym_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->tourist_1ym_blsb?$fee->tourist_1ym_blsb:"")?>" visa-type="tourist_1ym_blsb" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ym_8h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ym_8h?$fee->business_1ym_8h:"")?>" visa-type="business_1ym_8h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ym_4h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ym_4h?$fee->business_1ym_4h:"")?>" visa-type="business_1ym_4h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ym_1h?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ym_1h?$fee->business_1ym_1h:"")?>" visa-type="business_1ym_1h" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ym_dng?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ym_dng?$fee->business_1ym_dng:"")?>" visa-type="business_1ym_dng" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
								<td>
									<input type="text" class="fee" name="<?=$fee->business_1ym_blsb?>" item-id="<?=$fee->id?>" value="<?=($fee->business_1ym_blsb?$fee->business_1ym_blsb:"")?>" visa-type="business_1ym_blsb" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;">
								</td>
							</tr>
							<? } else { ?>
							<tr>
								<td colspan="13">
									<a style="color:red" href="<?=site_url("syslog/agents-processing-fees/{$agents_id}/$nation_type->id/add")?>">Add fees</a>
								</td>
							</tr>
							<? } ?>
						</table>
					</div>
					<? $i++;} ?>
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
		var visa_type = $(this).attr("visa-type");
		var val = $(this).val();

		var p = {};
		p["item_id"] 	= item_id;
		p["visa_type"] 	= visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-agents-processing-fee")?>",
			data: p
		});
	});
});
</script>