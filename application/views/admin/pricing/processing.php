<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Processing Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<table class="table table-bordered table-striped table-hover">
				<tr>
					<th rowspan="3">Visa Types</th>
					<th class="text-center" colspan="6">Visa on Ariival</th>
					<th class="text-center" colspan="6">E-Visa</th>
				</tr>
				<tr>
					<th colspan="3">For Tourist</th>
					<th colspan="3">For Business</th>
					<th colspan="3">For Tourist</th>
					<th colspan="3">For Business</th>
				</tr>
				<tr>
					<th class="text-center" width="50">Urgent</th>
					<th class="text-center" width="50">Emergency</th>
					<th class="text-center" width="50">Holiday</th>
					<th class="text-center" width="50">Urgent</th>
					<th class="text-center" width="50">Emergency</th>
					<th class="text-center" width="50">Holiday</th>
					<th class="text-center" width="50">Urgent</th>
					<th class="text-center" width="50">Emergency</th>
					<th class="text-center" width="50">Holiday</th>
					<th class="text-center" width="50">Urgent</th>
					<th class="text-center" width="50">Emergency</th>
					<th class="text-center" width="50">Holiday</th>
				</tr>
				<tr>
					<td>1 month single</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ms_urgent?>" value="<?=($fee->tourist_1ms_urgent?$fee->tourist_1ms_urgent:"")?>" visa-type="tourist_1ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ms_urgent?>" value="<?=($fee->capital_tourist_1ms_urgent?$fee->capital_tourist_1ms_urgent:"")?>" visa-type="capital_tourist_1ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ms_emergency?>" value="<?=($fee->tourist_1ms_emergency?$fee->tourist_1ms_emergency:"")?>" visa-type="tourist_1ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ms_emergency?>" value="<?=($fee->capital_tourist_1ms_emergency?$fee->capital_tourist_1ms_emergency:"")?>" visa-type="capital_tourist_1ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ms_holiday?>" value="<?=($fee->tourist_1ms_holiday?$fee->tourist_1ms_holiday:"")?>" visa-type="tourist_1ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ms_holiday?>" value="<?=($fee->capital_tourist_1ms_holiday?$fee->capital_tourist_1ms_holiday:"")?>" visa-type="capital_tourist_1ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ms_urgent?>" value="<?=($fee->business_1ms_urgent?$fee->business_1ms_urgent:"")?>" visa-type="business_1ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ms_urgent?>" value="<?=($fee->capital_business_1ms_urgent?$fee->capital_business_1ms_urgent:"")?>" visa-type="capital_business_1ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ms_emergency?>" value="<?=($fee->business_1ms_emergency?$fee->business_1ms_emergency:"")?>" visa-type="business_1ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ms_emergency?>" value="<?=($fee->capital_business_1ms_emergency?$fee->capital_business_1ms_emergency:"")?>" visa-type="capital_business_1ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ms_holiday?>" value="<?=($fee->business_1ms_holiday?$fee->business_1ms_holiday:"")?>" visa-type="business_1ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ms_holiday?>" value="<?=($fee->capital_business_1ms_holiday?$fee->capital_business_1ms_holiday:"")?>" visa-type="capital_business_1ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_urgent?>" value="<?=($fee->evisa_tourist_1ms_urgent?$fee->evisa_tourist_1ms_urgent:"")?>" visa-type="evisa_tourist_1ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_tourist_1ms_urgent?>" value="<?=($fee->capital_evisa_tourist_1ms_urgent?$fee->capital_evisa_tourist_1ms_urgent:"")?>" visa-type="capital_evisa_tourist_1ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_emergency?>" value="<?=($fee->evisa_tourist_1ms_emergency?$fee->evisa_tourist_1ms_emergency:"")?>" visa-type="evisa_tourist_1ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_tourist_1ms_emergency?>" value="<?=($fee->capital_evisa_tourist_1ms_emergency?$fee->capital_evisa_tourist_1ms_emergency:"")?>" visa-type="capital_evisa_tourist_1ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_tourist_1ms_holiday?>" value="<?=($fee->evisa_tourist_1ms_holiday?$fee->evisa_tourist_1ms_holiday:"")?>" visa-type="evisa_tourist_1ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_tourist_1ms_holiday?>" value="<?=($fee->capital_evisa_tourist_1ms_holiday?$fee->capital_evisa_tourist_1ms_holiday:"")?>" visa-type="capital_evisa_tourist_1ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_urgent?>" value="<?=($fee->evisa_business_1ms_urgent?$fee->evisa_business_1ms_urgent:"")?>" visa-type="evisa_business_1ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_business_1ms_urgent?>" value="<?=($fee->capital_evisa_business_1ms_urgent?$fee->capital_evisa_business_1ms_urgent:"")?>" visa-type="capital_evisa_business_1ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_emergency?>" value="<?=($fee->evisa_business_1ms_emergency?$fee->evisa_business_1ms_emergency:"")?>" visa-type="evisa_business_1ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_business_1ms_emergency?>" value="<?=($fee->capital_evisa_business_1ms_emergency?$fee->capital_evisa_business_1ms_emergency:"")?>" visa-type="capital_evisa_business_1ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->evisa_business_1ms_holiday?>" value="<?=($fee->evisa_business_1ms_holiday?$fee->evisa_business_1ms_holiday:"")?>" visa-type="evisa_business_1ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_evisa_business_1ms_holiday?>" value="<?=($fee->capital_evisa_business_1ms_holiday?$fee->capital_evisa_business_1ms_holiday:"")?>" visa-type="capital_evisa_business_1ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
				<tr>
					<td>1 month multiple</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1mm_urgent?>" value="<?=($fee->tourist_1mm_urgent?$fee->tourist_1mm_urgent:"")?>" visa-type="tourist_1mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1mm_urgent?>" value="<?=($fee->capital_tourist_1mm_urgent?$fee->capital_tourist_1mm_urgent:"")?>" visa-type="capital_tourist_1mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1mm_emergency?>" value="<?=($fee->tourist_1mm_emergency?$fee->tourist_1mm_emergency:"")?>" visa-type="tourist_1mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1mm_emergency?>" value="<?=($fee->capital_tourist_1mm_emergency?$fee->capital_tourist_1mm_emergency:"")?>" visa-type="capital_tourist_1mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1mm_holiday?>" value="<?=($fee->tourist_1mm_holiday?$fee->tourist_1mm_holiday:"")?>" visa-type="tourist_1mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1mm_holiday?>" value="<?=($fee->capital_tourist_1mm_holiday?$fee->capital_tourist_1mm_holiday:"")?>" visa-type="capital_tourist_1mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1mm_urgent?>" value="<?=($fee->business_1mm_urgent?$fee->business_1mm_urgent:"")?>" visa-type="business_1mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1mm_urgent?>" value="<?=($fee->capital_business_1mm_urgent?$fee->capital_business_1mm_urgent:"")?>" visa-type="capital_business_1mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1mm_emergency?>" value="<?=($fee->business_1mm_emergency?$fee->business_1mm_emergency:"")?>" visa-type="business_1mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1mm_emergency?>" value="<?=($fee->capital_business_1mm_emergency?$fee->capital_business_1mm_emergency:"")?>" visa-type="capital_business_1mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1mm_holiday?>" value="<?=($fee->business_1mm_holiday?$fee->business_1mm_holiday:"")?>" visa-type="business_1mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1mm_holiday?>" value="<?=($fee->capital_business_1mm_holiday?$fee->capital_business_1mm_holiday:"")?>" visa-type="capital_business_1mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
				<tr>
					<td>3 months single</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3ms_urgent?>" value="<?=($fee->tourist_3ms_urgent?$fee->tourist_3ms_urgent:"")?>" visa-type="tourist_3ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3ms_urgent?>" value="<?=($fee->capital_tourist_3ms_urgent?$fee->capital_tourist_3ms_urgent:"")?>" visa-type="capital_tourist_3ms_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3ms_emergency?>" value="<?=($fee->tourist_3ms_emergency?$fee->tourist_3ms_emergency:"")?>" visa-type="tourist_3ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3ms_emergency?>" value="<?=($fee->capital_tourist_3ms_emergency?$fee->capital_tourist_3ms_emergency:"")?>" visa-type="capital_tourist_3ms_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3ms_holiday?>" value="<?=($fee->tourist_3ms_holiday?$fee->tourist_3ms_holiday:"")?>" visa-type="tourist_3ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3ms_holiday?>" value="<?=($fee->capital_tourist_3ms_holiday?$fee->capital_tourist_3ms_holiday:"")?>" visa-type="capital_tourist_3ms_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3ms_urgent?>" value="<?=($fee->business_3ms_urgent?$fee->business_3ms_urgent:"")?>" visa-type="business_3ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3ms_urgent?>" value="<?=($fee->capital_business_3ms_urgent?$fee->capital_business_3ms_urgent:"")?>" visa-type="capital_business_3ms_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3ms_emergency?>" value="<?=($fee->business_3ms_emergency?$fee->business_3ms_emergency:"")?>" visa-type="business_3ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3ms_emergency?>" value="<?=($fee->capital_business_3ms_emergency?$fee->capital_business_3ms_emergency:"")?>" visa-type="capital_business_3ms_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3ms_holiday?>" value="<?=($fee->business_3ms_holiday?$fee->business_3ms_holiday:"")?>" visa-type="business_3ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3ms_holiday?>" value="<?=($fee->capital_business_3ms_holiday?$fee->capital_business_3ms_holiday:"")?>" visa-type="capital_business_3ms_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
				<tr>
					<td>3 months multiple</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3mm_urgent?>" value="<?=($fee->tourist_3mm_urgent?$fee->tourist_3mm_urgent:"")?>" visa-type="tourist_3mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3mm_urgent?>" value="<?=($fee->capital_tourist_3mm_urgent?$fee->capital_tourist_3mm_urgent:"")?>" visa-type="capital_tourist_3mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3mm_emergency?>" value="<?=($fee->tourist_3mm_emergency?$fee->tourist_3mm_emergency:"")?>" visa-type="tourist_3mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3mm_emergency?>" value="<?=($fee->capital_tourist_3mm_emergency?$fee->capital_tourist_3mm_emergency:"")?>" visa-type="capital_tourist_3mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3mm_holiday?>" value="<?=($fee->tourist_3mm_holiday?$fee->tourist_3mm_holiday:"")?>" visa-type="tourist_3mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3mm_holiday?>" value="<?=($fee->capital_tourist_3mm_holiday?$fee->capital_tourist_3mm_holiday:"")?>" visa-type="capital_tourist_3mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3mm_urgent?>" value="<?=($fee->business_3mm_urgent?$fee->business_3mm_urgent:"")?>" visa-type="business_3mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3mm_urgent?>" value="<?=($fee->capital_business_3mm_urgent?$fee->capital_business_3mm_urgent:"")?>" visa-type="capital_business_3mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3mm_emergency?>" value="<?=($fee->business_3mm_emergency?$fee->business_3mm_emergency:"")?>" visa-type="business_3mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3mm_emergency?>" value="<?=($fee->capital_business_3mm_emergency?$fee->capital_business_3mm_emergency:"")?>" visa-type="capital_business_3mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3mm_holiday?>" value="<?=($fee->business_3mm_holiday?$fee->business_3mm_holiday:"")?>" visa-type="business_3mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3mm_holiday?>" value="<?=($fee->capital_business_3mm_holiday?$fee->capital_business_3mm_holiday:"")?>" visa-type="capital_business_3mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
				<tr>
					<td>6 months multiple</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_6mm_urgent?>" value="<?=($fee->tourist_6mm_urgent?$fee->tourist_6mm_urgent:"")?>" visa-type="tourist_6mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_6mm_urgent?>" value="<?=($fee->capital_tourist_6mm_urgent?$fee->capital_tourist_6mm_urgent:"")?>" visa-type="capital_tourist_6mm_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_6mm_emergency?>" value="<?=($fee->tourist_6mm_emergency?$fee->tourist_6mm_emergency:"")?>" visa-type="tourist_6mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_6mm_emergency?>" value="<?=($fee->capital_tourist_6mm_emergency?$fee->capital_tourist_6mm_emergency:"")?>" visa-type="capital_tourist_6mm_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_6mm_holiday?>" value="<?=($fee->tourist_6mm_holiday?$fee->tourist_6mm_holiday:"")?>" visa-type="tourist_6mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_6mm_holiday?>" value="<?=($fee->capital_tourist_6mm_holiday?$fee->capital_tourist_6mm_holiday:"")?>" visa-type="capital_tourist_6mm_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_6mm_urgent?>" value="<?=($fee->business_6mm_urgent?$fee->business_6mm_urgent:"")?>" visa-type="business_6mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_6mm_urgent?>" value="<?=($fee->capital_business_6mm_urgent?$fee->capital_business_6mm_urgent:"")?>" visa-type="capital_business_6mm_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_6mm_emergency?>" value="<?=($fee->business_6mm_emergency?$fee->business_6mm_emergency:"")?>" visa-type="business_6mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_6mm_emergency?>" value="<?=($fee->capital_business_6mm_emergency?$fee->capital_business_6mm_emergency:"")?>" visa-type="capital_business_6mm_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_6mm_holiday?>" value="<?=($fee->business_6mm_holiday?$fee->business_6mm_holiday:"")?>" visa-type="business_6mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_6mm_holiday?>" value="<?=($fee->capital_business_6mm_holiday?$fee->capital_business_6mm_holiday:"")?>" visa-type="capital_business_6mm_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
				<tr>
					<td>1 year multiple</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ym_urgent?>" value="<?=($fee->tourist_1ym_urgent?$fee->tourist_1ym_urgent:"")?>" visa-type="tourist_1ym_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ym_urgent?>" value="<?=($fee->capital_tourist_1ym_urgent?$fee->capital_tourist_1ym_urgent:"")?>" visa-type="capital_tourist_1ym_urgent" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ym_emergency?>" value="<?=($fee->tourist_1ym_emergency?$fee->tourist_1ym_emergency:"")?>" visa-type="tourist_1ym_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ym_emergency?>" value="<?=($fee->capital_tourist_1ym_emergency?$fee->capital_tourist_1ym_emergency:"")?>" visa-type="capital_tourist_1ym_emergency" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ym_holiday?>" value="<?=($fee->tourist_1ym_holiday?$fee->tourist_1ym_holiday:"")?>" visa-type="tourist_1ym_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ym_holiday?>" value="<?=($fee->capital_tourist_1ym_holiday?$fee->capital_tourist_1ym_holiday:"")?>" visa-type="capital_tourist_1ym_holiday" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ym_urgent?>" value="<?=($fee->business_1ym_urgent?$fee->business_1ym_urgent:"")?>" visa-type="business_1ym_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ym_urgent?>" value="<?=($fee->capital_business_1ym_urgent?$fee->capital_business_1ym_urgent:"")?>" visa-type="capital_business_1ym_urgent" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ym_emergency?>" value="<?=($fee->business_1ym_emergency?$fee->business_1ym_emergency:"")?>" visa-type="business_1ym_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ym_emergency?>" value="<?=($fee->capital_business_1ym_emergency?$fee->capital_business_1ym_emergency:"")?>" visa-type="capital_business_1ym_emergency" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ym_holiday?>" value="<?=($fee->business_1ym_holiday?$fee->business_1ym_holiday:"")?>" visa-type="business_1ym_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ym_holiday?>" value="<?=($fee->capital_business_1ym_holiday?$fee->capital_business_1ym_holiday:"")?>" visa-type="capital_business_1ym_holiday" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".fee").click(function() {
		$(this).select();
	});
	
	$(".fee").blur(function() {
		var visa_type = $(this).attr("visa-type");
		var val = $(this).val();
		
		var p = {};
		p["visa_type"] = visa_type;
		p["val"] = val;
		
		$.ajax({
			type: "POST",
			url: "<?=site_url("syslog/ajax-processing-fee")?>",
			data: p
		});
	});
});
</script>