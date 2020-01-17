<div class="services">
	<div class="container">
		<div class="alternative-breadcrumb">
		<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
		</div>
	</div>
	<div class="services-img">
		<div class="container">
			<div class="text">
				<div class="txt-container">
					<div class="value-prop center">
						<h1>Extra Services Upon Arrival</h1>
						<h5>Full extra service at the airport help the traveler when upon arrival.</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container text-center" style="margin-top: 20px">
	<h2 class="home-heading">EXTRA SERVICES UPON ARRIVAL</h2> 
	<p class="f20" style="color: #AAA">In order to help Foreigners avoid confusing to choose the required services in their trip, We offer an <b>all-in-one package</b> which covers every little thing the visitor need for their trip.</p>
</div>

<div class="cluster-content extra-service-listing">
	<div class="container">
		<div class="row">
		<? foreach ($items as $item) { ?>
			<div class="col-sm-4">
				<div class="thumbnail">
					<a title="<?=$item->title?>" href="<?=site_url("services/view/{$item->alias}")?>"><img alt="<?=$item->title?>" class="img-responsive full-width" src="<?=$item->thumbnail?>"/></a>
					<div class="caption">
						<h3 class="title"><a title="<?=$item->title?>" href="<?=site_url("services/view/{$item->alias}")?>"><?=$item->title?></a></h3>
						<p><?=word_limiter(strip_tags($item->summary), 40)?></p>
						<p><a class="btn btn-danger" href="<?=site_url("services/view/{$item->alias}")?>">Read more</a></p>
					</div>
				</div>
			</div>
		<? } ?>
		</div>
	</div>
</div>
