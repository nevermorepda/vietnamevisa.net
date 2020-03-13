<?
	$document_required = $this->m_visa_fee->search($current_nation->id)->document_required;
	$non_document_required = $this->m_visa_fee->search($current_nation->id)->non_document_required;
	
	$tourist_1ms = $this->m_visa_fee->cal_visa_fee("1ms", 1, "", $current_nation->name);
	$tourist_1mm = $this->m_visa_fee->cal_visa_fee("1mm", 1, "", $current_nation->name);
	$tourist_3ms = $this->m_visa_fee->cal_visa_fee("3ms", 1, "", $current_nation->name);
	$tourist_3mm = $this->m_visa_fee->cal_visa_fee("3mm", 1, "", $current_nation->name);
	$tourist_6mm = $this->m_visa_fee->cal_visa_fee("6mm", 1, "", $current_nation->name);
	$tourist_1ym = $this->m_visa_fee->cal_visa_fee("1ym", 1, "", $current_nation->name);
	
	$business_1ms = $this->m_visa_fee->cal_visa_fee("1ms", 1, "", $current_nation->name, "business");
	$business_1mm = $this->m_visa_fee->cal_visa_fee("1mm", 1, "", $current_nation->name, "business");
	$business_3ms = $this->m_visa_fee->cal_visa_fee("3ms", 1, "", $current_nation->name, "business");
	$business_3mm = $this->m_visa_fee->cal_visa_fee("3mm", 1, "", $current_nation->name, "business");
	$business_6mm = $this->m_visa_fee->cal_visa_fee("6mm", 1, "", $current_nation->name, "business");
	$business_1ym = $this->m_visa_fee->cal_visa_fee("1ym", 1, "", $current_nation->name, "business");
	
	$tourist_urgent_fee		= $this->m_processing_fee->search("tourist_1ms_urgent");
	$tourist_emergency_fee	= $this->m_processing_fee->search("tourist_1ms_emergency");
	$business_urgent_fee	= $this->m_processing_fee->search("business_1ms_urgent");
	$business_emergency_fee	= $this->m_processing_fee->search("business_1ms_emergency");

	$processing_fee = $this->m_processing_fee->load(1);
	
	$arrival_ports = $this->m_arrival_port->items(NULL, 1);
	$fc_ports = array();
	$car_ports = array();
	foreach ($arrival_ports as $arrival_port) {
		if (in_array($arrival_port->code, array("SGN", "HAN", "DAN", "CXR"))) {
			$fc_ports[] = $arrival_port;
			$car_ports[] = $arrival_port;
		}
	}
	$price_nation = $this->m_visa_fee->search($current_nation->id);

	if (!empty($price_nation->get_fee_default)) {
		$price_nation = $this->m_visa_fee->search(0);
	}
?>

<div class="fee-banner banner-top" style="background: url('<?=IMG_URL?>new-template/VisaFee-banner.png') no-repeat scroll top center transparent;">
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-content">
					<h1>VIETNAM <span class="border-text" style="padding: 10px 50px 0px 15px;">VISA FEES</span></h1>
					<div class="alternative-breadcrumb">
					<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
					</div>
					<ul>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Reasonable and  Competitive Price</li>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">No hidden fees</li>
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
<div class="fees cluster-content">
	<div class="cluster-body">
		<div class="container">
			<div class="explain-fee">
				<h2 class="page-title home-sub-heading shadow-text">VIETNAM VISA FEES</h2>
				<p>In order to receive a Vietnam visa on arrival, passenger need to pay 2 types of fee: <span class="red font-weight-bold">Visa Processing fee</span> and <span class="red font-weight-bold">Government fee</span></p>
				<ul>
					<li><span class="font-weight-bold red">Processing fee:</span> It is the fee you will pay online for us to do all the paperwork to submit your application to the Vietnam Immigration Department for visa procedure. Processing fee depends on type and term of visa you want to get.</li>
					<li><span class="font-weight-bold red">Government fee:</span> This fee is paid for Vietnam Government to have a visa stamped onto your passport. For passengers who apply for Vietnam visa on arrival, you will pay in cash for Vietnam Immigration Officer at LANDING VISA counter when you arrive at Vietnam airport or you can pay stamp fee online with us on our website. For passengers enter Vietnam by Electronic Visa, Government fee is included when you pay online so you will not pay any fee at check-on point.</li>
				</ul>
			</div>
			<div class="text-center">
				<form id="frmCheckVisaFee" action="<?=site_url("visa-fee")?>" method="POST">
					<h3 class="hw-opt-title">List of eligible countries for a Vietnam visa</h3>
					<select class="form-control" id="nation" name="nation">
						<option value="" nation-id="">Choose Nationality</option>
						<? foreach ($nationalities as $nationality) { ?>
							<option value="<?=$nationality->alias?>" nation-id="<?=$nationality->id?>"><?=$nationality->name?></option>
						<? } ?>
					</select>
					<script>
						$('#nation').val('<?=!empty($current_nation->alias) ? $current_nation->alias : null?>');
						$('#nation').change(function() {
							var action = $(this).val();
							$('#frmCheckVisaFee').attr("action", "<?=base_url('visa-fee')?>/" + action + '.html');
						});


						// $('#nation').on('change', function(e) {
						// 	var get_request = window.location.href;
						// 	get_request = get_request.split('visa-fee');

						// 	if ($(this).val() != "") {
						// 		href_request = get_request[0]+'visa-fee/'+$(this).val()+'.html';
						// 	} else {
						// 		href_request = get_request[0]+'visa-fee.html';
						// 	}
						// 	window.location.href = href_request;
						// });
					</script>
					<div class="btn-checkfee m-2">
						<input type="submit" class="btn btn-danger" value="CHECK FEE">
					</div>
				</form>
				<br>
				<!-- <div class="available-visa text-left display-none">
					<ul class="ul-processing">
						<li class="voa-not-available">The Vietnam visa on arrival is not available for your nationality. Please contact to <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> at your country to apply.</li>
						<li class="voa-available">You are eligible to apply for visa Vietnam</li>
						<li class="voa-business">Business visa available</li>
						<li class="voa-tourist">Tourist visa available</li>
					</ul>
					<div class="text-center voa-button">
						<a class="btn btn-success" href="<?=site_url("apply-visa")?>">APPLY VISA</a>
					</div>
				</div> -->
			</div>
		</div>
		<div class="container">
			<? if ($document_required) { ?>
			<br>
			<div class="alert alert-warning">
				<p>Dear customer,</p>
				<p>It is informed that <span class="red"><?=!empty($current_nation->name) ? $current_nation->name : null?></span> passport holders can apply online on our website for Visa On Arrival but we ONLY can help you to process 1 month single tourist visa, not for a full 30 days, the Immigration just bases on your ticket to process visa (maximum 25 days). </p>
				<p>The processing will take 7- 10 working days. The documents following are required:</p>
				<ul>
					<li><strong>Passport scan</strong></li>
					<li><strong>Booking tour voucher of travel agency in Vietnam</strong></li>
					<li><strong>Flight ticket confirmation</strong></li>
					<li><strong>Hotel booking confirmation</strong></li>
				</ul>
				<p>Without those documents, we can not process visa for you. Please send to our email : <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></p>
				<p><span class="font-weight-bold">IMPORTANT NOTICE:</span> We can help you to process Vietnam Visa Arrival. Please note that the Vietnam Immigration requires you must have more than $1000 USD which you must show in cash or give your card to the Immigration Officer to check upon arrival. If you meet this condition then can continue to do the visa stamp procedure. Otherwise, you may not enter Vietnam, even if you have the APPROVAL LETTER. Please prepare this amount before your departure.</p>
				<p>Best regards, <br>
				Vietnam Evisa Team,
				</p>
			</div>
			<? } ?>
			<? if ($non_document_required) { ?>
			<br>
			<div class="alert alert-warning">
				<p>Dear customer,</p>
				<p>We would like to inform that <span class="red"><?=!empty($current_nation->name) ? $current_nation->name : null?></span> passport holders can apply online on our website to get visa on arrival. However, The Immigration will ask for passport scan of applicant to process Vietnam Visa. Please send to our email : <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> . Without Passport Scan, we can’t process visa for you.</p>
				<p><span class="font-weight-bold">IMPORTANT NOTICE:</span> We can help you to process Vietnam Visa Arrival. Please note that the Vietnam Immigration requires you must have more than $1000 USD which you must show in cash or give your card to the Immigration Officer to check upon arrival. If you meet this condition then can continue to do the visa stamp procedure. Otherwise, you may not enter Vietnam, even if you have the APPROVAL LETTER. Please prepare this amount before your departure.</p>
				<p>Best regards, <br>
				Vietnam Evisa Team,
				</p>
			</div>
			<? } ?>
			<? if (!sizeof($tourist_visa_types) && !sizeof($business_visa_types)) { ?>
			<div class="alert alert-warning">
				<p>Dear customer,</p>
				<p>Thanks for your concern, <br>
				We regret to inform that we can not assist Vietnam Visa with your Nationality <br>
				Please contact Vietnam Embassy nearest your location for supporting. <br>
				You can check the Vietnam Embassy list here : <a href="<?=site_url("vietnam-embassies/{$current_nation->alias}")?>"><?=site_url("vietnam-embassies/{$current_nation->alias}")?></a> <br>
				We apologize for any inconvenience this may cause.</p>
				<p>Thanks for contacting us. <br>
				Best regards, <br>
				Vietnam Evisa Team,
				</p>
			</div>
			<? } ?>
		</div>
		<div class="e-visa-fee">
			<div class="container">
				<div class="title">
					<h2 class="home-sub-heading shadow-text">VIETNAM ELECTRONIC VISA</h2>
					<h4 class="sub-title">(available at airports, land ports and seaports for 86 countries)</h4>
				</div>
				<? if (sizeof($tourist_evisa_types) && sizeof($business_evisa_types)) { ?>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="2">TYPES OF VISA</th>
						<th class="text-center" colspan="2">PROCESSING FEE <br></th>
						<th class="text-center" rowspan="2">GOVERNMENT FEE</th>
					</tr>
					<tr>
						<th class="text-center" rowspan="">NORMAL <br> (Guaranteed 3 working days)</th>
						<th class="text-center red" rowspan="">URGENT <br> (within 2 working days)</th>
					</tr>
					<tr>
						<td class="text-left">Tourist</td>
						<td class="text-center"><?=$price_nation->evisa_tourist_1ms?> USD/pax</td>
						<td class="text-center red">+ <?=$processing_fee->evisa_tourist_1ms_urgent?> USD/pax</td>
						<td class="text-center" rowspan="2">25 USD/pax</td>
					</tr>
					<tr>
						<td class="text-left">Business</td>
						<td class="text-center"><?=$price_nation->evisa_business_1ms?> USD/pax</td>
						<td class="text-center red">+ <?=$processing_fee->evisa_tourist_1ms_urgent?> USD/pax</td>
					</tr>
				</table>
				<? } ?>
			</div>
		</div>
		
		<div class="visa-arrival-fee">
			<div class="container">
				<div class="title clearfix">
					<h2 class="home-sub-heading shadow-text">VIETNAM VISA ON ARRIVAL</h2>
					<h4 class="sub-title">(available at International Airport Only for most of countries)</h4>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon6.png"><h3>TOURIST VISA FEES <?=strtoupper(!empty($current_nation->name) ? 'FOR '.$current_nation->name : null)?></h3>
					</div>
					<div class="content">
						<p>Vietnam Tourist Visa (DL Category) is part of the required immigration process for those who enter Vietnam for the purpose of traveling ONLY. </p>
					</div>
				</div>
				<?
				$normal_pr_time = "24-48 working hours";
				$can_rush = TRUE;
				if ($document_required) {
					$normal_pr_time = "5-7 working days";
					$can_rush = FALSE;
				}
			
				if (sizeof($tourist_visa_types)) {
					$row_number_service = 2;
					$col_number_service = 3;
				?>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="<?=$row_number_service?>">TYPES OF VISA</th>
						<th class="text-center" colspan="<?=$col_number_service+1?>">PROCESSING FEE</th>
						<th class="text-center" rowspan="<?=$row_number_service?>">GOVERNMENT FEE</th>
					</tr>
					<tr>
						<th class="sub-heading text-center" colspan="<?=$col_number_service-2?>">NORMAL PROCESSING <br>(<?=$normal_pr_time?>)</th>
						<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">URGENT <br>(4-8 working hours)</th>
						<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">EMERGENCY <br>(1-4 working hours)</th>
						<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">HOLIDAY FEE <br>(weekend + holiday)</th>
					</tr>
					<?
						foreach ($tourist_visa_types as $visa_type) { 
					?>
					<tr>
						<td class="text-left"><?=$this->m_visa_type->load($visa_type)->name?></td>
						<td class="text-center"><?=${"tourist_{$visa_type}"}->service_fee?> USD/pax</td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">+ <?=$processing_fee->{"tourist_{$visa_type}_urgent"}?> USD/pax</span>
							<? } else { ?>
							NA
							<? } ?>
						</td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">+ <?=$processing_fee->{"tourist_{$visa_type}_emergency"}?> USD/pax</span>
							<? } else { ?>
							NA
							<? } ?>
						</td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">+ <?=$processing_fee->{"tourist_{$visa_type}_holiday"}?> USD/pax</span>
							<? } else { ?>
							NA
							<? } ?>
						</td>
						<td class="text-center"><?=${"tourist_{$visa_type}"}->stamp_fee?> USD/pax</td>
					</tr>
					<? } ?>
				</table>
				<? } ?>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon7.png"><h3>BUSINESS VISA FEES  <?=strtoupper(!empty($current_nation->name) ? 'FOR '.$current_nation->name : null)?></h3>
					</div>
					<div class="content">
						<p>Vietnam Business Visa (DN Category) is part of the required immigration process for those who enter Vietnam for business purposes attending business conferences, conventions, meetings, and other business-related events.</p>
					</div>
				</div>
				<?
					if (sizeof($business_visa_types)) {
						$row_number_service = 2;
						$col_number_service = 3;
				?>
					<table class="table table-bordered pricing-table">
						<tr>
							<th class="text-left" rowspan="<?=$row_number_service?>">TYPES OF VISA</th>
							<th class="text-center" colspan="<?=$col_number_service+1?>">PROCESSING FEE</th>
							<th class="text-center" rowspan="<?=$row_number_service?>">GOVERNMENT FEE</th>
						</tr>
						<tr>
							<th class="sub-heading text-center" colspan="<?=$col_number_service-2?>">NORMAL PROCESSING <br>(<?=$normal_pr_time?>)</th>
							<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">URGENT <br>(4-8 working hours)</th>
							<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">EMERGENCY <br>(1-4 working hours)</th>
							<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">HOLIDAY FEE <br>(weekend + holiday)</th>
						</tr>
						<?
							foreach ($tourist_visa_types as $visa_type) { 
						?>
						<tr>
							<td class="text-left"><?=$this->m_visa_type->load($visa_type)->name?></td>
							<td class="text-center"><?=${"business_{$visa_type}"}->service_fee?> USD/pax</td>
							<td class="text-center">
								<? if ($can_rush) { ?>
								<span class="red">+ <?=$processing_fee->{"business_{$visa_type}_urgent"}?> USD/pax</span>
								<? } else { ?>
								NA
								<? } ?>
							</td>
							<td class="text-center">
								<? if ($can_rush) { ?>
								<span class="red">+ <?=$processing_fee->{"business_{$visa_type}_emergency"}?> USD/pax</span>
								<? } else { ?>
								NA
								<? } ?>
							</td>
							<td class="text-center">
								<? if ($can_rush) { ?>
								<span class="red">+ <?=$processing_fee->{"business_{$visa_type}_holiday"}?> USD/pax</span>
								<? } else { ?>
								NA
								<? } ?>
							</td>
							<td class="text-center"><?=${"business_{$visa_type}"}->stamp_fee?> USD/pax</td>
						</tr>
						<? } ?>
					</table>
				<? } ?>
				<!-- <div class="vs-anotate">
					<p>All Business and Tourist visa private visa letter request 
					<br><span style="color:#ff0000">+ 10 USD letter</span> ( people or group) <br>
					Full package service: processing fee + Fast track 
					<br><span style="color:#ff0000">+ Stamping fee/ government fee</span></p>
					<div class="bg-anotate"></div>
				</div> -->
				<? if (sizeof($tourist_visa_types) && sizeof($business_visa_types)) { ?>
				<div class="show-button">
					<a class="btn btn-danger" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>">APPLY VISA NOW</a>
				</div>
				<? } ?>
			</div>
		</div>
		<div class="ext-service">
			<div class="container">
				<div class="title clearfix">
					<h2 class="home-sub-heading shadow-text">EXTRA SERVICE ON ARRIVAL AT THE AIRPORT</h2>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon1.png"><h3>FAST TRACK</h3>
					</div>
					<div class="content">
						<p>Airport fast track and VIP services was established to support the travelers to get Visa stamp and sticker without waiting in line faster than normal processing.</p>
					</div>
				</div>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="2">TYPE OF FAST TRACK</th>
						<th class="text-center" colspan="<?=sizeof($fc_ports)?>"><span style="color:#ff0000;">ARRIVAL AIRPORTS IN VIETNAM</span></th>
					</tr>
					<tr>
						<? foreach ($fc_ports as $port) { ?>
						<th class="sub-heading text-center"><?=strtoupper($port->short_name)?></th>
					<? } ?>
					</tr>
					
					<tr>
						<td class="text-left">NORMAL FAST TRACK</td>
						<? foreach ($fc_ports as $port) { ?>
							<td class="text-center"><?=$this->m_fast_checkin_fee->search(1, $port->id)?> USD/<span class="pax-number">pax</span></td>
						<? } ?>
					</tr>
					<tr>
						<td class="text-left">VIP FAST TRACK</td>
						<? foreach ($fc_ports as $port) { ?>
							<td class="text-center"><?=$this->m_fast_checkin_fee->search(2, $port->id)?> USD/<span class="pax-number">pax</span></td>
						<? } ?>
					</tr>
					<tr>
						<td class="text-left">FULL PACKAGE </td>
						<td class="text-center" colspan="4">Fast track and Government fees. You do not need to do anything at the airport </td>
					</tr>
				</table>
				<!-- <div class="ft-anotate">
					<p>Big Group will be discount, please contact us at : <span style="color:#ff0000">Visa@domain.com</span></p>
					<div class="bg-anotate"></div>
				</div> -->

				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon3.png"><h3>AIRPORT CAR PICK UP</h3>
					</div>
					<div class="content clearfix">
						<p>Smoothly experience of driving with our careful, well-trained and friendly drivers. <br>
						For the group of 1 to 12 person(s), you will be offered a private car for your group with the appropriate number of seats and fee as:</p>
					</div>
				</div>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-center" rowspan="2" colspan="">TYPE OF CAR</th>
						<th class="text-center" colspan="<?=sizeof($car_ports)?>"><span style="color:#ff0000;">PICK UP AT AIRPORT</span></th>
					</tr>
					<tr>
					<? foreach ($car_ports as $port) { ?>
						<th class="sub-heading text-center"><?=strtoupper($port->short_name)?></th>
					<? } ?>
					</tr>
					<tr>
						<td class="text-center" style="width: 10%;" rowspan="2"><strong>4 seat car</strong></td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(4, $port->id)?> USD/time</span>
							</td>
						<? } ?>
					</tr>
					<tr>
						<td class="text-center">3 people & 3 luggages + handbags
						</td>
						<td class="text-center">3 people & 3 luggages + handbags
						</td>
						<td class="text-center">3 people & 3 luggages + handbags
						</td>
						<td class="text-center">3 people & 3 luggages + handbags
						</td>
					</tr>
					
					<tr>
						<td class="text-center" style="width: 10%;" rowspan="2"><strong>7 seat car</strong></td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(7, $port->id)?> USD/time</span>
							</td>
						<? } ?>
					</tr>
					<tr>
						<td class="text-center">5 people & 5 luggages + handbags
						</td>
						<td class="text-center">5 people & 5 luggages + handbags
						</td>
						<td class="text-center">5 people & 5 luggages + handbags
						</td>
						<td class="text-center">5 people & 5 luggages + handbags
						</td>
					</tr>

					<tr>
						<td class="text-center" style="width: 10%;" rowspan="2"><strong>16 seat car</strong></td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(16, $port->id)?> USD/time</span>
							</td>
						<? } ?>
					</tr>
					<tr>
						<td class="text-center">12 people & 10 luggages + handbags
						</td>
						<td class="text-center">12 people & 10 luggages + handbags
						</td>
						<td class="text-center">12 people & 10 luggages + handbags
						</td>
						<td class="text-center">12 people & 10 luggages + handbags
						</td>
					</tr>
				</table>	
				<div class="tf-anotate">
					<p>This fee is ONLY applied from the airport to city center. If your destination is not in the centre, please fill in the hotel address here to check exact fee.</p>
				</div>
			</div>
		</div>
		<div class="ext-service-ins">
			<div class="container">
				<div class="title clearfix">
					<h2 class="home-sub-heading shadow-text">EXTRA SERVICE INSIDE VIETNAM</h2>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon2.png"><h3>VISA EXTENSION</h3>
					</div>
					<!-- <div class="content">
						<p>We can only process visa extension for who arrive at Tan Son Nhat Airports. If you arrive from Hanoi, please send passport to Immigration</p>
					</div> -->
				</div>
				<!-- <table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="2">TYPE OF VISA</th>
						<th class="text-center" colspan="2"><span style="color:#ff0000;">LENGHT OF STAY</span></th>
					</tr>
					<tr>
						<th class="text-center" colspan="">1 MONTH</span> </th>
						<th class="text-center" rowspan="">3 MONTHS</th>
					</tr>
					
					<tr>
						<td class="text-left">TOURIST</td>
						<td class="text-center">110 USD/person</td>
						<td class="text-center">240 USD/person</td>
					</tr>
					<tr>
						<td class="text-left">BUSINESS</td>
						<td class="text-center">150 USD/person</td>
						<td class="text-center">250 USD/person</td>
					</tr>
				</table> -->
				<div class="summary">
					<p>We can help you to extend a visa based on your current visa to stay longer without exitting Vietnam. You just need to send your passport scan, visa stamp and visa sticker to our email <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>. After checking the documents with Vietnam Immigration Department, we will inform you the extension fee. If you agree with that fee, please come to our office and give us your passport with 1 portrait photograph. We will submit it to the Vietnam Immigration to extend visa for you then. Please take note that Visa Extension must be done offline so we just assist who is in Ho Chi Minh city. If you stay in other cities, please find a travel agent nearby your location for support.</p>
				</div>
				<!-- <div class="ext-service-ins-anotate">
					<p>Please send all necessarry documents: passport scan, visa scan, immigration stamp to <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></p>
					<div class="bg-anotate"></div>
				</div> -->
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function($) {
		$('.btn-check').click(function(event) {
			window.location.href = "<?=BASE_URL?>" + "/visa-fee/" + $("#nation").val() + ".html";
		});

		$("#nation").change(function(){
			$(".available-visa").hide();
			if ($(this).val() != "") {
				var p = {};
				p["nation_id"] = $(this).find("option:selected").attr("nation-id");
				
				$.ajax({
					type: "POST",
					url: BASE_URL + "/Visa-processing/ajax-check-visa-available.html",
					data: p,
					dataType: "json",
					success: function(result) {
						var types_of_tourist = result[0];
						var types_of_business = result[1];
						
						if (!types_of_tourist && !types_of_business) {
							$(".voa-not-available").show();
							$(".voa-available").hide();
							$(".voa-business").hide();
							$(".voa-tourist").hide();
							$(".voa-button").hide();
						} else {
							$(".voa-not-available").hide();
							$(".voa-available").show();
							$(".voa-button").show();
						}
						if (types_of_tourist) {
							$(".voa-tourist").show();
						} else {
							$(".voa-tourist").hide();
						}
						if (types_of_business) {
							$(".voa-business").show();
						} else {
							$(".voa-business").hide();
						}
						
						$(".available-visa").show();
					}
				});
			}
		});
	});
</script>
