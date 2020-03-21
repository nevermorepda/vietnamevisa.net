
<h1 class="hidden"><span class="" style="">Useful Information</span></h1>
<div class="container">
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
</div>
<div class="useful cluster-content">
	<div class="container">
		<h2 class="home-heading">Vietnam Visa</h2>
		<div class="cluster-body">
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
					<div class="useful-infinite">
						<div class="useful-content">
							<div class="row">
								<? 
								foreach ($items as $value) { 
									$useful_categories = $this->m_useful_category->load($value->catid);
								?>
								<div class="col-md-4">
									<div class="post">
										<div class="post-visual">
											<img src="<?=BASE_URL.$value->thumbnail?>" alt="">
										</div>
										<div class="post-content-wrapper">
											<div class="details">
												<div class="title">
													<h4 class="entry-title font-weight-bold">
														<a title="<?=$value->title?>" href="<?=site_url("useful-information/{$useful_categories->alias}/{$value->alias}")?>"><?=($offset+1).'. '?><?=$value->title?></a>
													</h4>
												</div>

												<div class="excerpt-container"><?=word_limiter(strip_tags($value->summary), 20)?></div>
											</div>
										</div>
										<div class="clearfix p-3"><a class="btn-rm" href="<?=site_url("useful-information/{$useful_categories->alias}/{$value->alias}")?>">Read more <i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
									</div>
								</div>
								<? $offset++;} 
								?>
							</div>
						</div>
					</div>
					<div class="pagi-bot text-center"><?=$pagination?></div>
				</div>
				<div class="col-lg-4 d-lg-block d-none d-sm-none d-md-none">
					<div class="widget widget-categories">
						<div class="font-weight-bold text-center title">CATEGORY</div>
						<ul class="list">
							<? foreach ($categories as $category) {
								$info = new stdClass();
								$info->catid = $category->id;
								$count_items = count($this->m_useful->items($info,1));

								$info = new stdClass();
								$info->parent_id = $category->id;
								$child_categories = $this->m_useful_category->items($info,1);
							?>
							<li class="item <?=($alias == $category->alias) ? 'active' : '' ?>">
								<a class="d-inline-block" href="<?=site_url("useful-information/{$category->alias}")?>"><?=$category->name?> </a>
								<?if (empty($child_categories)) {?>
								<div class="count-items float-right">(<?=$count_items?>)  </div>
								<? } ?>
							</li>
							<?
							if (!empty($child_categories)) {
							foreach ($child_categories as $child_category) { 
								$info = new stdClass();
								$info->catid = $child_category->id;
								$count_child_items = count($this->m_useful->items($info,1));?>

							<li class="item-child <?=($alias == $child_category->alias) ? 'active' : '' ?>">
								<a class="d-inline-block" href="<?=site_url("useful-information/{$child_category->alias}")?>"><?=$child_category->name?> </a>
								<div class="count-child-items float-right">(<?=$count_child_items?>)</div>
							</li>
							<? } } ?>
							<? } ?>	
						</ul>
					</div>
					<div class="support-online-widget">
						<div class="font-weight-bold text-center title">SUPPORT ONLINE</div>
						<div class="content">
							<p><i>Our pleasure to support you 24/7</i></p>

							<table class="table-borderless" cellpadding="2" width="100%">
								<tbody>
								<tr>
									<td>Address</td><td>:</td>
									<td class="address" style="padding-left: 8px"><a href="<?=ADDRESS?>"><?=ADDRESS?></a></td>
								</tr>
								<tr>
									<td>Email</td><td>:</td>
									<td class="email" style="padding-left: 8px"><a href="<?=MAIL_INFO?>"><?=MAIL_INFO?></a></td>
								</tr>
								<tr>
									<td>Tollfree</td><td>:</td>
									<td class="phone" style="padding-left: 8px"><a href="tel:<?=TOLL_FREE?>" title="TOLL FREE"><img class="pr-1" alt="TOLL FREE" src="<?=IMG_URL?>flags/United States.png"/><?=TOLL_FREE?></a></td>
								</tr>
								<tr>
									<td>Hotline</td><td>:</td>
									<td class="phone" style="padding-left: 8px"><a href="tel:<?=HOTLINE?>" title="HOTLINE"><img class="pr-1" alt="HOTLINE" src="<?=IMG_URL?>flags/Vietnam.png"/><?=HOTLINE?></a></td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
