<div class="clearfix">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8 col-xs-12">
				<h1 class="item-title"><?=$item->title?></h1>
				<div class="item-author">Posted by <a title="<?=SITE_NAME?>" href="<?=BASE_URL?>"><?=SITE_NAME?></a> on <?=date('M d, Y', strtotime($item->created_date))?></div>
				<div class="">
					<? if(!empty($item->thumbnail)) { ?>
					<img src="<?=$item->thumbnail?>" class="img-responsive full-width" alt="<?=$item->title?>">
					<br>
					<? } ?>
					<div class="content-text"><?=$item->content?></div>
					<?
						if (!empty($item->keywords)) {
							$primary_keywords = array("vietnam travel");
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
							<h2>Related Information</h2>
							<ul>
							<?
								foreach ($relatedItems as $rItem) {
								?>
									<li><a title="<?=$rItem->title?>" href="<?=site_url("news/travel/view/{$rItem->alias}")?>"><?=$rItem->title?></a></li>
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