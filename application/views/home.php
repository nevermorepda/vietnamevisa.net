<div class="page-content">
	<div class="slide-bar">
		<div class="slide-wrap">
			<div id="" class="slide-image owl-carousel owl-theme">
				<div class=" item" style="background-image: url(<?=IMG_URL?>new-template/slide1.png);"></div>
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
					<div class="slide-text">
						<h1>MAIN GATE TO GET<br>VISA TO VIETNAM<br>ONLINE</h1>
						<!-- <ul class="checklist d-none d-sm-none d-md-block">
							<li><i class="fa fa-check" aria-hidden="true"></i> <strong>Quick and easy</strong> – Only 4 steps to get the visa to Vietnam</li>
							<li><i class="fa fa-check" aria-hidden="true"></i> <strong>Accept credit cards</strong> – Low processing rates</li>
							<li><i class="fa fa-check" aria-hidden="true"></i> <strong>Free 24/7 support</strong> – Call our experts anytime</li>
							<li><i class="fa fa-check" aria-hidden="true"></i> <strong>Trusted and reliable</strong> – 5,000,000+ travellers worldwide</li>
						</ul> -->
					</div>
					<div class="slide-button">
						<a class="btn btn-light" href="<?=site_url("apply-visa")?>">APPLY NOW</a>
						<div class="bg-btn transition" style="width: 100%;"></div>
					</div>
					<div class="control-owl-slider">
						<ul>
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
				<script type="text/javascript">
					var owl = $('.slide-image');
					owl.owlCarousel({
						loop:false,
						nav: false,
						dots: false,
						autoplay : true,
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
<div class="cluster">
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
						<div class="content-pr">
							<h1><a class="title" title="Vietnam E-visa" href="<?=site_url('vietnam-e-visa')?>">Vietnam visa on arrival</a></h1>
							<ul>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> Valid for who arrives Airports only</li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> All countries can apply visa through this gate </li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> Refundable if vis deny </li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> Max stay 90 days and extend</li>
							</ul>
							<h1><a class="title" title="Vietnam E-visa" href="<?=site_url('vietnam-e-visa')?>">eVisa Vietnam</a></h1>
							<ul>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> Vietnam eVisa valid for Who arrive land ports and Airports</li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> 86 countries only</li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> Non refundable for any case</li>
								<li><i class="fa fa-caret-right" aria-hidden="true"></i> And max stay 30 days </li>
							</ul>
						</div>
						<div class="showmore-button">
							<a class="btn btn-general" href="<?=site_url('visa-processing')?>">SHOW MORE</a>
							<div class="bg-btn transition" style="width: 100%;"></div>
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
				<div class="col-md-4 dispart">
					<div class="title">
						<img alt="Airport concierge service" class="lazy" src="<?=IMG_URL?>new-template/icon1.png">
						<h3><a title="Airport concierge service" href="<?=site_url("services/view/airport-fast-track-service")?>">VIP FAST TRACK</a></h3>
					</div>
					<p class="summary">Our staff will meet you at the aircraft gate with your name on the welcome board and assist you to get visa stamp and visa sticker without getting line as other. Just 5-10 minutes you will at the luggage lounge to wait for your belonging.</p>
					<a class="btn btn-light btn-detail" href="<?=site_url("services/view/airport-fast-track-service")?>">DETAIL</a>
				</div>
				<div class="col-md-4 dispart">
					<div class="title">
						<img alt="Car pickup service" class="lazy" src="<?=IMG_URL?>new-template/icon3.png">
						<h3><a title="Car pickup service" href="<?=site_url("services/view/airport-pick-up-service")?>">AIRPORT CAR PICKUP</a></h3>
					</div>
					<p class="summary">You are tired in the plane during the flight and you want to rest in hotel immediately to be ready for an interesting vacation. We highly recommend the car pick-up service beside Applying Vietnam Visa Online Service.</p>
					<a class="btn btn-light btn-detail" href="<?=site_url("services/view/airport-pick-up-service")?>">DETAIL</a>
				</div>
				<div class="col-md-4 dispart">
					<div class="title">
						<img alt="Vietnam hotel booking" class="lazy" src="<?=IMG_URL?>new-template/icon2.png">
						<h3><a title="Vietnam hotel booking" href="<?=site_url("services/view/vietnam-visa-extension-and-renewal")?>">VISA EXTENSION AND RENEWAL</a></h3>
					</div>
					<p class="summary">This section explains the customer how to apply to their visa extension for the temporary staying permission in Vietnam with the purpose for visiting relatives, traveling, business or others.</p>
					<a class="btn btn-light btn-detail" href="<?=site_url("services/view/vietnam-visa-extension-and-renewal")?>">DETAIL</a>
				</div>
			</div>
		</div>
		<div class="cluster-content">
			<div class="row">
				<div class="col-md-6 dispart">
					<div class="title">
						<img alt="Optional Tours" class="lazy" src="<?=IMG_URL?>new-template/icon4.png">
						<h3><a title="Optional Tours" href="<?=site_url('tours')?>">OPTIONAL TOURS</a></h3>
					</div>
					<div class="tour-content">
						<a href="<?=site_url('tours')?>"><img class="img-thumnail img-responsive img-pr" alt="" src="<?=IMG_URL?>new-template/thumb-optiontours.png"></a>
						<p class="summary"><?=$tours[0]->description;?></p>
					</div>
					<a class="btn btn-light btn-detail" href="<?=site_url('tours')?>">DETAIL</a>
				</div>
				<div class="col-md-6 dispart">
					<div class="title">
						<img alt="Vietnam discovery tours" class="lazy" src="<?=IMG_URL?>new-template/icon5.png">
						<h3><a title="Vietnam discovery tours" href="<?=site_url('tours')?>">VIET NAM DISCOVERY TOURS</a></h3>
					</div>
					<div class="tour-content">
						<a href="<?=site_url('tours')?>"><img class="img-thumnail img-responsive img-pr" alt="" src="<?=IMG_URL?>new-template/thumbnail/thumb-vntours.png"></a>
						<p class="summary"><?=$tours[1]->description;?></p>
					</div>
					<a class="btn btn-light btn-detail" href="<?=site_url('tours')?>">DETAIL</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="shopperapproved d-block d-sm-block d-md-none">
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
							<a class="btn btn-general" href="<?=site_url('about-us')?>">SHOW MORE</a>
							<div class="bg-btn transition" style="width: 100%;"></div>
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