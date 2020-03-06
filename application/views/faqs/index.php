
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
<div class="container">
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
</div>
<div class="faqs">
	<div class="container">
		<h2 class="home-heading text-center" style="padding-bottom: 30px; text-shadow: 3px 3px #bdbdbd;">Frequently Asked Questions</h2>
		<div class="cluster-body">
			<div class="row">
				<div class="col-sm-8">
					<? require_once(APPPATH."views/module/search.php"); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="faqs-category "><h3 class="font-weight-bold">Vietnam Visa</h3></div>
					<div class="faqs-infinite">
						<? foreach ($items as $value) { 
							$faqs_categories = $this->m_faqs_category->load($value->catid);
						?>
						<div class="post">
							<div class="post-content-wrapper">
								<div class="details">
									<div>
										<h4 class="entry-title font-weight-bold d-inline-block">
											<img class="d-inline-block" src="<?=IMG_URL?>new-template/icon/icon-faqs.png">
											<a title="<?=$value->title?>" href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>"><?=$value->title?></a>
										</h4>
									</div>
									<div class="excerpt-container"><?=$value->summary?></div>
								</div>
							</div>
							<div class="float-right"><a class="btn-rm" href="<?=site_url('')?>">Read more</a></div>
						</div>
						<? } ?>
					</div>
					<div><?=$pagination?></div>
				</div>
				<div class="col-sm-4">
					<? require_once(APPPATH."views/module/categories.php"); ?>
				</div>
			</div>
		</div>
	</div>
</div>