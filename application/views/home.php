<div class="pages-content">
	<div class="slide-bar">
		<div class="slide-wrap">
			<div id="" class="slide-image owl-carousel owl-theme">
				<div class=" item" style="background-image: url(<?=IMG_URL?>new-template/slidex.png);"></div>
				<div class=" item" style="background-image: url(<?=IMG_URL?>new-template/slide2.png);"></div>
				<div class=" item" style="background-image: url(<?=IMG_URL?>new-template/slide3.png);"></div>
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
			
			<div class="slide-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-10 col-md-8">
							<div class="slide-text">
								<h1>VIETNAM VISA EXPERT</h1>
								<ul class="checklist ">
									<li><p>Professional process and reliable fee</p></li>
									<li><p>Your best option to get Vietnam visa</p></li>
									<li><p>Just 4 steps to get Vietnam visa</p></li>
									<li><p>Secure and efficient application submission</p></li>
								</ul>
							</div>
							<div class="slide-button">
								<a class="btn btn-danger" href="<?=site_url("apply-visa")?>">APPLY NOW</a>
							</div>
							<div class="control-owl-slider">
								<ul class="d-none d-sm-none d-md-block">
									<li class="dot icon0 active" data="0"></li>
									<li class="dot icon1" data="1"></li>
									<li class="dot icon2" data="2"></li>
								</ul>
								<div class="owl-dots">
									<div class="owl-dot active"><span></span></div>
									<div class="owl-dot"><span></span></div>
									<div class="owl-dot"><span></span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					var owl = $('.slide-image');
					owl.owlCarousel({
						loop:false,
						nav: false,
						dots: false,
						autoplay : false,
						items:1
						})
					$('.control-owl-slider .dot').click(function() {
						var pos = $(this).attr('data');
						owl.trigger('to.owl.carousel',pos,300);
					});
					owl.on('changed.owl.carousel', function(event) {
						var pos = event.item.index;
						$('.control-owl-slider .dot').removeClass('active');
						$('.control-owl-slider .icon'+pos).addClass('active');
					});
				</script>
			</div>
		</div>
	</div>
</div>

<!-- Step apply visa -->
<div class="cluster cluster-intrud">
	<div class="container">
		<div class="cluster-body wow fadeInUp">
			<div class="wrap-type-visa">
				<div class="row">
					<div class="col-lg-6">
						<div class="video-pr">
							<div class="embed-responsive" style="display: table;width: 100%">
								<div class="imgvideo" style="background-image: url(<?=IMG_URL?>new-template/img-visa.png)"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
							</div>
						</div>
						<script type="text/javascript">
							$('.imgvideo').click(function(event) {
								$('.embed-responsive').addClass('embed-responsive-4by3');
								$('.embed-responsive').prepend('<iframe width="560" height="315" src="https://www.youtube.com/embed/LasWgUPNVI4?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
								$(this).css('display', 'none');
							});
						</script>
					</div>
					<!-- <div class="col-sm-6">
						<a href="./vietnam-e-visa.html"><img class="full-width img-responsive" alt="" src="./images/img-visa.png"></a>
					</div> -->
					<div class="col-lg-6">
						<div class="des-pr m-4">
							<h2><a class="heading" title="Vietnam E-visa" href="">Vietnam Visa Online</a></h2>
							<div class="m-2">
								<p class="pt-3">We assist for Vietnam Visa with convenient and professional processing:</p>
								<p>Visa On Arrival (VOA) is a process of obtaining the pre-approved visa letter (visa approval letter) via applying online. The travelers will pick up the actual visa stamp and visa sticker by showing the Approval Letter at international airports in Vietnam upon arrival.</p>
								<p>Electronic Visa (E-Visa) is another modern type of Vietnam visa online. With this type of visa, you will receive E-Visa via email and you do not have to pay stamping fee upon arrival and enter Vietnam with multiple options of entry ports: land ports, seaports or airports.</p>
							</div>
						</div>
						
					</div>
				</div>
				<div class="content-pr">
					<div class="row">
						<div class="col-sm-6">
							<h3><a class="title" title="Vietnam E-visa" href="<?=site_url('vietnam-e-visa')?>">VIETNAM VISA ON ARRIVAL</a></h3>
							<ul>
								<li><p>Pick up visa at Vietnam International airports</p></li>
								<li><p>Diverse selection of visa types</p></li>
								<li><p>Most countries can apply</p></li>
							</ul>
						</div>
						<div class="col-sm-6">
							<h3><a class="title" title="Vietnam E-visa" href="<?=site_url('vietnam-e-visa')?>">VIETNAM ELECTRONIC VISA</a></h3>
							<ul>
								<li><p>Available for 8 airports, 16 landports, 9 seaports and 80 countries</p></li>
								<li><p>Valid for 30 days, and single entry only</p></li>
								<li><p>No fees upon arrival</p></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="clearfix">
					<a class="btn btn-danger float-right" href="<?=site_url('visa-processing')?>">SHOW MORE</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="cluster cluster-our-services">
	<div class="container wow fadeInUp">
		<div class="title">
			<h1 class="heading">Consular Services</h1>
		</div>
		<div class="cluster-content">
			<div class="row">
				<div class="col-md-6 dischap">
					<div class="post dispart p-3 mb-3">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$csl_services[0]->title?>" class="img-responsive " src="<?=BASE_URL.$csl_services[0]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("consular/view/{$csl_services[0]->alias}")?>"><?=$csl_services[0]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($csl_services[3]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("consular/view/{$csl_services[3]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6 dischap">
					<div class="post p-3 mb-3">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$csl_services[1]->title?>" class="img-responsive " src="<?=BASE_URL.$csl_services[1]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("consular/view/{$csl_services[1]->alias}")?>"><?=$csl_services[1]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($csl_services[1]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("consular/view/{$csl_services[1]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="post dispart p-3 mt-5">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$csl_services[2]->title?>" class="img-responsive " src="<?=BASE_URL.$csl_services[2]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("consular/view/{$csl_services[2]->alias}")?>"><?=$csl_services[2]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($csl_services[2]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("consular/view/{$csl_services[2]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="post p-3 mt-5">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$csl_services[3]->title?>" class="img-responsive " src="<?=BASE_URL.$csl_services[3]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("consular/view/{$csl_services[3]->alias}")?>"><?=$csl_services[3]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($csl_services[3]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("consular/view/{$csl_services[3]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="cluster cluster-our-services">
	<div class="container wow fadeInUp">
		<div class="title">
			<h1 class="heading">Extra Services</h1>
		</div>
		<div class="cluster-content">
			<div class="row">
				<div class="col-md-6 dischap">
					<div class="post dispart p-3 mb-3">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$ex_services[0]->title?>" class="img-responsive " src="<?=BASE_URL.$ex_services[0]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("services/view/{$ex_services[0]->alias}")?>"><?=$ex_services[0]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($ex_services[0]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("services/view/{$ex_services[0]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6 dischap">
					<div class="post p-3 mb-3">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$ex_services[1]->title?>" class="img-responsive " src="<?=BASE_URL.$ex_services[1]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("services/view/{$ex_services[1]->alias}")?>"><?=$ex_services[1]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($ex_services[1]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("services/view/{$ex_services[1]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="post dispart p-3 mt-5">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$ex_services[2]->title?>" class="img-responsive " src="<?=BASE_URL.$ex_services[2]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("services/view/{$ex_services[2]->alias}")?>"><?=$ex_services[2]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($ex_services[2]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("services/view/{$ex_services[2]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="post p-3 mt-5">
						<div class="title">
							<div class="bg-icon"></div>
							<img alt="<?=$ex_services[3]->title?>" class="img-responsive " src="<?=BASE_URL.$ex_services[3]->icon?>"/>
							<h3><a class="font-weight-bold" title="Airport concierge service" href="<?=site_url("services/view/{$ex_services[3]->alias}")?>"><?=$ex_services[3]->title;?></a></h3>
						</div>
						<p class="summary"><?=word_limiter(strip_tags($ex_services[3]->summary), 30);?></p>
						<div class="clearfix">
							<a class="btn-detail f13 float-right" href="<?=site_url("services/view/{$ex_services[3]->alias}")?>">Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="shopperapproved d-block d-sm-block d-md-none">
	<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
		<h2 class="home-sub-heading">Testimonial</h2>
		<a class="text-center sa-medal" title="Customer ratings" target="_blank" rel="noopener" href="https://www.shopperapproved.com/reviews/vietnam-visa.org.vn/">
			<img alt="Customer ratings" class="medal-red lazy" src="<?=IMG_URL?>medal-red.png" style="display: inline;">
			<span class="sa-total">1163</span>
		</a>
	</div>
</div>
<div class="testimonial d-none d-sm-none d-md-block">
	<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
		<h2 class="home-sub-heading">Testimonial</h2>
		<h3 style="color: #AAA;">A few words of our travellers.</h3>
		<div class="cluster-content">
			<div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_horizontal sa_count5 sa_rounded sa_colorBlack sa_borderGray sa_bgWhite sa_showdate sa_jMY"></div><script type="text/javascript">var sa_interval = 10000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/3.0/24798.js'); shopper_first = true; </script><div style="text-align:right;"><a href="http://www.shopperapproved.com/reviews/vietnam-visa.org.vn/" target="_blank" rel="nofollow" class="sa_footer"><img class="sa_widget_footer" alt="Customer reviews" src="//www.shopperapproved.com/widgets/widgetfooter-darklogo.png" style="border: 0;"></a></div>
		</div>
	</div>
</div>
 -->
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
						<p><a href="<?=BASE_URL?>"><span style="text-decoration: underline;"><?=SITE_NAME?></span></a> is a reliable portal for Vietnam Visa with Tourist and Business purpose. We provide the service with the fastest, easiest and most economical way to get a visa to Vietnam.</p>
						<p>Over 10-year-experience in Vietnam visa service and enthusiastic visa team, Vietnamevisa.net is always proud of our excellent services for the clients who would like to avoid the long visa procedures at their local Vietnam's Embassies. We work with the vision:</p>
						<ul>
							<li>No Hidden Charges</li>
							<li>Competitive Prices</li>
							<li>Timely Visa Processing</li>
							<li>Prompt Support via chat, email, or phone</li>
							<li>Fast And Secure</li>
						</ul>
						<p> It is legitimated and supported by the Vietnamese Immigration Department. Please take a view about our previous client’s experiences on... </p>
						<div class="showmore-button">
							<a class="btn btn-danger" href="<?=site_url('about-us')?>">SHOW MORE</a>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="about-us-images">
						<img src="<?=IMG_URL?>new-template/aboutus-img.png" class="img-responsive full-width" alt="About Us">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End about us -->
