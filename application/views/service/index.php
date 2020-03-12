<div class="banner-top faqs-banner" style="background: url('<?=IMG_URL?>new-template/bannerFAQs.png') no-repeat scroll top center transparent;">
	<div class="container">
		<div class="text-content">
			<h1>
				<span class="" style="">FAQs</span>
				<div class="bd-right d-none d-lg-block d-md-block"></div>
			</h1>
			<ul>
				<li>Always listen to our customer </li>
				<li>Provide helpful and clear information</li>
			</ul>
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
<div class="extra-service-listing" style="background: url(http://localhost/vietnamevisa.net/template/images/new-template/background.png) no-repeat scroll top center transparent;">
	<div class="container">
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	</div>
	<div class="cluster-content">
		<div class="container">
			<h2 class="home-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Extra Services Upon Arrival</h2>
			<div class="row">
			<? foreach ($items as $item) { 
			?>
				<div class="col-sm-6">
					<div class="mb-3">
						<div class="post">
							<div class="icon"><a title="<?=$item->title?>" href="<?=site_url("services/view/{$item->alias}")?>"><img alt="<?=$item->title?>" class="img-responsive " src="<?=BASE_URL.$item->icon?>"/></a></div>
							<div class="content pt-2">
								<div class="caption ">
									<h3 class="title font-weight-bold d-inline-block"><a title="<?=$item->title?>" href="<?=site_url("services/view/{$item->alias}")?>"><?=$item->title?></a></h3>
								</div>
								<p><?=word_limiter(strip_tags($item->summary), 50)?></p>
								<div class="clearfix"><a class="btn-detail" href="<?=site_url("services/view/{$item->alias}")?>">Detail</a></div>
							</div>
						</div>
					</div>
				</div>
			<? } ?>
			</div>
		</div>
</div>
</div>
