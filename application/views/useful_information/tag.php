<div class="<?=$this->util->slug($this->router->fetch_class())?>" style="background-color: #fff;">
	<div class="banner d-none d-lg-block d-xl-block" style="background-image: url(<?=IMG_URL?>wizban/banner-blog.jpg?cr=<?=CACHE_RAND?>);">
		<div class="container">
			<div class="banner-title">
				<h2>BLOG</h2>
			</div>
		</div>
	</div>
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
	<div class="container">
		<h1 style="font-size: 25px;" class="heading-text">ALL POSTS TAGGED <?=(!empty($tag)?strtoupper(str_replace("-", " ", "\"".$tag."\"")):"")?></h1>
	</div>

	<div class="cluster cluster-news">
		<div class="container">
			<div class="cluster-body">
				<div class="row">
					<div class="col-sm-9">
						<ul class="news-items list-unstyled">
							<?
								foreach ($items as $item) {
									$class = $this->util->slug($this->router->fetch_class());
							?>
							<li class="news-item">
								<div class="row news-item-wrap">
									<div class="col-sm-3 col-xs-4 news-item-left">
										<a title="<?=$item->title?>" href="<?=site_url("{$class}/{$this->m_blog_category->load($item->category_id)->alias}/{$item->alias}")?>">
											<img class="img-responsive" alt="<?=$item->title?>" src="<?=$item->thumbnail?>">
										</a>
									</div>
									<div class="col-sm-9 col-xs-8 news-item-body">
										<h4 class="news-item-heading"><a title="<?=$item->title?>" href="<?=site_url("{$class}/{$this->m_blog_category->load($item->category_id)->alias}/{$item->alias}")?>"><?=$item->title?></a></h4>
										<div class="hidden-xs"><?=$item->description?></div>
									</div>
								</div>
							</li>
							<? } ?>
						</ul>
						<div><?=$pagination?></div>
					</div>
					<div class="col-sm-3">
						<? require_once(APPPATH."views/module/widget/search.php"); ?>
						<? require_once(APPPATH."views/module/widget/categories.php"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
