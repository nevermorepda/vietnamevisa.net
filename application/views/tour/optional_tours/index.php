<div class="tour-banner">
	<div class="tour-img">
		<div class="container">
			<div class="text">
				<div class="txt-container">
					<div class="value-prop center">
						<h1>Tour and Travel booking</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="optional-tour">
	<div class="container">
		<div class="heading">
			<h2 class="home-sub-heading" style="padding-top: 15px; text-shadow: 3px 3px #bdbdbd;">Optional Tours</h2>
		</div>
		<div class="sub-heading">
			<p>Besides Saigon city tours, we can definitely offer you various other exciting private tours by cars to famous tourist attractions in Vietnam. Therefore, you will get the nice chances to discover interesting Vietnamese culture, history and landscapes.</p>
		</div>
		<div class="tours-wrapper">
			<div class="row">
				<?foreach ($items as $item) { 
					$categories_tour = $this->m_category_tour->load($item->catid);
				 ?>
					<div class="col-md-6 col-sm-6 col-lg-3">
						<div class="tour">
							<div class="tour-visual"> 
								<img src="<?=BASE_URL.$item->thumbnail?>" alt="">
							</div>
							<div class="surrounded" style="height: 110px;">
								<div class="head"><a href="<?=site_url("tours/booking/{$item->alias}")?>"><?=$item->title?></a></div>
								<div class="description"><?=word_limiter($item->description,12)?></div>
							</div>
							<div class="features">
								<ul>
									<li class="location"><i class="fa fa-map-marker" aria-hidden="true"></i><?=$item->location?></li>
									<li class="duration"><i class="fa fa-clock-o" aria-hidden="true"></i></i>Duration: <?=$item->duration?> hours</li>
								</ul>
							</div>
							<div class="price">
								From <span style="font-size: 25px;color: #ed1c24;font-weight: 600;">$<?=$item->price?></span>
							</div>
							<div class="tour-bottom-line"></div>
							<div class="text-center"><div class="btn-booknow"><a href="<?=site_url("tours/{$categories_tour->alias}/{$item->alias}")?>" class="booknow" >Book Now</a></div></div>
						</div>
					</div>
				<? } ?>
			</div>
		</div>
	</div>
</div>
