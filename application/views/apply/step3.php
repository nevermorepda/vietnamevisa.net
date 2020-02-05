	<div class="banner-top applyform-banner" style="background: url('<?=IMG_URL?>new-template/ApplyVisaForm-banner.png') no-repeat scroll top center transparent;">
		<div class="container">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-8">
					<div class="text-content">
						<h1>APPLY <span class="border-text" style="padding: 20px 20px 0px 10px;"> VISA FORM</span></h1>
						<div class="alternative-breadcrumb">
						<!-- <? require_once(APPPATH."views/module/breadcrumb.php"); ?> -->
						</div>
						<ul>
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Sed do eiusmod tempor incididunt ut labore et dolore magna </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="slide-wrap">
		<div class="slide-contact">
			<div class="container">
				<ul>
					<li><img src="<?=IMG_URL?>new-template/flag/flag-vn.png"><a href="" title="Contact hotline"><?=HOTLINE?></a></li>
					<li><img src="<?=IMG_URL?>new-template/flag/flag-usa.png"><a href="" title="Contact hotline"><?=HOTLINE_US?></a></li>
					<li><a href="" title="Contact hotline"><i class="fa fa-envelope-o" aria-hidden="true"></i><?=MAIL_INFO?></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="container">
		<!-- breadcrumb -->
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
		<!-- end breadcrumb -->
		
		<div class="applyform-content cluster-content">
			<!-- <div class="tab-step clearfix">
				<h1 class="note">Vietnam Visa Application Form</h1>
				<ul class="style-step d-none d-sm-none d-md-block">
					<li class="active"><a style="color: #fff;" href="<?=site_url('apply-visa')?>"><font class="number">1.</font> Visa Options</a></li>
					<li class="active"><font class="number">2.</font> Login Account</li>
					<li class="active"><a style="color: #fff;" href="<?=site_url('apply-visa/step2')?>"><font class="number">3.</font> Applicant Details</a></li>
					<li class="active"><font class="number">4.</font> Review & Payment</li>
				</ul>
			</div> -->

			<h2 class="home-sub-heading text-center" style="padding-top: 15px; padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Vietnam Visa Application Form</h2>
				<div class="step-apply text-center">
					<div class="step active">
						<div class="line-step line-step1">
							<span class="step-number"></span>
						</div>
						Visa Options
					</div>
					<div class="step active">
						<div class="line-step line-step2">
							<span class="step-number"></span>
						</div>
						Login Account
					</div>
					<div class="step active">
						<div class="line-step line-step3">
							<span class="step-number"></span>
						</div>
						Applicant Details
					</div>
					<div class="step active">
						<div class="line-step line-step4">
							<span class="step-number"></span>
						</div>
						Review & Payment
					</div>
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
					<div class="row">
						<div class="col-sm-9">
							<div style="position: relative;">
								<table width="100%" class="table-summary" >
									<tr>
										<th>Type of service</th>
										<th class="text-center">Quantity</th>
										<th class="text-center">Unit price</th>
										<th class="text-center">Total fee</th>
									</tr>
									<tr>
										<td>Visa on Arrival - <?=$this->m_visa_type->load($step1->visa_type)->name?></td>
										<td class="text-center"><?=$step1->group_size?></td>
										<td class="text-center">(<?
											$str = "";
											$i = 0;
											foreach ($step1->arr_service_fee as $service_fee) {
												if ($i != 0) {
													$str .=' + '.$service_fee;
												} else {
													$str .= $service_fee;
												}
												
												$i++;
											}
											echo $str;
											?>) $</td>
										<td class="text-center"><?=$step1->total_service_fee?> $</td>
									</tr>
									<? if ($step1->processing_time != "Normal") { ?>
										<tr>
											<td>Processing time - <?=$step1->processing_time?></td>
											<td class="text-center"><?=$step1->group_size?></td>
											<td class="text-center"><?=$step1->rush_fee?> $</td>
											<td class="text-center"><?=$step1->rush_fee*$step1->group_size?> $</td>
										</tr>
									<? } ?>
									<?
										if ($step1->private_visa) {
											?>
											<tr>
												<td>Private letter</td>
												<td class="text-center">-</td>
												<td class="text-center"><?=$step1->private_visa_fee?> $</td>
												<td class="text-center"><?=$step1->private_visa_fee?> $</td>
											</tr>
											<?
										}
									?>
									<? if ($step1->full_package) { ?>
										<tr>
											<td>Visa stamping fee</td>
											<td class="text-center"><?=$step1->group_size?></td>
											<td class="text-center"><?=$step1->stamp_fee?> $</td>
											<td class="text-center"><?=$step1->stamp_fee*$step1->group_size?> $</td>
										</tr>
										<tr>
											<td>Airport fast check-in</td>
											<td class="text-center"><?=$step1->group_size?></td>
											<td class="text-center"><?=$step1->full_package_fc_fee?> $</td>
											<td class="text-center"><?=$step1->full_package_fc_fee*$step1->group_size?> $</td>
										</tr>
									<? } ?>
									<? if ($step1->fast_checkin) { ?>
										<tr>
											<td><?=(($step1->fast_checkin==2) ? "VIP" : "Airport")?> fast check-in</td>
											<td class="text-center"><?=$step1->group_size?></td>
											<td class="text-center"><?=$step1->fast_checkin_fee?> $</td>
											<td class="text-center"><?=$step1->fast_checkin_total_fee?> $</td>
										</tr>
									<? } ?>
									<? if ($step1->car_pickup) { ?>
										<tr>
											<td>Car pick-up (<?=$step1->car_type?>, <?=$step1->num_seat?> seats)</td>
											<td class="text-center">1</td>
											<td class="text-center"><?=$step1->car_fee?> $</td>
											<td class="text-center"><?=$step1->car_total_fee?> $</td>
										</tr>
									<? } ?>
									<? if ($step1->vip_discount) { ?>
										<tr>
											<td>VIP discount</td>
											<td class="text-center">-</td>
											<td class="text-center">- <?=$step1->vip_discount?>%</td>
											<td class="text-center">- <?=($step1->total_service_fee * $step1->vip_discount/100)?> $</td>
										</tr>
									<? } ?>
									<? if (!empty($step1->discount) || !empty($step1->member_discount)) { 
										$title_discount = 'Member discount';
										$discount = $step1->member_discount;
										if ($step1->discount_unit == "USD") {
											round($step1->discount,2);
										} else {
											if ($step1->member_discount < $step1->discount) {
												$title_discount = 'Promotion discount';
												$discount = $step1->discount;
											}
										}
										$discount_fee = round(($step1->total_service_fee * $discount/100),2);
									?>
										<tr>
											<td><?=$title_discount?></td>
											<td class="text-center">-</td>
											<td class="text-center">- <?=$discount?><?=$step1->discount_unit?></td>
											<td class="text-center">- <?=$discount_fee?> $</td>
										</tr>
									<? } ?>
									<tr>
										<td class="total" colspan="3">Total</td>
										<td class="text-center total"><?=$step1->total_fee?> $</td>
									</tr>
								</table>
							<!-- <img style="position: absolute;right: 0;bottom: 0;" src="<?=IMG_URL?>private-letter.png" alt="private-letter"> -->
							</div>
						</div>
						<div class="col-sm-3">
							<img style="" src="<?=IMG_URL.'refun-100.jpg'?>" class="img-responsive full-width" alt="refun 100%">
						</div>
					</div>
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
						<? if (defined("OP") && OP == "ON" && ($step1->processing_time != "Holiday")) { ?>
						<div class="col-xs-4 col-sm-4 text-center">
							<label for="payment1"><img class="img-responsive" src="<?=IMG_URL?>payment/onepay.png" alt="OnePay" /></label>
							<br />
							<div class="radio">
								<label><input id="payment1" type="radio" name="payment" value="OnePay" />Credit Card by OnePay</label>
							</div>
						</div>
						<? } ?>
						<!-- <div class="col-xs-4 col-sm-4 text-center">
							<label for="payment4"><img class="img-responsive" src="<?=IMG_URL?>payment/western_union.png" alt="Western Union" /></label>
							<br />
							<div class="radio">
								<label><input id="payment4" type="radio" name="payment" value="Western Union" />Western Union</label>
							</div>
						</div> -->
						<div class="col-xs-4 col-sm-4 text-center">
							<label for="payment4"><img class="img-responsive" src="<?=IMG_URL?>banktransfer.png" alt="Bank Transfer" /></label>
							<br />
							<div class="radio">
								<label><input id="payment4" type="radio" name="payment" value="Bank Transfer" />Bank Transfer</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label">CAPTCHA <span class="required">*</span></label>
						<div class="clearfix">
							<div class="left">
								<input type="text" style="width: 100px" value="" id="security_code" name="security_code" required="" class="form-control">
							</div>
							<div class="left" style="margin-left: 10px; line-height: 30px;">
								<label class="security-code"><?=$this->util->createSecurityCode()?></label>
							</div>
						</div>
					</div>
					<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
						<div class="text-center">
							<!-- <button class="btn btn-danger btn_back" type="button" onclick="window.location='</?=BASE_URL_HTTPS."/apply-visa/step2.html"?>'"><i class="icon-double-angle-left icon-large"></i> BACK</button> -->
							<!-- <div class="show-button m-4" >
								<a class="btn btn-general" type="button" onclick="window.location='<?=BASE_URL_HTTPS."/apply-visa/step2.html"?>'"><i class="icon-double-angle-left icon-large">BACK </a>
								<div class="bg-btn transition" style="width: 100%;"></div>
							</div> -->
							<div class="show-button m-4" >
								<a class="btn btn-danger" href="<?=site_url("apply-visa/step2")?>"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp; BACK </a>
							</div>
							<!-- <button class="btn btn-danger btn_next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button> -->
							<div class="show-button m-4">
								<button class="btn btn-danger" type="submit">SUBMIT TO PAYMENT &nbsp;&nbsp;<i class="icon-double-angle-right icon-large"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- About us -->
<div class="d-none d-sm-none d-md-block">
	<div class="about-us-cluster">
		<div class="container wow fadeInUp">
			<div class="row">
				<div class="col-sm-6">
					<div class="about-us-content">
						<div class="title">
							<h1 class="heading">About Us</h1>
						</div>
						<p>It is our great pleasure to assist you in obtaining Vietnam Visa and we would like to get this opportunity to say “thank you” for your interest in our site Vietnam Visa Org Vn.</p>
						<p>With 10-year-experience in Vietnam visa service and enthusiastic visa team, Vietnam Visa Org Vn is always proud of our excellent services for the clients who would like to avoid the long visa procedures at their local Vietnam's Embassies. Vietnam Visa on arrival is helpful for overseas tourists and businessmen because it is the most convenient, simple and secured way to get Vietnam visa stamp. It is legitimated and supported by the Vietnamese Immigration Department.</p>
						<p>Let’s save your money, your time in the first time to visit our country! Whatever service you need, we are happy to tailor a package reflecting your needs and budget.</p>
						<div class="showmore-button">
							<a class="btn btn-danger" href="<?=site_url('about-us')?>">SHOW MORE</a>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="about-us-images">
						<img src="<?=IMG_URL?>new-template/thumbnail/aboutus-img.png" class="img-responsive full-width" alt="About Us">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End about us -->

<script type="text/javascript">
$(document).ready(function() {
	<? if ($this->session->flashdata('error')) { ?>
		messageBox("ERROR", "Error", "<?=$this->session->flashdata('error')?>");
	<? } ?>
});
</script>
<script>
	$(document).ready(function() {
		$('.btn').mouseenter(function() {
			$(this).parent().find('.bg-btn').css({'top':'0px','left':'0px'});
		});
		$('.btn').mouseleave(function() {
			$(this).parent().find('.bg-btn').css({'top':'10px','left':'10px'});
		});
	});
</script>