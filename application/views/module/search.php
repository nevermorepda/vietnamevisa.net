<div class="widget widget-search">
	<form action="<?=site_url("{$this->util->slug($this->router->fetch_class())}")?>" method="get" accept-charset="utf-8">
		<div class="wrap-search input-group">
			<input type="text" name="search_text" id="input" class="form-control ipt-search" value="" placeholder="Search">
			<div class="input-group-append">
				<button type="submit" class="btn-search">&rarr;</button>
			</div>
			<!-- <button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button> -->
		</div>
	</form>
</div>