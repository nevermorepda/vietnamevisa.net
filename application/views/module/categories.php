<div class="widget widget-categories">
	<div class="font-weight-bold text-center title">CATEGORY</div>
	<ul class="list">
		<? foreach ($categories as $category) {
			$info = new stdClass();
			$info->catid = $category->id;
			$count_items = count($this->m_faqs->items($info,1));

			$info = new stdClass();
			$info->parent_id = $category->id;
			$child_categories = $this->m_faqs_category->items($info,1);
		?>
		<li class="item <?=($alias == $category->alias) ? 'active' : '' ?>">
			<a class="d-inline-block" href="<?=site_url("faqs/{$category->alias}")?>"><?=$category->name?> </a>
			<div class="count-items float-right">(<?=$count_items?>)</div>
		</li>
		<?
		if (!empty($child_categories)) {
		foreach ($child_categories as $child_category) { 
			$info = new stdClass();
			$info->catid = $child_category->id;
			$count_child_items = count($this->m_faqs->items($info,1));?>
		<li class="item item-child <?=($alias == $child_category->alias) ? 'active' : '' ?>">
			<a class="d-inline-block" href="<?=site_url("faqs/{$child_category->alias}")?>"><?=$child_category->name?> </a>
			<ul class="child-category">
							</ul>
			<div class="count-items float-right">(<?=$count_child_items?>)</div>
		</li>
		<? } } ?>
		<? } ?>	
	</ul>
</div>