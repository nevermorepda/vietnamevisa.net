<div class="container">
	<div id="search-panel">
		<img alt="<?=SITE_NAME?>" src="<?=IMG_URL?>vietnam-visa-logo.png">
		<!-- Google Custom Search Element -->
		<script>
			var myCallback = function() {
				google.search.cse.element.render();
				google.search.cse.element.getelement('gcse_el').execute("<?=$q?>");
			};

			(function() {
			    var cx = '011268399305415352840:jxjcmjg6zfc';
			    var gcse = document.createElement('script');
			    gcse.type = 'text/javascript';
			    gcse.async = true;
			    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			        '//cse.google.com/cse.js?cx=' + cx;
			    var s = document.getElementsByTagName('script')[0];
			    s.parentNode.insertBefore(gcse, s);
			})();
		</script>
		<gcse:search gname="gcse_el"></gcse:search>
	</div>
</div>

<style type="text/css">
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
	.cse .gsc-search-button input.gsc-search-button-v2, input.gsc-search-button-v2 {
		height: 26px !important;
		width: 68px !important;
		margin-top: 3px;
	}
</style>