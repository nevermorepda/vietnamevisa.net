
<div class="widget widget-latest-item">
	<h4 class="font-weight-bold f20">LATEST POST</h4>
	<ul class="list">
		<? foreach ($latest_items as $latest_item) { 
			$faqs_categories = $this->m_faqs_category->load($latest_item->catid);
		?>
		<li class="item">
			<a title="<?=$latest_item->title?>" href="<?=site_url("faqs/{$faqs_categories->alias}/{$latest_item->alias}")?>">
				<div class="wrap-item">
					<div class="image-item"><img class="img-fluid" src="<?=BASE_URL.$latest_item->thumbnail?>" alt="<?=$latest_item->title?>"></div>
					<div class="content-item">
						<div class="title-item mb-2 font-weight-bold"><?=word_limiter($latest_item->title,10)?></div>
						<div class="date-item text-danger font-weight-medium"><?=date("d M Y",strtotime($latest_item->created_date))?></div>
					</div>
				</div>
			</a>
		</li>
		<? } ?>
	</ul>
</div>