window.fbAsyncInit = function() {
  FB.init({
	appId		: '762751813859314',
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use version 2.2
  });
};

// Load the SDK asynchronously
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is successful.
// This function is only called in those cases.
function facebookLogin(controllerUrl,redirectUrl){
	FB.login(function(response) {
		if (response.authResponse) {
			console.log(response.authResponse.userID);
			FB.api('/me?fields=id,name,email,gender', function(response) {
				var avatar = "https://graph.facebook.com/"+response.id+"/picture?type=large";
				$.ajax({
					type : 'POST',
					data : { id: response.id, fullname: response.name, email: response.email, username: response.username, avatar:avatar, gender: response.gender, providername : 'facebook' },
					url : controllerUrl,
					success : function(data){
						window.location.href = data;
					},
					async:false
				});
			});
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	},{scope: 'public_profile, email'});
}

function facebookLogout(redirectUrl){
	FB.logout(function(response) {
		window.location.href = redirectUrl;
	});
}
