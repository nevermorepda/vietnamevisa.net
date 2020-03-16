
<div class="banner-top faqs-banner d-none d-sm-none d-md-block" style="background: url('<?=IMG_URL?>new-template/banner-faqs.png') no-repeat scroll top center transparent;">
	<img src="<?=IMG_URL?>new-template/flag-faqs.png" class="img-responsive flag-faqs" alt="flag-faqs">
	<div class="container">
		<div class="text-content">
			<h1>
				<span class="" style="">FAQs</span>
				<div class="bd-right d-none d-lg-block d-md-block"></div>
			</h1>
			<ul>
				<li>Always listen to our customer </li>
				<li>Provide helpful and clear information</li>
			</ul>
		</div>
	</div>
</div>
<div class="slide-wrap d-none d-sm-none d-md-block">
	<div class="slide-ex-contact">
		<div class="container">
			<ul>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-vn.png"><a href="" title="Contact hotline"><?=HOTLINE?></a></li>
				<li><img src="<?=IMG_URL?>new-template/flag/flag-usa.png"><a href="" title="Contact hotline"><?=HOTLINE_US?></a></li>
				<li><a href="" title="Contact hotline"><i class="fa fa-envelope-o" aria-hidden="true"></i><?=MAIL_INFO?></a></li>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
</div>
<div class="faqs cluster-content">
	<div class="container">
		<h2 class="home-heading text-center" style="padding-bottom: 50px; text-shadow: 3px 3px #bdbdbd;">Frequently Asked Questions</h2>
		<div class="cluster-body">
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8"><? require_once(APPPATH."views/module/search.php"); ?></div>
						<div class="col-sm-2"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-sm-8 col-xs-12">
					<div class="faqs-infinite">
						<div class="faqs-category "><h3 class="font-weight-bold"><?=!empty($category->alias) ? $category->name : "Vietnam Visa"?></h3></div>
						<div class="faqs-content">
						<? 
						foreach ($items as $value) { 
							$faqs_categories = $this->m_faqs_category->load($value->catid);
						?>
						<div class="post">
							<div class="post-content-wrapper">
								<div class="details">
									<div>
										<h4 class="entry-title font-weight-bold">
											<a title="<?=$value->title?>" href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>"><?=($offset+1).'. '?><?=$value->title?></a>
										</h4>
									</div>
									<div class="excerpt-container"><?=$value->summary?></div>
								</div>
							</div>
							<div class="clearfix"><a class="btn-rm" href="<?=site_url("faqs/{$faqs_categories->alias}/{$value->alias}")?>">Read more</a></div>
						</div>
						<? $offset++;} 
						?>
						</div>
						
					</div>
					<div class="pagi-bot text-center"><?=$pagination?></div>
				</div>
				<div class="col-lg-4 col-sm-4 d-none d-sm-none d-md-block">
					<? require_once(APPPATH."views/module/categories.php"); ?>
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
