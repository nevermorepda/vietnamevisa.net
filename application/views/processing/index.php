<?
	$fee = $this->m_visa_fee->search(0);
	$processing_fee = $this->m_processing_fee->items()[0];
?>
<div class="<?=$this->util->slug($this->router->fetch_class())?>">
	<div class="banner-top howitworks-banner" style="background: url('<?=IMG_URL?>new-template/HowItWorks-banner.png') no-repeat scroll top center transparent;">
		<div class="container">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-8">
					<div class="text-content">
						<h1>HOW <span class="border-text" style="padding: 10px 75px 0px 15px;">IT WORKS</span></h1>
						<div class="alternative-breadcrumb">
						<!-- <? require_once(APPPATH."views/module/breadcrumb.php"); ?> -->
						</div>
						<ul>
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Online processing, time saving </li>
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">No passport to send-off </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="slide-contact">
		<div class="container">
			<ul>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-vn.png"><a href="" title="Contact hotline"><?=HOTLINE?></a></li>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-usa.png"><a href="" title="Contact hotline"><?=HOTLINE_US?></a></li>
				<li><a href="" title="Contact hotline"><i class="fa fa-envelope-o" aria-hidden="true"></i><?=MAIL_INFO?></a></li>
			</ul>
		</div>
	</div>
	<div class="howitworks-content"  style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
		<div class="process">
			<div class="container">
				<h2 class="home-sub-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Application Process</h2>
				<div class="row">
					<div class="col-sm-6 col-lg-3 col-md-6">
						<div class="box-step p-3" style="border: 5px solid #ffcd0e;">
							<div class="step-numb" style="color: #ffcd0e;">1</div>
							<div class="step-title" style="color: #ffcd0e;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon1.png">
								<h3>APPLY ONLINE</h3>
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
								<h3>PAYMENT ONLINE</h3>
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
								<h3>RECEIVE VISA LETTER</h3>
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
								<h3>GET VISA STAMP UPON ARRIVAL</h3>
							</div>
							<div class="step-content">
								<p>Present your visa letter at check-in point to get Vietnam visa stamp.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="different">
			<div class="container">
				<h2 class="home-sub-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">The different between <br>
					<span style="color: #851919">Vietnam Visa on arrival</span> & <span style="color: #de8c15">Vietnam Electronic Visa</span>
				</h2>
				<div class="row">
					<div class="col-sm-6">
						<div class="content-left">
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Effect from 1986</hh55>
								</div>
								<div class="content"></div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Airport only</h5>
								</div>
								<div class="content"></div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Type of visa</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Lenght of stay</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Visa approval letter look like</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon1.png" alt="">Valid for Airorts</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
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
													<? $c = count($region_items); foreach ($region_items as $key => $region_item) { ?>
														<a href="<?=site_url("visa-requirements/{$region_item->alias}");?>"><?=$region_item->citizen;?><?=($key < ($c-1)) ? ', ' : '' ?> </a> 
													<?  } ?>
												</td>
											</tr>
											<? } ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6" style="border-left: 2px dashed #ccc;">
						<div class="content-right">
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Effect 2017</h5>
								</div>
								<div class="content"></div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">26 ports and Airports</h5>
								</div>
								<div class="content"></div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Type of visa</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Lenght of stay</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Visa approval letter look like</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
							<div class="item">
								<div class="title">
									<h5><img src="<?=IMG_URL?>new-template/icon/list-icon2.png" alt="">Valid for Airorts</h5>
								</div>
								<div class="content">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
								</div>
							</div>
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
												$region_items = $this->m_requirement->join_country_items($info,1);
											?>
											<tr>
												<td width="100px"><?=$region?></td>
												<td>
													<? $c = count($region_items); foreach ($region_items as $key => $region_item) { ?>
														<a href="<?=site_url("visa-requirements/{$region_item->alias}");?>"><?=$region_item->citizen;?><?=($key < ($c-1)) ? ', ' : '' ?> </a> 
													<?  } ?>
												</td>
											</tr>
											<? } ?>
										</table>
									</div>
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

