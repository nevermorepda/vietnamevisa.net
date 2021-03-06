<?
	require_once(APPPATH."libraries/ip2location/IP2Location.php");
	$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
	$country_name = $loc->lookup($this->util->realIP(), IP2Location::COUNTRY_NAME);
	
	$nations = $this->m_visa_fee->voa_nations();
	$visa_types = $this->m_visa_type->items(NULL, 1);
	$visit_purposes = $this->m_visit_purpose->items(NULL, 1);
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
?>

<script type="text/javascript" src="<?=JS_URL?>apply.visa.step1.js"></script>
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
		<h2 class="home-heading text-center" style="">Vietnam Visa Application Form</h2>
	</div>
</div>
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
				<span class="step-number">2</span>
			</div>
			<div class="step">
				<div class="line-right"></div>
				<div class="line-left"></div>
				<span class="step-number">3</span>
			</div>
			<div class="step">
				<div class="line-left"></div>
				<span class="step-number">4</span>
			</div>
		</div>
		<div class="step-apl-content">
			<div class="bystep active">Visa Option</div>
			<div class="bystep">Account Login</div>
			<div class="bystep">Application Details</div>
			<div class="bystep">Review & Payment</div>
		</div>
		
		<div class="applyform">
			<form id="frmApply" class="form-horizontal" role="form" action="<?=BASE_URL_HTTPS."/apply-visa/step2.html"?>" method="POST">
				<div class="row clearfix">
					<div class="col-md-7">
						<div class="panel-options">
							<div class="title text-left">VISA OPTION</div>
							<!-- <div class="row">
								<div class="col-md-4">
									<label class="control-label">Passport holder <span class="required">*</span></label>
								</div>
								<div class="col-md-8">
									<select id="passport_holder" name="passport_holder" class="form-control passport_holder">
										<option value="">Please select...</option>
										<?// foreach ($nations as $nation) { ?>
										<option value="<?//=$nation->name?>"><?//=$nation->name?></option>
										<?// } ?>
									</select>
									<script> $('#passport_holder').val('<?//=$step1->passport_holder?>'); </script>
									<input id="passport_holder" name="passport_holder" class="form-control passport_holder" list="brow" placeholder="Please select...">
									<datalist id="brow">
										<?// foreach ($nations as $nation) { ?>
										<option value="<?//=$nation->name?>"><?//=$nation->name?></option>
										<?// } ?>
									</datalist>
									<script> $('#passport_holder').val('<?//=$step1->passport_holder?>'); </script>
								</div>
							</div> -->
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Number of visa <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<select id="group_size" name="group_size" class="form-control group_size">
											<option value="1">1 Applicant</option>
											<? for ($i=2; $i<=15; $i++) { ?>
											<option value="<?=$i?>"><?=$i?> Applicants</option>
											<? } ?>
										</select>
										<script> $('#group_size').val('<?=$step1->group_size?>'); </script>
									</div>
								</div>
							</div>
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Type of visa <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<select id="visa_type" name="visa_type" class="form-control visa_type">
											<option value="e-1ms">1 month single (e-visa)</option>
											<? foreach ($visa_types as $visa_type) {
												if ($visa_type->code == '6mm') {
											?>
											<option value="<?=$visa_type->code?>"><?=$visa_type->name?> (US Only)</option>
											<?} elseif($visa_type->code == '1ym') {?>
											<option value="<?=$visa_type->code?>"><?=$visa_type->name?> (US Only)</option>
											<? } else { ?>
											<option value="<?=$visa_type->code?>"><?=$visa_type->name?></option>
											<? } } ?>
										</select>
										<script> $('#visa_type').val('<?=$step1->visa_type?>'); </script>
									</div>
								</div>
							</div>
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Purpose of visit <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<select id="visit_purpose" name="visit_purpose" class="form-control visit_purpose">
											<option value="">Please select...</option>
											<? foreach ($visit_purposes as $visit_purpose) { ?>
											<option value="<?=$visit_purpose->name?>"><?=$visit_purpose->name?></option>
											<? } ?>
										</select>
										<script> genVisitOptions(); $('#visit_purpose').val('<?=$step1->visit_purpose?>'); </script>
									</div>
								</div>
							</div>
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Arrival date <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-sm-4 col-xs-4">
												<select id="arrivalyear" name="arrivalyear" class="form-control arrival_year">
													<option value="">Year...</option>
													<? for ($y=date("Y"); $y<=date("Y")+3; $y++) { ?>
													<option value="<?=$y?>"><?=$y?></option>
													<? } ?>
												</select>
												<script> $("#arrivalyear").val("<?=$step1->arrivalyear?>"); </script>
											</div>
											<div class="col-sm-4 col-xs-4">
												<select id="arrivalmonth" name="arrivalmonth" class="form-control arrival_month">
													<option value="">Month...</option>
													<? for ($m=1; $m<=12; $m++) { ?>
													<option value="<?=$m?>"><?=date('M', mktime(0, 0, 0, $m, 10))?></option>
													<? } ?>
												</select>
												<script> $("#arrivalmonth").val("<?=$step1->arrivalmonth?>"); </script>
											</div>
											<div class="col-sm-4 col-xs-4">
												<select id="arrivaldate" name="arrivaldate" class="form-control arrival_date">
													<option value="">Day...</option>
													<? for ($d=1; $d<=31; $d++) { ?>
													<option value="<?=$d?>"><?=$d?></option>
													<? } ?>
												</select>
												<script> $("#arrivaldate").val("<?=$step1->arrivaldate?>"); </script>
											</div>
										</div>
										<div class="processing-note mt-2">
											When you arrive Vietnam?
										</div>
									</div>
								</div>
							</div>
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Arrival airport <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<select id="arrival_port" name="arrival_port" class="form-control arrival_port">
											<option value="" selected="selected">Please select...</option>
											<? foreach ($arrival_ports as $arrival_port) {
												if (in_array($arrival_port->code, array("SGN", "HAN", "DAN", "CXR"))) { ?>
													<option cate-id="<?=$arrival_port->category_id?>" value="<?=$arrival_port->id?>"><?=$arrival_port->airport?></option>
											<?	}
											} ?>
										</select>
										<script> $('#arrival_port').val('<?=$step1->arrival_port?>'); </script>
										<div class="processing-note mt-2">
											The first port you arrive to Vietnam.
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="row form-group optional wrap_exit_port" style="display: none;">
								<div class="col-md-3">
									<label class="control-label">Exit through checkpoint <span class="required">*</span></label>
								</div>
								<div class="col-md-9">
									<select id="exit_port" name="exit_port" class="form-control frm-input exit_port">
										<option value="" selected="selected">Please select...</option>
									</select>
									<script> $('#exit_port').val('<?=$step1->exit_port?>'); </script>
								</div>
							</div> -->
							<script type="text/javascript">
								$(".visa_type").change(function(){
									var typ = $(this).val();
									var str_holiday = '';
									var str = '<option value="" selected="selected">Please select...</option>';
									var frm_url = '<?=BASE_URL_HTTPS."/apply-visa/step2.html"?>';
									if (typ != 'e-1ms') {
										<? foreach ($arrival_ports as $arrival_port) {
											if (in_array($arrival_port->code, array("SGN", "HAN", "DAN", "CXR"))) { ?>
												str += '<option cate-id="<?=$arrival_port->category_id?>" value="<?=$arrival_port->id?>"><?=$arrival_port->airport?></option>';
										<?	}
										} ?>
										str_holiday += '<label><input id="processing_time_holiday" note-id="processing-time-holiday-note" class="processing_time" type="radio" name="processing_time" value="Holiday" <?=($step1->processing_time=="Holiday"?"checked='checked'":"")?>/><strong>Holiday (for Saturday, Sunday or public holiday)</strong></label>';
										str_holiday += '<div id="processing-time-holiday-note" class="processing-option none"><div class="processing-note">You need to choose this option if you are flying out on a weekend or holiday. The extra charge is from <b><?=$this->m_visa_fee->cal_visa_fee("1ms", 1, "Holiday")->rush_fee?> $</b>/person. You should call our hotline <a class="red" title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to confirm the application has been received and acknowledged to <span class="red">process immediately</span>. This fee, however, includes the stamping fee since we will have an associate obtaining the visa for you at the airport before your arrival.</div></div>';
										$('.exit_port').html('');
										$('.wrap_exit_port').css('display', 'none');
										$('.review_exit_port').css('display', 'none');
										$('#promotion_li').css('display', 'block');
										$('.stamping_price').css('display', 'none');
										$('.emergency_process').css('display', 'block');
										$('#private_letter').css('display', 'block');
										$('.box_full_package').css('display', 'block');
									} else {
										frm_url = '<?=BASE_URL_HTTPS."/apply-e-visa/step2.html"?>';
										<? $ports = array('Airport','Landport','Seaport'); for ($i=1; $i <= 3 ; $i++) {
												$info = new stdClass();
												$info->category_id = $i;
												$arrival_ports = $this->m_arrival_port->items($info, 1);
											?>
											str += '<optgroup label="<?=$ports[$i-1]?>">';
											<? foreach ($arrival_ports as $arrival_port) { ?>
												str += '<option cate-id="<?=$arrival_port->category_id?>" value="<?=$arrival_port->short_name?>"><?=$arrival_port->airport?></option>';
											<? } ?>
											str += '</optgroup>';
										<? } ?>
										$('.exit_port').html(str);
										$('.wrap_exit_port').css('display', 'flex');
										$('.review_exit_port').css('display', 'block');
										$('#promotion_li').css('display', 'none');
										$('.stamping_price').css('display', 'block');
										$('.emergency_process').css('display', 'none');
										$('#private_letter').css('display', 'none');
										$('.box_full_package').css('display', 'none');
									}
									$('#frmApply').attr('action', frm_url);
									$('.holiday_process').html(str_holiday);
									$('.arrival_port').html(str);
								});
							</script>
							<div class="form-group optional">
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">Processing time <span class="required">*</span></label>
									</div>
									<div class="col-md-9">
										<div class="radio">
											<label>
												<input id="processing_time_normal" note-id="processing-time-normal-note" class="processing_time" type="radio" name="processing_time" value="Normal" <?=($step1->processing_time=="Normal"?"checked='checked'":"")?>/>
												<strong>Normal (Guaranteed <span class="process-date note-normal"><?=((strtoupper($country_name)=='VIET NAM')?'1-2 working days':'1-2 working days')?></span>)</strong>
											</label>
											<div id="processing-time-normal-note" class="processing-option none">
												<div class="processing-note">
													We guarantee delivery of approval letter in <span class="note-normal"><?=((strtoupper($country_name)=='VIET NAM')?'1-2 working days':'1-2 working days')?></span> by email.
												</div>
											</div>
										</div>
										<div class="radio" style="margin-top: 5px">
											<label>
												<input id="processing_time_urgent" note-id="processing-time-urgent-note" class="processing_time" type="radio" name="processing_time" value="Urgent" <?=($step1->processing_time=="Urgent"?"checked='checked'":"")?>/>
												<strong>Urgent (Guaranteed <span class="note-urgent">4-8 working hours</span>)</strong>
											</label>
											<div id="processing-time-urgent-note" class="processing-option none">
												<div class="processing-note">
													It is effective for who needs visa in emergency. We will send the approval letter by email in <span class="red"><span class="note-urgent">4 to 8 hours</span>. If you apply on a Saturday, Sunday or holiday, it will be processed the next business day. The extra charge is from <b><?=$this->m_visa_fee->cal_visa_fee("1ms", 1, "Urgent")->rush_fee?> $</b>/person.
												</div>
											</div>
										</div>
										<div class="radio emergency_process" style="margin-top: 5px">
											<label>
												<input id="processing_time_emergency" note-id="processing_time_emergency-note" class="processing_time" type="radio" name="processing_time" value="Emergency" <?=($step1->processing_time=="Emergency"?"checked='checked'":"")?>/>
												<strong class="red">Emergency (Within <span class="note-emergency">30 minutes</span>)</strong>
											</label>
											<div id="processing_time_emergency-note" class="processing-option none">
												<div class="processing-note">
													It only takes <span class="red note-emergency">30 minutes</span> for the processing (Since we get the essential documents for Emergency Cases from you and depend on your application time and arrival time). You should call our hotline <a class="red" title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to confirm the application has been received and acknowledged to process immediately.
												</div>
											</div>
										</div>
										<div class="radio holiday_process" style="margin-top: 5px">
											<label>
												<input id="processing_time_holiday" note-id="processing-time-holiday-note" class="processing_time" type="radio" name="processing_time" value="Holiday" <?=($step1->processing_time=="Holiday"?"checked='checked'":"")?>/>
												<strong>Holiday (for Saturday, Sunday or public holiday)</strong>
											</label>
											<div id="processing-time-holiday-note" class="processing-option none">
												<div class="processing-note">
													You need to choose this option if the time you apply for visa and your arrival time to Vietnam is non-working time of The Vietnam Immigration Department (Saturdays; Sundays; national holidays; from 4pm to 8am next day Vietnam time). The holiday fee is <b><?=$this->m_visa_fee->cal_visa_fee("1ms", 1, "Holiday")->rush_fee?> $</b>/person. You should call our hotline <a class="red" title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a> to get confirmation for  your application <span class="red">received and acknowledged to process immediately</span>. This fee also includes goverment fee and fast track serice at Vietnam airports, you will not pay any fee upon arrival and our staff will assist you to get your Vietnam visa stamp when you arrive.
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group optional extra_service box_full_package">
								<div class="row full_package_group <?=((strtoupper($country_name)=='VIET NAM')?'full_package_group_none':'')?>">
									<div class="col-md-12">
										<div class="div"></div>
									</div>
									<div class="col-md-3">
										<label class="control-label">Full package service</label>
										<p class="help-block red">(Recommended)</p>
									</div>
									<div class="col-md-9">
										<div class="checkbox">
											<label>
												<input type="checkbox" id="full_package" name="full_package" class="full_package" value="1" <?=($step1->full_package==1?"checked='checked'":"")?>>
												<strong>Full visa services at the airport</strong>
											</label>
											<div class="processing-note">
												<span class="glyphicon glyphicon-ok"></span> Including the Airport Fast-Track service.<br>
												<span class="glyphicon glyphicon-ok"></span> Including Visa stamping fee for Vietnam Government.<br>
												<span class="red">You don't need to pay any extra fee.</span><br>
												<span class="red hidden">Save more 10% for the visa service fee.</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group optional extra_service" id="extra_service">
								<div class="row">
									<div class="col-md-12">
										<div class="div"></div>
									</div>
									<div class="col-md-3">
										<label class="control-label">Upon arrival services</label>
									</div>
									<div class="col-md-9">
										<div id="private_letter">
											<div class="checkbox">
												<label>
													<input type="checkbox" id="private_visa" name="private_visa" class="private_visa" value="1" <?=($step1->private_visa==1?"checked='checked'":"")?>>
													<strong class="text-color-red">Show me in a private visa letter</strong>
												</label>
											</div>
											<div class="processing-note">
												<p class="mb-1">The Vietnam Immigration Department normally processes a lot of applications and it is common and legal to get a visa approval letter with several names of applicants applying at the same time.</p>
												<p class="mb-1">In case, you want to keep your information in secret, you can ask for the option “Private Letter” to get your approval letter with only yourself or your group information. Each application will pay an extra fee amount of <b id="note-letter-fee" style="color:red"></b> to get the private visa approval letter.</p>
												<p class="mb-1">Please notice that if you do not choose the “Private letter” option, you will receive a shared approval letter and you cannot change anything after your application is processed.</p>
											</div>
										</div>
										<div class="checkbox cb_fast_checkin">
											<label>
												<input type="checkbox" id="fast_checkin" name="fast_checkin" class="fast_checkin" value="1" <?=($step1->fast_checkin==1?"checked='checked'":"")?>>
												Airport fast track
											</label>
											<div class="processing-note">
												To avoid wasting your time and get line for getting visa stamp, our staff will handle all procedure for you. You will check-in faster than the others.
											</div>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" id="car_pickup" name="car_pickup" class="car_pickup" value="1" <?=($step1->car_pickup==1?"checked='checked'":"")?>>
												Airport car pick-up
											</label>
											<div class="processing-note">
												Our friendly drivers standing outside with your name on the welcome sign. He will pick you up at the airport to your hotel.
											</div>
										</div>
										<div class="clearfix car-select" id="car-select" style="background-color: #F8F8F8; border: 1px solid #DDDDDD; padding: 10px; <?=($step1->car_pickup==1?"display: none;":"")?>">
											<label class="control-label">Car type</label>
											<div class="">
												<select class="form-control car_type" name="car_type" id="car_type">
													<option value="Economic Car" selected="selected">Economic Car</option>
												</select>
												<script> $('#car_type').val('<?=$step1->car_type?>'); </script>
											</div>
											<label class="control-label">Seats</label>
											<div class="">
												<select class="form-control num_seat" name="num_seat" id="num_seat">
													<option value="4" selected="selected">4 seats</option>
													<option value="7">7 seats</option>
													<option value="16">16 seats</option>
													<option value="24">24 seats</option>
												</select>
												<script> $('#num_seat').val('<?=$step1->num_seat?>'); </script>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group optional d-none d-sm-none d-md-block">
								<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
									<label class="col-md-3 control-label"></label>
									<div class="col-md-9">
										<a class="btn btn-danger btn-next" style="color:#fff;">NEXT <i class="icon-double-angle-right icon-large"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<? $level = $this->util->level_account(); ?>
					<div class="col-md-5">
						<div class="panel-fees">
							<div class="title text-center">VISA OPTION SUMMARY</div>
							<div class="pl-3 pb-2"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= date('M dS, Y ')?><div style="font-size: 12px; padding: 2px 5px 3px; background: #ececec; border-radius: 2px; display: inline-block;" class="clock-time"><?= date('H:i A')?></div> (Vietnam Time)</div>
							<ul>
								<!-- <li class="clearfix">
									<label>Passport holder:</label>
									<span class="passport_holder_t">Please select...</span>
								</li> -->
								<li class="clearfix">
									<label>Number of visa:</label>
									<span class="group_size_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Type of visa:</label>
									<span class="visa_type_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Purpose of visit:</label>
									<span class="visit_purpose_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Arrival date:</label>
									<span class="arrival_date_t">Please select...</span>
								</li>
								<li class="clearfix">
									<label>Arrival airport:</label>
									<span class="arrival_port_t">Please select...</span>
								</li>
								<!-- <li class="clearfix review_exit_port">
									<label>Exit airport:</label>
									<span class="exit_port_t">Please select...</span>
								</li> -->
								<li class="clearfix stamping_price" style="display: none;">
									<label>Visa stamping fee:</label>
									<span class="total_visa_stamping_price price">25 $ x 1 applicants = 25 $</span>
								</li>
								<li class="clearfix service_fee">
									<div class="clearfix">
										<label>Visa service fee:</label>
										<span class="total_visa_price price"></span>
									</div>
									<div class="processing_fee_note text-right" style="position: relative;">
										<i class="processing_fee">(<a class="" target="_blank" title="processing fee" href="<?=site_url("visa-fee")?>#stamping-fee">the processing fee</a> is based on tar-iff table)</i>
										<!-- <i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?=site_url("visa-fee")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i> -->
										<!-- <img style="position: absolute;right: 20px;top: 16px;" src="<?=IMG_URL?>private-letter.png" alt="private-letter"> -->
									</div>
								</li>
								<li class="clearfix" id="processing_time_li" style="display: none">
									<label>Processing time:</label>
									<span class="processing_note_t"></span>
									<div class="clr"></div>
									<span class="processing_t price"></span>
									<div class="clr"></div>
								</li>
								<li class="clearfix" id="private_visa_li" style="display: none">
									<label class="">Private letter:</label>
									<span class="private_visa_t price"></span>
								</li>
								<li class="clearfix" id="full_package_li" style="display: none">
									<label>Full package service:</label>
									<div class="full_package_services"></div>
								</li>
								<li class="clearfix" id="extra_service_li" style="display: none">
									<label>Extra services:</label>
									<div class="extra_services"></div>
								</li>
								<li class="clearfix" id="vipsave_li" style="display: none">
									<label>VIP discount:</label>
									<span class="vipsave_t price"></span>
								</li>
								<li class="clearfix promo_code" id="promotion_li" style="">
									<div id="promotion-box-input" >
										<div class="row clearfix">
											<label class="col-md-5">Got a promotion code?</label>
											<div class="col-md-7">
												<div class="input-group">
													<input type="text" class="promotion-input form-control" id="promotion-input" name="promotion-input" value=""/>
													<span class="input-group-btn" style="float: none;">
														<button type="button" class="btn btn-danger btn-apply-code">APPLY</button>
													</span>
												</div>
												<div class="promotion-error red none">Code invalid. Please try again!</div>
											</div>
										</div>
									</div>
									<div class="clearfix" id="promotion-box-succed" style="display: <?=(!empty($step1->discount) || !empty($step1->member_discount))?'block':'none'?>">
										<label class="left">Promotion discount:</label>
										<span class="promotion_t price"></span>
									</div>
								</li>
								<li class="total clearfix">
									<div class="left_edge"></div>
									<div class="right_edge"></div>
									<div class="clearfix">
										<label class="total_fee">Total fee:</label>
										<span class="total_price"></span>
									</div>
									<div class="stamping_fee_note text-right" style="position: relative;">
										<i class="stamping_fee_included none">(<a target="_blank" title="stamping fee" href="<?=site_url("visa-fee")?>#stamping-fee">stamping fee</a> included, no need to pay any extra fee)</i>
										<i class="stamping_fee_excluded">(<a target="_blank" title="stamping fee" href="<?=site_url("visa-fee")?>#stamping-fee">stamping fee</a> is excluding, you will pay in cash at the airport)</i>
										<!-- <img style="position: absolute;right: 20px;top: 16px;" src="<?=IMG_URL?>private-letter.png" alt="private-letter"> -->
									</div>
								</li>
								<li class="clearfix">
									<div class="form-group d-block d-sm-block d-md-none">
										<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
											<label class="col-md-4 control-label"></label>
											<div class="col-md-8 text-center">
												<a class="btn btn-danger btn-next " style="color:#fff;">NEXT <i class="icon-double-angle-right icon-large"></i></a>
											</div>
										</div>
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
				<input type="hidden" id="vip_discount" name="vip_discount" value="<?=$step1->vip_discount?>">
			</form>
		</div>
		<div class="applymore15 d-none d-sm-none d-md-block">
			<p>For applying more than 10 applicants, please <a href="<?=site_url("contact")?>">contact us</a> to get the best fee.</p>
			<p>You can also manually fill in the <a href="<?=site_url("download-visa-application-forms")?>" class="here">application form</a> then submit the information to <a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></p>
		</div>
		<div class="shopperapproved d-block d-sm-block d-md-none text-center">
			<h2 class="text-center home-sub-heading">Testimonial</h2>
			<a class="sa-medal" title="Customer ratings" target="_blank" rel="noopener" href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/">
				<img alt="Customer ratings" class="medal-red lazy" src="<?=IMG_URL?>medal-red.png" style="display: inline;">
				<?
					ini_set('default_socket_timeout', 3);
					$sa_content = file_get_contents('https://www.shopperapproved.com/feeds/schema.php/?siteid=24798&token=sfx0VK6J');
					//$sa_total = substr($sa_content, strpos($sa_content, '<span itemprop="ratingCount">')+strlen('<span itemprop="ratingCount">'), 3);
					$str = explode('based on', $sa_content);
					$str = explode(' ', $str[1]);
					$sa_total = $str[1];
				?>
				<span class="sa-total"><?=$sa_total?></span>
			</a>
		</div>
		<!-- <div class="testimonial d-none d-sm-none d-md-block">
			<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
				<h2 class="text-center home-sub-heading">Testimonial</h2>
				<h3 class="text-center" style="color: #AAA;">A few words of our travellers.</h3>
				<div class="cluster-content">
					<div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_horizontal sa_count5 sa_rounded sa_colorBlack sa_borderGray sa_bgWhite sa_showdate sa_jMY"></div><script type="text/javascript">var sa_interval = 10000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/3.0/24798.js'); shopper_first = true; </script><div style="text-align:right;"><a href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/" target="_blank" rel="nofollow" class="sa_footer"><img class="sa_widget_footer" alt="Customer reviews" src="//www.shopperapproved.com/widgets/widgetfooter-darklogo.png" style="border: 0;"></a></div>
				</div>
			</div>
		</div> -->
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	<? if ($this->session->flashdata('session-expired')) { ?>
		messageBox("INFO", "Session Expired", "<?=$this->session->flashdata('session-expired')?>");
	<? } ?>
});
</script>
