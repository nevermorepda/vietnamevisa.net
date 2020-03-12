<link type="text/css" rel="stylesheet" href="<?=CSS_URL?>pagination.css"/>
<script type="text/javascript" src="<?=JS_URL?>jquery.pagination.js"></script>
<script type="text/javascript">
	$(function() {
		var numofitem = '<?=sizeof($items)?>';
		if ((numofitem / 10) > 1) {
			$("#items-pagination").pagination({
		        items: numofitem,
		        itemsOnPage: 10,
		        cssStyle: 'light-theme',
		        onPageClick: function(pageNumber){selectReviewPage(pageNumber, numofitem);}
		    });
		}
	});
	function selectReviewPage(pageNumber, items) {
		for (var i=1; i<=items; i++) {
			$("#page-"+i).hide();
		}
		$("#page-"+pageNumber).show();
	}
</script>

<div class="clearfix">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8 col-xs-12">
				<h1 class="page-title">Vietnam Visa News</h1>
				<div class="item-list">
					<ul id="page-1" style="margin: 0px; padding: 0px; list-style-type: none;">
					<?
						$cnt  = 0;
						$idx  = 0;
						$page = 1;
						foreach ($items as $item) {
							if ($cnt != 0 && ($cnt % 10) == 0) {
								$page ++;
								$cnt = 0;
					?>
					</ul>
					<ul id="page-<?=$page?>" style="margin: 0px; padding: 0px; list-style-type: none; display: none">
					<?
							}
							$cnt ++;
							$idx ++;
					?>
						<li>
							<div class="item clearfix">
								<h2 class="item-head"><a title="<?=$item->title?>" href="<?=site_url("news/view/{$item->alias}")?>"><?=$item->title?></a></h2>
								<?=$item->summary?>
								<span class="right"><a title="Read more" class="btn btn-danger" href="<?=site_url("news/view/{$item->alias}")?>">Read more »</a></span>
							</div>
						</li>
						<?	} ?>
					</ul>
				</div>
				<div id="items-pagination" class="clearfix" style="margin: 20px 0px 40px;"></div>
			</div>
			<div class="col-lg-3 col-sm-4 d-none d-sm-none d-md-block">
				<? require_once(APPPATH."views/module/support.php"); ?>
				<? require_once(APPPATH."views/module/confidence.php"); ?>
				<? require_once(APPPATH."views/module/services.php"); ?>
			</div>
		</div>
	</div>
</div>
