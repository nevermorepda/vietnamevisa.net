<?
	$service_fee_group = array();
	$nationality_group = array();
	foreach ($step1->nationality as $nationality) {
		if (array_key_exists($nationality, $nationality_group)) {
			$nationality_group[$nationality] = $nationality_group[$nationality] + 1;
		} else {
			$nationality_group[$nationality] = 1;
		}
	}
?>

<div class="apply-visa">
	<div class="slide-bar hidden">
		<div class="slide-wrap">
			<div class="slide-content">
				<div class="container">
					<div class="slide-text">
						<h1>APPLY VIETNAM VISA ONLINE</h1>
						<h4>Just a few steps fill in online form, you are confident to have Vietnam visa approval on your hand.</h4>
					</div>
				</div>
			</div>
		</div>
	</div>

	<img src="<?=IMG_URL?>new-template/banner/banner-apply-online.png" class="img-responsive full-width d-none d-sm-none d-lg-block d-md-none" alt="">
	<h1 class="hidden"><span class="" style="">APPLY VISA</span></h1>
	<div class="slide-wrap d-none d-sm-none d-md-block">
		<div class="slide-ex-contact">
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
	</div>
	<div class="applyform-heading">
		<div class="container">
			<h2 class="home-heading text-center" style="text-shadow: 3px 3px #bdbdbd;">Vietnam Visa Application Form</h2>
		</div>
	</div>
	<div class="visa-form">
		<div class="applyform-content cluster-content">
			<div class="container">
				<div class="step-apply ">
					<div class="step">
						<div class="line-right"></div>
						<span class="step-number active">1</span>
					</div>
					<div class="step">
						<div class="line-right"></div>
						<div class="line-left"></div>
						<span class="step-number active">2</span>
					</div>
					<div class="step">
						<div class="line-right"></div>
						<div class="line-left"></div>
						<span class="step-number active">3</span>
					</div>
					<div class="step">
						<div class="line-left"></div>
						<span class="step-number active">4</span>
					</div>
				</div>
				<div class="step-apl-content">
					<div class="bystep active">Visa Option</div>
					<div class="bystep active">Account Login</div>
					<div class="bystep active">Application Details</div>
					<div class="bystep active">Review & Payment</div>
				</div>
				
				<div class="form-apply" style="margin-top: 20px;">
					<form id="frmApply" class="form-horizontal" role="form" action="<?=site_url("apply-e-visa/completed")?>" method="POST">
						<div class="row clearfix">
							<div class="col-sm-12">
								<div class="group hidden">
									<h3 class="group-heading">Visa Option Summary</h3>
									<div class="group-content">
										<table class="table table-bordered table-striped">
											<tr>
												<th>Type of visa</th>
												<th>Purpose of visit</th>
												<th>Processing time</th>
												<th>Arrival date</th>
											</tr>
											<tr>
												<td><?=$this->util->getVisaType2String($step1->visa_type)?></td>
												<td><?=$step1->visit_purpose?></td>
												<td><?=$step1->processing_time?></td>
												<td><?=date("M d, Y", strtotime($step1->arrival_date))?></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="group hidden">
									<h3 class="group-heading">Arrival Port Details</h3>
									<div class="group-content">
										<table class="table table-bordered table-striped">
											<tr>
												<th>Arrival airpport</th>
												<th>Flight No. / Arrival time</th>
												<th>Private letter</th>
												<th>Car Pick-up</th>
												<th>Fast-track</th>
											</tr>
											<tr>
												<td><?=$this->m_arrival_port->load($step1->arrival_port)->airport?></td>
												<td class="text-center"><?=$step1->flightnumber.' - '.$step1->arrivaltime?></td>
												<td class="text-center"><?=($step1->private_visa?"Yes":"No")?></td>
												<td class="text-center"><?=($step1->car_pickup?$step1->car_type." (".$step1->num_seat." seats)":"No")?></td>
												<td class="text-center"><?=($step1->full_package?"Full package":($step1->fast_checkin?"Yes":"No"))?></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="group">
									<h3 class="group-heading">Passport Details</h3>
									<div class="group-content">
										<table class="table table-bordered table-striped">
											<tr>
												<th>No.</th>
												<th>Full name<br><span class="help-block">state in passport</span></th>
												<th>Gender</th>
												<th>Date of birth</th>
												<th>Nationality<br><span class="help-block">current passport</span></th>
												<th>Passport No.</th>
												<!-- <th>Type</th> -->
												<th>Expired date</th>
												<!-- <th>Religion</th> -->
											</tr>
											<? for ($i=1; $i<=$step1->group_size; $i++) { ?>
											<tr>
												<td class="text-center"><?=$i?></td>
												<td><?=$step1->fullname[$i]?></td>
												<td class="text-center"><?=$step1->gender[$i]?></td>
												<td><?=date("M d, Y", strtotime($step1->birthmonth[$i]."/".$step1->birthdate[$i]."/".$step1->birthyear[$i]))?></td>
												<td><?=$step1->nationality[$i]?></td>
												<td><?=$step1->passport[$i]?></td>
												<!-- <td><?//=$step1->passport_type[$i]?></td> -->
												<td><?=date("M d, Y", strtotime($step1->expirymonth[$i].'/'.$step1->expirydate[$i].'/'.$step1->expiryyear[$i]))?></td>
												<!-- <td><?//=$step1->religion[$i]?></td> -->
											</tr>
											<? } ?>
										</table>
									</div>
								</div>
							</div>
							<div class="col-lg-8 col-sm-8">
								<h3 class="group-heading">Payment method</h3>
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
											<label><input id="payment1" type="radio" name="payment" value="OnePay" /> Credit Card by OnePay</label>
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
									<!-- <div class="col-xs-4 col-sm-4 text-center">
										<label for="payment4"><img class="img-responsive" src="<?=IMG_URL?>banktransfer.png" alt="Bank Transfer" /></label>
										<br />
										<div class="radio">
											<label><input id="payment4" type="radio" name="payment" value="Bank Transfer" /> Bank Transfer</label>
										</div>
									</div> -->
								</div>
								<!-- <div class="">
									<label class="form-label">CAPTCHA <span class="required">*</span></label>
									<div class="clearfix">
										<div class="left">
											<input type="text" style="width: 100px" value="" id="security_code" name="security_code" required="" class="form-control">
										</div>
										<div class="left" style="margin-left: 10px; line-height: 30px;">
											<label class="security-code"><?=$this->util->createSecurityCode()?></label>
										</div>
									</div>
								</div> -->
								<div class="text-center">
									<!-- <a style="padding-left: 80px;padding-right: 80px;" class="btn btn-danger btn-1x" href="<?=site_url("apply-e-visa/step2")?>"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp; BACK</a> -->
									<div class="show-button m-4 d-inline-flex" >
										<a class="btn btn-danger" href="<?=site_url("apply-e-visa/step2")?>"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp; BACK </a>
									</div>
									<!-- <button style="    margin: 10px;" class="btn btn-danger btn-1x btn-next" type="submit">SUBMIT TO PAYMENT &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button> -->
									<div class="show-button m-4 d-inline-flex">
										<button class="btn btn-danger" type="submit">SUBMIT TO PAYMENT &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-4">
								<div class="panel-fees">
									<h3 class="panel-heading" style="padding: 10px;font-size: 25px;">Visa Fees</h3>
									<div class="panel-body">
										<ul>
											<li class="clearfix hidden">
												<label>Passport holder:</label>
												<span class="passport_holder_t"><?=$step1->passport_holder?></span>
											</li>
											<li class="clearfix">
												<label>Number of persons:</label>
												<span class="group_size_t"><?=$step1->group_size?> <?=($step1->group_size>1?"people":"person")?></span>
											</li>
											<li class="clearfix">
												<label>Type of visa:</label>
												<span class="visa_type_t"><?=$this->util->getVisaType2String($step1->visa_type).' (e-visa)'?></span>
											</li>
											<li class="clearfix">
												<label>Purpose of visit:</label>
												<span class="visit_purpose_t"><?=$step1->visit_purpose?></span>
											</li>
											<li class="clearfix">
												<label>Arrival airport:</label>
												<span class="arrival_port_t"><?=$step1->arrival_port?></span>
											</li>
											<li class="clearfix">
												<label>Arrival date:</label>
												<span class="arrival_date_t"><?=date("M/d/Y", strtotime($step1->arrival_date))?></span>
											</li>
											<li class="clearfix">
												<label>Exit port:</label>
												<span class="exit_port_t"><?=$step1->exit_port?></span>
											</li>
											<!-- <li class="clearfix">
												<label>Exit date:</label>
												<span class="arrival_date_t"><?//=date("M/d/Y", strtotime($step1->exit_date))?></span>
											</li> -->
											<li class="clearfix">
												<label>Visa stamping fee:</label>
												<span class="total_stamping_fee_t price pointer" data-toggle="collapse" data-target="#stamping-fee-detail"><?=$step1->stamp_fee*$step1->group_size?> $ <i class="fa fa-chevron-circle-down"></i></span>
												<div id="stamping-fee-detail" class="stamping-fee-detail text-right collapse">
													<span class="total_stamping_price price"><?=$step1->stamp_fee." $ x ".$step1->group_size." ".($step1->group_size>1?"people":"person")." = ".$step1->stamp_fee*$step1->group_size?> $</span>
												</div>
											</li>
											<li class="clearfix">
												<label>Visa service fee:</label>
												<span class="total_visa_price_t price pointer" data-toggle="collapse" data-target="#service-fee-detail"><?=$step1->total_service_fee?> $ <i class="fa fa-chevron-circle-down"></i></span>
												<div id="service-fee-detail" class="service-fee-detail text-right collapse">
													<?
													foreach ($nationality_group as $nationality => $count) {
														$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $nationality, $step1->visit_purpose,null,2);
														$service_fee_group[$nationality] = $visa_fee->service_fee;
														$service_fee_detail  = '<div class="service-fee-item">';
														$service_fee_detail .= '<div class="text-right"><strong>'.$nationality.'</strong></div>';
														$service_fee_detail .= '<div class="price text-right">'.$visa_fee->service_fee.' $ x '.$count.' '.($count>1?"people":"person").' = '.($visa_fee->service_fee * $count).' $</div>';
														$service_fee_detail .= '</div>';
														echo $service_fee_detail;
													}
													?>
												</div>
											</li>
											<li class="clearfix <?=(($step1->processing_time != 'Normal')?'':'display-none')?>" id="processing_time_li">
												<div class="clearfix">
													<label>Processing time:</label>
													<span class="processing_note_t"><?=$step1->processing_time?></span>
												</div>
												<span class="processing_t price"><?=$step1->rush_fee." $ x ".$step1->group_size." ".($step1->group_size>1?"people":"person")." = ".$step1->rush_fee*$step1->group_size?> $</span>
											</li>
											<li class="clearfix <?=(!empty($step1->private_visa)?'':'display-none')?>" id="private_visa_li">
												<label>Private letter:</label>
												<span class="private_visa_t price"><?=$step1->private_visa_fee?> $</span>
											</li>
											<li class="clearfix <?=(!empty($step1->full_package)?'':'display-none')?>" id="full_package_li">
												<label>Full package service:</label>
												<div class="full_package_services">
													<div class="clearfix"><label>1. Government fee</label><span class='price'><?=$step1->stamp_fee?> $ x <?=$step1->group_size?> <?=($step1->group_size>1?"people":"person")?> = <?=$step1->stamp_fee*$step1->group_size?> $</span></div>
													<div class="clearfix"><label>2. Airport fast check-in</label><span class='price'><?=$step1->full_package_fc_fee?> $ x <?=$step1->group_size?> <?=($step1->group_size>1?"people":"person")?> = <?=$step1->full_package_fc_fee*$step1->group_size?> $</span></div>
												</div>
											</li>
											<li class="clearfix <?=(($step1->fast_checkin||$step1->car_pickup)?'':'display-none')?>" id="extra_service_li">
												<label>Airport assistance services:</label>
												<div class="extra_services">
													<?
														$serviceCnt = 1;
														if ($step1->fast_checkin==1) {
													?>
														<div class="clearfix"><label><?=($serviceCnt++)?>. Fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> $ x <?=$step1->group_size?> <?=($step1->group_size>1?"people":"person")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> $</span></div>
													<?
														}
														if ($step1->fast_checkin==2) {
													?>
														<div class="clearfix"><label><?=($serviceCnt++)?>. VIP fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> $ x <?=$step1->group_size?> <?=($step1->group_size>1?"people":"person")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> $</span></div>
													<?	
														}
														if ($step1->car_pickup) {
													?>
														<div class="clearfix"><label><?=($serviceCnt++)?>. Car pick-up</label><span class='price'>(<?=$step1->car_type?>, <?=$step1->num_seat?> seats) = <?=$step1->car_total_fee?> $</span></div>
													<?
														}
													?>
												</div>
												<div class="review-car-plus-fee" <?=empty($step1->car_plus_fee) ? 'style="display: none;"' : ''?>><span class='price'>+ (<?=$step1->car_distance-$step1->car_distance_default?>km) = <?=$step1->car_plus_fee?> $</span></div>
											</li>
											<li class="clearfix <?=(!empty($step1->vip_discount)?'':'display-none')?>" id="vipsave_li">
												<label>VIP discount <span class="vipsavepercent_t"><?=$step1->vip_discount?>%</span></label>
												<span class="vipsave_t price">- <?=round($step1->total_service_fee * $step1->vip_discount/100)?> $</span>
											</li>
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
											<li class="clearfix <?=(!empty($discount)?'':'display-none')?>" id="promotion_li" style="background-color: #F8F8F8;">
												<div class="clearfix">
													<label class="left"><?=$title_discount?>:</label>
													<span class="promotion_t price">
													- <?=$discount_fee?> $
													<?="({$discount}{$step1->discount_unit})"?>
													</span>
												</div>
											</li>
											<? } ?>
											<li class="total clearfix">
												<div class="left_edge"></div>
												<div class="right_edge"></div>
												<div class="clearfix">
													<label class="pull-left total_fee ">TOTAL FEE:</label>
													<div class="pull-right subtotal-price">
														<div class="price-block">
															<span class="price total_price"><?=$step1->total_fee?> $</span>
														</div>
													</div>
												</div>
												<!-- <div class="text-left" style="font-size: 14px;">
												<?// if ($step1->processing_time == "Holiday" || !empty($step1->full_package)) { ?>
													<i class="stamping_fee_included">(<a target="_blank" title="stamping fee" href="<?//=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
												<?// } else { ?>
													<i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?//=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> is included)</i>
												<?// } ?>
												</div> -->
											</li>
										</ul>
									</div>
									<div class="payment-methods">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-american-express.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-mastercard.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-paypal.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-visa.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-UnionPay.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-JCB.png">
										<img alt="" src="<?=IMG_URL?>/payment-icon/icon-payment-discover.png">
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" id="task" name="task" value=""/>
					</form>
				</div>
				<!-- <br>
				<div class="row">
					<div class="col-xs-4">
						<div class="text-center">
							<a><img alt="" src="<?=IMG_URL?>comodossl.png"></a>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="text-center">
							<a><img alt="" src="<?=IMG_URL?>siteadvisor.gif"></a>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="text-center">
							<a><img alt="" src="<?=IMG_URL?>https.png"></a>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>

