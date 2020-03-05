
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
	<div class="cluster cluster-news">
		<div class="container">
			
			<div class="cluster-body">
				<div class="row">
					<div class="col-sm-8">
						<div class="post-content">
							<div class="faqs-infinite">
								<? require_once(APPPATH."views/module/search.php"); ?>
								<? foreach ($items as $value) { 
									$faqs_categories = $this->m_faqs_category->load($value->catid);
								?>
								<div class="post">
									<div class="post-content-wrapper">
										<? if (!empty($value->thumbnail)) { ?>
										<figure class="image-container">
											<a href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>" class="hover-effect"><img class="img-fluid" src="<?=BASE_URL.$value->thumbnail?>" alt="<?=$value->title?>"></a>
										</figure>
										<? } ?>
										<div class="details">
											<h3 class="entry-title">
												<a title="<?=$value->title?>" href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>"><?=$value->title?></a>
											</h3>
											<div class="excerpt-container">
												<?=$value->summary?>
											</div>
											<div class="post-meta">
												<? if (!empty($value->thumbnail)) { ?>
												<div class="entry-date"><?=date("d M Y",strtotime($value->created_date))?></div>
												<? } ?>
												<div class="entry-author fn">
													<b>Posted By:</b> <a href="#" class="author"><?=SITE_NAME?></a>
												</div>
												<div class="entry-action">
													<a href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>" class="button entry-comment btn-small"><i class="fa fa-comment"></i> <span>Comment</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<? } ?>
							</div>
						</div>
						<div><?=$pagination?></div>
					</div>
					<div class="col-sm-4">
						<? require_once(APPPATH."views/module/latest_items.php"); ?>
						<? require_once(APPPATH."views/module/categories.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>