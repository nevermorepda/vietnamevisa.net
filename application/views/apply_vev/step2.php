<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
	$country_name = $loc->lookup($this->util->realIP(), IP2Location::COUNTRY_NAME);
	$nations = $this->m_nation->nation_jion_visa_fee();
?>

<script type="text/javascript" src="<?=JS_URL?>e-visa-step2.js"></script>
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

	<div class="visa-form">
		<div class="applyform-content cluster-content">
			<div class="container">
			<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
				<div class="">
					<div class="">
						<!-- <div class="tab-step clearfix">
							<h1 class="note">Vietnam E-Visa Application Form</h1>
							<ul class="style-step d-none d-sm-none d-md-block">
								<li class="active"><a style="color: #fff;" href="<?=site_url('apply-e-visa')?>"><font class="number">1.</font> Visa Options</a></li>
								<li class="active"><font class="number">2.</font> Login Account</li>
								<li class="active"><font class="number">3.</font> Applicant Details</li>
								<li><font class="number">4.</font> Review & Payment</li>
							</ul>
						</div> -->
						<h2 class="home-sub-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Vietnam Visa Application Form</h2>
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
							<div class="step">
								<div class="line-step line-step4">
									<span class="step-number"></span>
								</div>
								Review & Payment
							</div>
						</div>
						<div class="applyform step2">
							<form id="frmApply" class="form-horizontal" role="form" action="<?=site_url("apply-e-visa/step3")?>" method="POST" enctype="multipart/form-data">
								<input type="hidden" id="visa_type" name="visa_type" value="<?=$step1->visa_type?>">
								<input type="hidden" id="group_size" name="group_size" value="<?=$step1->group_size?>">
								<input type="hidden" id="arrival_port" name="arrival_port" value="<?=$step1->arrival_port?>">
								<input type="hidden" id="visit_purpose" name="visit_purpose" value="<?=$step1->visit_purpose?>">
								<input type="hidden" id="processing_time" name="processing_time" value="<?=$step1->processing_time?>">
								<input type="hidden" id="private_visa" name="private_visa" value="<?=$step1->private_visa?>">
								<input type="hidden" id="full_package" name="full_package" value="<?=$step1->full_package?>">
								<input type="hidden" id="fast_checkin" name="fast_checkin" value="<?=$step1->fast_checkin?>">
								<input type="hidden" id="car_pickup" name="car_pickup" value="<?=$step1->car_pickup?>">
								<input type="hidden" id="car_type" name="car_type" value="<?//=$step1->car_type?>">
								<input type="hidden" id="num_seat" name="num_seat" value="<?//=$step1->num_seat?>">
								<input type="hidden" id="discount" name="discount" value="<?=$step1->discount?>">
								<input type="hidden" id="discount_unit" name="discount_unit" value="<?=$step1->discount_unit?>">
								<div class="row clearfix">
									<div class="col-lg-9 col-sm-9">
										<div class="group passport-information">
											<h2 class="group-heading">Passport Information</h2>
											<div class="group-content">
												<p class="help-block" style="margin-top:0;">All the passport validation must be at least 6 months from travel date. We are not response if your passport expires or less than 6 months from travel date.</p>
												<? for ($cnt=1; $cnt<=$step1->group_size; $cnt++) { ?>
												<div class="form-group row passport-detail" style="margin-bottom: 0px;">
													<div class="col-sm-5 padding-left-col">
														<label class="form-label">#<?=$cnt?>. Full name<span class="required">*</span></label>
														<div>
															<input type="text" id="fullname_<?=$cnt?>" name="fullname_<?=$cnt?>" class="form-control fullname_<?=$cnt?>" value="<?=$step1->fullname[$cnt]?>" />
														</div>
													</div>
													<div class="col-sm-2">
														<label class="form-label">Gender<span class="required">*</span></label>
														<div>
															<select id="gender_<?=$cnt?>" name="gender_<?=$cnt?>" class="form-control gender_<?=$cnt?>">
																<option value="">----</option>
																<option value="Male">Male</option>
																<option value="Female">Female</option>
															</select>
															<script> $("#gender_<?=$cnt?>").val("<?=$step1->gender[$cnt]?>"); </script>
														</div>
													</div>
													<div class="col-sm-5">
														<label class="form-label">Birth date<span class="required">*</span></label>
														<div class="row row-sm">
															<div class="col-sm-4 col-xs-4">
																<select id="birthyear_<?=$cnt?>" name="birthyear_<?=$cnt?>" class="form-control birthyear_<?=$cnt?> birthdate" applicant-num="<?=$cnt?>">
																	<option value="">----</option>
																	<? for ($y=(date("Y") - 100); $y<=date("Y"); $y++) { ?>
																	<option value="<?=$y?>"><?=$y?></option>
																	<? } ?>
																</select>
																<script> $("#birthyear_<?=$cnt?>").val("<?=$step1->birthyear[$cnt]?>"); </script>
															</div>
															<div class="col-sm-4 col-xs-4">
																<select id="birthmonth_<?=$cnt?>" name="birthmonth_<?=$cnt?>" class="form-control birthmonth_<?=$cnt?> birthdate" applicant-num="<?=$cnt?>">
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
														</div>
													</div>
												</div>

												<div class="form-group row passport-detail" style="margin-bottom: 0px;">
													<!-- <div class="col-sm-3 padding-left-col">
														<label class="form-label">Type<span class="required">*</span></label>
														<div>
															<select id="passport_type_<?=$cnt?>" name="passport_type_<?=$cnt?>" class="form-control nationality passport_type_<?=$cnt?>">
																<option value="Diplomatic passport">Diplomatic passport</option>
																<option value="Official passport">Official passport</option>
																<option value="Ordinary passport">Ordinary passport</option>
															</select>
														</div>
													</div> -->
													<div class="col-sm-4">
														<label class="form-label">Nationality<span class="required">*</span></label>
														<div>
															<select id="nationality_<?=$cnt?>" name="nationality_<?=$cnt?>" class="form-control nationality nationality_<?=$cnt?>">
																<option value="">Select...</option>
																<?
																	$arrival_date = explode('-', $step1->arrival_date);
																	$arrival_port = $this->m_arrival_port->load_short_name($step1->arrival_port);
																	$limit_todate = mktime(0, 0, 0, 4, 26, 2017);
																	$entry_date = mktime(0, 0, 0, $arrival_date[0], $arrival_date[1], $arrival_date[2]);
																	foreach ($nations as $nation) {
																		if (($arrival_port->code == "SGN") && in_array(strtoupper($nation->name), array("AUSTRALIA", "NEW ZEALAND")) && ($entry_date < $limit_todate)) {
																			continue;
																		}
																		$types_of_tourist = $this->m_visa_fee->types_evisa_of_tourist($nation->id,'evisa_');
																		$types_of_business = $this->m_visa_fee->types_evisa_of_business($nation->id,'evisa_');
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
													<div id="myModalss" class="modal fade modal-info" role="dialog">
														<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h4 class="modal-title">About Vietnam visa for <span class="nation-document"></span> nationality</h4>
															</div>
															<div class="modal-body">
																<h3>VIETNAM VISA FOR <span class="nation-document"></span> NATIONALITY</h3>
																<p>We are informed that your nationality is categorized as the special nation on the list of the Vietnam Immigration Department.</p>
																<p>In order to process your visa, please contact us via email address <a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> and supply us your:</p>
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
													<div class="col-sm-3">
														<label class="form-label">Passport number<span class="required">*</span></label>
														<div>
															<input type="text" id="passport_<?=$cnt?>" name="passport_<?=$cnt?>" class="form-control passport_<?=$cnt?>" value="<?=$step1->passport[$cnt]?>" />
														</div>
													</div>
													<!-- <div class="col-sm-5">
														<label class="form-label">Expiry date<span class="required">*</span></label>
														<div class="row row-sm">
															<div class="col-sm-4 col-xs-4">
																<select id="expiryyear_<?=$cnt?>" name="expiryyear_<?=$cnt?>" class="form-control expiryyear_<?=$cnt?> expirydate" applicant-num="<?=$cnt?>">
																	<option value="">----</option>
																	<? for ($y=date("Y"); $y<=(date("Y")+100); $y++) { ?>
																	<option value="<?=$y?>"><?=$y?></option>
																	<? } ?>
																</select>
																<script> $("#expiryyear_<?=$cnt?>").val("<?=$step1->expiryyear[$cnt]?>"); </script>
															</div>
															<div class="col-sm-4 col-xs-4">
																<select id="expirymonth_<?=$cnt?>" name="expirymonth_<?=$cnt?>" class="form-control expirymonth_<?=$cnt?> expirydate" applicant-num="<?=$cnt?>">
																	<option value="">--</option>
																	<? for ($m=1; $m<=12; $m++) { ?>
																	<option value="<?=$m?>"><?=date('M', mktime(0, 0, 0, $m, 10))?></option>
																	<? } ?>
																</select>
																<script> $("#expirymonth_<?=$cnt?>").val("<?=$step1->expirymonth[$cnt]?>"); </script>
															</div>
															<div class="col-sm-4 col-xs-4">
																<select id="expirydate_<?=$cnt?>" name="expirydate_<?=$cnt?>" class="form-control expirydate_<?=$cnt?>">
																	<option value="">--</option>
																	<? for ($d=1; $d<=31; $d++) { ?>
																	<option value="<?=$d?>"><?=$d?></option>
																	<? } ?>
																</select>
																<script> $("#expirydate_<?=$cnt?>").val("<?=$step1->expirydate[$cnt]?>"); </script>
															</div>
														</div>
													</div> -->
													<!-- <div class="col-sm-6">
														<label class="form-label">Religion<span class="required">*</span></label>
														<div>
															<input type="text" id="religion_<?=$cnt?>" name="religion_<?=$cnt?>" class="form-control religion_<?=$cnt?>" value="<?=!empty($step1->religion[$cnt]) ? $step1->religion[$cnt] : ''?>" />
														</div>
													</div> -->
												</div>

												<div class="form-group row passport-detail">
													<div class="col-sm-6 padding-left-col">
														<label class="form-label">Attach your photograph<span class="required">*</span></label>
														<div class="passport-upload file-photography-<?=$cnt?>" <?=!empty($step1->photo_path[$cnt]) ? 'style="background: url('.BASE_URL.$step1->photo_path[$cnt].')"' : 'style="background: #e7e7e7;"'?>>
															<label>
																<input type="file" name="passport_photo_<?=$cnt?>" sts="<?=!empty($step1->photo_path[$cnt]) ? 1 : 0 ?>" class="file-upload photography-upload-<?=$cnt?>" typ="photography" stt="<?=$cnt?>" value="">
																<i class="fa fa-cloud-upload"></i>
															</label>
															<i class="fa fa-times" typ="photography" stt="<?=$cnt?>"></i>
														</div>
													</div>
													<div class="col-sm-6">
														<label class="form-label">Attach your passport data page image <span class="required">*</span></label>
														<div class="passport-upload file-passport-<?=$cnt?>" <?=!empty($step1->passport_path[$cnt]) ? 'style="background: url('.BASE_URL.$step1->passport_path[$cnt].')"' : 'style="background: #e7e7e7;"'?>>
															<label>
																<input type="file" name="passport_data_<?=$cnt?>" sts="<?=!empty($step1->passport_path[$cnt]) ? 1 : 0 ?>" class="file-upload passport-upload-<?=$cnt?>" typ="passport" stt="<?=$cnt?>" value="">
																<i class="fa fa-cloud-upload"></i>
															</label>
															<i class="fa fa-times" typ="passport" stt="<?=$cnt?>"></i>
														</div>
													</div>
												</div>
												<? } ?>
											</div>
										</div>
										<script type="text/javascript">
											$(".file-upload").change(function() {
												readURL(this);
											});
											
											function readURL(input) {
												if (input.files && input.files[0]) {
													var stt = $(input).attr('stt');
													var typ = $(input).attr('typ');
													var reader = new FileReader();
													reader.onload = function(e) {
														$('.file-'+typ+'-'+stt).css({
															"background": "url('"+e.target.result+"')"
														});
														$('.file-'+typ+'-'+stt+' > i').css({
															"color": "rgba(52, 73, 94, 0.38)"
														});
													};
													reader.readAsDataURL(input.files[0]);
												}
											}
											$(".fa-times").click(function(event) {
												var stt = $(this).attr('stt');
												var typ = $(this).attr('typ');
												$('.file-'+typ+'-'+stt).css({
													"background": "#e7e7e7"
												});
												$('.'+typ+'-upload-'+stt).val('');
											});
										</script>
										<!-- <div class="group">
											<h3 class="group-heading">Extra service at the airport (Recommended)</h3>
											<div class="group-content">
												<div class="form-group row">
													<div class="col-md-12">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="private_visa" name="private_visa" class="private_visa" value="1" <?=($step1->private_visa==1?"checked='checked'":"")?>>
																Private visa letter/confidential letter <span class="text-color-red">(Recommended)</span>
															</label>
															<a class="glyphicon glyphicon-question-sign tooltip-marker hidden" data-toggle="popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="According to Vietnam Immigration Office policy, they list a number of people on the same visa approval letter. By using this service, there are only yourself (and your family and your partner’s) details on the approval letter. It costs only <b><?=$this->m_private_letter_fee->search(((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type)?>$</b> extra for one confidential letter."></a>
															<div class="processing-note private-visa-note <?=(($step1->private_visa == 1)?'':'display-none')?>">
																Private / Confidential for you and your group in 1 letter, <b><?=$this->m_private_letter_fee->search(((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type)?>$</b> extra.
															</div>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-md-12">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="car_pickup" name="car_pickup" class="car_pickup" value="1" <?=($step1->car_pickup==1?"checked='checked'":"")?>>
																Car pick-up
															</label>
															<a class="glyphicon glyphicon-question-sign tooltip-marker hidden" data-toggle="popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="We offer the car pick-up service with considerate and well-trained drivers to take you to your hotel door quickly and safely so as to help you feel comfortable at most. The fee differs based on the type of car."></a>
															<div class="processing-note car-pickup-note <?=(($step1->car_pickup == 1)?'':'display-none')?>">
																<div class="row" id="car-select">
																	<div class="col-sm-6">
																		<label class="control-label" style="padding-top: 0px; padding-left: 0px;"><?=$step1->car_type?></label>
																		<select class="form-control num_seat" name="num_seat" id="num_seat">
																			<option value="4" selected="selected">4 seats</option>
																			<option value="7">7 seats</option>
																			<option value="16">16 seats</option>
																			<option value="24">24 seats</option>
																		</select>
																		<script> $('#num_seat').val('<?=$step1->num_seat?>'); </script>
																	</div>
																	<div class="col-sm-6">
																		Driver will wait for you in front of Airport and take you to your destination in city central.
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group row fast-checkin-group">
													<div class="col-md-12">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="fast_checkin" name="fast_checkin" class="fast_checkin" value="1" <?=($step1->fast_checkin==1?"checked='checked'":"")?>>
																Fast-track
															</label>
															<a class="glyphicon glyphicon-question-sign tooltip-marker hidden" data-toggle="popover" data-trigger="hover" data-html="true" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="Our staff will be ready to meet you at the airport with your name on the welcome board and complete the entry procedure to get visa sticker within a few minutes. This service costs <b><?=$this->m_fast_checkin_fee->search(1, $step1->arrival_port)?>$</b>/person."></a>
															<div class="processing-note fast-checkin-note <?=(($step1->fast_checkin == 1)?'':'display-none')?>">
																Our staff will wait for you at the arrival hall with your name/group name on the welcome sign. All visa procedure will be handle in a few minutes after we have your passport. Then our staff will escort you out of the control counter by diplomatic gate or APEC gate for Cruise.
															</div>
														</div>
													</div>
												</div>
												<div class="form-group row full-package-group <?=((strtoupper($country_name)=='VIET NAM')?'hidden':'')?>">
													<div class="col-md-12">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="full_package" name="full_package" class="full_package" value="1" <?=($step1->full_package==1?"checked='checked'":"")?>>
																Full package <span class="text-color-red">(Recommended)</span>
															</label>
														</div>
														<div class="processing-note full-package-note <?=(($step1->full_package == 1)?'':'display-none')?>">
															<ul style="list-style-type: decimal; padding-left: 15px;">
																<li><p><b>Fast-track</b>: Our staff is waiting for you at the arrival hall and help you to get visa stamp to your passport without get line. Extra <b><?=$this->m_fast_checkin_fee->search(1, $step1->arrival_port)?>$</b>/person.</p></li>
																<li><p><b>Government fee</b>: We call visa stamping fee will be paid online now.</p></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div> -->
										<!-- <div class="group" id="flightinfo">
											<h3 class="group-heading">Flight Information</h3>
											<div class="group-content">
												<p>Please fill out the flight information that we can pick you up on time at the airport.</p>
												<p>
													<div class="radio">
														<label for="flight_notbooked"><input type="radio" id="flight_notbooked" name="flight_booking" class="flight_booking" value="0" <?=(($step1->flight_booking == 0) ? 'checked="checked"' : "")?> /> I have not booked yet</label>
													</div>
												</p>
												<p>
													<div class="radio">
														<label for="flight_booked"><input type="radio" id="flight_booked" name="flight_booking" class="flight_booking" value="1" <?=(($step1->flight_booking == 1) ? 'checked="checked"' : "")?> /> I have booked <span class="text-color-red">(Recommended)</span></label>
													</div>
												</p>
												<div class="processing-note flight_table <?=(($step1->flight_booking == 1)?'':'display-none')?>" name="flight_table" id="flight_table">
													<div class="row">
														<div class="col-sm-6">
															<label class="control-label" style="padding-top: 0px; padding-left: 0px;">
																Flight number <span class="required">*</span>
															</label>
															<input type="text" id="flightnumber" name="flightnumber" class="form-control flightnumber" value="<?=$step1->flightnumber?>"/>
														</div>
														<div class="col-sm-6">
															<label class="control-label" style="padding-top: 0px; padding-left: 0px;">
																Arrival time <span class="required">*</span>
															</label>
															<input type="text" id="arrivaltime" name="arrivaltime" class="form-control arrivaltime" value="<?=$step1->arrivaltime?>"/>
															<span class="help-block" style="font-weight: normal;">Vietnam Standard Time (GMT +7). Eg: 08:30 PM</span>
														</div>
													</div>
												</div>
											</div>
										</div> -->
										<div class="group">
											<h2 class="group-heading">Contact Information</h2>
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
														Secondary email
													</label>
													<div class="col-sm-9">
														<input type="text" id="contact_email2" name="contact_email2" class="form-control" value="<?=$step1->contact_email2?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="form-label col-sm-3 text-right">
														Phone number <span class="required">*</span>
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
															<label for="terms_conditions_confirm"><input type="checkbox" id="terms_conditions_confirm" name="terms_conditions_confirm" checked="checked"> I have read and agreed <a title="Terms and Conditions" class="terms_conditions_confirm" target="_blank" href="<?=site_url("terms")?>">Terms and Conditions</a>.</label>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-sm-3">
													</div>
													<div class="col-sm-9">
														<!-- <a class="btn btn-danger btn-1x" style="padding-left: 35px;padding-right: 35px;" href="<?=site_url("apply-e-visa/step1")?>"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp; BACK</a> -->
														<div class="show-button m-4">
															<button class="btn btn-danger" href="<?=site_url("apply-e-visa/step1")?>"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp; BACK </button>
														</div>
														<!-- <button class="btn btn-danger btn-1x btn-next" type="submit">NEXT STEP &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button> -->
														<div class="show-button m-4">
															<button class="btn btn-danger" type="submit">NEXT STEP &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-sm-3">
										<div class="panel-fees">
											<h3 class="panel-heading" style="padding: 10px;">Visa Fees</h3>
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
														<span class="visa_type_t"><?=$this->util->getVisaType2String($step1->visa_type)?></span>
													</li>
													<li class="clearfix">
														<label>Purpose of visit:</label>
														<span class="visit_purpose_t"><?=$step1->visit_purpose?></span>
													</li>
													<li class="clearfix">
														<label>Arrival port:</label>
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
												<!-- 	<li class="clearfix">
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
														<span class="total_visa_price_t price pointer" data-toggle="collapse" data-target="#service-fee-detail"><?=$step1->service_fee*$step1->group_size?> $ <i class="fa fa-chevron-circle-down"></i></span>
														<div id="service-fee-detail" class="service-fee-detail text-right collapse">
															<span class="total_visa_price price"><?=$step1->service_fee." $ x ".$step1->group_size." ".($step1->group_size>1?"people":"person")." = ".$step1->service_fee*$step1->group_size?> $</span>
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
															<div><label>1. Government fee</label><span class='price'><?=$step1->stamp_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->stamp_fee*$step1->group_size?> $</span></div>
															<div><label>2. Airport fast check-in</label><span class='price'><?=$step1->full_package_fc_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->full_package_fc_fee*$step1->group_size?> $</span></div>
														</div>
													</li>
													<li class="clearfix <?=(($step1->fast_checkin||$step1->car_pickup)?'':'display-none')?>" id="extra_service_li">
														<label>Airport assistance services:</label>
														<div class="extra_services">
															<?
																$serviceCnt = 1;
																if ($step1->fast_checkin==1) {
															?>
																<div><label><?=($serviceCnt++)?>. Fast check-in</label><span class='price'><?=$step1->fast_checkin_fee?> $ x <?=$step1->group_size?> applicant<?=($step1->group_size>1?"s":"")?> = <?=$step1->fast_checkin_fee*$step1->group_size?> $</span></div>
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
													</li>
													<li class="clearfix <?=(!empty($step1->vip_discount)?'':'display-none')?>" id="vipsave_li">
														<label>VIP discount <span class="vipsavepercent_t"><?=$step1->vip_discount?>%</span></label>
														<span class="vipsave_t price">- <?=round($step1->total_service_fee * $step1->vip_discount/100)?> $</span>
													</li>
													<li class="clearfix <?=(!empty($step1->discount)?'':'display-none')?>" id="promotion_li" style="background-color: #F8F8F8;">
														<div class="clearfix">
															<label class="left">Promotion discount:</label>
															<span class="promotion_t price">
															<? if ($step1->discount_unit == "USD") { ?>
															- <?=$step1->discount?> $
															<? } else { ?>
															- <?=round($step1->total_service_fee * $step1->discount/100)?> $
															<? } ?>
															</span>
														</div>
													</li>
													<li class="total clearfix">
														<br>
														<div class="clearfix">
															<label class="pull-left text-color-red">TOTAL FEE:</label>
															<div class="pull-right subtotal-price">
																<div class="price-block">
																	<span class="price total_price"><?=$step1->total_fee?> $</span>
																</div>
															</div>
														</div>
														<!-- <div class="text-left" style="font-size: 14px;">
															<i class="stamping_fee_included display-none">(<a target="_blank" title="stamping fee" href="<?//=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
															<i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?//=site_url("vietnam-visa-fees")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i>
														</div> -->
													</li>
												</ul>
											</div>
										</div>
										<div class="payment-methods">
											<img alt="" src="<?=IMG_URL?>payment-methods.jpg">
										</div>
									</div>
								</div>
								<input type="hidden" id="task" name="task" value=""/>
							</form>
						</div>
					</div>
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

