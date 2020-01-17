$(document).ready(function() {
	$(".btnstep").click(function(){
		var err = 0;
		var msg = new Array();
		if ($(".departure-date").val() == "") {
			$(".departure-date").addClass("error");
			err++;
		} else {
			$(".departure-date").removeClass("error");
		}
		if ($(".travelers").val() == "") {
			$(".travelers").addClass("error");
			err++;
		} else {
			$(".travelers").removeClass("error");
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
	
	directionChanged();
});

function directionChanged()
{
	if ($("#direction").val() == "One-Way") {
		$("#return_date").css("display","none");
	}
	else {
		$("#return_date").css("display","block");
	}
}
