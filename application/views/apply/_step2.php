<script type="text/javascript" src="<?=JS_URL?>apply.visa.step2.js"></script>

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
				<li><font class="number">4.</font> Review &amp; Payment</li>
			</ul>
		</div>
		<div class="applyform step2">
			<form id="frmApply" class="form-horizontal" role="form" action="<?=BASE_URL_HTTPS."/apply-visa/step3.html"?>" method="POST">
				<input type="hidden" id="visa_type" name="visa_type" value="<?=$step1->visa_type?>">
				<input type="hidden" id="group_size" name="group_size" value="<?=$step1->group_size?>">
				<input type="hidden" id="arrival_port" name="arrival_port" value="<?=$step1->arrival_port?>">
				<input type="hidden" id="visit_purpose" name="visit_purpose" value="<?=$step1->visit_purpose?>">
				<input type="hidden" id="processing_time" name="processing_time" value="<?=$step1->processing_time?>">
				<div class="row clearfix">
					<div class="col-lg-9 col-sm-8">
						<div class="group passport-information">
							<h2>Passport Information</h2>
							<div class="group-content">
								<? for ($cnt=1; $cnt<=$step1->group_size; $cnt++) { ?>
								<div class="form-group passport-detail">
									<div class="col-sm-3">
										<label class="form-label">#<?=$cnt?>. Full name<span class="required">*</span></label>
										<div>
											<input type="text" id="fullname_<?=$cnt?>" name="fullname_<?=$cnt?>" class="form-control fullname_<?=$cnt?>" value="<?=$step1->fullname[$cnt]?>" />
										</div>
									</div>
									<div class="col-sm-1">
										<label class="form-label">Gender<span class="required">*</span></label>
										<div>
											<select id="gender_<?=$cnt?>" name="gender_<?=$cnt?>" class="form-control gender_<?=$cnt?>">
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
											<script> $("#gender_<?=$cnt?>").val("<?=$step1->gender[$cnt]?>"); </script>
										</div>
									</div>
									<div class="col-sm-3">
										<label class="form-label">Birth date<span class="required">*</span></label>
										<div class="row row-sm">
											<div class="col-sm-4 col-xs-4">
												<select id="birthmonth_<?=$cnt?>" name="birthmonth_<?=$cnt?>" class="form-control birthmonth_<?=$cnt?>">
													<option value="">--</option>
													<? for ($m=1; $m<=12; $m++) { ?>
													<option value="<?=$m?>"><?=date('M', mktime(0, 0, 0, $m, 10))?></option>
													<? } ?>
												</select>
												<script> $("#birthmonth_<?=$cnt?>").val("<?=$step1->birthmonth[$cnt]?>"); </script>
											</div>
											<div class="col-sm-4 col-xs-4">
												<select id="birthdate_<?=$cnt?>" name="birthdate_<?=$cnt?>" class="form-control birthdate_<?=$cnt?>">
													<option value="">--</option>
													<? for ($d=1; $d<=31; $d++) { ?>
													<option value="<?=$d?>"><?=$d?></option>
													<? } ?>
												</select>
												<script> $("#birthdate_<?=$cnt?>").val("<?=$step1->birthdate[$cnt]?>"); </script>
											</div>
											<div class="col-sm-4 col-xs-4">
												<select id="birthyear_<?=$cnt?>" name="birthyear_<?=$cnt?>" class="form-control birthyear_<?=$cnt?>">
													<option value="">----</option>
													<? for ($y=1910; $y<=date("Y"); $y++) { ?>
													<option value="<?=$y?>"><?=$y?></option>
													<? } ?>
												</select>
												<script> $("#birthyear_<?=$cnt?>").val("<?=$step1->birthyear[$cnt]?>"); </script>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<label class="form-label">Nationality<span class="required">*</span></label>
										<div>
											<select id="nationality_<?=$cnt?>" name="nationality_<?=$cnt?>" class="form-control nationality nationality_<?=$cnt?>">
												<option value="<?=$step1->nationality[$cnt]?>" selected="selected"><?=$step1->nationality[$cnt]?></option>
											</select>
										</div>
									</div>
									<div class="col-sm-2">
										<label class="form-label">Passport number<span class="required">*</span></label>
										<div>
											<input type="text" id="passportnumber_<?=$cnt?>" name="passportnumber_<?=$cnt?>" class="form-control passportnumber_<?=$cnt?>" value="<?=$step1->passportnumber[$cnt]?>" />
										</div>
									</div>
								</div>
								<? } ?>
								<div class="processing-note">
									<strong>Tips:</strong>
									<ul>
										<li>The exact information includes full name, date of birth, passport number and nationality as your passport details.</li>
										<li>Passport expiration date must has at least 6 months validity when arriving to Vietnam.</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="group" id="flightinfo">
							<h2>Flight Information</h2>
							<div class="group-content">
								<p>Please fill out the flight information that we can pick you up on time at the airport.</p>
								<p>
									<div class="radio">
										<label for="flight_notbooked"><input type="radio" id="flight_notbooked" name="flight_booking" class="flight_booking" value="0" <?=(($step1->flight_booking == 0) ? 'checked="checked"' : "")?> /> I have not booked yet</label>
									</div>
								</p>
								<p>
									<div class="radio">
										<label for="flight_booked"><input type="radio" id="flight_booked" name="flight_booking" class="flight_booking" value="1" <?=(($step1->flight_booking == 1) ? 'checked="checked"' : "")?> /> I have booked (Recommended)</label>
									</div>
								</p>
								<div class="flight_table" name="flight_table" id="flight_table" style="<?=(($step1->flight_booking == 1) ? 'display:block' : 'display:none')?>">
									<div class="form-group">
										<label class="form-label col-sm-3 col-xs-4 text-right">
											Flight number <span class="required">*</span>
										</label>
										<div class="col-sm-2 col-xs-8">
											<input type="text" id="flightnumber" name="flightnumber" class="form-control flightnumber" value="<?=$step1->flightnumber?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="form-label col-sm-3 col-xs-4 text-right">
											Arrival time <span class="required">*</span>
										</label>
										<div class="col-sm-2 col-xs-8">
											<input type="text" id="arrivaltime" name="arrivaltime" class="form-control arrivaltime" value="<?=$step1->arrivaltime?>"/>
											<span class="help-block">(ie. 08:30 PM)</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="group">
							<h2>Contact Information</h2>
							<div class="group-content">
								<div class="form-group">
									<label class="form-label col-sm-3 text-right">
										Full name <span class="required">*</span>
									</label>
									<div class="col-sm-9">
										<div class="row">
											<div class="col-xs-4 col-sm-4 col-md-4">
												<select id="contact_title" name="contact_title" class="form-control">
													<option value="Mr" selected="selected">Mr</option>
													<option value="Ms">Ms</option>
													<option value="Mrs">Mrs</option>
												</select>
												<script> $("#contact_title").val('<?=(!empty($step1->contact_title)?$step1->contact_title:"Mr")?>'); </script>
											</div>
											<div class="col-xs-8 col-sm-8 col-md-8" style="padding-left: 0">
												<input type="text" id="contact_fullname" name="contact_fullname" class="form-control" value="<?=$step1->contact_fullname?>" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label col-sm-3 text-right">
										Email <span class="required">*</span>
									</label>
									<div class="col-sm-9">
										<input type="text" id="contact_email" name="contact_email" class="form-control" value="<?=$step1->contact_email?>">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label col-sm-3 text-right">
										Alternate email
									</label>
									<div class="col-sm-9">
										<input type="text" id="contact_email2" name="contact_email2" class="form-control" value="<?=$step1->contact_email2?>">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label col-sm-3 text-right">
										Phone number
									</label>
									<div class="col-sm-9">
										<input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?=$step1->contact_phone?>">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label col-sm-3 text-right">
										Leave a message
									</label>
									<div class="col-sm-9">
										<textarea id="comment" name="comment" class="form-control" rows="5"><?=$step1->comment?></textarea>
										<div class="checkbox">
											<label for="information_confirm"><input type="checkbox" id="information_confirm" name="information_confirm" checked="checked"> I would like to confirm the above information is correct.</label>
										</div>
										<div class="checkbox">
											<label for="terms_conditions_confirm"><input type="checkbox" id="terms_conditions_confirm" name="terms_conditions_confirm" checked="checked"> I have read and agreed <a title="Terms and Condition" class="terms_conditions_confirm" target="_blank" href="<?=site_url("terms-and-conditions")?>">Terms and Condition</a>.</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="group">
							<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
								<div class="text-center">
									<button class="btn btn-danger btn_back" type="button" onclick="window.location='<?=BASE_URL_HTTPS."/apply-visa/step1.html"?>'"><i class="icon-double-angle-left icon-large"></i> BACK</button>
									<button class="btn btn-danger btn_next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-4">
						<div class="panel-fees">
							<ul>
								<li class="clearfix">
									<label>Passport holder:</label>
									<span class="passport_holder_t"><?=$step1->passport_holder?></span>
								</li>
								<li class="clearfix">
									<label>Number of visa:</label>
									<span class="group_size_t"><?=$step1->group_size?> Applicant<?=($step1->group_size>1?"s":"")?></span>
								</li>
								<li class="clearfix">
									<label>Type of visa:</label>
									<span class="visa_type_t"><?=$this->m_visa_type->load($step1->visa_type)->name?></span>
								</li>
								<li class="clearfix">
									<label>Purpose of visit:</label>
									<span class="visit_purpose_t"><?=$step1->visit_purpose?></span>
								</li>
								<li class="clearfix">
									<label>Arrival airport:</label>
									<span class="arrival_port_t"><?=$this->m_arrival_port->load($step1->arrival_port)->airport?></span>
								</li>
								<li class="clearfix">
									<label>Arrival date:</label>
									<span class="arrival_date_t"><?=date("M/d/Y", strtotime($step1->arrivalmonth."/".$step1->arrivaldate."/".$step1->arrivalyear))?></span>
								</li>
								<li class="clearfix">
									<label>Visa service fee:</label>
									<span class="total_visa_price price"><?=$step1->service_fee." USD x ".$step1->group_size." application".($step1->group_size>1?"s":"")." = ".$step1->service_fee*$step1->group_size?> USD</span>
								</li>
								<li class="clearfix" id="processing_time_li" style="display: <?=(($step1->processing_time != 'Normal')?'block':'none')?>">
									<div class="clearfix">
										<label>Processing time:</label>
										<span class="processing_note_t"><?=$step1->processing_time?></span>
									</div>
									<span class="processing_t price"><?=$step1->rush_fee." USD x ".$step1->group_size." application".($step1->group_size>1?"s":"")." = ".$step1->rush_fee*$step1->group_size?> USD</span>
								</li>
								<li class="clearfix" id="private_visa_li" style="display: <?=(!empty($step1->private_visa)?'block':'none')?>">
									<label>Private letter:</label>
									<span class="private_visa_t price"><?=$step1->private_visa_fee?> USD</span>
								</li>
								<li class="clearfix" id="full_package_li" style="display: <?=(!empty($step1->full_package)?'block':'none')?>">
									<label>Full package service:</label>
									<div class="full_package_services">
										<div><label>1. Visa stamping fee</label><span class='price'><?=$step1->stamp_fee?> USD x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->stamp_fee*$step1->group_size?> USD</span></div>
										<div><label>2. Airport fast check-in</label><span class='price'><?=$step1->full_package_fc_fee?> USD x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->full_package_fc_fee*$step1->group_size?> USD</span></div>
									</div>
								</li>
								<li class="clearfix" id="extra_service_li" style="display: <?=(($step1->fast_checkin||$step1->car_pickup)?'block':'none')?>">
									<label>Extra services:</label>
									<div class="extra_services">
										<?
											$serviceCnt = 1;
											if ($step1->fast_checkin==1) {
										?>
											<div><label><?=($serviceCnt++)?>. Airport fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> USD x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> USD</span></div>
										<?
											}
											if ($step1->fast_checkin==2) {
										?>
											<div><label><?=($serviceCnt++)?>. VIP fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> USD x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> USD</span></div>
										<?	
											}
											if ($step1->car_pickup) {
										?>
											<div><label><?=($serviceCnt++)?>. Car pick-up</label><span class='price'>(<?=$step1->car_type?>, <?=$step1->num_seat?> seats) = <?=$step1->car_total_fee?> USD</span></div>
										<?
											}
										?>
									</div>
								</li>
								<li class="clearfix" id="vipsave_li" style="display: <?=(!empty($step1->vip_discount)?'block':'none')?>">
									<label>VIP discount <span class="vipsavepercent_t"><?=$step1->vip_discount?>%</span></label>
									<span class="vipsave_t price">- <?=round($step1->total_service_fee * $step1->vip_discount/100)?> USD</span>
								</li>
								<li class="clearfix" id="visa_service_save_li" style="display: <?=(!empty($step1->service_fee_discount)?'block':'none')?>">
									<label>Visa fee discount <span class="visa_service_save_percent_t"><?=$step1->service_fee_discount?>%</span></label>
									<span class="visa_fee_save_t price">- <?=round($step1->total_service_fee * $step1->service_fee_discount/100)?> USD</span>
								</li>
								<li class="clearfix" id="promotion_li" style="background-color: #F8F8F8; display: <?=(!empty($step1->discount)?'block':'none')?>">
									<div class="clearfix" id="promotion_box_succed" style="display: <?=(!empty($step1->discount)?'block':'none')?>">
										<label class="left">Promotion discount <span class="promotionpercent_t" value="<?=$step1->discount?>">(<?=$step1->discount?>%)</span></label>
										<span class="promotion_t price">- <?=round($step1->total_service_fee * $step1->discount/100)?> USD</span>
									</div>
								</li>
								<li class="total clearfix">
									<div class="clearfix">
										<label>TOTAL FEE:</label>
										<span class="total_price"><?=$step1->total_fee?> USD</span>
									</div>
									<div class="text-right">
									<? if ($step1->processing_time == "Holiday" || !empty($step1->full_package)) { ?>
										<i class="stamping_fee_included">(<a target="_blank" title="stamping fee" href="<?=site_url("visa-fee")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
									<? } else { ?>
										<i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?=site_url("visa-fee")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i>
									<? } ?>
									</div>
								</li>
							</ul>
							<div class="payment-methods">
								<img alt="" src="<?=IMG_URL?>payment-methods.jpg">
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="entry_page" name="entry_page" value="<?=$step1->entry_page?>"/>
				<input type="hidden" id="task" name="task" value=""/>
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