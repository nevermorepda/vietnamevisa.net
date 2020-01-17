$(document).ready(function() {
	$(".btnstep").click(function(){
		var err = 0;
		var msg = new Array();
		if ($(".checkin-date").val() == "") {
			$(".checkin-date").addClass("error");
			err++;
		} else {
			$(".checkin-date").removeClass("error");
		}
		if ($(".checkout-date").val() == "") {
			$(".checkout-date").addClass("error");
			err++;
		} else {
			$(".checkout-date").removeClass("error");
		}
		if ($(".rooms").val() == "") {
			$(".rooms").addClass("error");
			err++;
		} else {
			$(".rooms").removeClass("error");
		}
		if ($(".fullname").val() == "") {
			$(".fullname").addClass("error");
			err++;
		} else {
			$(".fullname").removeClass("error");
		}
		if ($(".email").val() == "") {
			$(".email").addClass("error");
			err++;
		} else {
			$(".email").removeClass("error");
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
