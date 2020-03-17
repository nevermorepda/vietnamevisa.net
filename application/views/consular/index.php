<img src="<?=IMG_URL?>new-template/banner/banner-consular-services.png" class="img-responsive full-width d-none d-sm-none d-lg-block d-md-none" alt="">
<h1 class="hidden"><span class="" style="">CONSULAR SERVICES</span></h1>
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
<div class="extra-service-listing" style="background: url(<?=IMG_URL?>new-template/background.png) no-repeat scroll top center transparent;">
	<div class="container">
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	</div>
	<div class="cluster-content">
		<div class="container">
			<h2 class="home-heading text-center" style="padding-bottom: 50px; text-shadow: 3px 3px #bdbdbd;">Consular Services</h2>
			<div class="row">
			<? foreach ($items as $item) { 
			?>
				<div class="col-sm-6">
					<div class="mb-3">
						<div class="post">
							<div class="icon"><a title="<?=$item->title?>" href="<?=site_url("consular/view/{$item->alias}")?>"><img alt="<?=$item->title?>" class="img-responsive " src="<?=BASE_URL.$item->icon?>"/></a></div>
							<div class="content">
								<div class="caption ">
									<h3 class="title font-weight-bold d-inline-block"><a title="<?=$item->title?>" href="<?=site_url("consular/view/{$item->alias}")?>"><?=$item->title?></a></h3>
								</div>
								<p><?=word_limiter(strip_tags($item->summary), 50)?></p>
								<div class="clearfix"><a class="btn-detail" href="<?=site_url("consular/view/{$item->alias}")?>">Detail</a></div>
							</div>
						</div>
					</div>
				</div>
			<? } ?>
			</div>
		</div>
	</div>
</div>
