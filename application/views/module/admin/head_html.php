<?
$meta_info = new stdClass();
$meta_info->url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$configured_metas = $this->m_meta->items($meta_info, 1);

if (empty($meta['title'])) {
	$meta['title'] = "Vietnam Visa: Vietnam Visa on Arrival - Vietnam Visa Online";
}
if (empty($meta['keywords'])) {
	$meta['keywords'] = "Vietnam visa, Vietnam visa on arrival, Vietnam visa online, Vietnam visa application, Vietnam immigration";
}
if (empty($meta['description'])) {
	$meta['description'] = "We recommend that you choose Vietnam visa on arrival, as picking up Vietnam visa at the airport is quite simple, easy, no additional charges and no fail.";
	$meta['description'] = "";
}
if (empty($meta['canonical'])) {
	$meta['canonical'] = "";
}
if (empty($meta['author'])) {
	$meta['author'] = SITE_NAME;
}

if (!empty($configured_metas)) {
	$configured_meta = array_shift($configured_metas);
	$meta['title'] = $configured_meta->title;
	$meta['keywords'] = $configured_meta->keywords;
	$meta['description'] = $configured_meta->description;
	$meta['canonical'] = $configured_meta->canonical;
}
?>

<title><?=$meta['title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="must-revalidate">
<meta http-equiv="Expires" content="<?=gmdate("D, d M Y H:i:s", time() + (60*60))?> GMT">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?=$meta['description']?>" />
<meta name="keywords" content="<?=$meta['keywords']?>" />
<meta name="news_keywords" content="<?=$meta['keywords']?>" />
<meta property="og:site_name" content="<?=$meta['author']?>" />
<meta property="og:title" content="<?=$meta['title']?>" />
<meta property="og:description" content="<?=$meta['description']?>" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?=current_url()?>" />
<meta property="og:image" content="<?=IMG_URL?>visa-map.jpg" />
<meta property="og:image:type" content="image/jpeg" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?=$meta['description']?>" />
<meta name="twitter:title" content="<?=$meta['title']?>" />
<meta name="twitter:image" content="<?=IMG_URL?>visa-map.jpg" />
<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta name="author" content="<?=$meta['author']?>" />
<meta name="google-site-verification" content="dY5xCapFcXO7OnQacN6byJf2sh-QOsBEh5FjPKBfX-k" />
<!-- <meta property="fb:admins" content="594250103967893"/> -->

<link rel='SHORTCUT ICON' href='<?=BASE_URL?>/favicon.ico'/>
<link rel="alternate" href="<?=BASE_URL?>" hreflang="en" />
<link rel="canonical" href="<?=PROTOCOL.$meta_info->url?>" />
<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>bootstrap.css" />
<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>jquery.ui.css" />
<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>style.css" />
<link rel="stylesheet" type="text/css" href="<?=CSS_URL?>font-awesome.css">
<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>../flexslider/css/flexslider.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald">
<link rel="author" href="https://plus.google.com/111337747674016562751/">

<script type="text/javascript" src="<?=JS_URL?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>jquery.ui.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>jquery.lazy.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>bootstrap.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>materialize.js"></script>
<script type="text/javascript" src="<?=JS_URL?>tooltip.js"></script>
<script type="text/javascript" src="<?=JS_URL?>util.js"></script>
<script type="text/javascript" src="<?=JS_URL?>../flexslider/js/jquery.flexslider.js"></script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '505300863540095');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=505300863540095&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script type="text/javascript">
	var BASE_URL = "<?=BASE_URL?>";
</script>


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?=ADMIN_CSS_URL?>admin.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_JS_URL?>admin.js"></script>