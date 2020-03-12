<div class="clearfix">
	<div class="container">
		<div class="main-content pt-4">
			<div class="row clearfix">
				<div class="col-lg-8 col-sm-8 col-xs-12">
					<h1 class="item-title"><?=$item->title?></h1>
					<div class="item-author">Posted by <a title="<?=SITE_NAME?>" href="<?=BASE_URL?>"><?=SITE_NAME?></a> on <?=date('M d, Y', strtotime($item->created_date))?></div>
					<div class="">
						<? if(!empty($item->thumbnail)) { ?>
						<img src="<?=$item->thumbnail?>" class="img-responsive" alt="<?=$item->title?>">
						<br>
						<? } ?>
						<div class="content-text"><?=$item->content?></div>
						<?
							if (!empty($item->keywords)) {
								$keywords = explode(",", $item->keywords);
								echo '<div class="b-keywords">';
								echo '<span class="keyword-label">KEYWORDS:</span> ';
								foreach ($keywords as $keyword) {
									$keyword = trim($keyword);
									$array_keyword[] = '<a rel="nofollow" class="keyword-link" title="'.$keyword.'" href="'.BASE_URL.'/search.html?searchCriteria='.urlencode($keyword).'">'.$keyword.'</a>';
								}
								echo implode(", ", $array_keyword);
								echo '</div>';
							}
						?>
					</div>
				</div>
				<div class="col-lg-4 col-sm-4 d-none d-sm-none d-md-block">
					<div class="wg wg_1">
						<div class="wg_h text-center ">
							<h3 class="wg_t font-weight-bold m-0">WHY US?</h3>
						</div>
						<div class="wg_m wg_1m">
							<ul class="lt1">
								<li>Saving your time and money</li>
								<li>Fast and reliable procedure</li>
								<li>24/7 support online </li>
								<li>One stop site</li>
								<li>Secure customer’s information</li>
							</ul>
						</div>
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