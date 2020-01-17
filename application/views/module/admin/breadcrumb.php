<?
	if ($this->util->slug($this->router->fetch_class()) != "home" && !empty($breadcrumb)) {
		$ibreadcrumb = 1;
?>
<div class="breadcrumbs">
	<div class="container-fluid">
		<ul class="breadcrumb clearfix" itemscope itemtype="http://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemtype="http://schema.org/Thing" itemprop="item" href="<?=BASE_URL?>" class="active"><span itemprop="name"><i class="fa fa-home"></i> Home</span></a><meta itemprop="position" content="<?=$ibreadcrumb++?>" /></li>
			<?
				foreach ($breadcrumb as $k => $v) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemtype="http://schema.org/Thing" itemprop="item" title="'.$k.'" href="'.$v.'" class="active"><span itemprop="name">'.$k.'</span></a><meta itemprop="position" content="'.($ibreadcrumb++).'" /></li>';
				}
			?>
		</ul>
	</div>
</div>
<?
	}
?>