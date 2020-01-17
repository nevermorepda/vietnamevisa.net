	<div class="container">
		<!-- breadcrumb -->
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
		<!-- end breadcrumb -->
		
		<div class="">
			<div class="tab-step clearfix">
				<h1 class="note">Vietnam Visa Application Form</h1>
				<ul class="style-step hidden-xs">
					<li class="active"><font class="number">1.</font> Visa Options</li>
					<li class="active"><font class="number">2.</font> Account Login</li>
					<li class="active"><font class="number">3.</font> Applicant Details</li>
					<li class="active"><font class="number">4.</font> Review &amp; Payment</li>
				</ul>
			</div>
			<div class="applyform step3">
				<form action="<?=BASE_URL_HTTPS."/apply-visa/completed.html"?>" method="POST">
					<input type="hidden" name="key" value="<?=(!empty($_GET["key"])?$_GET["key"]:"")?>">
					<h3>Please review your visa application details !</h3>
					<table width="100%" class="table-summary">
						<tr>
							<th>Type of visa</th>
							<th>Purpose of visit</th>
							<th>Arrival airport</th>
							<th>Processing time</th>
							<th>Arrival date</th>
							<th>Flight number</th>
						</tr>
						<tr>
							<td>Visa on Arrival - <?=$this->m_visa_type->load($step1->visa_type)->name?></td>
							<td><?=$step1->visit_purpose?></td>
							<td><?=$this->m_arrival_port->load($step1->arrival_port)->airport?></td>
							<td><?=$step1->processing_time?></td>
							<td><?=date("M d, Y", strtotime($step1->arrivalmonth."/".$step1->arrivaldate."/".$step1->arrivalyear))?></td>
							<td><?=$step1->flightnumber?> - <?=$step1->arrivaltime?></td>
						</tr>
					</table>
					<br>
					<h3>Passport details</h3>
					<table width="100%" class="table-summary">
						<tr>
							<th width="20" class="text-center">No.</th>
							<th>Full name</th>
							<th>Gender</th>
							<th>Date of birth</th>
							<th>Nationality</th>
							<th>Passport number</th>
						</tr>
						<?
							for ($i=1; $i<=$step1->group_size; $i++) {
								?>
								<tr>
									<td class="text-center"><?=$i?></td>
									<td><?=$step1->fullname[$i]?></td>
									<td><?=$step1->gender[$i]?></td>
									<td><?=date("M d, Y", strtotime($step1->birthmonth[$i]."/".$step1->birthdate[$i]."/".$step1->birthyear[$i]))?></td>
									<td><?=$step1->nationality[$i]?></td>
									<td><?=$step1->passportnumber[$i]?></td>
								</tr>
								<?
							}
						?>
					</table>
					<br>
					<h3>Service fees</h3>
					<table width="100%" class="table-summary">
						<tr>
							<th>Type of service</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Unit price</th>
							<th class="text-center">Total fee</th>
						</tr>
						<tr>
							<td>Visa on Arrival - <?=$this->m_visa_type->load($step1->visa_type)->name?></td>
							<td class="text-center"><?=$step1->group_size?></td>
							<td class="text-center"><?=$step1->service_fee?> USD</td>
							<td class="text-center"><?=$step1->service_fee*$step1->group_size?> USD</td>
						</tr>
						<? if ($step1->processing_time != "Normal") { ?>
							<tr>
								<td>Processing time - <?=$step1->processing_time?></td>
								<td class="text-center"><?=$step1->group_size?></td>
								<td class="text-center"><?=$step1->rush_fee?> USD</td>
								<td class="text-center"><?=$step1->rush_fee*$step1->group_size?> USD</td>
							</tr>
						<? } ?>
						<?
							if ($step1->private_visa) {
								?>
								<tr>
									<td>Private letter</td>
									<td class="text-center">-</td>
									<td class="text-center"><?=$step1->private_visa_fee?> USD</td>
									<td class="text-center"><?=$step1->private_visa_fee?> USD</td>
								</tr>
								<?
							}
						?>
						<? if ($step1->full_package) { ?>
							<tr>
								<td>Visa stamping fee</td>
								<td class="text-center"><?=$step1->group_size?></td>
								<td class="text-center"><?=$step1->stamp_fee?> USD</td>
								<td class="text-center"><?=$step1->stamp_fee*$step1->group_size?> USD</td>

							</tr>
							<tr>
								<td>Airport fast check-in</td>
								<td class="text-center"><?=$step1->group_size?></td>
								<td class="text-center"><?=$step1->full_package_fc_fee?> USD</td>
								<td class="text-center"><?=$step1->full_package_fc_fee*$step1->group_size?> USD</td>
							</tr>
						<? } ?>
						<? if ($step1->fast_checkin) { ?>
							<tr>
								<td><?=(($step1->fast_checkin==2) ? "VIP" : "Airport")?> fast check-in</td>
								<td class="text-center"><?=$step1->group_size?></td>
								<td class="text-center"><?=$step1->fast_checkin_fee?> USD</td>
								<td class="text-center"><?=$step1->fast_checkin_total_fee?> USD</td>
							</tr>
						<? } ?>
						<? if ($step1->car_pickup) { ?>
							<tr>
								<td>Car pick-up (<?=$step1->car_type?>, <?=$step1->num_seat?> seats)</td>
								<td class="text-center">1</td>
								<td class="text-center"><?=$step1->car_fee?> USD</td>
								<td class="text-center"><?=$step1->car_total_fee?> USD</td>
						</tr>
					<? } ?>
					<? if ($step1->vip_discount) { ?>
						<tr>
							<td>VIP discount</td>
							<td class="text-center">-</td>
							<td class="text-center">- <?=$step1->vip_discount?>%</td>
							<td class="text-center">- <?=round($step1->total_service_fee * $step1->vip_discount/100)?> USD</td>
						</tr>
					<? } ?>
					<? if (!empty($step1->service_fee_discount)) { ?>
						<tr>
							<td>Visa service fee discount</td>
							<td class="text-center">-</td>
							<td class="text-center">- <?=$step1->service_fee_discount?>%</td>
							<td class="text-center">- <?=round($step1->total_service_fee * $step1->service_fee_discount/100)?> USD</td>
						</tr>
					<? } ?>
					<? if (!empty($step1->discount)) { ?>
						<tr>
							<td>Promotion discount</td>
							<td class="text-center">-</td>
							<td class="text-center">- <?=$step1->discount?>%</td>
							<td class="text-center">- <?=round($step1->total_service_fee * $step1->discount/100)?> USD</td>
						</tr>
					<? } ?>
					<tr>
						<td class="total" colspan="3">Total</td>
						<td class="text-center total"><?=$step1->total_fee?> USD</td>
					</tr>
				</table>
				<br>
				<h3>Payment method</h3>
				<p>Please select one of below payment method to proceed the visa application.</p>
				<br /><br />
				<div class="row">
					<div class="col-xs-4 col-sm-4 text-center">
						<label for="payment3"><img class="img-responsive" src="<?=IMG_URL?>payment/paypal.png" alt="Paypal" /></label>
						<br />
						<div class="radio">
							<label><input id="payment3" type="radio" name="payment" value="Paypal" checked="checked" />Credit Card by Paypal</label>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 text-center hidden">
						<label for="payment1"><img class="img-responsive" src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" /></label>
						<br />
						<div class="radio">
							<label><input id="payment1" type="radio" name="payment" value="OnePay" />Credit Card by OnePay</label>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 text-center">
						<label for="payment4"><img class="img-responsive" src="<?=IMG_URL?>payment/western_union.png" alt="Western Union" /></label>
						<br />
						<div class="radio">
							<label><input id="payment4" type="radio" name="payment" value="Western Union" />Western Union</label>
						</div>
					</div>
				</div>
				<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
					<div class="text-center">
						<button class="btn btn-danger btn_back" type="button" onclick="window.location='<?=BASE_URL_HTTPS."/apply-visa/step2.html"?>'"><i class="icon-double-angle-left icon-large"></i> BACK</button>
						<button class="btn btn-danger btn_next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	<? if ($this->session->flashdata('error')) { ?>
		messageBox("ERROR", "Error", "<?=$this->session->flashdata('error')?>");
	<? } ?>
});
</script>