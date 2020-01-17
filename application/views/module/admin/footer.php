<a title="UP" class="scroll-top d-none d-sm-none d-md-block" href="#"></a>

<? if ($admin->user_type == USR_SUPPER_ADMIN) { ?>
<div class="alert alert-warning alert-dismissible notify-panel" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <div class="notify-panel-body"></div>
</div>

<script type="text/javascript">
	var userActionTimerID;
	
	function userAction() {
		clearTimeout(userActionTimerID);
		
		$.ajax({
			type : 'GET',
			data : {},
			url : "<?=site_url('syslog/ajax-user-action')?>",
			success : function(data){
				$(".notify-panel-body").html(data);
				if (data != "") {
					$(".notify-panel").show("fade");
				} else {
					$(".notify-panel").hide("fade");
				}
				userActionTimerID = setTimeout(userAction, 10000);
			}
		});
	};
	
	$(document).ready(function() {
		userActionTimerID = setTimeout(userAction, 5000);
	});
</script>
<? } ?>

<script type="text/javascript">
	$(document).ready(function() {
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('.scroll-top').fadeIn();
			} else {
				$('.scroll-top').fadeOut();
	    	}
		});
		$('.scroll-top').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
		$('[data-toggle="tooltip"]').tooltip();
		$.post("<?=BASE_URL?>/files/browse.php",{"syslog":"<?=(in_array($this->session->admin->user_type, array(USR_ADMIN, USR_SUPPER_ADMIN)))?>"});
	});
	
	function openKCFinderBrowse(field, url) {
		window.KCFinder = {
			callBack: function(url) {
				field.value = url;
				window.KCFinder = null;
			}
		};
		window.open('<?=BASE_URL?>/files/browse.php?type=' + field + '&dir='+ field + '/' + url, 'kcfinder_browse',
			'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
			'resizable=1, scrollbars=0, width=800, height=600'
		);
	}
	
	function openKCFinder4Textbox(field) {
		window.KCFinder = {
			callBack: function(url) {
				field.value = url;
				window.KCFinder = null;
			}
		};
		window.open('<?=BASE_URL?>/files/browse.php?type=image&dir=files/public', 'kcfinder_textbox',
			'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
			'resizable=1, scrollbars=0, width=800, height=600'
		);
	}
	
	tinymce.init({
		selector: '.tinymce',
		theme: 'modern',
		convert_urls: false,
		plugins: [
			'advlist table autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools'
		],
		toolbar: 'insertfile undo redo | removeformat | styleselect | fontselect fontsizeselect | bold italic | forecolor backcolor | table | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
		content_css: [
			'<?=CSS_URL?>style.css',
			'<?=CSS_URL?>bootstrap.css'
		],
		file_browser_callback: function(field, url, type, win) {
			tinymce.activeEditor.windowManager.open({
				file: '<?=BASE_URL?>/files/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
				title: 'File Manager',
				width: 700,
				height: 500,
				inline: true,
				close_previous: false
			}, {
				window: win,
				input: field
			});
			return false;
		}
	});
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97323142-1', 'auto');
  ga('send', 'pageview');
</script>