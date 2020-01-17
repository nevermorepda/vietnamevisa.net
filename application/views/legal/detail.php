<div class="clearfix">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8 col-xs-12">
				<h1 class="item-title"><?=$item->title?></h1>
				<div class="item-author">Posted by <a title="<?=SITE_NAME?>" href="<?=BASE_URL?>"><?=SITE_NAME?></a> on <?=date('M d, Y', strtotime($item->created_date))?></div>
				<div class="">
					<div class=""><?=$item->content?></div>
					<?
						if (!empty($item->keywords)) {
							$keywords = explode(",", $item->keywords);
							echo '<div class="b-keywords">';
							echo '<span class="keyword-label">KEYWORDS:</span> ';
							foreach ($keywords as $keyword) {
								$keyword = trim($keyword);
								$array_keyword[] = '<a rel="nofollow" class="keyword-link" title="'.$keyword.'" href="'.BASE_URL.'/search.html?searchCriteria='.urlencode($keyword).'">'.$keyword.'</a>';
							}
							echo implode(", ", $array_keyword);
							echo '</div>';
						}
					?>
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
