<?
	$fee = $this->m_visa_fee->search(0);
	$processing_fee = $this->m_processing_fee->items()[0];
?>
<div class="<?=$this->util->slug($this->router->fetch_class())?>">
	<div class="banner-top faqs-banner d-none d-sm-none d-md-block" style="background: url('<?=IMG_URL?>new-template/banner-faqs.png') no-repeat scroll top center transparent;">
		<img src="<?=IMG_URL?>new-template/flag-faqs.png" class="img-responsive flag-faqs" alt="flag-faqs">
		<div class="container">
			<div class="text-content">
				<h1>
					<span class="" style="">HOW IT WORKS</span>
					<div class="bd-right d-none d-lg-block d-md-block"></div>
				</h1>
				<ul>
					<li>Online processing, time saving </li>
					<li>No passport to send-off</li>
				</ul>
			</div>
		</div>
	</div>
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
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	</div>
	<div class="howitworks-content"  style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
		<div class="process">
			<div class="container">
				<h2 class="home-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Application Process</h2>
				<div class="row">
					<div class="col-sm-6 col-lg-3 col-md-6">
						<div class="box-step p-3" style="border: 5px solid #ffcd0e;">
							<div class="step-numb" style="color: #ffcd0e;">1</div>
							<div class="step-title" style="color: #ffcd0e;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon1.png">
								<h3>Apply Online</h3>
							</div>
							<div class="step-content">
								<p>Fill out online visa application form by providing your passport information.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 col-md-6">
						<div class="box-step p-3" style="border: 5px solid #de8c15;">
							<div class="step-numb" style="color: #de8c15;">2</div>
							<div class="step-title" style="color: #de8c15;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon2.png">
								<h3>Payment online</h3>
							</div>
							<div class="step-content">
								<p>Make payment for our visa service via Online Payment Gates.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 col-md-6">
						<div class="box-step p-3" style="border: 5px solid #ba411d;">
							<div class="step-numb" style="color: #ba411d;">3</div>
							<div class="step-title" style="color: #ba411d;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon3.png">
								<h3>Receive Visa Letter</h3>
							</div>
							<div class="step-content">
								<p>You will get the Approval Letter or Electronic Visa via email as the confirmation.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 col-md-6">
						<div class="box-step p-3" style="border: 5px solid #a92020;">
							<div class="step-numb" style="color: #a92020;">4</div>
							<div class="step-title" style="color: #a92020;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon4.png">
								<h3>Get visa stamp</h3>
							</div>
							<div class="step-content">
								<p>Present your visa letter at check-in point to get Vietnam Visa Stamp upon arrival.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="apl-button text-center pt-3">
					<a class="btn btn-danger" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>">APPLY VISA</a>
				</div>
			</div>
		</div>
		<div class="different">
			<div class="container">
				<h2 class="home-sub-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">The Difference Between <br>
					<span style="color: #851919">Vietnam Visa On Arrival</span> <span style="font-size: 25px;">&</span> <span style="color: #de8c15">Vietnam Electronic Visa</span>
				</h2>
				<div class="row">
					<div class="col-sm-6">
						<div class="content-left">
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">How it look?</h5>
								</div>
								<div class="content"><img class="full-width" src="<?=IMG_URL?>/Vietnam-visa-stamp-on-arrival.png" alt=""></div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="content-right">
							<div class="item">
								<div class="title">
									<h5><img  src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">How it look?</h5>
								</div>
								<div class="content"><img class="full-width" src="<?=IMG_URL?>/vietnam-evisa-for-panama-citizens-1.png" alt=""></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">How to apply</h5>
							</div>
							<div class="content">
								<p><span style="color: #851919; font-weight: 600;">Step 1:</span>Fill in the application form for Visa On Arrival <a href="http://www.vietnamevisa.net/apply-visa.html"><span class="font-italic">here</span></a> to choose the type of visa</p>
								<p><span style="color: #851919; font-weight: 600;">Step 2:</span> Double check the information and make the payment by Credit/Debit Card via Online Payment Gates and Bank Transfer</p>
								<p><span style="color: #851919; font-weight: 600;">Step 3:</span> : You will receive an email with your application ID in the title to confirm about the successful visa application and the time when you will receive the Approval Letter via email</p>
								<p><span style="color: #851919; font-weight: 600;">Step 4:</span> Advising to print the Approval Letter out in advance to board the plane and get the visa upon arrival with the documents: 2 portraits size 4x6 cm, the Entry & Exit form, Stamping Fee in cash and the Approval Letter printing in color.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">How to apply</h5>
							</div>
							<div class="content">
								<p><span style="color: #de8c15; font-weight: 600;">Step 1:</span> Fill in the application form for Electronic Visa <a href="http://www.vietnamevisa.net/apply-visa.html"><span class="font-italic">here</span></a> to choose the type of visa</p>
								<p><span style="color: #de8c15; font-weight: 600;">Step 2:</span> Double check the information and make the payment by Credit/Debit Card via Online Payment Gates and Bank Transfer. Fill in the passport information and upload the portrait and passport scan in *.jpg, *.png or *.gif and the maximum upload file size is 8MB.</p>
								<p><span style="color: #de8c15; font-weight: 600;">Step 3:</span> You will receive an email to confirm successful visa application with the application ID in the title and the time when we will send the Electronic Visa to your email</p>
								<p><span style="color: #de8c15; font-weight: 600;">Step 4:</span> Advising to print the Electronic Visa out in advance and show at the exactly entry port to get the visa stamp upon arrival without paying any fee.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Effect from 2003</h5>
							</div>
							<div class="content"></div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Effect from 2017</h5>
							</div>
							<div class="content"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item d-table">
							<div class="title d-table-cell">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Purpose of Visit:</h5>
							</div>
							<div class="content d-table-cell">Tourist/Busines</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item d-table">
							<div class="title d-table-cell">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Purpose of Visit:</h5>
							</div>
							<div class="content d-table-cell">Tourist/Busines</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item d-table">
							<div class="title d-table-cell">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Type of visa:</h5>
							</div>
							<div class="content d-table-cell">
								<p>Single/multiple entry</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item d-table">
							<div class="title d-table-cell">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Type of visa:</h5>
							</div>
							<div class="content d-table-cell">
								<p>Only single entry</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item ">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Length of stay:</h5>
							</div>
							<div class="content">
								<ul>
									<li>1 – 3 months</li>
									<li>6 months - 1 year (United State of America ONLY)</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item ">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Length of stay:</h5>
							</div>
							<div class="content">
								<ul>
									<li>30 days</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Involving fees:</h5>
							</div>
							<div class="content">
								<p>Requires to pay fee for the visa approval letter and stamp fee in cash at Vietnam Airport when collecting visa on arrival</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Involving fees:</h5>
							</div>
							<div class="content">
								<p>Requires you pay once and no need to pay any fee on arrival</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Processing time:</h5>
							</div>
							<div class="content">
								<ul>
									<li>1-2 working days for normal case</li>
									<li>4-8 working hours for urgent case</li>
									<li>30 mins for emergency case</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Processing time:</h5>
							</div>
							<div class="content">
								<ul>
									<li>3 working days for Normal case</li>
									<li>1-2 working hours for Urgent case</li>
									<li>Non-available Emergency case</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Eligible ports:</h5>
							</div>
							<div class="content">
								<ul>
									<li>Tan Son Nhat Airport (Ho Chi Minh)</li>
									<li>Noi Bai Airport (Ha Noi)</li>
									<li>Cam Ranh Airport (Nha Trang)</li>
									<li>Da Nang Airport</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Eligible ports:</h5>
							</div>
							<div class="content">
								<p>8 airports, 16 land ports, and 9 seaports. Check Eligible Ports <a href="<?=DOC_URL?>List-of-evisa-port.pdf"><span class="font-italic">here</span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">How to use:</h5>
							</div>
							<div class="content">
								<p>Requires visitors to apply online for a visa approval letter first, then get the visa at Landing Visa Counter at Vietnam airport before going to the passport control. A visa stamping fee is required to pay in cash on arrival.</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">How to use:</h5>
							</div>
							<div class="content">
								<p>When the travelers arrive in Vietnam going to the Passport Control to show E-Visa for checking and get the Stamp on the passport for 30 days without paying any fees.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col col-sm-6">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Countries of permit</h5>
							</div>
							<div class="content">
								<div class="nation clearfix">
									<?
										$regions = array();
										foreach ($requirements as $requirement) {
											if (!in_array($requirement->country_region, $regions)) {
												$regions[] = $requirement->country_region;
											}
										}
										sort($regions);
									?>
									<table class="table">
										<? $dem=0; foreach ($regions as $region) { 
											$info = new stdClass();
											$info->region = $region;
											$region_items = $this->m_requirement->join_country_items($info,1);
										?>
										<tr>
											<td width="100px"><?=$region?></td>
											<td>
												<?if(!empty($region_items)) {  $c = count($region_items); foreach ($region_items as $key => $region_item) { ?>
													<a href="<?=site_url("visa-requirements/{$region_item->alias}");?>"><?=$region_item->citizen;?><?=($key < ($c-1)) ? ', ' : '' ?> </a> 
												<? } } else {
													echo 'N/A';
												} ?>
											</td>
										</tr>
										<? } ?>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col col-sm-6 right" style="border-left: 2px dashed #ccc;">
						<div class="item">
							<div class="title">
								<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Countries of permit</h5>
							</div>
							<div class="content">
								<div class="nation clearfix">
									<?
										$regions = array();
										foreach ($requirements as $requirement) {
											if (!in_array($requirement->country_region, $regions)) {
												$regions[] = $requirement->country_region;
											}
										}
										sort($regions);
									?>
									<table class="table">
										<? $dem=0; foreach ($regions as $region) { 
											$info = new stdClass();
											$info->region = $region;
											$info->type = 1;
											$region_items = $this->m_requirement->join_country_items($info,1);
										?>
										<tr>
											<td width="100px"><?=$region?></td>
											<td>
												<?if(!empty($region_items)) { $c = count($region_items); foreach ($region_items as $key => $region_item) { ?>
													<a href="<?=site_url("visa-requirements/{$region_item->alias}");?>"><?=$region_item->citizen;?><?=($key < ($c-1)) ? ', ' : '' ?> </a> 
												<? } } else {
													echo 'N/A';
												} ?>
											</td>
										</tr>
										<? } ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="apl-button text-center pt-3">
					<a class="btn btn-danger" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>">APPLY VISA NOW</a>
				</div>
			</div>
		</div>
	</div>
</div>

