<?
	$tabindex = !empty($tabindex) ? $tabindex : "home";
	if ($this->session->userdata("user")) {
		$user = $this->session->userdata("user");
	}
?>

<div class="header">
	<!-- <div id="top-header">
		<ul class="container">
			<li><i class="fa fa-clock-o" aria-hidden="true"></i> <span>Vietnam Time (GMT+7):</span> Fri, Dec 06, <span class="clock-time">16:20:19 PM</span></li>
			<li class="contact-number">
				<ul class="contact-tel">
					<li class="tel"><a href="tel:+84.909.180.525 " title="HOTLINE">VN: <span>+84.909.180.525 </span></a></li>
					<li style="margin-left:10px;" class="tel"><a href="tel:+1.844.839.6666" title="TOLL FREE">USA: <span>+1.844.839.6666</span></a></li>
				</ul>
			</li>
			<li class="top-menu">
				<ul class="menu-items">
					<li class="menu-item">
						<a href="./payment-online.html" class="po-sign-in"><i style="font-weight: bold;" class="fa fa-usd" aria-hidden="true"></i> Payment Online / </a>
					</li>
					<li class="menu-item noaction menu-item-user-fullname" style="position: relative; display: none;">
						<a class="dropdown-toggle po-sign-in" id="menu-myaccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							<i class="fa fa-user" aria-hidden="true"></i> <span class="user-fullname"></span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="menu-myaccount">
							<li><a class="My Account" href="./member.html"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li>
							<li><a class="Sign Out" href="./member/logout.html"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a></li>
						</ul>
					</li>
					<li class="menu-item menu-item-user-signin">
						<a href="./member.html" class="po-sign-in"><i class="fa fa-user" aria-hidden="true"></i> Sign in</a>
					</li>
				</ul>
			</li>
		</ul>
	</div> -->
	<div class="banner-header">
		<div class="container">
			<div class="banner">
				<div class="logo">
					<a title="Vietnam Visa" href="<?=BASE_URL?>"><img style="width: 240px;" src="<?=IMG_URL?>/new-template/logo.png" alt="Vietnam Visa" /></a>
				</div>
				<div class="top-menu">
					<ul class="menu-items">
						<li class="menu-item">
							<a href="<?=site_url("payment-online")?>" class="po-sign-in"><i style="font-weight: bold;" class="fa fa-usd" aria-hidden="true"></i> Payment Online </a>
						</li>
						<li class="menu-item noaction menu-item-user-fullname" style="position: relative; display: none;">
							<a class="dropdown-toggle po-sign-in" id="menu-myaccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								<i class="fa fa-user" aria-hidden="true"></i> <span class="user-fullname"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="menu-myaccount">
								<li><a class="My Account" href="<?=site_url("member")?>"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li>
								<li><a class="Sign Out" href="<?=site_url("member/logout")?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-user-signin">
							<a href="<?=site_url("member")?>" class="po-sign-in"><i class="fa fa-user" aria-hidden="true"></i> Sign in</a>
						</li>
						<li class="menu-item" data-toggle="modal" data-target="#searchModal">
							<a class="<?=(($tabindex == "search") ? "active" : "")?>" title="" href="#"><i class="fa fa-search"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="main-menu clearfix">
		<div class="container clearfix">
			<ul class="menu-items clearfix">
				<li><a class="<?=(($tabindex == "home") ? "active" : "")?>" title="" href="<?=BASE_URL?>">Home</a></li>
				<li class="menu-item-div"></li>
				<li>
					<a href="<?=site_url("visa-processing")?>" class="<?=(($tabindex == "processing") ? "active" : "")?>" title="">How It Works</a>
					<!-- <ul class="sub-menu">
						<li><a style="padding: 6px;" class="<?=(($tabindex == "visa-processing") ? "active" : "")?>" title="" href="<?=site_url("vietnam-visa-on-arrival")?>">Visa On Arrival</a></li>
						<li><a class="<?=(($tabindex == "vietnam-e-visa") ? "active" : "")?>" title="" href="<?=site_url("vietnam-e-visa")?>">E-Visa</a></li>
					</ul> -->
				</li>
				<li class="menu-item-div"></li>
				<li>
					<a class="<?=(($tabindex == "apply-visa") ? "active" : "")?>" title="">Apply Visa Form</a>
					<!-- <ul class="sub-menu">
						<li><a class="<?=(($tabindex == "apply-visa") ? "active" : "")?>" title="" href="<?=site_url("apply-visa")?>">Visa On Arrival</a></li>
						<li><a class="<?=(($tabindex == "apply-e-visa") ? "active" : "")?>" title="" href="<?=site_url("apply-e-visa")?>">E-Visa</a></li>
					</ul> -->
				</li>
				<li class="menu-item-div"></li>
				<li><a class="<?=(($tabindex == "visa-fee") ? "active" : "")?>" title="" href="<?=site_url("visa-fee")?>">Visa Fee</a></li>
				<li class="menu-item-div"></li>
				<!-- <li><a class="" title="" href="./services.html">Extra Services</a></li>
				<li class="menu-item-div"></li> -->
				<li><a class="<?=(($tabindex == "faqs") ? "active" : "")?>" title="" href="<?=site_url("faqs")?>">FAQs</a></li>
				<li class="menu-item-div"></li>
				<li><a class="<?=(($tabindex == "contact") ? "active" : "")?>" title="" href="<?=site_url("contact")?>">Contact</a></li>
				<li class="menu-item-div"></li>
			</ul>
		</div>
	</div>
</div>

<div class="header-sm">
	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse">
				<span class="sr-only">Toggle navigation</span>
				<i class="fa fa-bars" aria-hidden="true"></i>
			</button>
			<a class="navbar-brand" title="Vietnam Visa" href="<?=BASE_URL?>"><img style="width: 120px;" src="<?=IMG_URL?>logo-vietnam-visa-org-vn-m.svg" alt="Vietnam Visa" /></a>
		</div>
		<div class="navbar-menu-toggle">
			<div id="target-menu">
				<div class="navbar-menu-toggle-right">
					<div class="navbar-scroller">
						<ul class="">
							<li>
								<a href="tel:<?=HOTLINE?>"><span class="glyphicon glyphicon-earphone"></span> <?=HOTLINE?> </a>
							</li>
							<li>
								<a href="<?=site_url("contact")?>"><span class="glyphicon glyphicon-envelope"></span> <?=MAIL_INFO?></a>
							</li>
							<li>
								<a href="<?=site_url("member")?>"><span class="glyphicon glyphicon-user"></span> Sign In</a>
							</li>
							<li>
								<a title="" href="<?=BASE_URL?>"><span class="glyphicon glyphicon-home"></span> Home</a>
							</li>
							<li>
								<a href="<?=site_url("visa-processing")?>"><span class="glyphicon glyphicon-time"></span> How It Works</a>
							</li>
							<!-- <li class="item-menu" stt="0">
								<a title=""><span class="glyphicon glyphicon-time"></span> How It Works</a>
								<ul class="sub-menu">
									<li><a class="" title="" href="./vietnam-e-visa.html">E-Visa</a></li>
									<li><a class="" title="" href="./visa-processing.html">Visa On Arrival</a></li>
									
								</ul>
							</li> -->
							<li class="item-menu">
								<a title=""><span class="glyphicon glyphicon-send"></span> Apply Vietnam Visa</a>
								<ul class="sub-menu">
									<li><a class="<?=(($tabindex == "apply-visa") ? "active" : "")?>" title="" href="<?=site_url("apply-visa")?>">Visa On Arrival</a></li>
									<li><a class="<?=(($tabindex == "apply-e-visa") ? "active" : "")?>" title="" href="<?=site_url("apply-e-visa")?>">E-Visa</a></li>
								</ul>
							</li>
							<li>
								<a title="" href="<?=site_url("visa-fee")?>"><span class="glyphicon glyphicon-usd"></span> Visa Fees</a>
							</li>
							<!-- <li>
								<a title="" href="<?=site_url("services")?>"><span class="glyphicon glyphicon-cog"></span> Extra Services</a>
							</li> -->
							<li>
								<a title="" href="<?=site_url("faqs")?>"><span class="glyphicon glyphicon-question-sign"></span> FAQs</a>
							</li>
							<li>
								<a title="" href="<?=site_url("contact")?>"><span class="glyphicon glyphicon-envelope"></span> Contact</a>
							</li>
							<li data-toggle="modal" data-target="#searchModal">
								<a title="" href="#"><span><i class="fa fa-search"></i> Search</span></a>
							</li>
						</ul>
						<div class="navbar-sm-footer">
							<p>&copy; Copyright <?=date("Y")." ".SITE_NAME?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="searchModal" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Search for visa to Vietnam</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<script>
					(function() {
						var cx = '013925715147185311263:6dkn73ryshh';
						var gcse = document.createElement('script');
						gcse.type = 'text/javascript';
						gcse.async = true;
						gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(gcse, s);
					})();
				</script>
				<gcse:search></gcse:search>
			</div>
		</div>
	</div>
</div>


<style type="text/css">
	.reset-box-sizing, .reset-box-sizing *, .reset-box-sizing *:before, .reset-box-sizing *:after, .gsc-inline-block {
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	input.gsc-input, .gsc-input-box, .gsc-input-box-hover, .gsc-input-box-focus, .gsc-search-button {
		box-sizing: content-box;
		line-height: normal;
	}
	.gsc-orderby-container, .gcsc-branding, .gsc-adBlock, .gsc-adBlockVertical {
		display: none;
	}
	.gsc-result-info, .cse .gsc-control-cse, .gsc-control-cse {
		padding-left: 0px;
		padding-right: 0px;
	}
	.gsc-table-result, .gsc-thumbnail-inside, .gsc-url-top {
		padding-left: 0px;
		padding-right: 0px;
	}
	.gsc-results .gsc-cursor-box {
		margin-left: 0px;
		margin-right: 0px;
	}
	.gsst_a {
		padding-top: 6px;
		padding-right: 0px;
	}
	input.gsc-search-button, input.gsc-search-button:hover, input.gsc-search-button:focus {
		border-color: #E4241D;
		background-color: #E4241D;
	}
	.gsc-search-button-v2,
	.gsc-search-button-v2:hover,
	.gsc-search-button-v2:focus {
		background-color: #de4a4a;
		border-color: #de4a4a;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.item-menu').click(function(event) {
		if (parseInt($(this).attr('stt')) == 0) {
			$(this).find('.sub-menu').css('display', 'block');
			$(this).attr('stt',1);
		}
		else {
			$(this).find('.sub-menu').css('display', 'none');
			$(this).attr('stt',0);
		}
	});

	$(".navbar-toggle").click(function(){
		if ($(".navbar-menu-toggle-right").position().left < 0) {
			$(".navbar-menu-toggle-right").css("left", "0px");
		} else {
			$(".navbar-menu-toggle-right").css("left", "-500px");
		}
	});

	// Click outside the menu to close
	$(document).click(function(){
		if ($(".navbar-menu-toggle-right").position().left == 0) {
			$(".navbar-menu-toggle-right").css("left", "-500px");
		}
	});

	// Load username
	$.ajax({
		type: "POST",
		url: BASE_URL + "/member/ajax-username.html",
		data: {},
		dataType: "html",
		success: function(result) {
			if (result != "") {
				$(".user-fullname").html(result);
				$(".menu-item-user-fullname").show();
				$(".menu-item-user-signin").hide();
			}
		}
	});
});
</script>

<script type="text/javascript">
	// Javascript show current time
	var nIntervId;

	function updateTime() {
		nIntervId = setInterval(function(){
			var offset = 7;
			var now = new Date( new Date().getTime() + offset * 3600 * 1000);
			var str = now.toUTCString().replace( / GMT$/, "" );

			var ampm = (now.getUTCHours() >= 12) ? "PM" : "AM";
				$('.clock-time').html(now.getUTCHours() + ':' + now.getUTCMinutes() + ':' + now.getUTCSeconds() + ' ' + ampm);
		}, 1000);
	}

	$(function() {
		updateTime();
	});
</script>