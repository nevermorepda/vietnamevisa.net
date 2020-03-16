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
<div class="clearfix">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8 col-xs-12">
				<h1 class="item-title"><?=$item->title?></h1>
				<div class="item-author">Posted by <a title="<?=SITE_NAME?>" href="<?=BASE_URL?>"><?=SITE_NAME?></a> on <?=date('M d, Y', strtotime($item->created_date))?></div>
				<div class="">
					<div class="content"><?=$item->content?></div>
					<?
						if (!empty($item->keywords)) {
							$primary_keywords = array("vietnam visa", "vietnam visa on arrival", "vietnam visa online");
							$keywords = explode(",", $item->keywords);
							foreach ($primary_keywords as $keyword) {
								if (!in_array($keyword, $keywords)) {
									//$keywords[] = $keyword;
								}
							}
							echo '<div class="b-keywords">';
							echo '<span class="keyword-label">KEYWORDS:</span> ';
							foreach ($keywords as $keyword) {
								$keyword = trim($keyword);
								if (!empty($keyword)) {
									$array_keyword[] = '<a rel="nofollow" class="keyword-link" title="'.$keyword.'" href="'.BASE_URL.'/search.html?searchCriteria='.urlencode($keyword).'">'.$keyword.'</a>';
								}
							}
							echo implode(", ", $array_keyword);
							echo '</div>';
						}
					?>
					<div id="review-detail">
						<? require_once(APPPATH."views/module/comment.php"); ?>						
					</div>
					<?
					$relatedItems = $this->m_content->getNewerItems($item->id, 5);
					$relatedItems = array_merge($relatedItems, $this->m_content->getOlderItems($item->id, 5));
					if (sizeof($relatedItems)) {
					?>
						<div class="related-item">
							<h2>Related FAQs</h2>
							<ul>
							<?
								foreach ($relatedItems as $rItem) {
								?>
									<li><a title="<?=$rItem->title?>" href="<?=site_url("faqs/view/{$rItem->alias}")?>"><?=$rItem->title?></a></li>
								<?
								}
							?>
							</ul>
						</div>
					<? } ?>
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
