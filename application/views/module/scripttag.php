<?
	ini_set('default_socket_timeout', 3);
	$sa_content = file_get_contents('https://www.shopperapproved.com/feeds/schema.php/?siteid=24798&token=sfx0VK6J');
	// $sa_total = substr($sa_content, strpos($sa_content, '<span itemprop="ratingCount">')+strlen('<span itemprop="ratingCount">'), 3);
	// echo $sa_content;
	$str = explode('based on', $sa_content);
	$str = explode(' ', $str[1]);
	$sa_total = $str[1];
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script> -->
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"name": "VIETNAM VISA",
	"url": "<?=BASE_URL?>",
	"logo": "<?=((stripos(IMG_URL, "http") === false) ? BASE_URL.IMG_URL."vietnam-visa-logo.png" : IMG_URL."vietnam-visa-logo.png")?>",
	"contactPoint": [{
		"@type": "ContactPoint",
		"telephone": "<?=HOTLINE?>",
		"contactType": "Customer service"
	}]
}
</script>

<script type="application/ld+json">
{
	"@context" : "http://schema.org",
	"@type" : "LocalBusiness",
	"name" : "VIETNAM VISA",
	"image" : "<?=((stripos(IMG_URL, "http") === false) ? BASE_URL.IMG_URL."landing-visa.jpg" : IMG_URL."landing-visa.jpg")?>",
	"telephone" : "<?=HOTLINE?>",
	"email" : "<?=MAIL_INFO?>",
	"address" : {
		"@type" : "PostalAddress",
		"streetAddress" : "<?=ADDRESS?>",
		"addressLocality" : "Ho Chi Minh"
	},
	"priceRange" : "$9.00"
}
</script>

<script type="application/ld+json">
{
	"@context": "http://schema.org/",
	"@type": "Review",
	"itemReviewed": {
		"@type": "Service",
		"name": "Vietnam Visa On Arrival"
	},
	"author": {
		"@type": "Person",
		"name": "Jenny Pham"
	},
	"reviewRating": {
		"@type": "Rating",
		"ratingValue": "5",
		"bestRating": "5"
	},
	"publisher": {
		"@type": "Organization",
		"name": "VIETNAM VISA"
	}
}
</script>
<script type="application/ld+json">
{
	"@context": "http://schema.org/",
	"@type": "WebSite",
	"name": "Vietnam Visa",
	"headline": "<?=$meta['title']?>",
	"description": "<?=$meta['description']?>",
	"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "<?=$sa_value?>",
		"ratingCount": "<?=$sa_total?>"
	}
}
</script>

<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
  window.__lc = window.__lc || {};
  window.__lc.license = 11351272;
  (function() {
    var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
    lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
  })();
</script>
<noscript>
<a href="https://www.livechatinc.com/chat-with/11351272/" rel="nofollow">Chat with us</a>,
powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
</noscript>
<!-- End of LiveChat code -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97323142-1', 'auto');
  ga('send', 'pageview');
</script>

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 855743151;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/855743151/?guid=ON&amp;script=0"/>
</div>
</noscript>

<? if (!empty($transaction_id)) { ?>
<!-- Google Code for Conversion Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 855743151;
var google_conversion_language = "en";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "E06MCNvB5XAQr7WGmAM";
var google_conversion_value = <?=$transaction_fee?>;
var google_conversion_currency = "USD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/855743151/?value=1.00&amp;currency_code=VND&amp;label=E06MCNvB5XAQr7WGmAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<? } ?>

<!-- Start of AddThis code -->
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58e6fc3014cd917a"></script> -->
<!-- End of AddThis code -->