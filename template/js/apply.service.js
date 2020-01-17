$(document).ready(function() {
	$(".group-size").change(function(){
		updatePanel();
	});
	$(".arrival-port").change(function(){
		updatePanel();
	});
	$(".airport-fast-track").change(function(){
		updatePanel();
	});
	$(".car-pickup").change(function(){
		updatePanel();
	});
	$(".car-type").change(function(){
		updatePanel();
	});
	$(".num-seat").change(function(){
		updatePanel();
	});
	
	$(".name-prefix").change(function(){
		updatePanel();
	});
	
	$(".welcome-name").change(function(){
		updatePanel();
	});
	
	$(".arrival-date").change(function(){
		updatePanel();
	});
	
	$(".flight-number").change(function(){
		updatePanel();
	});
	
	$(".btnstep").click(function(){
		var err = 0;
		var msg = new Array();
		if ($("#airport-fast-track-no").is(":checked") && $("#car-pickup-no").is(":checked")) {
			msg.push("Please select <b>Airport fast track</b> or <b>Car pick-up</b> service.");
			err++;
		}
		if ($(".welcome-name").val() == "") {
			$(".welcome-name").addClass("error");
			msg.push("Welcome name is required.");
			err++;
		} else {
			$(".welcome-name").removeClass("error");
		}
		if ($(".arrival-date").val() == "") {
			$(".arrival-date").addClass("error");
			msg.push("Arrival date is required.");
			err++;
		} else {
			$(".arrival-date").removeClass("error");
		}
		if ($(".flight-number").val() == "") {
			$(".flight-number").addClass("error");
			msg.push("Flight number is required.");
			err++;
		} else {
			$(".flight-number").removeClass("error");
		}
		if ($(".fullname").val() == "") {
			$(".fullname").addClass("error");
			msg.push("Your name is required.");
			err++;
		} else {
			$(".fullname").removeClass("error");
		}
		if ($(".email").val() == "") {
			$(".email").addClass("error");
			msg.push("Your email is required.");
			err++;
		} else {
			$(".email").removeClass("error");
		}
		if ($("#security_code").val() == "" || $("#security_code").val().toUpperCase() != $(".security-code").html().toUpperCase()) {
			$("#security_code").addClass("error");
			err++;
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
	
	updatePanel();
});

function updatePanel() {
	onTextChanged();
	onFCChanged();
	onCarPickupChanged();
	calServiceFee();
}

function onTextChanged()
{
	$(".group-size-t").html($(".group-size :selected").text());
	$(".arrival-port-t").html($(".arrival-port :selected").text());
	$(".welcome-name-t").html($(".name-prefix").val() + " " + $(".welcome-name").val());
	$(".arrival-time-t").html($(".arrival-date").val());
	$(".flight-number-t").html($(".flight-number").val());
}

function onFCChanged()
{
}

function onCarPickupChanged()
{
	if ($("#car-pickup-yes").is(":checked")) {
		$(".car-select").show();
		$(".car-pickup-li").show();
	} else {
		$(".car-select").hide();
		$(".car-pickup-li").hide();
	}
}

function calServiceFee()
{
	var fc_fee			= 0;
	var service_type	= 0;
	var group_size		= parseInt($(".group-size").val());
	var arrival_port	= "Ha Noi";
	var car_fee			= 0;
	var car_type		= $(".car-type").val();
	var num_seat		= parseInt($(".num-seat").val());
	
	if ($("#airport-fast-track-normal").is(":checked")) {
		service_type = 1;
	}
	if ($("#airport-fast-track-vip").is(":checked")) {
		service_type = 2;
	}
	if ($(".arrival-port").val() != "") {
		arrival_port = $(".arrival-port").val();
	}
	
	var p = {};
	p['group_size']		= group_size;
	p['service_type']	= service_type;
	p['arrival_port']	= arrival_port;
	p['car_type']		= car_type;
	p['num_seat']		= num_seat;
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/booking/ajax-cal-service-fees.html",
		data: p,
		dataType: 'json',
		success: function(result) {
			if (service_type > 0) {
				fc_fee = parseInt(result[0]);
			}
			
			if (fc_fee > 0) {
				$(".airport-fast-track-t").html(fc_fee + " $ x " + $(".group-size :selected").text() + " = " + (fc_fee*group_size) + " $");
			} else {
				$(".airport-fast-track-t").html("0 $");
			}
			
			if ($("#car-pickup-yes").is(":checked")) {
				car_fee = parseInt(result[1]);
			}
			
			if (car_fee > 0) {
				$(".car-pickup-t").html(car_type + ", " + num_seat + " seats = " + car_fee + " $");
			} else {
				$(".car-pickup-t").html("0 $");
			}
			
			var total = (fc_fee*group_size) + car_fee;
			$(".total_price").html(total + " $");
		}
	});
}
