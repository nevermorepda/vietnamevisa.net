
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

<div class="faqs cluster-content"  style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
	<div class="container">
		<h2 class="home-sub-heading" style="padding-bottom: 30px;">More question about Visa to Vietnam</h2>
		<div class="row">
			<div class="col-md-12">
				<ul>
					<? $i = 0;
					foreach ($faqs as $faq) { ?>
					<li>
						<h3 class="click-faqs" status="0" data-index="<?=$faq->id?>" id="faqs-<?=$faq->id?>" ><a href="<?=site_url("faqs/{$faq->alias}")?>" class="collapsed" title="<?=$faq->title?>"><?=($i+1)?>. <?=$faq->title?></a></h3>
					</li>
					<? $i++; } ?>
				</ul>
			</div>
			<!-- <div class="col-md-6">
				<ul>
					<? $i = 0;
					foreach ($evisa_faqs as $evisa_faq) { ?>
					<li>
						<h3 class="click-faqs" status="0" data-index="<?=$evisa_faq->id?>" id="faqs-<?=$evisa_faq->id?>" ><a href="<?=site_url("faqs/{$faq->alias}")?>" class="collapsed" title="<?=$evisa_faq->title?>"><?=($i+1)?>. <?=$evisa_faq->title?></a></h3>
					</li>
					<? $i++; } ?>
				</ul>
			</div> -->
		</div>
	</div>
</div>
