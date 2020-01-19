<!-- <style>
.page-content {
	background-color: #ECEFF1;
}
</style>
<div class="faqs">
	<div class="container">
		<div class="alternative-breadcrumb">
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
		</div>
	</div>
	<div class="faqs-img">
		<div class="container">
			<div class="text">
				<div class="txt-container">
					<div class="value-prop center">
						<h1>Vietnam Visa FAQs</h1>
						<h5>All most popular questions and answers about Vietnam Visa on Arrival.</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container text-center" style="margin-top: 20px">
	<h2 class="home-heading">FREQUENTLY ASKED QUESTIONS</h2> 
	<p class="f20" style="color: #AAA">We have listed the most frequently asked questions regarding visa on arrival below. However, if you have any further questions, feel free to contact us. You will receive an answer shortly.</p>
</div>

<div class="cluster-content tab-faqs">
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
<div class="banner-top faqs-banner" style="background: url('<?=IMG_URL?>new-template/FAQs-banner.png') no-repeat scroll top center transparent;">
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<div class="text-content">
					<h1><span class="border-text" style="padding: 10px 175px 0px 15px;">FAQS</span></h1>
					<div class="alternative-breadcrumb">
					<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
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

<div class="faqs cluster-content"  style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
	<div class="container">
		<h2 class="home-sub-heading" style="padding-top: 15px; padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">More question about Visa to Vietnam</h2>
		<div class="row">
			<div class="col-md-6">
				<ul>
					<? $i = 0;
					foreach ($faqs as $faq) { ?>
					<li>
						<h3 class="click-faqs" status="0" data-index="<?=$faq->id?>" id="faqs-<?=$faq->id?>" ><a href="<?=site_url("faqs/{$faq->alias}")?>" class="collapsed" title="<?=$faq->title?>"><?=($i+1)?>. <?=$faq->title?></a></h3>
					</li>
					<? $i++; } ?>
				</ul>
			</div>
			<div class="col-md-6">
				<ul>
					<? $i = 0;
					foreach ($evisa_faqs as $evisa_faq) { ?>
					<li>
						<h3 class="click-faqs" status="0" data-index="<?=$evisa_faq->id?>" id="faqs-<?=$evisa_faq->id?>" ><a href="<?=site_url("faqs/{$faq->alias}")?>" class="collapsed" title="<?=$evisa_faq->title?>"><?=($i+1)?>. <?=$evisa_faq->title?></a></h3>
					</li>
					<? $i++; } ?>
				</ul>
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
							<a class="btn btn-general" href="<?=site_url('about-us')?>">SHOW MORE</a>
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
