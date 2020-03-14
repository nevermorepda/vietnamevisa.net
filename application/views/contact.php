
<div class="banner-top faqs-banner d-none d-sm-none d-md-block" style="background: url('<?=IMG_URL?>new-template/banner-faqs.png') no-repeat scroll top center transparent;">
	<img src="<?=IMG_URL?>new-template/flag-faqs.png" class="img-responsive flag-faqs" alt="flag-faqs">
	<div class="container">
		<div class="text-content">
			<h1>
				<span class="" style="">CONTACT US</span>
				<div class="bd-right d-none d-lg-block d-md-block"></div>
			</h1>
			<ul>
				<li>Support online 24/7</li>
				<li>Office available Mon-Friday</li>
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
<div class="contact cluster-content" style="background: url('<?=IMG_URL?>new-template/background.png') no-repeat scroll top center transparent;">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2 class="home-heading" style="padding-bottom: 15px; text-shadow: 3px 3px #bdbdbd;">Contact information</h2>
				<div class="clearfix">
					<div class="left" style="width: 100px">
						<p><i class="fa fa-map-marker"></i><strong>Address:</strong></p>
					</div>
					<div class="left" style="padding-bottom: 15px;">
						<p class="">
							<b>VIETNAM VISA DEPARTMENT</b><br>
							<?=ADDRESS?>
						</p>
					</div>
				</div>
				<div class="clearfix">
					<div class="left" style="width: 100px; padding-bottom: 15px;">
						<p><i class="fa fa-phone"></i><strong>Hotline:</strong></p>
					</div>
					<div class="left">
						<span><?=HOTLINE?></span>
					</div>
				</div>
				<div class="clearfix">
					<div class="left" style="width: 100px; padding-bottom: 15px;">
						<p><i class="fa fa-envelope-o"></i><strong>Email:</strong></p>
					</div>
					<div class="left">
						<a title="Email" href="mailto:visa@vietnam-visa.org.vn"><?=MAIL_INFO?></a>
					</div>
				</div>
				<div class="clearfix">
					<div class="left" style="width: 100px; padding-bottom: 15px;">
						<p><i class="fa fa-facebook"></i><strong>Facebook:</strong></p>
					</div>
					<div class="left">
						<a target="_blank" title="Email" href="https://www.facebook.com/vietnamvisavs">www.facebook.com/vietnamvisavs</a>
					</div>
				</div>
				<!--<div class="googlemap">
					<div id="mapcanvas" style="height: 300px; width: 100%;"></div>
				</div>-->
			</div>
			<div class="col-md-6">
				<h2 class="home-heading" style="padding-bottom: 15px; text-shadow: 3px 3px #bdbdbd;">Contact form</h2>
				<form id="contact-form" action="<?=site_url("contact/message")?>" method="POST">
					<div class="form-group">
						<label class="form-label">YOUR NAME <span class="required">*</span></label>
						<input type="text" value="" id="fullname" name="fullname" required="" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">EMAIL <span class="required">*</span></label>
						<input type="email" value="" id="email" name="email" required="" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">PHONE NUMBER</label> <span style="font-size: 12px !important;" class=""> (optional)</span>
						<input type="text" value="" id="phone" name="phone" class="form-control"><br>
					</div>
					<div class="form-group">
						<label class="form-label">MESSAGE <span class="required">*</span></label>
						<textarea required="" style="height: 108px;" id="message" name="message" type="text" class="form-control"></textarea>
					</div>
					<div class="form-group captcha">
						<label class="form-label">CAPTCHA <span class="required">*</span></label>
						<div class="clearfix">
							<div class="left">
								<input type="text" style="width: 100px" value="" id="security_code" name="security_code" required="" class="form-control">
							</div>
							<div class="left" style="margin-left: 10px; line-height: 30px;">
								<label class="security-code"><?=$this->util->createSecurityCode()?></label>
							</div>
						</div>
					</div>
						<!-- <div class="form-group">
							<input type="submit" class="btn btn-danger btn-contact" name="submit" value="SEND MESSAGE">
						</div> -->
					<div class="form-group showmore-button">
						<input type="submit" name="submit" class="btn btn-danger btn-contact" value="SEND NOW">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="googleMap" style="width:100%;height:400px;"></div>

<script>
function myMap() {
// The location of Vietnam
var vietnam = {lat: 10.7800015, lng: 106.6626761};
var locations = [
	['Marker 1',10.7800015,106.6626761],
	['Marker 2',38.359898,-99.868568],
	['Marker 3',13.727894,100.586378],
	['Marker 4',22.087180,79.537795],
	['Marker 5',50.881478,10.256028],
];

// The map, centered at vietnam
var map = new google.maps.Map(
	document.getElementById('googleMap'), {zoom: 3, center: vietnam});

// The marker, positioned at vietnam
		for (i = 0; i < locations.length; i++) {
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map,
			clickable: true
		});
	}
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_MAPS_KEY?>&callback=myMap"></script>

<? if ($this->session->flashdata('success')) { ?>
<script>
	$(document).ready(function() {
		messageBox("INFO", "Success", "<?=$this->session->flashdata('success')?>");
	});
</script>
<? } ?>

<script>
$(document).ready(function() {
	$(".btn-contact").click(function() {
		var err = 0;
		var msg = new Array();
		if ($("#fullname").val() == "") {
			$("#fullname").addClass("error");
			msg.push("Your name is required.");
			err++;
		} else {
			$("#fullname").removeClass("error");
		}

		if ($("#email").val() == "") {
			$("#email").addClass("error");
			msg.push("Your email is required.");
			err++;
		} else {
			$("#email").removeClass("error");
		}

		if ($("#message").val() == "") {
			$("#message").addClass("error");
			msg.push("Please give us your message.");
			err++;
		} else {
			$("#message").removeClass("error");
		}

		if ($("#security_code").val() == "" || $("#security_code").val().toUpperCase() != $(".security-code").html().toUpperCase()) {
			$("#security_code").addClass("error");
			msg.push("Captcha code does not matched.");
			err++;
		} else {
			$("#security_code").removeClass("error");
		}

		if (err == 0) {
			return true;
		}
		else {
			showErrorMessage(msg);
			return false;
		}
	});
});
</script>
