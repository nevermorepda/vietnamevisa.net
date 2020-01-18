<?php
// WEB ROOT URI
define("PROTOCOL",				"http://localhost/");
define("DOMAIN",				"vietnamevisa.net");
define("BASE_URL",				PROTOCOL.DOMAIN);
define("BASE_URL_HTTPS",		BASE_URL);
define("TPL_URL",				BASE_URL."/template/");
define("IMG_URL",				TPL_URL."images/");
define("CSS_URL",				TPL_URL."css/");
define("JS_URL",				TPL_URL."js/");

define("CLOUDFRONT",			"//d20eakrm1ybs3f.cloudfront.net/vietnam-evisa.org/");
define("CF_TPL_URL",			CLOUDFRONT."template/");
define("CF_IMG_URL",			CF_TPL_URL."images/");
define("CF_CSS_URL",			CF_TPL_URL."css/");
define("CF_JS_URL",				CF_TPL_URL."js/");

define("ADMIN_URL",				BASE_URL."/syslog/login.html");
define("ADMIN_TPL_URL",			BASE_URL."/template/admin/");
define("ADMIN_IMG_URL",			ADMIN_TPL_URL."images/");
define("ADMIN_CSS_URL",			ADMIN_TPL_URL."css/");
define("ADMIN_JS_URL",			ADMIN_TPL_URL."js/");
define("ADMIN_AGENT_ID",		"M_VIETNAM_VISA_ORG_VN");
define("ADMIN_ROW_PER_PAGE",	10);
define("SUPER_ADMIN_FULL_ROLE",	'8061|8060|5|1|8267');

define("BOOKING_PREFIX",		"VISA");
define("BOOKING_E_PREFIX",		"VISAE");
define("BOOKING_PREFIX_EX",		"EX-".BOOKING_PREFIX."-");
define("BOOKING_PREFIX_PO",		"PO-".BOOKING_PREFIX."-");
define("BOOKING_TOUR_PREFIX",	"T");

define("CACHE_TIME",			30);
define("CACHE_RAND",			date("Ymd"));
define("ROW_PER_PAGE",			10);
define("ID_EXTRA_SERVICES",		10);
define("DEVICES_PC",			"Windows 10|Windows 8.1|Windows 8|Windows 7|Windows Vista|Windows 2003|Windows XP|Windows 2000|Windows NT 4.0|Windows NT|Windows 98|Mac OS X|Power PC Mac|Macintosh|Linux|GNU/Linux");
define("DEVICES_MB",			"Android|iOS|BlackBerry|Windows Phone");

// REMOTE FILE MANAGER
define("CDN_URL",				"http://www.vietnamnvisa.com");
define("CDN_AGENT_ID",			"CDN_MEDIA_VISA_SYSLOG");
define("CDN_MAIL_NOREPLY_USER",	"noreply@vietnamnvisa.com");
define("CDN_MAIL_NOREPLY_PASS",	"KsFXwvSS8265@");
define("PATH_CKFINDER",			$_SERVER['DOCUMENT_ROOT'].'/'.DOMAIN.'/files/upload/image/img-content/*');

// WEB DATABASE
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "vietnamvisa");
define("DRIVER",   "mysqli");

// --------------------------------------------
// USER DEFINE
// --------------------------------------------
define("SITE_NAME", 	"Vietnamevisa.net");

// USER TYPES
define("USR_USER",				2);
define("USR_ADMIN",				1);
define("USR_SUPPER_ADMIN",		-1);

define("VAT",		10);
// Paypal
define("PAYPAL", "ON");
define("PAYPAL_PAYMENT",		"paypal@vietnamvisateam.com");
define("PAYPAL_USER",			"paypal_api1.vietnamvisateam.com");
define("PAYPAL_PWD",			"HDS26K886MQQ3NUE");
define("PAYPAL_SIGNATURE",		"AUkau1FwogE3kL3qo1vGTARqlijQAQR00eHJqe8eQoUOI2ZS3MeX.UVE");
//define("PAYPAL_PAYMENT",		"paypal@travelovietnam.com");
//define("PAYPAL_USER",			"paypal_api1.travelovietnam.com");
//define("PAYPAL_PWD",			"4REQ9BC4D649RVTY");
//define("PAYPAL_SIGNATURE",	"AmsFCmptjBSFmThGONrqqaczQzYbA4bNvtQdHEJCcNXlUxIRiAYn1qa0");
define("PAYPAL_VERSION",		"93");
define("PAYPAL_CURRENCY",		"USD");
define("PAYPAL_CANCEL_URL",		BASE_URL."/apply-visa.html");
define("PAYPAL_RETURN_URL",		BASE_URL."/apply-visa.html");

define("PAYPAL_TOUR_CANCEL_URL",BASE_URL."/tours/failure.html");
define("PAYPAL_TOUR_RETURN_URL",BASE_URL."/tours/failure.html");

define("PAYPAL_E_CANCEL_URL",		BASE_URL."/apply-e-visa.html");
define("PAYPAL_E_RETURN_URL",		BASE_URL."/apply-e-visa.html");

// Gate2Shop
define("G2S", "OFF");
define("G2S_SECRET_KEY",		"OXdboh2JpHmGxdQbiq89Hi9JyG4pFuPiAZgGnC0TyWmngeFfNfxwnimj8K4yx6QM");
define("G2S_MERCHANT_ID",		"3486823679499290452");
define("G2S_MERCHANT_SITE_ID",	"86891");
define("G2S_CURRENTCY",			"USD");
define("G2S_VERSION",			"3.0.0");

// OnePay
define("OP", "OFF");
define("OP_PAYMENT_URL",		"https://onepay.vn/vpcpay/vpcpay.op?");
define("OP_QUERY_URL",			"https://migs.mastercard.com.au/vpcdps");
define("OP_RETURN_URL",			BASE_URL."/apply-visa.html");
define("OP_E_RETURN_URL",		BASE_URL."/apply-e-visa.html");
define("OP_T_RETURN_URL",		BASE_URL."/payment.html");
define('OP_SECURE_SECRET',		'DD9F0B7DB5DFA307A067F17F6E1576E6');
define('OP_MERCHANT',			'OP_VNEVISA08');
define('OP_ACCESSCODE',			'E1ACF954');

// Google reCaptcha
define('RECAPTCHA_KEY',			'6LecZBgTAAAAAIaIO0g4yUJtDToIc7D8OR2WP2UF');
define('RECAPTCHA_SECRET',		'6LecZBgTAAAAAONTUrc7vt24lHNBAuvhMO2-jBtQ');

// Google Plus API key
define('GOOGLE_KEY',			'724539714112-fpe7i8pgia4tg37gna48e94dan9ijpk2.apps.googleusercontent.com');

// Facebook API key
define('FB_KEY',				'762751813859314');

?>