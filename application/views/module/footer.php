<?	$visa_news_info = new stdClass();
	$visa_news_info->catid = 2;
	$visa_news = $this->m_content->items($visa_news_info, 1, 3);

	$info = new stdClass();
	$info->parent_id = 0;
	$useful_categories = $this->m_useful_category->items($info,1);
?>
<div class="footer">
	<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
		<div class="row">
			<div class="col-md-5 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-11">
						<a title="Vietnam Visa" href="<?=BASE_URL?>"><img style="width: 240px;" src="<?=IMG_URL?>logo_vietnamevisa.net.svg" alt="Vietnam Visa" /></a>
						<br>
						<ul class="fnav-links">	
							<li><?=ADDRESS?></li>
							<li><i class="fa fa-phone"></i> <a title="Contact hotline" href="tel:<?=HOTLINE?> "><?=HOTLINE?> </a></li>
							<li><i class="fa fa-envelope-o"></i> <a title="Contact email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></li>
						</ul>
						<div class="social-link">
							<ul>
								<li><a target="_blank" title="Contact form" href="https://www.facebook.com/vietnamvisaorganization"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a target="_blank" title="Contact form" href="https://twitter.com/visa_viet"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a target="_blank" title="Contact form" href="https://plus.google.com/u/0/112540648872987664355"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<h3 class="fnav-title"><a href="<?=site_url("useful-information")?>">USEFUL INFORMATION</a></h3>
				<ul class="fnav-links">
					<li><a title="Vietnam Visa" href="<?=site_url("useful-information/{$useful_categories[0]->alias}")?>"><?=$useful_categories[0]->name?></a></li>
					<li><a title="Embassy list" href="<?=site_url("vietnam-embassies")?>"><?=$useful_categories[1]->name?></a></li>
					<li><a title="Visa News" href="<?=site_url("useful-information/{$useful_categories[2]->alias}")?>"><?=$useful_categories[2]->name?></a></li>
					<li><a title="Travel Tips" href="<?=site_url("useful-information/{$useful_categories[3]->alias}")?>"><?=$useful_categories[3]->name?></a></li>
					<li><a title="Consultant Services Guideline" href="<?=site_url("useful-information/{$useful_categories[4]->alias}")?>"><?=$useful_categories[4]->name?></a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<h3 class="fnav-title"><a href="">QUICK LINKS</a></h3>
				<ul class="fnav-links">
					<li><a title="About Us" href="<?=site_url("about-us")?>">About Us</a></li>
					<li><a title="Terms and Conditions" href="<?=site_url("terms-and-conditions")?>">Terms & Conditions</a></li>
					<li><a title="Privacy policy" href="<?=site_url("policy")?>">Privacy Policy</a></li>
					<li><a title="Payment Instruction" href="<?=site_url("payment-instruction")?>">Payment Instruction</a></li>
					<li><a title="Cancellation and Refund Policy" href="<?=site_url("refund-policy")?>">Cancellation & Refund Policy</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="footer-bottom">
	<div class="container">
		<div class="text-center">
			<div class="copyright">
				<p style="font-size:13px;">We are pleased to inform that <?=DOMAIN?> is the E-commercial website in Vietnam in processing Vietnam visa. We are not affiliated with the Government. We are offering useful services for helping the Customer to understand visa application, visa processing and visa requirements which is being related to Visa on arrival.
				<br>Once you use our services, we have a mission to handle visa applications in Vietnam Immigration Department and provide the legal services to you and on time. You can also obtain Vietnam visa by yourself at Vietnam Embassies in your living country or visit the official website for a lower price. - by <a href="<?=BASE_URL?>"><?=DOMAIN?></a></p>
			</div>
		</div>
	</div>
</div>

<div id="dialog" class="modal-error modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modal title</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
			</div>
			<div class="modal-body">
				<p>&hellip;</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<a title="UP" class="scrollup" href="#"></a>


<!-- Start of AddThis code -->
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58e6fc3014cd917a"></script> -->
<!-- End of AddThis code -->