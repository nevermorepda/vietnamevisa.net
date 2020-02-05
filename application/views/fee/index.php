<?
	$document_required = $this->m_visa_fee->search($current_nation->id)->document_required;
	
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
			<div class="col-sm-3"></div>
			<div class="col-sm-9">
				<div class="text-content">
					<h1>VIETNAM <span class="border-text" style="padding: 10px 50px 0px 15px;">VISA FEES</span></h1>
					<div class="alternative-breadcrumb">
					<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
					</div>
					<ul>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Flexible processing fee</li>
						<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Chose your passport holder to be sure correct fees</li>
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

<div class="fee cluster-content">
	<div class="cluster-body">
		<div class="container">
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
					<div class="show-button m-2">
						<input type="submit" class="btn btn-general" value="CHECK FEE">
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
				<p>We are pleased to inform that <span class="red f16"><?=$current_nation->name?></span> is listed in the special nation list of the Vietnam Immigration Department. It takes more time for Vietnam Immigration Department to check carefully and process visa.</p>
				<p>In order to process your visa, please contact us via email address <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a> and supply us your:</p>
				<ul>
					<li><strong>Passport scan (personal informative page) </strong></li>
					<li><strong>Date of arrival and exit</strong></li>
					<li><strong>Purpose to enter Vietnam: business invitation letter or booking tour voucher of travel agency in Vietnam</strong></li>
					<li><strong>Flight ticket</strong></li>
					<li><strong>Hotel booking or staying address</strong></li>
				</ul>
				<p>The Vietnam Immigration Department will check your status within 2 days. Then we will inform the result for you. If your visa application is approved, we will send you the notification including the visa letter.</p>
				<p>For further questions please feel free to contact us via email <a class="red" title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></p>
			</div>
			<? } ?>
		</div>
		<div class="e-visa-fee">
			<div class="container">
				<div class="title">
					<h1 class="home-sub-heading">eVisa on arrival</h1>
					<h4 class="sub-title">(available for 26 landport and airport, 86 countries)</h4>
				</div>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="">E VISA TYPES</th>
						<th class="text-center" colspan="">PROCESSING FEE <br><span style="font-style: italic; font-size:15px">(Normal 3 days)</span> </th>
						<th class="text-center" rowspan="">GOVERMENT FEE</th>
						<th class="text-center" rowspan="">TOTAL</th>
						<th class="text-center" rowspan=""></th>
					</tr>
					<tr>
						<td class="text-left">1 month single for tourist</td>
						<td class="text-center"><?=$price_nation->evisa_tourist_1ms?></td>
						<td class="text-center">25</td>
						<td class="text-center"><?=25+($price_nation->evisa_tourist_1ms)?> USD/person</td>
						<td class="text-center">
							<div class="apply-button">
								<a class="btn-apl" href="">APPLY NOW</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-left">1 month single for business</td>
						<td class="text-center"><?=$price_nation->evisa_business_1ms?></td>
						<td class="text-center">25</td>
						<td class="text-center"><?=25+($price_nation->evisa_business_1ms)?> USD/person</td>
						<td class="text-center">
							<div class="apply-button">
								<a class="btn-apl" href="">APPLY NOW</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-left red">Urgent 1 business </td>
						<td class="text-center red" colspan="2">
							<span class="red">Plus <?=$processing_fee->evisa_tourist_1ms_urgent?> USD/pax</span>
						</td>
						<td class="text-center red"><?=$processing_fee->evisa_tourist_1ms_urgent?> USD/pax</td>
						<td class="text-center">
							<div class="apply-button">
								<a class="btn-apl" href="">APPLY NOW</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-left red">Emergency 1 business </td>
						<td class="text-center red" colspan="2">
							<span class="red">Plus <?=$processing_fee->evisa_tourist_1ms_emergency?> USD/pax</span>
						</td>
						<td class="text-center red"><?=$processing_fee->evisa_tourist_1ms_emergency?> USD/pax</td>
						<td class="text-center">
							<div class="apply-button">
								<a class="btn-apl" href="">APPLY NOW</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="visa-arrival-fee">
			<div class="container">
				<div class="title clearfix">
					<h1 class="home-sub-heading">Vietnam visa arrival</h1>
					<h4 class="sub-title">(available for International airport only, all countries can apply visa)</h4>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon6.png"><h3>TOURIST VISA</h3>
					</div>
					<div class="content">
						<p>Vietnam Tourist Visa or Vietnam Travel Visa (DL Category) is issued to those who wish to arrive in Vietnam for the purpose of visiting family members or friends or other personal affairs. In general, Tourist Visa is good for TOURISM purposes only.</p>
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
						<th class="text-center" rowspan="<?=$row_number_service?>">GOVERMENT FEE</th>
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
						<td class="text-center"><?=${"tourist_{$visa_type}"}->service_fee?></td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">Plus <?=$processing_fee->{"tourist_{$visa_type}_urgent"}?> USD/pax</span>
							<? } else { ?>
							NA
							<? } ?>
						</td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">Plus <?=$processing_fee->{"tourist_{$visa_type}_emergency"}?> USD/pax</span>
							<? } else { ?>
							NA
							<? } ?>
						</td>
						<td class="text-center">
							<? if ($can_rush) { ?>
							<span class="red">Plus <?=$processing_fee->{"tourist_{$visa_type}_holiday"}?> USD/pax</span>
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
						<img src="<?=IMG_URL?>new-template/icon/icon7.png"><h3>BUSINESS VISA</h3>
					</div>
					<div class="content">
						<p>Business Visa (DN Category) is issued to those who intend to go to Vietnam for business purposes, such as the negotiation of contracts, estate settlement, consultation with business associates, and participation in scientific, educational, professional or business conventions, conferences or seminars and other legitimate activities of a commercial or professional nature.</p>
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
								<th class="text-center" colspan="<?=$col_number_service+1?>">BUSINESS VISA FEE</th>
								<th class="text-center" rowspan="<?=$row_number_service?>">STAMPING FEE</th>
							</tr>
							<tr>
								<th class="sub-heading text-center" colspan="<?=$col_number_service-2?>">NORMAL PROCESSING <br>(<?=$normal_pr_time?>)</th>
								<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">URGENT <br>(4-8 working hours)</th>
								<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">EMERGENCY <br>(1-4 working hours)</th>
								<th class="sub-heading text-center red" rowspan="<?=$row_number_service-1?>">HOLIDAY FEE <br>(weekend + holiday)</th>
							</tr>
							<!--  -->
							<?
								foreach ($tourist_visa_types as $visa_type) { 
							?>
							<tr>
								<td class="text-left"><?=$this->m_visa_type->load($visa_type)->name?></td>
								<td class="text-center"><?=${"business_{$visa_type}"}->service_fee?></td>
								<td class="text-center">
									<? if ($can_rush) { ?>
									<span class="red">Plus <?=$processing_fee->{"business_{$visa_type}_urgent"}?> USD/pax</span>
									<? } else { ?>
									NA
									<? } ?>
								</td>
								<td class="text-center">
									<? if ($can_rush) { ?>
									<span class="red">Plus <?=$processing_fee->{"business_{$visa_type}_emergency"}?> USD/pax</span>
									<? } else { ?>
									NA
									<? } ?>
								</td>
								<td class="text-center">
									<? if ($can_rush) { ?>
									<span class="red">Plus <?=$processing_fee->{"business_{$visa_type}_holiday"}?> USD/pax</span>
									<? } else { ?>
									NA
									<? } ?>
								</td>
								<td class="text-center"><?=${"business_{$visa_type}"}->stamp_fee?> USD/pax</td>
							</tr>
							<? } ?>
						</table>
					<? } ?>
				<div class="vs-anotate">
					<p>All Business and Tourist visa private visa letter request 
					<br><span style="color:#ff0000">+ 10 USD letter</span> ( people or group) <br>
					Full package service: processing fee + Fast track 
					<br><span style="color:#ff0000">+ Stamping fee/ government fee</span></p>
					<div class="bg-anotate"></div>
				</div>
				<div class="show-button">
					<a class="btn btn-danger" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>">APPLY VISA NOW</a>
				</div>
			</div>
		</div>
		<div class="ext-service">
			<div class="container">
				<div class="title clearfix">
					<h1 class="home-sub-heading">Extra Service on arrival at the airport</h1>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon1.png"><h3>FAST TRACK</h3>
					</div>
					<div class="content">
						<p>We offer this service for you as VIP deligate of Officer. After long flight, businessman, ...</p>
					</div>
				</div>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-left" rowspan="2">TYPE FAST TRACK</th>
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
						<td class="text-left">FULL SERVICE </td>
						<td class="text-center" colspan="4">Normal Fast track + Goverment fees. You dont need to do anything at the airport</td>
					</tr>
				</table>
				<div class="ft-anotate">
					<p>Big Group will be discount, please contact us at : <span style="color:#ff0000">Visa@domain.com</span></p>
					<div class="bg-anotate"></div>
				</div>

				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon3.png"><h3>TRANSFER</h3>
					</div>
					<div class="content clearfix">
						<p>We offers private car who wait for you with businessman.<br>
						We do for all car of service, even you can rent a car for long trips. More information please visit us.</p>
						<div class="apply-button m-2" style="display: inline-flex;">
							<a class="btn-apl" href="">MORE DETAIL</a>
						</div>
					</div>
				</div>
				<table class="table table-bordered pricing-table">
					<tr>
						<th class="text-center" rowspan="2" colspan="2">TYPE OF CAR</th>
						<th class="text-center" colspan="<?=sizeof($car_ports)?>"><span style="color:#ff0000;">ARRIVAL AIRPORTS IN VIETNAM</span></th>
					</tr>
					<tr>
					<? foreach ($car_ports as $port) { ?>
						<th class="sub-heading text-center"><?=strtoupper($port->short_name)?></th>
					<? } ?>
					</tr>
					<tr>
						<td class="text-center" style="width: 10%;"><strong>4</strong></td>
						<td class="text-center" rowspan="2">SEATS</td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(4, $port->id)?> USD/car</span>
								<br>capacity 2-3 people
								<br>3 lugagues
							</td>
						<? } ?>
					</tr>
					
					<tr>
						<td class="text-center" style="width: 10%;"><strong>7</strong></td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(7, $port->id)?> USD/car</span>
								<br>capacity 2-3 people
								<br>3 lugagues
							</td>
						<? } ?>
					</tr>

					<tr>
						<td class="text-center" style="width: 10%;"><strong>16</strong></td>
						<td class="text-center" rowspan="2">SEATS</td>
						<? foreach ($car_ports as $port) { ?>
							<td class="text-center"><span style="color: #ff0000; font-weight: 600;"><?=$this->m_car_fee->search(16, $port->id)?> USD/car</span>
								<br>capacity 2-3 people
								<br>3 lugagues
							</td>
						<? } ?>
					</tr>
				</table>	
				<div class="tf-anotate">
					<p>For Car rental, please contact us at : <span style="color:#ff0000">Visa@domain.com</span></p>
					<div class="bg-anotate"></div>
				</div>
			</div>
		</div>
		<div class="ext-service-ins">
			<div class="container">
				<div class="title clearfix">
					<h1 class="home-sub-heading">Extra Service inside Vietnam</h1>
				</div>
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon2.png"><h3>VISA EXTENSION</h3>
					</div>
					<div class="content">
						<p>We can only process visa extension for who arrive at Tan Son Nhat Airports. If you arrive from Hanoi, please send passport to Immigration</p>
					</div>
				</div>
				<table class="table table-bordered pricing-table">
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
				</table>
				<div class="ext-service-ins-anotate">
					<p>Please send all necessarry documents: passport scan, visa scan, immigration stamp to <span style="color:#ff0000">visa@vietnam-visa.org.vn</span></p>
					<div class="bg-anotate"></div>
				</div>
			</div>
		</div>
		<div class="optional-tours">
			<div class="container">
				<div class="wrap-service-type">
					<div class="heading clearfix">
						<img src="<?=IMG_URL?>new-template/icon/icon4.png"><h3>OPTIONAL TOURS</h3>
					</div>
					<div class="content">
						<p>We offer short tours for city, please click to find which suitable for you</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="thumb-tour">
							<img src="<?=IMG_URL?>new-template/thumbnail/thumb-tour1.png">
						</div>
						<div class="content">
							<div class="title-tour">Cu Chi Tunel</div>
							<div class="description">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="thumb-tour">
							<img src="<?=IMG_URL?>new-template/thumbnail/thumb-tour2.png">
						</div>
						<div class="content">
							<div class="title-tour">City Tours</div>
							<div class="description">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
							</div>
						</div>
					</div>
				</div>
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