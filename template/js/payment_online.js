$(document).ready(function() {
	$("#proceed").click(function() {
		var err = 0;
		var msg = new Array();
		if ($("#fullname").val() == "") {
			$("#fullname").addClass("error");
			err += 1;
			msg.push("Your name is required.");
		}
		else {
			$("#fullname").removeClass("error");
		}
		
		if ($("#email").val() == "") {
			$("#email").addClass("error");
			err += 1;
			msg.push("Your email is required.");
		}
		else {
			if (!isEmail($("#email").val())) {
				$("#email").addClass("error");
				err += 1;
				msg.push("Invalid email address.");
			} else {
				$("#email").removeClass("error");
			}
		}
		
		if ($("#amount").val() == "") {
			$("#amount").addClass("error");
			err += 1;
			msg.push("Amount to pay is required.");
		}
		else {
			$("#amount").removeClass("error");
		}
		
		if($("#note").val() == "") {
			$("#note").addClass("error");
			err += 1;
			msg.push("Note for payment is required.");
		}
		else {
			$("#note").removeClass("error");
		}
		
		if ($("#security_code").val() == "" || $("#security_code").val().toUpperCase() != $(".security-code").html().toUpperCase()) {
			$("#security_code").addClass("error");
			err += 1;
			msg.push("Captcha code does not matched.");
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

function isEmail(emailStr)
{
	var emailPat = /^(.+)@(.+)$/;
	var matchArray = emailStr.match(emailPat);
	if (matchArray == null) {
		return false;
	}
	return true;
}

function checkNumber(input)
{
	var pattern="0123456789";
	var len = input.value.length;
	if (len != 0) {
		var index = 0;
		while ((index < len) && (len != 0)) {
			if (pattern.indexOf(input.value.charAt(index)) == -1)
			{
				if (index == len-1) {
					input.value=input.value.substring(0,len-1);
				} else if(index == 0) {
					input.value=input.value.substring(1,len);
				} else {
					input.value=input.value.substring(0,index)+input.value.substring(index+1,len);index=0;len=input.value.length;
				}
			}
			else {
				index++;
			}
		}
	}
}
