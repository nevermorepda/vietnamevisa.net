<div class="widget widget-categories">
	<div class="font-weight-bold text-center title">CATEGORY</div>
	<ul class="list">
		<? foreach ($categories as $category) {
			$info = new stdClass();
			$info->catid = $category->id;
			$count_items = count($this->m_faqs->items($info,1));
		?>
		<li class="item">
			<a class="d-inline-block" href="<?=site_url("faqs/{$category->alias}")?>"><?=$category->name?> </a>
			<div class="count-items float-right">(<?=$count_items?>)</div>
		</li>
		<? } ?>
	</ul>
</div>