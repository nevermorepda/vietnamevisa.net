<div style='float: left'>
	<b:if cond='data:post.isFirstPost'>
	<script>(function(d){
      var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
      js = d.createElement('script'); js.id = id; js.async = true;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      d.getElementsByTagName('head')[0].appendChild(js);
    }(document));</script>
	</b:if>
	<fb:like expr:href="data:post.canonicalUrl" layout='button_count'
		send='true' show_faces='false' font="arial" action="like"
		colorscheme="light"></fb:like>
</div>