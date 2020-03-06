<? $nations = $this->m_nation->nation_jion_visa_fee();?>
<script type="text/javascript" src="<?=JS_URL?>apply.visa.step2.js"></script>

<div class="banner-top applyform-banner" style="background: url('<?=IMG_URL?>new-template/ApplyVisaForm-banner.png') no-repeat scroll top center transparent;">
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-content">
					<h1>APPLY <span class="border-text" style="padding: 20px 20px 0px 10px;"> VISA</span></h1>
					<div class="alternative-breadcrumb">
					<!-- <? require_once(APPPATH."views/module/breadcrumb.php"); ?> -->
					</div>
					<ul>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Safety and reliable procedure</li>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Professional staffs</li>
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
<div class="applyform-heading">
	<div class="container">
		<!-- breadcrumb -->
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	<!-- end breadcrumb -->
		<h2 class="home-heading text-center" style="text-shadow: 3px 3px #bdbdbd;">Vietnam Visa Application Form</h2>
	</div>
</div>
<div class="applyform-content cluster-content">
	<div class="container">
			<div class="step-apply ">
				<div class="step">
					<div class="line-right"></div>
					<span class="step-number">1</span>
				</div>
				<div class="step">
					<div class="line-right"></div>
					<div class="line-left"></div>
					<span class="step-number">2</span>
				</div>
				<div class="step">
					<div class="line-right"></div>
					<div class="line-left"></div>
					<span class="step-number active">3</span>
				</div>
				<div class="step">
					<div class="line-left"></div>
					<span class="step-number">4</span>
				</div>
			</div>
			<div class="step-apl-content">
				<div class="bystep">Visa Option</div>
				<div class="bystep">Account Login</div>
				<div class="bystep active">Application Details</div>
				<div class="bystep">Review & Payment</div>
			</div>

			<div class="applyform step2">
				<form id="frmApply" class="form-horizontal" role="form" action="<?=BASE_URL_HTTPS."/apply-visa/step3.html"?>" method="POST">
					<input type="hidden" id="visa_type" name="visa_type" value="<?=$step1->visa_type?>">
					<input type="hidden" id="group_size" name="group_size" value="<?=$step1->group_size?>">
					<input type="hidden" id="arrival_port" name="arrival_port" value="<?=$step1->arrival_port?>">
					<input type="hidden" id="visit_purpose" name="visit_purpose" value="<?=$step1->visit_purpose?>">
					<input type="hidden" id="processing_time" name="processing_time" value="<?=$step1->processing_time?>">
					<input type="hidden" id="private_visa" name="private_visa" value="<?=$step1->private_visa?>">
					<input type="hidden" id="full_package" name="full_package" value="<?=$step1->full_package?>">
					<input type="hidden" id="fast_checkin" name="fast_checkin" value="<?=$step1->fast_checkin?>">
					<input type="hidden" id="car_pickup" name="car_pickup" value="<?=$step1->car_pickup?>">
					<input type="hidden" id="car_type" name="car_type" value="<?=$step1->car_type?>">
					<input type="hidden" id="num_seat" name="num_seat" value="<?=$step1->num_seat?>">
					<input type="hidden" id="discount" name="discount" value="<?=$step1->discount?>">
					<input type="hidden" id="discount_unit" name="discount_unit" value="<?=$step1->discount_unit?>">
					<div class="row clearfix">
						<div class="col-lg-8 col-sm-8">
							<div class="panel-options">
								<div class="group passport-information">
								<h2>Passport Information</h2>
								<div class="group-content">
									<? for ($cnt=1; $cnt<=$step1->group_size; $cnt++) { ?>
									<div class="row form-group passport-detail">
										<div class="col-sm-3">
											<label class="form-label">#<?=$cnt?>. Full name<span class="required">*</span></label>
											<div>
												<input type="text" id="fullname_<?=$cnt?>" name="fullname_<?=$cnt?>" class="form-control fullname_<?=$cnt?>" value="<?=!empty($step1->fullname[$cnt]) ? $step1->fullname[$cnt] : ''?>" />
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
												<!-- <select id="nationality_<?//=$cnt?>" name="nationality_<?//=$cnt?>" class="form-control nationality nationality_<?//=$cnt?>">
													<option value="" selected="selected">Nationality</option>
													<?// foreach ($is as $key => $value) { ?>
													<option value="<?//=$step1->nationality[$cnt]?>" selected="selected"><?//=$step1->nationality[$cnt]?></option>
													<?// } ?>
												</select> -->
												<div>
													<select id="nationality_<?=$cnt?>" name="nationality_<?=$cnt?>" class="form-control nationality nationality_<?=$cnt?>">
														<option value="">Select...</option>
														<?
															$arrival_port = $this->m_arrival_port->load($step1->arrival_port);
															$limit_todate = mktime(0, 0, 0, 4, 26, 2017);
															$entry_date = mktime(0, 0, 0, $step1->arrivalmonth, $step1->arrivaldate, $step1->arrivalyear);
															foreach ($nations as $nation) {
																if (($arrival_port->code == "SGN") && in_array(strtoupper($nation->name), array("AUSTRALIA", "NEW ZEALAND")) && ($entry_date < $limit_todate)) {
																	continue;
																}
																$types_of_tourist = $this->m_visa_fee->types_of_tourist($nation->id);
																$types_of_business = $this->m_visa_fee->types_of_business($nation->id);
																if (empty($types_of_tourist) && empty($types_of_business)) {
																	continue;
																}
																if ($step1->visit_purpose == "For business" && in_array($step1->visa_type, $types_of_business)) {
																	echo '<option value="'.$nation->name.'" document_required="'.$nation->document_required.'">'.$nation->name.'</option>';
																} else if ($step1->visit_purpose != "For business" && in_array($step1->visa_type, $types_of_tourist)) {
																	echo '<option value="'.$nation->name.'" document_required="'.$nation->document_required.'">'.$nation->name.'</option>';
																}
															}
														?>
													</select>
													<script> $("#nationality_<?=$cnt?>").val("<?=$step1->nationality[$cnt]?>"); </script>
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<label class="form-label">Passport number<span class="required">*</span></label>
											<div>
												<input type="text" id="passportnumber_<?=$cnt?>" name="passportnumber_<?=$cnt?>" class="form-control passportnumber_<?=$cnt?>" value="<?=!empty($step1->passportnumber[$cnt]) ? $step1->passportnumber[$cnt] : ''?>" />
											</div>
										</div>
									</div>
									<? } ?>
									<div class="processing-note">
										<strong>Tips:</strong>
										<ul>
											<li>Please fill in your passport informtion in the application form correctly as in your passport data page.</li>
											<li>Your passport must be valid at least 6 months upon arrival to Vietnam. Otherwise, we can’t help you to get visa</li>
											<?if($step1->processing_time=="Holiday" || $step1->processing_time=="Emergency") { ?>
											<li>Please follow your email after making payment to ensure you will get visa approval letter on time.  Any problems in hurry, please call us at <span class="red"><?=HOTLINE?></span></li>
											<?}?>
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
										<div class="row form-group">
											<label class="form-label col-sm-3 col-xs-4 text-right">
												<strong>Flight number <span class="required">*</span></strong>
											</label>
											<div class="col-sm-2 col-xs-8">
												<input type="text" id="flightnumber" name="flightnumber" class="form-control flightnumber" value="<?=$step1->flightnumber?>"/>
											</div>
										</div>
										<div class="row form-group">
											<label class="form-label col-sm-3 col-xs-4 text-right">
												<strong>Arrival time <span class="required">*</span></strong>
											</label>
											<div class="col-sm-2 col-xs-8">
												<input type="text" id="arrivaltime" name="arrivaltime" class="form-control arrivaltime" value="<?=$step1->arrivaltime?>"/>
												<span class="help-block">(ie. 08:30 PM)</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<? if (!empty($step1->car_pickup)) { $car_plus_fees = $this->m_car_plus_fee->items();?>
							<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_MAPS_KEY?>&libraries=places"></script>
							<div class="group" id="flightinfo">
								<h2>Car pick-up Information</h2>
								<div class="group-content">
									<p>Please fill out the flight information that we can pick you up on time at the airport.</p>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<label class="input-group-text" for="inputGroupSelect01">Airport</label>
												</div>
												<select class="custom-select" id="inputGroupSelect01">
													<option value="" selected="selected">Please select...</option>
													<? foreach ($car_plus_fees as $car_plus_fee) { ?>
													<option value="<?=$car_plus_fee->port?>" name-item="<?=$car_plus_fee->airport?>"><?=$car_plus_fee->airport?></option>
													<? } ?>
												</select>
												<script type="text/javascript">
													$('.custom-select').val('<?=$step1->arrival_port?>');
												</script>
											</div>
										</div>
										<div class="col-md-6">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroup-sizing-default">Destination</span>
												</div>
												<input type="text" id="destination" class="form-control" value="<?=$step1->car_destination?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
											</div>
										</div>
									</div>
									<p class="cnt-car-plus-fee" <?=empty($step1->car_plus_fee) ? 'style="display: none;"' : ''?>>Your distance <strong class="total-distance"><?=$step1->car_distance?>km</strong> <span class="text-color-red">(<strong class="distance-fee"><?=$step1->car_total_fee?>$</strong> for cover <strong class="distance"><?=$step1->car_distance_default?>km</strong>)</span>. You have to pay an additional <strong class="car-plus-fee text-color-red"><?=$step1->car_plus_fee?>$</strong> for the remaining <strong class="distance-plus"><?=$step1->car_distance-$step1->car_distance_default?>km</strong>.</p>
								</div>
							</div>
							<script type="text/javascript">
								$(function () {
									google.maps.event.addDomListener(window, 'load', function () { });
									function calculateDistance() {
										var service = new google.maps.DistanceMatrixService();
										service.getDistanceMatrix({
											origins: [$('option:selected', '.custom-select').attr('name-item')],
											destinations: [$('#destination').val()],
											travelMode: google.maps.TravelMode.DRIVING,
											unitSystem: google.maps.UnitSystem.IMPERIAL,
											avoidHighways: false,
											avoidTolls: false,
										}, callback);
									}
									function callback(response, status) {
										if ($('.custom-select').val() != '' && $('#destination').val() != ''){
											var p = {};
											p['distance'] = response.rows[0].elements[0].distance.value;
											p['port_id'] = $('.custom-select').val();
											p['destination'] = $('#destination').val();
											$.ajax({
												url: '<?=site_url("apply-visa/ajax-call-car-plus-fees")?>',
												type: 'POST',
												dataType: 'json',
												data: p,
												success: function (res) {
													if (res === undefined || res.length == 0) {
														$('.cnt-car-plus-fee').css('display', 'none');
														$('.review-car-plus-fee').css('display', 'none');
														$('.total_price').html($('#total_fee').val());
													} else {
														var total_visa_fee = parseFloat($('#total_fee').val());
														$('.distance').html(res[0].distance+'km');
														$('.total-distance').html(res[2]+'km');
														$('.car-plus-fee').html(res[1]+'$');
														$('.distance-plus').html((res[2]-res[0].distance).toFixed(2)+'km');
														$('.review-car-plus-fee > span').html('+ ('+(res[2]-res[0].distance).toFixed(2)+'km) '+' = '+res[1]+' $');
														$('.total_price').html(total_visa_fee+res[1]+' $');

														$('.cnt-car-plus-fee').css('display', 'block');
														$('.review-car-plus-fee').css('display', 'block');
													}
												}
											});
										} else {
											updatePanel();
											$('.review-car-plus-fee > span').html('');
											$('.cnt-car-plus-fee').css('display', 'none');
											$('.review-car-plus-fee').css('display', 'none');
										}
									}
									function initialize() {
										var input = document.getElementById('destination');
										var autocomplete = new google.maps.places.Autocomplete(input);
										google.maps.event.addListener(autocomplete, 'place_changed', function () {
											calculateDistance();
										});
									}
									google.maps.event.addDomListener(window, 'load', initialize);
									$('.custom-select').change(function(event) {
										if ($('#destination').val() != ''){
											calculateDistance();
										} else {
											updatePanel();
										}
									});
								});
							</script>
							<? } ?>
							<div class="group">
								<h2>Contact Information</h2>
								<div class="group-content">
									<div class="form-group row">
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
									<div class="form-group row">
										<label class="form-label col-sm-3 text-right">
											Email <span class="required">*</span>
										</label>
										<div class="col-sm-9">
											<input type="text" id="contact_email" name="contact_email" class="form-control" value="<?=$step1->contact_email?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="form-label col-sm-3 text-right">
											Alternate email
										</label>
										<div class="col-sm-9">
											<input type="text" id="contact_email2" name="contact_email2" class="form-control" value="<?=$step1->contact_email2?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="form-label col-sm-3 text-right">
											Phone number
										</label>
										<div class="col-sm-9">
											<input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?=$step1->contact_phone?>">
										</div>
									</div>
									<div class="form-group row">
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
										<div class="show-button m-4 d-inline-block">
											<a class="btn btn-danger" onclick="window.location='<?=BASE_URL_HTTPS."/apply-visa/step1.html"?>'"><i class="fa fa-angle-left" aria-hidden="true"></i> BACK </a>
										</div>
										<div class="show-button m-4 d-inline-block">
											<a class="btn btn-danger btn-next" >NEXT STEP &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="col-lg-4 col-sm-4">
							<div class="panel-fees">
								<ul>
									<!-- <li class="clearfix">
										<label>Passport holder:</label>
										<span class="passport_holder_t"><?=$step1->passport_holder?></span>
									</li> -->
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
										<span class="total_visa_price_t price pointer" data-toggle="collapse" id="cal-service-fee-detail" data-target="#service-fee-detail" stt="0"><?=$step1->service_fee*$step1->group_size?> $ <i class="fa fa-chevron-circle-down"></i></span>
										<div id="service-fee-detail" class="service-fee-detail text-right collapse">
											<span class="total_visa_price price"><?=$step1->service_fee." $ x ".$step1->group_size." ".($step1->group_size>1?"people":"person")." = ".$step1->service_fee*$step1->group_size?> $</span>
										</div>
									</li>
									<li class="clearfix" id="processing_time_li" style="display: <?=(($step1->processing_time != 'Normal')?'block':'none')?>">
										<div class="clearfix">
											<label>Processing time:</label>
											<span class="processing_note_t"><?=$step1->processing_time?></span>
										</div>
										<span class="processing_t price"><?=$step1->rush_fee." $ x ".$step1->group_size." application".($step1->group_size>1?"s":"")." = ".$step1->rush_fee*$step1->group_size?> $</span>
									</li>
									<li class="clearfix" id="private_visa_li" style="display: <?=(!empty($step1->private_visa)?'block':'none')?>">
										<label>Private letter:</label>
										<span class="private_visa_t price"><?=$step1->private_visa_fee?> $</span>
									</li>
									<li class="clearfix" id="full_package_li" style="display: <?=(!empty($step1->full_package)?'block':'none')?>">
										<label>Full package service:</label>
										<div class="full_package_services">
											<div><label>1. Visa stamping fee</label><span class='price'><?=$step1->stamp_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->stamp_fee*$step1->group_size?> $</span></div>
											<div><label>2. Airport fast check-in</label><span class='price'><?=$step1->full_package_fc_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->full_package_fc_fee*$step1->group_size?> $</span></div>
										</div>
									</li>
									<li class="clearfix" id="extra_service_li" style="display: <?=(($step1->fast_checkin||$step1->car_pickup)?'block':'none')?>">
										<label>Extra services:</label>
										<div class="extra_services">
											<?
												$serviceCnt = 1;
												if ($step1->fast_checkin==1) {
											?>
												<div><label><?=($serviceCnt++)?>. Airport fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> $</span></div>
											<?
												}
												if ($step1->fast_checkin==2) {
											?>
												<div><label><?=($serviceCnt++)?>. VIP fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> $</span></div>
											<?	
												}
												if ($step1->car_pickup) {
											?>
												<div><label><?=($serviceCnt++)?>. Car pick-up</label><span class='price'>(<?=$step1->car_type?>, <?=$step1->num_seat?> seats) = <?=$step1->car_total_fee?> $</span></div>
											<?
												}
											?>
										</div>
										<div class="review-car-plus-fee" <?=empty($step1->car_plus_fee) ? 'style="display: none;"' : ''?>><span class='price'>+ (<?=$step1->car_distance-$step1->car_distance_default?>km) = <?=$step1->car_plus_fee?> $</span></div>
									</li>
									<li class="clearfix" id="vipsave_li" style="display: <?=(!empty($step1->vip_discount)?'block':'none')?>">
										<label>VIP discount:</label>
										<span class="vipsave_t price">- <?=round($step1->total_service_fee * $step1->vip_discount/100)?> $</span>
									</li>
									<li class="clearfix" id="promotion_li" style="background-color: #F8F8F8; display: <?=(!empty($step1->discount)?'block':'none')?>">
										<div class="clearfix" id="promotion_box_succed" style="display: <?=(!empty($step1->discount) || !empty($step1->member_discount))?'block':'none'?>">
											<label class="left">Promotion discount:</label>
											<!--<span class="promotion_t price">- <?=(($step1->discount_unit == "USD") ? $step1->discount : round($step1->total_service_fee * $step1->discount/100))?> $</span>-->
											<span class="promotion_t price">- <?=(($step1->discount_unit == "USD") ? $step1->discount : $step1->total_service_fee * $step1->discount/100)?> $</span>
										</div>
									</li>
									<li class="total clearfix">
										<div class="left_edge"></div>
										<div class="right_edge"></div>
										<div class="clearfix">
											<label class="total_fee pull-left">Total fee:</label>
											<div class="pull-right subtotal-price">
												<div class="price-block">
													<span class="price total_price"><?=$step1->total_fee?> $</span>
													<input type="hidden" id="total_fee" value="<?=$step1->total_fee?>">
												</div>
											</div>
										</div>
										<div class="stamping_fee_note text-left">
											<? if (!empty($step1->full_package)) { ?>
											<i class="">(<a target="_blank" title="stamping fee" href="<?=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
											<? } else { ?>
											<i class="">(<a target="_blank" title="stamping fee" href="<?=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i>
											<? } ?>
										</div>
									</li>
								</ul>
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
	</div>
</div>

<div class="modal fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background: #ED1C24; color:#fff">
				<h4 class="modal-title">About Vietnam visa for <span class="nation-document">BANGLADESH</span> nationality</h4>
			</div>
			<div class="modal-body">
				<h3>VIETNAM VISA FOR <span class="nation-document">BANGLADESH</span> NATIONALITY</h3>
				<p>We are informed that your nationality is categorized as the special nation on the list of the Vietnam Immigration Department.</p>
				<p>In order to process your visa, please contact us via email address <a href="mailto:visa@vietnam-visa.org.vn">visa@vietnam-visa.org.vn</a> and supply us your:</p>
				<ul>
					<li>Passport scan (personal information page)</li>
					<li>Flight ticket</li>
					<li>Hotel booking or staying address in Vietnam</li>
				</ul>
				<p>The Vietnam Immigration Department will check your status within 2 days. Then we will inform the result for you. If your visa application is approved, we will send you the notification including the visa letter.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
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