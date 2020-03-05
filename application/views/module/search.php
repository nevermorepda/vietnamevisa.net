<div class="widget widget-search">
	<form action="<?=site_url("{$this->util->slug($this->router->fetch_class())}")?>" method="get" accept-charset="utf-8">
		<div class="wrap-search input-group">
			<input type="text" name="search_text" id="input" class="form-control ipt-search" value="" placeholder="Enter search content">
			<div class="input-group-append">
				<div class="btn-checkfee pl-4">
					<input type="submit" class="btn btn-danger btn-search" value="SEARCH">
				</div>
			</div>
			<!-- <button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button> -->
		</div>
	</form>
</div>