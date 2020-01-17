<?
	if ($this->util->slug($this->router->fetch_class()) != "home" && !empty($breadcrumb)) {
		$ibreadcrumb = 1;
?>
<nav aria-label="breadcrumb" class="nav-breadcrumbs">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item"><a itemtype="http://schema.org/Thing" itemprop="item"  href="<?=BASE_URL?>"><span itemprop="name"><i class="fa fa-home"></i> Home</span></a></li>
		<?
			foreach ($breadcrumb as $k => $v) {
				echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemtype="http://schema.org/Thing" itemprop="item" title="'.$k.'" href="'.$v.'" class="active"><span itemprop="name">'.$k.'</span></a><meta itemprop="position" content="'.($ibreadcrumb++).'" /></li>';
			}
		?>
	</ol>
</nav>
<?
	}
?>