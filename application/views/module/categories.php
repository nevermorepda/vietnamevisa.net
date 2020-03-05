<div class="widget widget-categories">
	<h4 class="font-weight-bold f20">CATEGORIES</h4>
	<ul class="list">
		<? foreach ($categories as $category) {
			$info = new stdClass();
			$info->catid = $category->id;
			$count_items = count($this->m_faqs->items($info,1));
		?>
		<li class="item">
			<a href="<?=site_url("faqs/{$category->alias}")?>"><?=$category->name?> (<?=$count_items?>)</a>
		</li>
		<? } ?>
	</ul>
</div>