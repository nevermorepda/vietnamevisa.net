<div class="<?=$this->util->slug($this->router->fetch_class())?>">
<div class="container">
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
</div>
<div class="faqs cluster-content">
	<div class="container">
		<h2 class="home-heading"><?=!empty($cate->name) ? $cate->name : 'VIETNAM VISA'?></h2>
		<div class="cluster-body">
			<div class="row">
				<div class="col-lg-8 col-sm-8 col-xs-12">
					<div class="faqs-infinite">
						<div class="faqs-category "><h3 class="font-weight-bold"><?=$item->title?></h3></div>
						<div class="faqs-content">
							<div class="post">
								<div class="post-content-wrapper">
									<div class="details">
										<div class="extract-container">
											<?=$item->content?>
											<div class="text-right">
												<p class="help-block">Written by <span class="font-italic"><?=!empty($item->user_id) ? $this->m_user->load($item->user_id)->fullname : 'vietnamevisa.net'?></span> | <?=date('D, M d, Y',strtotime($item->created_date))?></p>
											</div>
											<? require_once(APPPATH."views/module/comment.php"); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
					$relatedItems = $this->m_useful->getNewerItems($item->id, 5);
					$relatedItems = array_merge($relatedItems, $this->m_useful->getOlderItems($item->id, 5));
					if (sizeof($relatedItems)) {
					?>
						<div class="related-item">
							<h2>RELATED QUESTIONS</h2>
							<ul>
							<?
								foreach ($relatedItems as $rItem) {
								?>
									<li><img class="d-inline-block pr-3" src="<?=IMG_URL?>new-template/icon/icon-faqs.png"><a title="<?=$rItem->title?>" href="<?=site_url("useful-information/view/{$rItem->alias}")?>"><?=$rItem->title?></a></li>
								<?
								}
							?>
							</ul>
						</div>
					<? } ?>
				</div>
				<div class="col-lg-4 col-sm-4 d-none d-sm-none d-md-block">
					<div class="widget widget-categories">
						<div class="font-weight-bold text-center title">CATEGORY</div>
						<ul class="list">
							<? foreach ($categories as $category) {
								$info = new stdClass();
								$info->catid = $category->id;
								$count_items = count($this->m_useful->items($info,1));

								$info = new stdClass();
								$info->parent_id = $category->id;
								$child_categories = $this->m_useful_category->items($info,1);
							?>
							<li class="item <?=($alias == $category->alias) ? 'active' : '' ?>">
								<a class="d-inline-block" href="<?=site_url("useful-information/{$category->alias}")?>"><?=$category->name?> </a>
								<?if (empty($child_categories)) {?>
								<div class="count-items float-right">(<?=$count_items?>)  </div>
								<? } ?>
							</li>
							<?
							if (!empty($child_categories)) {
							foreach ($child_categories as $child_category) { 
								$info = new stdClass();
								$info->catid = $child_category->id;
								$count_child_items = count($this->m_useful->items($info,1));?>

							<li class="item-child <?=($alias == $child_category->alias) ? 'active' : '' ?>">
								<a class="d-inline-block" href="<?=site_url("useful-information/{$child_category->alias}")?>"><?=$child_category->name?> </a>
								<div class="count-child-items float-right">(<?=$count_child_items?>)</div>
							</li>
							<? } } ?>
							<? } ?>	
						</ul>
					</div>
					<div class="support-online-widget">
						<div class="font-weight-bold text-center title">SUPPORT ONLINE</div>
						<div class="content">
							<p><i>Our pleasure to support you 24/7</i></p>

							<table class="table-borderless" cellpadding="2" width="100%">
								<tbody>
								<tr>
									<td>Address</td><td>:</td>
									<td class="address" style="padding-left: 8px"><a href="<?=ADDRESS?>"><?=ADDRESS?></a></td>
								</tr>
								<tr>
									<td>Email</td><td>:</td>
									<td class="email" style="padding-left: 8px"><a href="<?=MAIL_INFO?>"><?=MAIL_INFO?></a></td>
								</tr>
								<tr>
									<td>Tollfree</td><td>:</td>
									<td class="phone" style="padding-left: 8px"><a href="tel:<?=TOLL_FREE?>" title="TOLL FREE"><img class="pr-1" alt="TOLL FREE" src="<?=IMG_URL?>flags/United States.png"/><?=TOLL_FREE?></a></td>
								</tr>
								<tr>
									<td>Hotline</td><td>:</td>
									<td class="phone" style="padding-left: 8px"><a href="tel:<?=HOTLINE?>" title="HOTLINE"><img class="pr-1" alt="HOTLINE" src="<?=IMG_URL?>flags/Vietnam.png"/><?=HOTLINE?></a></td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
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