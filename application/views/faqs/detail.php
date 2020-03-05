<div class="<?=$this->util->slug($this->router->fetch_class())?>">
	
	<div class="heading-bar hidden">
		<div class="container">
			<h2 class="heading-text">BLOG</h2>
		</div>
	</div>	
	<div class="cluster cluster-news">
		<div class="container">
			<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
			<div class="cluster-body">
				<div class="row">
					<div class="col-lg-9 col-sm-8 col-xs-12">
						<div class="post-content">
							<div class="blog-infinite">
								<div class="post">
									<div class="post-content-wrapper">
										<? if (!empty($item->thumbnail)) { ?>
										<figure class="image-container">
											<img class="img-fluid" src="<?=BASE_URL.$item->thumbnail?>" alt="<?=$item->title?>">
											<div class="entry-date"><?=date("d M Y",strtotime($item->created_date))?></div>
										</figure>
										<? } ?>
										<div class="details">
											<div class="excerpt-container">
												<?=$item->content?>
												<div class="text-right">
													<p class="help-block">Written by <span class="font-italic"><?=!empty($item->user_id) ? $this->m_user->load($item->user_id)->fullname : 'visa-vietnam.org.vn'?></span> | <?=date('D, M d, Y',strtotime($item->created_date))?></p>
												</div>
												<? require_once(APPPATH."views/module/comment.php"); ?>
											</div>
										</div>
									</div>
								</div>
								<?
								$relatedItems = $this->m_blog->getNewerItems($item->id, 5);
								$relatedItems = array_merge($relatedItems, $this->m_blog->getOlderItems($item->id, 5));
								if (sizeof($relatedItems)) {
								?>
									<div class="related-item">
										<h2>Related Information</h2>
										<ul>
										<?
											foreach ($relatedItems as $rItem) {
											?>
												<li><a title="<?=$rItem->title?>" href="<?=site_url("news/view/{$rItem->alias}")?>"><?=$rItem->title?></a></li>
											<?
											}
										?>
										</ul>
									</div>
								<? } ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-4 d-none d-sm-none d-md-block">
						<? require_once(APPPATH."views/module/support.php"); ?>
						<? require_once(APPPATH."views/module/confidence.php"); ?>
						<? require_once(APPPATH."views/module/services.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "NewsArticle",
	"mainEntityOfPage": {
		"@type": "WebPage",
		"@id": "<?=current_url()?>"
	},
	"headline": "<?=$item->title?>",
	"image": {
		"@type": "ImageObject",
		"url": "<?=((stripos($item->thumbnail, "http") === false) ? BASE_URL.$item->thumbnail : $item->thumbnail)?>",
		"height": 800,
		"width": 800
	},
	"datePublished": "<?=date('c', strtotime($item->created_date))?>",
	"dateModified": "<?=date('c', strtotime($item->updated_date))?>",
	"author": {
		"@type": "Person",
		"name": "Ken Phan"
	},
	"publisher": {
		"@type": "Organization",
		"name": "<?=SITE_NAME?>",
		"logo": {
			"@type": "ImageObject",
			"url": "<?=IMG_URL.'visa-vietnam.svg'?>",
			"width": 600,
			"height": 60
		}
	},
	"description": "<?=addslashes(strip_tags($item->description))?>"
}
</script>
 -->