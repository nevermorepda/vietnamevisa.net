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
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
							<li><img src="<?=IMG_URL?>new-template/icon/icon-top.png">Sed do eiusmod tempor incididunt ut labore et dolore magna </li>
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
				<h2 class="home-sub-heading text-center" style="padding-top: 15px; padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Application Process</h2>
				<div class="row">
					<div class="col-sm-3">
						<div class="box-step p-3" style="border: 5px solid #ffcd0e;">
							<div class="step-numb" style="color: #ffcd0e;">1</div>
							<div class="step-title" style="color: #ffcd0e;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon1.png">
								<h3>Apply Online</h3>
							</div>
							<div class="step-content">
								<p>Fill all passport details to the form online</p>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box-step p-3" style="border: 5px solid #de8c15;">
							<div class="step-numb" style="color: #de8c15;">2</div>
							<div class="step-title" style="color: #de8c15;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon2.png">
								<h3>Payment</h3>
							</div>
							<div class="step-content">
								<p>Check inforamtion and settle the processing fee</p>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box-step p-3" style="border: 5px solid #ba411d;">
							<div class="step-numb" style="color: #ba411d;">3</div>
							<div class="step-title" style="color: #ba411d;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon3.png">
								<h3>Get approval letter</h3>
							</div>
							<div class="step-content">
								<p>Vietnam visa letter send to your email</p>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box-step p-3" style="border: 5px solid #a92020;">
							<div class="step-numb" style="color: #a92020;">4</div>
							<div class="step-title" style="color: #a92020;">
								<img src="<?=IMG_URL?>new-template/icon/hiw-icon4.png">
								<h3>Get visa</h3>
							</div>
							<div class="step-content">
								<p>Get your visa sticker/visa stamp on arrival ports</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="different">
			<div class="container">
				<h2 class="home-sub-heading text-center" style="padding-top: 15px; padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">The different between <br>
					<span style="color: #851919">Vietnam Visa on arrival</span> & <span style="color: #de8c15">Vietnam eVisa on arrival</span>
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
										<? $dem=0; foreach ($regions as $region) { 
											$info = new stdClass();
											$info->region = $region;
											$region_items = $this->m_requirement->join_country_items($info,1);
											$c = ceil(count($region_items)/4);
											$c_items = count($region_items);
										?>
										<div class="nation_permit pb-4">
											<div class="nation_title pb-3"><?=$region;?></div>
											<table>
												<?
												$str = '';
												for ($i=0; $i < $c; $i++) { 
													$str .= '<tr>';
													for ($j = 4*$i; $j < 4*($i+1); $j++) { 
														if (!empty($region_items[$j])) {
															$str .= '<td>'.'<a href="'.site_url("visa-requirements/{$region_items[$j]->alias}").'">'.$region_items[$j]->citizen.'</a></td>';
														}
													}
													$str .= '</tr>';
												}
												echo $str;
												?>
											</table>
										</div>
										<? } ?>
										<!-- <div class="row permit">
											<? foreach ($regions as $region) { ?>
											<div class="col-sm-3 number"><?=$region;?></div>
											<div class="col-sm-9">
												<ul class="row list">
													<? foreach ($requirements as $requirement) { ?>
														<? if ($requirement->country_region == $region) { ?>
														<li class="col-sm-4"><a href=""><?=$requirement->citizen?></a></li>
														<? } ?>
													<? } ?>
												</ul>
											</div>
											<? } ?>
										</div> -->
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
									<div class="list-countries">
										<div class="group-contries group-A">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">A</a></div>
											<div class="sonline"><a href="">Armenia</a></div>
											<div class="sonline"><a href="">Australia</a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries">
											<div class="sonline"><a href="">Argentina</a></div>
											<div class="sonline"><a href="">Austria</a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-B">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">B</a></div>
											<div class="sonline"><a href="">Belgium</a></div>
											<div class="sonline"><a href="">Brazil</a></div>
											<div class="sonline"><a href="">Bulgaria</a></div>
										</div>
										<div class="group-contries">
											<div class="sonline"><a href="">Belarus</a></div>
											<div class="sonline" style="width: 50%;"><a href="">Bosnia and Herzegovina</a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-C">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">C</a></div>
											<div class="sonline"><a href="">Chile</a></div>
											<div class="sonline"><a href="">China (<span class="required">*</span>)</a></div>
											<div class="sonline"><a href="">Colombia</a></div>
										</div>
										<div class="group-contries">
											<div class="sonline"><a href="">Canada</a></div>
											<div class="sonline" style="width: 50%;"><a href="">Czech Republic</a></div>
											<div class="sonline"><a href="">Croatia</a></div>
										</div>
										<div class="group-contries group-D">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">D</a></div>
											<div class="sonline"><a href="">Denmark</a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-E">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">E</a></div>
											<div class="sonline"><a href="">Estonia</a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-F">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">F</a></div>
											<div class="sonline"><a href="">Finland</a></div>
											<div class="sonline"><a href="">Fiji</a></div>
											<div class="sonline"><a href="">France</a></div>
										</div>
										<div class="group-contries group-G">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">G</a></div>
											<div class="sonline"><a href="">Georgia</a></div>
											<div class="sonline"><a href="">Germany</a></div>
											<div class="sonline"><a href="">Greece</a></div>
										</div>
										<div class="group-contries group-H">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">H</a></div>
											<div class="sonline"><a href="">Hungary</a></div>
											<div class="sonline"><a href="">HongKong</a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-I">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">I</a></div>
											<div class="sonline"><a href="">India</a></div>
											<div class="sonline"><a href="">Iceland</a></div>
											<div class="sonline"><a href="">Ireland</a></div>
										</div>
										<div class="group-contries">
											<div class="sonline"><a href="">Italy</a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
										</div>
										<div class="group-contries group-J">
											<div class="sonline"><a href="" style="background:#ebebeb;font-weight: 600;">J</a></div>
											<div class="sonline"><a href="">Japan</a></div>
											<div class=""><a href=""></a></div>
											<div class=""><a href=""></a></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="faqs cluster-content"  style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
		<div class="container">
			<h2 class="home-sub-heading" style="padding-top: 15px; padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">More question about Visa to Vietnam</h2>
			<div class="row">
				<div class="col-md-6">
					<ul>
						<? $i = 0;
						foreach ($faqs as $faq) { ?>
						<li>
							<h3 class="click-faqs" status="0" data-index="<?=$faq->id?>" id="faqs-<?=$faq->id?>" ><a class="collapsed" rel="nofollow" title="<?=$faq->title?>" data-toggle="collapse" aria-expanded="false" aria-controls="collapse"><?=($i+1)?>. <?=$faq->title?></a></h3>
							<div class="collapse" id="detail<?=$faq->id?>">
								<p><?=$faq->content?></p>
							</div>
						</li>
						<? $i++; } ?>
					</ul>
				</div>
				<div class="col-md-6">
					<ul>
						<? $i = 0;
						foreach ($evisa_faqs as $evisa_faq) { ?>
						<li>
							<h3 class="click-faqs" status="0" data-index="<?=$evisa_faq->id?>" id="faqs-<?=$evisa_faq->id?>" ><a class="collapsed" rel="nofollow" title="<?=$evisa_faq->title?>" data-toggle="collapse" aria-expanded="false" aria-controls="collapse"><?=($i+1)?>. <?=$evisa_faq->title?></a></h3>
							<div class="collapse" id="detail<?=$evisa_faq->id?>">
								<p><?=$evisa_faq->content?></p>
							</div>
						</li>
						<? $i++; } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('.click-faqs').click(function() {
				var faqsIndex = parseInt($(this).data('index'));
				$('#detail' + faqsIndex).slideToggle();
				var stt = parseInt($(this).attr('status'));
				if (stt == 0) {
					$(this).attr('status',1);
					$(this).addClass('collapsed')
				} else {
					$(this).attr('status',0);
					$(this).removeClass('collapsed')
				}
			});
		});
	</script>

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
								<a class="btn btn-general" href="./about-us.html">SHOW MORE</a>
								<div class="bg-btn transition" style="width: 100%;"></div>
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
	<!-- <div class="slide-bar d-none d-sm-none d-md-block">
		<div class="slide-wrap">
			<div class="slide-content">
				<div class="container">
					<div class="visa-process-wrap">
						<div class="cluster-heading">
							<div class="text-center">
								<h1>VISA APPLICATION PROCESS</h1>
								<div class="heading-div"></div>
							</div>
						</div>
						<div class="cluster-body pr-section-bg">
							<div class="row">
								<div class="col-sm-3">
									<div class="row">
										<div class="col-xs-3 col-sm-12">
											<div class="text-center">
												<img class="img-responsive img-circle img-pr" alt="Apply Visa" src="<//?=IMG_URL?>step/step-1.jpg" style="max-width: 189px;">
											</div>
										</div>
										<div class="col-xs-9 col-sm-12">
											<div class="text-center">
												<div class="pr-block clearfix">
													<div class="pr-blockL">1</div>
													<div class="pr-blockR text-left">
														<h4>Apply online</h4>
														<p>Complete your online visa application form</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="row">
										<div class="col-xs-3 col-sm-12">
											<div class="text-center">
												<img class="img-responsive img-circle img-pr" alt="Visa Fee" src="<//?=IMG_URL?>step/step-2.jpg" style="max-width: 189px;">
											</div>
										</div>
										<div class="col-xs-9 col-sm-12">
											<div class="text-center">
												<div class="pr-block clearfix">
													<div class="pr-blockL">2</div>
													<div class="pr-blockR text-left">
														<h4>Make payment</h4>
														<p>Get confirmation and pay the service fee</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="row">
										<div class="col-xs-3 col-sm-12">
											<div class="text-center">
												<img class="img-responsive img-circle img-pr" alt="Visa Letter" src="<//?=IMG_URL?>step/step-3.jpg" style="max-width: 189px;">
											</div>
										</div>
										<div class="col-xs-9 col-sm-12">
											<div class="text-center">
												<div class="pr-block clearfix">
													<div class="pr-blockL">3</div>
													<div class="pr-blockR text-left">
														<h4>Get approval letter/E-visa</h4>
														<p>Receive your visa approval letter/E-visa and instructions to get visa stamped</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="row">
										<div class="col-xs-3 col-sm-12">
											<div class="text-center">
												<img class="img-responsive img-circle img-pr" alt="Visa Stamped" src="<//?=IMG_URL?>step/step-4.jpg" style="max-width: 189px;">
											</div>
										</div>
										<div class="col-xs-9 col-sm-12">
											<div class="text-center">
												<div class="pr-block clearfix">
													<div class="pr-blockL">4</div>
													<div class="pr-blockR text-left">
														<h4>Get visa stamp</h4>
														<p>Have your visa stamped upon arrival</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="cluster">
		<div class="container">
			<div class="cluster-heading wow fadeInUp">
				<div class="text-center title">
					<h2 class="text-center heading">TYPES <span class="text-color-red">OF VISA</span></h2>
				</div>
			</div>
			<div class="cluster-body pr-section-bg wow fadeInUp">
				<div class="wrap-type-visa">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6 d-none d-lg-block">
									<a href="<//?=site_url('visa-processing')?>"><img class="img-thumnail full-width img-responsive img-pr" alt="" src="<//?=IMG_URL?>voa-home.png"></a>
								</div>
								<div class="description col-md-6">
									<h4><a class="title" title="Vietnam Visa On Arrival" href="<//?=site_url('visa-processing')?>">Vietnam Visa On Arrival</a></h4>
									<ul>
										<li> Valid in 1 month or 3 months with single or multiple entries.</li>
										<li>For those who enter Vietnam by airports only.</li>
										<li>Visitors can enter Vietnam at either Ho Chi Minh, Ha Noi, Cam Ranh or Da Nang airport with this type of visa.</li>
									</ul>
									<p><a href="<//?=site_url('apply-visa')?>" class="btn btn-danger" style="font-size: 13px;">APPLY NOW</a> <a href="<//?=site_url('vietnam-visa-on-arrival')?>" class="btn btn-danger" style="font-size: 13px;">READ MORE</a></p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6 d-none d-lg-block">
									<a href="<//?=site_url('vietnam-e-visa')?>"><img class="img-thumnail full-width img-responsive img-pr" alt="" src="<//?=IMG_URL?>evisa-home.png"></a>
								</div>
								<div class="description col-md-6">
									<h4><a class="title" title="Vietnam E-visa" href="<//?=site_url('vietnam-e-visa')?>">Vietnam E-visa</a></h4>
									<ul>
										<li> Valid in 1 month only with a single entry.</li>
										<li> For those who enter Vietnam by airports, land ports, seaports.</li>
										<li> With this visa, tourists can only enter Vietnam at the port that issued.</li>
									</ul>
									<p><a href="<//?=site_url('apply-e-visa')?>" class="btn btn-danger" style="font-size: 13px;">APPLY NOW</a> <a href="<//?=site_url('vietnam-e-visa')?>" class="btn btn-danger" style="font-size: 13px;">READ MORE</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="service-fees d-none d-lg-block">
				<div class="tourist-visa-fee">
					<table class="table table-bordered pricing-table">
						<tbody>
							<tr>
								<th class="text-left" rowspan="2">TOURIST VISA</th>
								<th class="text-center" colspan="3">SERVICE FEE</th>
								<th class="text-center" rowspan="2">STAMPING FEE</th>
							</tr>
							<tr>
								<th class="sub-heading text-center" rowspan="1" colspan="1">NORMAL PROCESSING <br>(24-48 working hours)</th>
								<th class="sub-heading text-center red" rowspan="1">URGENT <br>(4-8 working hours)</th>
								<th class="sub-heading text-center red" rowspan="1">EMERGENCY <br>(1-4 working hours)</th>
							</tr>
							<tr>
								<td class="text-left">1 month single (E-visa)</td>
								<td class="text-center"><//?=$fee->evisa_tourist_1ms?> USD</td>
								<td class="text-center red">Plus <//?=$processing_fee->evisa_tourist_1ms_urgent?> USD/pax</td>
								<td class="text-center red">Plus <//?=$processing_fee->evisa_tourist_1ms_emergency?> USD/pax</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month single</td>
								<td class="text-center"><//?=$fee->tourist_1ms?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_1ms_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_1ms_emergency?> USD/pax</span>
								</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month multiple</td>
								<td class="text-center"><//?=$fee->tourist_1mm?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_1mm_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_1mm_emergency?> USD/pax</span>
								</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months single</td>
								<td class="text-center"><//?=$fee->tourist_3ms?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_3ms_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_3ms_emergency?> USD/pax</span>
								</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months multiple</td>
								<td class="text-center"><//?=$fee->tourist_3mm?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_3mm_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->tourist_3mm_emergency?> USD/pax</span>
								</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="service-fees d-none d-lg-block">
				<div class="tourist-visa-fee">
					<table class="table table-bordered pricing-table">
						<tbody>
							<tr>
								<th class="text-left" rowspan="2">BUSINESS VISA</th>
								<th class="text-center" colspan="3">SERVICE FEE</th>
								<th class="text-center" rowspan="2">STAMPING FEE</th>
							</tr>
							<tr>
								<th class="sub-heading text-center" rowspan="1" colspan="1">NORMAL PROCESSING <br>(24-48 working hours)</th>
								<th class="sub-heading text-center red" rowspan="1">URGENT <br>(4-8 working hours)</th>
								<th class="sub-heading text-center red" rowspan="1">EMERGENCY <br>(1-4 working hours)</th>
							</tr>
							<tr>
								<td class="text-left">1 month single (E-visa)</td>
								<td class="text-center"><//?=$fee->evisa_business_1ms?> USD</td>
								<td class="text-center red">Plus <//?=$processing_fee->evisa_business_1ms_urgent?> USD/pax</td>
								<td class="text-center red">Plus <//?=$processing_fee->evisa_business_1ms_emergency?> USD/pax</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month single</td>
								<td class="text-center"><//?=$fee->business_1ms?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_1ms_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_1ms_emergency?> USD/pax</span>
								</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month multiple</td>
								<td class="text-center"><//?=$fee->business_1mm?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_1mm_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_1mm_emergency?> USD/pax</span>
								</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months single</td>
								<td class="text-center"><//?=$fee->business_3ms?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_3ms_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_3ms_emergency?> USD/pax</span>
								</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months multiple</td>
								<td class="text-center"><//?=$fee->business_3mm?> USD</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_3mm_urgent?> USD/pax</span>
								</td>
								<td class="text-center">
									<span class="red">Plus <//?=$processing_fee->business_3mm_emergency?> USD/pax</span>
								</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="service-fees d-block d-sm-block d-md-none">
				<div class="tourist-visa-fee">
					<table class="table table-bordered pricing-table">
						<tbody>
							<tr>
								<th class="text-left" rowspan="2">TOURIST VISA</th>
								<th class="text-center">SERVICE FEE</th>
								<th class="text-center" rowspan="2">STAMPING FEE</th>
							</tr>
							<tr>
								<th class="sub-heading text-center" rowspan="1" colspan="1">NORMAL PROCESSING <br>(24-48 working hours)</th>
							</tr>
							<tr>
								<td class="text-left">1 month single (E-visa)</td>
								<td class="text-center"><//?=$fee->evisa_tourist_1ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month single</td>
								<td class="text-center"><//?=$fee->tourist_1ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month multiple</td>
								<td class="text-center"><//?=$fee->tourist_1mm?> USD</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months single</td>
								<td class="text-center"><//?=$fee->tourist_3ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months multiple</td>
								<td class="text-center"><//?=$fee->tourist_3mm?> USD</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="service-fees d-block d-sm-block d-md-none">
				<div class="tourist-visa-fee">
					<table class="table table-bordered pricing-table">
						<tbody>
							<tr>
								<th class="text-left" rowspan="2">BUSINESS VISA</th>
								<th class="text-center">SERVICE FEE</th>
								<th class="text-center" rowspan="2">STAMPING FEE</th>
							</tr>
							<tr>
								<th class="sub-heading text-center" rowspan="1" colspan="1">NORMAL PROCESSING <br>(24-48 working hours)</th>
							</tr>
							<tr>
								<td class="text-left">1 month single (E-visa)</td>
								<td class="text-center"><//?=$fee->evisa_business_1ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month single</td>
								<td class="text-center"><//?=$fee->business_1ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">1 month multiple</td>
								<td class="text-center"><//?=$fee->business_1mm?> USD</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months single</td>
								<td class="text-center"><//?=$fee->business_3ms?> USD</td>
								<td class="text-center">25 USD/pax</td>
							</tr>
							<tr>
								<td class="text-left">3 months multiple</td>
								<td class="text-center"><//?=$fee->business_3mm?> USD</td>
								<td class="text-center">50 USD/pax</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="clearfix">
				<h2 class="text-center mb-4">Advantages of processing your Visa application to Vietnam with our agency</h2>
				<table class="table table-bordered" style="font-size:15px;">
					<tr class="text-center" style="font-weight: 600; background-color: #f0f0f0;">
						<td>Services</td>
						<td>Others</td>
						<td><?=SITE_NAME?></td>
					</tr>
					<tr>
						<td><strong>Online application available 24/7/365.</strong></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>24/7/365 email support and assistance by visa experts.</strong></td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Phone support 7 days a week.</strong></td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Review of application by visa experts</strong> before submission to the government.</td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Correction of missing/incorrect information</strong> by visa experts.</td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Verification/validation of information by visa experts.</strong></td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Simplified application process.</strong></td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Privacy protection and secure form.</strong></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Photo and document editing.</strong> We accept all formats (PDF, JPG, PNG), with no limit on file size.</td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Your approved visa letter will be sent by email.</strong></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Recovery of your Visa via email</strong> in the event of loss or misplacement.</td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
					<tr>
						<td><strong>Multiple methods of payment used worldwide.</strong></td>
						<td class="text-center"><span style="color:red"><i class="fa fa-times" aria-hidden="true"></i></span></td>
						<td class="text-center"><span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<//?
		ini_set('default_socket_timeout', 3);
		$sa_content = file_get_contents('https://www.shopperapproved.com/feeds/schema.php/?siteid=24798&token=sfx0VK6J');
		// $sa_total = substr($sa_content, strpos($sa_content, '<span itemprop="ratingCount">')+strlen('<span itemprop="ratingCount">'), 3);
		// echo $sa_content;
		$str = explode('based on', $sa_content);
		$str = explode(' ', $str[1]);
		$sa_total = $str[1];
	?>
	<div class="shopperapproved d-block d-sm-block d-md-none text-center">
		<h2 class="text-center home-sub-heading">Testimonial</h2>
		<a class="sa-medal" title="Customer ratings" target="_blank" rel="noopener" href="//www.shopperapproved.com/reviews/vietnam-visa.org.vn/">
			<img alt="Customer ratings" class="medal-red lazy" src="<//?=IMG_URL?>medal-red.png" style="display: inline;">
			<span class="sa-total"><//?=$sa_total?></span>
		</a>
	</div>
	<div class="testimonial d-none d-sm-none d-md-block">
		<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
			<h2 class="text-center home-sub-heading">Testimonial</h2>
			<h3 class="text-center" style="color: #AAA;">A few words of our travellers.</h3>
			<div class="cluster-content">
				<div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_horizontal sa_count5 sa_rounded sa_colorBlack sa_borderGray sa_bgWhite sa_showdate sa_jMY"></div><script type="text/javascript">var sa_interval = 10000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/3.0/24798.js'); shopper_first = true; </script><div style="text-align:right;"><a href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/" target="_blank" rel="nofollow" class="sa_footer"><img class="sa_widget_footer" alt="Customer reviews" src="//www.shopperapproved.com/widgets/widgetfooter-darklogo.png" style="border: 0;"></a></div>
			</div>
		</div>
	</div> -->
	<!-- <div class="container">
		<div class="comments">
			<h2 class="title">Leave a reply</h2>
			<div class="content-list">
			</div>
		</div>
	</div> -->
</div>
<!-- <div class="cluster-content tab-faqs">
	<div class="container">
		<ul class="nav nav-tabs" id="myFaqs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="nav-voa-tab" data-toggle="tab" href="#nav-voa" role="tab" aria-controls="nav-voa" aria-selected="true" style="font-weight: bold;">VISA ON ARRIVAL</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="nav-vev-tab" data-toggle="tab" href="#nav-vev" role="tab" aria-controls="nav-vev" aria-selected="false" style="font-weight: bold;">E-VISA</a>
			</li>
		</ul>
		<div class="tab-content" id="myFaqsContent">
			<div class="tab-pane fade show active" id="nav-voa" role="tabpanel" aria-labelledby="nav-voa-tab">
				<div class="faqs-listing">
					<ul>
					<//? foreach ($faqs as $faq) { ?>
						<li>
							<h2><a class="collapsed" rel="nofollow" title="<//?=$faq->title?>" data-toggle="collapse" href="<//?="#".$faq->alias?>" aria-expanded="false" aria-controls="collapse<//?=$faq->id?>"><//?=$faq->title?></a></h2>
							<div class="collapse" id="<//?=$faq->alias?>">
								<//?=$faq->content?>
							</div>
						</li>
					<//? } ?>
					</ul>
				</div>
			</div>
			<div class="tab-pane fade" id="nav-vev" role="tabpanel" aria-labelledby="nav-vev-tab">
				<div class="faqs-listing">
					<ul>
					<//? foreach ($evisa_faqs as $evisa_faq) { ?>
						<li>
							<h2><a class="collapsed" rel="nofollow" title="<//?=$evisa_faq->title?>" data-toggle="collapse" href="<//?="#".$evisa_faq->alias?>" aria-expanded="false" aria-controls="collapse<//?=$evisa_faq->id?>"><//?=$evisa_faq->title?></a></h2>
							<div class="collapse" id="<//?=$evisa_faq->alias?>">
								<//?=$evisa_faq->content?>
							</div>
						</li>
					<//? } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div> -->

<!-- Modal -->
<!-- <div class="modal fade" id="pop-up-del" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Delete comment</h4>
	    </div>
	    <div class="modal-body">
	      <p>Are you sure?</p>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id="btn-send-delete" get_id="" class="btn btn-primary">Yes</button>
	      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	    </div>
	  </div>
	</div>
</div> -->
<!-- </? if ($this->session->flashdata("status")) { ?>
<script>
$(document).ready(function() {
	messageBox("INFO", "Sent", "</?=$this->session->flashdata("status")?>");
});
</script>
</? } ?> -->
<!-- <script type="text/javascript">
	function get_comment () {
		$(document).ready(function() {
			$.ajax({
				url: '<//?=site_url("comment/ajax-get-comment")?>',
				type: 'POST',
				dataType: 'json',
				success: function (result) {
					var c = result[0].length;
					var str = '';
					for (var i = 0; i < c; i++) {
						var c_child = result[0][i].child.length;
						var avatar = (result[0][i].avatar != null) ? result[0][i].avatar : '<?=IMG_URL?>no-avatar.png';
						var cmt_name = (result[0][i].user_id != 0) ? result[0][i].user_fullname : result[0][i].fullname;
						var created_date = new Date(result[0][i].created_date);
						var date = created_date.toString().substring(0, 21);
						str += '<div class="item">';
							str += '<div class="left">';
								str += '<img src="'+avatar+'" class="img-responsive avatar" alt="'+cmt_name+'">';
							str += '</div>';
							str += '<div class="right">';
								str += '<div class="name">'+cmt_name+'</div>';
								str += '<div class="date">'+date+'</div>';
								str += '<div class="content edit-box-'+result[0][i].id+'">'+result[0][i].comment+'</div>';
								if (result[1] != 0) {
								str += '<div class="text-left">';
									str += '<a class="btn-reply" set_id="'+result[0][i].id+'">reply</a> ';
									if (result[0][i].user_id == result[1]) {
									str += '<a class="btn-edit" set_id="'+result[0][i].id+'">edit</a> ';
									str += '<a class="btn-del" set_id="'+result[0][i].id+'" data-toggle="modal" data-target="#pop-up-del">delete</a>';
									}
								str += '</div>';
								}
							str += '</div>';
						str += '</div>';
						for (var j = 0; j < c_child; j++) {
							var avatar_c = (result[0][i].child[j].avatar != null) ? result[0][i].child[j].avatar : '<?=IMG_URL?>no-avatar.png';
							var cmt_name_c = (result[0][i].child[j].user_id != 0) ? result[0][i].child[j].user_fullname : result[0][i].child[j].fullname;
							var created_date_c = new Date(result[0][i].child[j].created_date);
							var date_c = created_date_c.toString().substring(0, 21);
							str += '<div class="item-child">';
								str += '<div class="left">';
									str += '<img src="'+avatar_c+'" class="img-responsive avatar" alt="'+cmt_name_c+'">';
								str += '</div>';
								str += '<div class="right">';
									str += '<div class="name">'+cmt_name_c+'</div>';
									str += '<div class="date">'+date_c+'</div>';
									str += '<div class="content edit-box-'+result[0][i].child[j].id+'">'+result[0][i].child[j].comment+'</div>';
									if (result[1] != 0) {
									str += '<div class="text-left">';
										str += '<a class="btn-reply" set_id="'+result[0][i].id+'">reply</a>';
										if (result[0][i].child[j].user_id == result[1]) {
										str += '<a class="btn-edit" set_id="'+result[0][i].child[j].id+'">edit</a> ';
										str += '<a class="btn-del" set_id="'+result[0][i].child[j].id+'" data-toggle="modal" data-target="#pop-up-del">delete</a>';
										}
									str += '</div>';
									}
								str += '</div>';
							str += '</div>';
						}
					str += '<div class="send-comment-box box-'+result[0][i].id+'"></div>';
					}
					if (result[1] != 0) {
						str += '<div class="comment-box">';
							str += '<input type="hidden" class="parent-id" name="" value="0">';
							str += '<textarea name="comment" class="form-control comment" rows="2"></textarea><br>';
							str += '<div class="text-right"><a class="btn-send btn btn-primary">Send</a></div>';
						str += '</div>';
					} else {
						str += '<div style="font-size: 25px;margin-top: 12px;"><a href="<//?=site_url('member/login')?>">Sign in</a> to comment</div>'
					}
					$('.content-list').html(str);
				}
			});
			
		});
	}
	get_comment();
</script> -->
<!-- <script type="text/javascript">
	$(document).on('click', '.btn-del', function(event) {
		$('#btn-send-delete').attr('get_id',$(this).attr('set_id'));
	});
	$(document).on('click', '.btn-edit', function(event) {
		var id = $(this).attr('set_id');
		var cmt = $('.edit-box-'+id).html();
		var str = '<textarea name="comment_edit" class="form-control comment-edit" rows="2">'+cmt+'</textarea><br><div class="text-right"><a class="btn btn-primary btn-send-edit" set_id="'+id+'">Save</a></div>';
		$('.edit-box-'+id).html(str);
	});
	$(document).on('click', '.btn-send-edit', function(event) {
		event.preventDefault();
		var cmt = $(this).parents('.content').find('.comment-edit').val();
		var id = $(this).attr('set_id');
		var p = {};
		p['comment'] = cmt;
		p['id'] = id;
		$.ajax({
			url: '<//?=site_url("comment/ajax-update-comment")?>',
			type: 'POST',
			dataType: 'html',
			data: p,
			success: function (result) {
				if (result) {
					$('.edit-box-'+id).html(result);
				}
			}
		});
	});
	$(document).on('click', '#btn-send-delete', function(event) {
		event.preventDefault();
		var id = $(this).attr('get_id');
		var p = {};
		p['id'] = id;
		$.ajax({
			url: '<//?=site_url("comment/ajax-delete-comment")?>',
			type: 'POST',
			dataType: 'html',
			data: p,
			success: function (result) {
				if (result) {
					location.reload();
				}
			}
		});
	});
</script> -->
<!-- <script type="text/javascript">
	$(document).on('click', '.btn-reply', function(event) {
		var id = $(this).attr('set_id');
		$('.send-comment-box').html('');
		var str = '<div class="item-child">';
				str += '<div class="left"></div>';
				str += '<div class="right">';
					str += '<div class="comment-box">';
						str += '<input type="hidden" class="parent-id" name="" value="'+id+'">';
						str += '<textarea name="comment" class="form-control comment" rows="2"></textarea>';
						<//? if (!empty($this->session->userdata('user'))) { ?>
						str += '<div class="text-right"><a class="btn-send btn btn-primary">Send</a></div>';
						</? } else { ?>
						str += '<div class="text-right"><a href="</?=site_url('member/login')?>" class="btn btn-primary">Send</a></div>';
						</? } ?>
					str += '</div>';
				str += '</div>';
			str += '</div>';
		$('.box-'+id).html(str);
	});
</script> -->
<!-- <script type="text/javascript">
	$(document).on('click', '.btn-send', function(event) {
		event.preventDefault();
		var err = 0;
		$(".comment").removeClass("error");
		var msg = new Array();
		if ($(this).parents('.comment-box').find(".comment").val() == "") {
			$(this).parents('.comment-box').find(".comment").addClass("error");
			msg.push("Please give us your comment.");
			err++;
		} else {
			$(this).parents('.comment-box').find(".comment").removeClass("error");
		}

		if (err == 0) {
			var p = {};
			p['comment'] = $(this).parents('.comment-box').find(".comment").val();
			p['parent_id'] = $(this).parents('.comment-box').find(".parent-id").val();
			$.ajax({
				url: '<//?=site_url("comment")?>',
				type: 'POST',
				dataType: 'json',
				data: p,
				success: function (result) {
					if (result) {
						messageBox('INFO','Sent','Your request has been sent please wait for approval');
						get_comment();
					}
				}
			});
		}
		else {
			showErrorMessage(msg);
			return false;
		}
	});
</script> -->
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