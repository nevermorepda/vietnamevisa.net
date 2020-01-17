<div class="visa-tips">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8">
				<h1 class="page-title"><?=$item->title?></h1>
				<div id="">
					<div class="clearfix"><?=$item->content?></div>
				</div>
				<? require_once(APPPATH."views/module/comment.php"); ?>
				<?
				$relatedItems = $this->m_tips->getOlderItems($item->id, 5);
				$relatedItems = array_merge($relatedItems, $this->m_tips->getNewerItems($item->id, 5));
				if (sizeof($relatedItems)) {
				?>
					<div class="related-item">
						<h2>Related Information</h2>
						<ul>
						<?
							foreach ($relatedItems as $rItem) {
							?>
								<li><a title="<?=$rItem->title?>" href="<?=site_url("vietnam-visa-tips/view/{$rItem->alias}")?>"><?=$rItem->title?></a></li>
							<?
							}
						?>
						</ul>
					</div>
				<? } ?>
			</div>
			<div class="col-lg-3 col-sm-4 d-none d-sm-none d-md-block">
				<? require_once(APPPATH."views/module/support.php"); ?>
				<? require_once(APPPATH."views/module/confidence.php"); ?>
				<? require_once(APPPATH."views/module/services.php"); ?>
			</div>
		</div>
	</div>
</div>
