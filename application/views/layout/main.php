<!DOCTYPE html>
<html lang="en-US">
	<head>
		<? require_once(APPPATH."views/module/head_html.php"); ?>
		<meta name="google-site-verification" content="kQG4HLNz93eksWSduwtRafkr1GzlUNIyuZIAp7ru1Ms" />
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PLJZ8XV');</script>
		<!-- End Google Tag Manager -->
	</head>
	<body>
		<?
			if ($this->util->slug($this->router->fetch_class()) != 'apply-visa') {
				unset($_SESSION['step']);
			}
		?>
		<div class="page-container">
			<? require_once(APPPATH."views/module/header.php"); ?>
			<div class="page-content">
			<?=$content?>
			</div>
			<? require_once(APPPATH."views/module/footer.php"); ?>
		</div>
		<? require_once(APPPATH."views/module/scripttag.php"); ?>
	</body>
</html>
