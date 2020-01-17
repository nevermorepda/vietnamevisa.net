<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Private Letter Fees
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
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
				<tr>
					<td>Private letter</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ms?>" value="<?=($fee->tourist_1ms?$fee->tourist_1ms:"")?>" visa-type="tourist_1ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ms?>" value="<?=($fee->capital_tourist_1ms?$fee->capital_tourist_1ms:"")?>" visa-type="capital_tourist_1ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1mm?>" value="<?=($fee->tourist_1mm?$fee->tourist_1mm:"")?>" visa-type="tourist_1mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1mm?>" value="<?=($fee->capital_tourist_1mm?$fee->capital_tourist_1mm:"")?>" visa-type="capital_tourist_1mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3ms?>" value="<?=($fee->tourist_3ms?$fee->tourist_3ms:"")?>" visa-type="tourist_3ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3ms?>" value="<?=($fee->capital_tourist_3ms?$fee->capital_tourist_3ms:"")?>" visa-type="capital_tourist_3ms" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_3mm?>" value="<?=($fee->tourist_3mm?$fee->tourist_3mm:"")?>" visa-type="tourist_3mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_3mm?>" value="<?=($fee->capital_tourist_3mm?$fee->capital_tourist_3mm:"")?>" visa-type="capital_tourist_3mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_6mm?>" value="<?=($fee->tourist_6mm?$fee->tourist_6mm:"")?>" visa-type="tourist_6mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_6mm?>" value="<?=($fee->capital_tourist_6mm?$fee->capital_tourist_6mm:"")?>" visa-type="capital_tourist_6mm" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->tourist_1ym?>" value="<?=($fee->tourist_1ym?$fee->tourist_1ym:"")?>" visa-type="tourist_1ym" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_tourist_1ym?>" value="<?=($fee->capital_tourist_1ym?$fee->capital_tourist_1ym:"")?>" visa-type="capital_tourist_1ym" style="background-color: #F0F0F0; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ms?>" value="<?=($fee->business_1ms?$fee->business_1ms:"")?>" visa-type="business_1ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ms?>" value="<?=($fee->capital_business_1ms?$fee->capital_business_1ms:"")?>" visa-type="capital_business_1ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1mm?>" value="<?=($fee->business_1mm?$fee->business_1mm:"")?>" visa-type="business_1mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1mm?>" value="<?=($fee->capital_business_1mm?$fee->capital_business_1mm:"")?>" visa-type="capital_business_1mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3ms?>" value="<?=($fee->business_3ms?$fee->business_3ms:"")?>" visa-type="business_3ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3ms?>" value="<?=($fee->capital_business_3ms?$fee->capital_business_3ms:"")?>" visa-type="capital_business_3ms" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_3mm?>" value="<?=($fee->business_3mm?$fee->business_3mm:"")?>" visa-type="business_3mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_3mm?>" value="<?=($fee->capital_business_3mm?$fee->capital_business_3mm:"")?>" visa-type="capital_business_3mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_6mm?>" value="<?=($fee->business_6mm?$fee->business_6mm:"")?>" visa-type="business_6mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_6mm?>" value="<?=($fee->capital_business_6mm?$fee->capital_business_6mm:"")?>" visa-type="capital_business_6mm" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
					</td>
					<td>
						<input type="text" class="fee" name="<?=$fee->business_1ym?>" value="<?=($fee->business_1ym?$fee->business_1ym:"")?>" visa-type="business_1ym" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none;"><br>
						<input type="text" class="fee" name="<?=$fee->capital_business_1ym?>" value="<?=($fee->capital_business_1ym?$fee->capital_business_1ym:"")?>" visa-type="capital_business_1ym" style="background-color: #D9EDF7; width: 50px; text-align: right; border: none; margin-top: 2px;">
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
			url: "<?=site_url("syslog/ajax-private-letter-fee")?>",
			data: p
		});
	});
});
</script>