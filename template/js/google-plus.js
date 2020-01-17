(function() {
	var po = document.createElement('script');
	po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(po, s);
 })();

/* Executed when the APIs finish loading */
function render() {
	// Additional params including the callback, the rest of the params will
	// come from the page-level configuration.
	var additionalParams = {
		'callback': signinCallback,
		'clientid': '130328514959-05lat7alelkngot8mna8r50q0q2ebjpa.apps.googleusercontent.com',
		'cookiepolicy': 'single_host_origin',
		'approvalprompt':'force',
		'requestvisibleactions': 'http://schemas.google.com/AddActivity',
		'scope': 'https://www.googleapis.com/auth/plus.profile.emails.read'
	};

	// Attach a click listener to a button to trigger the flow.
	var signinButton = document.getElementById('google-login');
		signinButton.addEventListener('click', function() {
	 	gapi.auth.signIn(additionalParams); // Will use page level configuration
	});
}

function signinCallback(authResult) {
	if (authResult['status']['signed_in']) {
		console.log('Login state: logged in');
		gapi.client.load('plus','v1', function(){
			var request = gapi.client.plus.people.get({
				'userId': 'me'
			});

			request.execute(function(resp) {
				email = resp['emails'].filter(function(v) {
					return v.type === 'account'; // Filter out the primary email
				})[0].value;
				id = resp.id;
				name = resp.displayName;
				image_link = resp.image['url'].substring(0,resp.image['url'].length - 2 ) + '200';
				gender = 0;
				if (resp.gender == 'male') {
					gender = 1;
				}

				$.ajax({
					type : 'POST',
					// async:false,
					data : { id: resp.id, fullname: resp.displayName, email: email, avatar:image_link, gender: gender, providername : 'google-plus'},
					url : 'https://www.vietnamevisa.net/auth/socialLogin',
					success : function(data){
						window.location.href = data;
					},
				});
			});
		});
	} else {
		// Update the app to reflect a signed out user
		// Possible error values:
		//   "user_signed_out" - User is signed-out
		//   "access_denied" - User denied access to your app
		//   "immediate_failed" - Could not automatically log in the user
	}
}