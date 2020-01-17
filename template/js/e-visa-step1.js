function validateEmail(email) 
{
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}
$(document).ready(function() {
	$(".passport_holder").change(function(){
		// genVisaTypeOptions();
	});
	$(".group_size").change(function(){
		updatePanel();
	});
	$(".visa_type").change(function(){
		genVisitOptions();
		updatePanel();
	});
	$(".visit_purpose").change(function(){
		checkProcessingTime();
		updatePanel();
	});
	$(".arrival_port").change(function(){
		updatePanel();
	});
	// $(".arrival_date").change(function(){
	// 	checkProcessingTime();
	// 	checkArrivalDate();
	// 	updatePanel();
	// });
	$(".arrival_month").change(function(){
		checkProcessingTime();
		checkArrivalDate();
		updatePanel();
	});
	$(".arrival_date").change(function(){
		checkProcessingTime();
		checkArrivalDate();
		updatePanel();
	});
	$(".arrival_year").change(function(){
		checkProcessingTime();
		checkArrivalDate();
		updatePanel();
	});
	$(".exit_date").change(function(){
		checkExitDate();
	});
	$(".processing_time").change(function(){
		updatePanel();
	});
	$(".private_visa").change(function(){
		updatePanel();
	});
	$(".full_package").change(function(){
		updatePanel();
	});
	$(".fast_checkin").change(function(){
		updatePanel();
	});
	$(".car_pickup").change(function(){
		updatePanel();
	});
	$(".car_type").change(function(){
		updatePanel();
	});
	$(".num_seat").change(function(){
		updatePanel();
	});
	$(".private_visa").change(function(){
		updatePanel();
	});
	$(".full_package").change(function(){
		updatePanel();
	});
	$(".fast_checkin").change(function(){
		updatePanel();
	});
	$(".car_pickup").change(function(){
		updatePanel();
	});
	
	$(".btn-apply-code").click(function(){
		var processing_time = $("input[name='processing_time']:checked").val();
		var visa_type = $('#visa_type').val();
		var promotion_input = $('.promotion-input').val();
		
		var p = {};
		p['visa_type'] = visa_type;
		p['processing_time'] = processing_time;
	    p['code'] = promotion_input;
		
	    $('.promotion-error').hide();
	    
	    $.ajax({
			type: "POST",
			url: BASE_URL + "/apply-e-visa/apply-code.html",
			data: p,
			dataType: "html",
			success: function(result) {
				if (result != "") {
					$('.promotion-error').hide();
					$('#promotion-box-input').hide();
					$('#promotion-box-succed').show();
					updatePanel();
				} else {
					$('.promotion-error').show();
					$('#promotion-input').select();
					$('#promotion-box-input').show();
					$('#promotion-box-succed').hide();
				}
			}
		});
	});
	function check_arricaldate(day){
		var arrival_date = new Date(day);
		var today = new Date();
		var result = false;
		if (arrival_date.getDay() == 0 || arrival_date.getDay() == 6) {
			var num_date = arrival_date.getDate() - today.getDate();
			if (num_date < 4 && num_date >= 0) {
				result = true;
			}
		}
		return result;
	}
	$(".btn-next").click(function(){
		var err = 0;
		var msg = new Array();
		if (check_arricaldate($('.arrival_date').val())) {
			err++;
			msg.push("Arrival date too short we do not evisa timely.");
		}
		if ($(".group_size :selected").val() == "") {
			$(".group_size").addClass("error");
			err++;
			msg.push("Number of visa is required.");
		} else {
			$(".group_size").removeClass("error");
		}
		
		if ($(".visa_type :selected").val() == "") {
			$(".visa_type").addClass("error");
			err++;
			msg.push("Type of visa is required.");
		} else {
			$(".visa_type").removeClass("error");
		}
		
		if ($(".visit_purpose :selected").val() == "") {
			$(".visit_purpose").addClass("error");
			err++;
			msg.push("Purpose of visit is required.");
		} else {
			$(".visit_purpose").removeClass("error");
		}
		
		if ($(".arrival_port :selected").val() == "" || $(".arrival_port :selected").val() == "0") {
			$(".arrival_port").addClass("error");
			err++;
			msg.push("Arrival airport is required.");
		} else {
			$(".arrival_port").removeClass("error");
		}
		if ($(".exit_port :selected").val() == "" || $(".exit_port :selected").val() == "0") {
			$(".exit_port").addClass("error");
			err++;
			msg.push("Exit airport is required.");
		} else {
			$(".exit_port").removeClass("error");
		}
		// if (!checkArrivalDate()) {
		// 	$(".arrival_date").addClass("error");
		// 	err++;
		// 	var txt = "Arrival date is greater than the current date.";
		// 	if (msg.indexOf(txt) == -1) {
		// 		msg.push(txt);
		// 	}
		// } else {
		// 	$(".arrival_date").removeClass("error");
		// }
		// if (!checkExitDate()) {
		// 	$(".exit_date").addClass("error");
		// 	err++;
		// 	var txt = "Exit date is greater than the arrival date.";
		// 	if (msg.indexOf(txt) == -1) {
		// 		msg.push(txt);
		// 	}
		// } else {
		// 	$(".exit_date").removeClass("error");
		// }
		if ($('input[name=processing_time]:checked').val() == undefined) {
			err++;
			msg.push("Processing time isn't checked.");
		}
		if (err == 0) {
			// Check date time
			var date		= new Date();
			var currentDate	= new Date(date.getFullYear(), date.getMonth(), date.getDate());
			var arrivalDate	= new Date($(".arrival_year").val(),$(".arrival_month").val()-1,$(".arrival_date").val());
			var exitDate	= new Date($(".exit_year").val(),$(".exit_month").val()-1,$(".exit_date").val());
			if (arrivalDate.getTime() < currentDate.getTime()) {
				$(".arrival_date").addClass("error");
				$(".arrival_month").addClass("error");
				$(".arrival_year").addClass("error");
				msg.push("Arrival date must be greater than current date!");
				err++;
			}
			if (err == 0) {
				if (arrivalDate.getTime() >= exitDate.getTime()) {
					$(".exit_date").addClass("error");
					$(".exit_month").addClass("error");
					$(".exit_year").addClass("error");
					msg.push("Exit date must be greater than Arrival date!");
					err++;
				}
			}
			// if (err == 0) {
			// 	var max_travel_days = checkTravelDays();
			// 	if (max_travel_days) {
			// 		$(".exit_date").addClass("error");
			// 		$(".exit_month").addClass("error");
			// 		$(".exit_year").addClass("error");
			// 		msg.push("The days of stay in Vietnam is longer than "+max_travel_days+" days. Please change your type of visa or correct the exit date.");
			// 		err++;
			// 	}
			// }
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
	//checkExitDate();
	checkProcessingTime();
});

function updatePanel()
{
	onPassportHolderChanged();
	onApplicantChanged();
	onVisaTypeChanged();
	onPurposeChanged();
	onArrivalPortChanged();
	onRushChanged();
	onPrivateLetterChanged();
	onServiceChanged();
	calServiceFees();
}

function onPassportHolderChanged()
{
	$(".passport_holder_t").html($(".passport_holder :selected").text());
}

function onApplicantChanged()
{
	$(".group_size_t").html($(".group_size :selected").text());
}

function onVisaTypeChanged()
{
	var type_of_visa = $(".visa_type :selected").val();
	
	if (type_of_visa == "1ms") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(30 days stay, only 1 time entry/exit)");
	}
	if (type_of_visa == "3ms") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(90 days stay, only 1 time entry/exit)");
	}
	if (type_of_visa == "1mm") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(30 days stay, multiple times of entry/exit)");
	}
	if (type_of_visa == "3mm") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(90 days stay, multiple times of entry/exit)");
	}
	if (type_of_visa == "6mm") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(180 days stay, multiple times of entry/exit)");
	}
	if (type_of_visa == "1ym") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(1 year stay, multiple times of entry/exit)");
	}
}

function genVisaTypeOptions()
{
	var p = {};
	p["passport_holder"] = $(".passport_holder :selected").val();
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-visa-types.html",
		data: p,
		dataType: "json",
		success: function(result) {
			var visaTypes = document.getElementById("visa_type");
			if (visaTypes.length > 0) {
				for (var i=(visaTypes.length-1); i>=0; i--) {
					visaTypes.remove(i);
				}
			}
			
			var _1ym_available = false;
			for (var i=0; i<result.length; i++) {
				var option = document.createElement("option");
				option.text = result[i];
				option.value = result[i].match(/\b(\w)/g).join('');
				if (option.value == "1ym") {
					_1ym_available = true;
				}
				visaTypes.add(option);
			}
			
			$(".visa_type").trigger("change");
		},
		async: false
	});
	
	var nation  = $(".passport_holder :selected").val();
	var free15d = ["United Kingdom", "Great Britain", "France", "Germany", "Spain", "Italy"];
	var isFree  = (free15d.indexOf(nation) != -1);
	
	if (isFree && ($("#visa_type").val() == "1ms")) {
		var msg = "<h3>VIETNAM VISA FOR "+nation.toUpperCase()+" NATIONALITY</h3>";
			msg += "<p>Vietnam has been exemption 15 days visa for traveler from "+nation.toUpperCase()+". If you stay in Vietnam more than 15 days or wish to get visa to Vietnam, please ignore this message.</p>";
			msg += "<p><a target='_blank' href='http://www.visa-vietnam.org.vn/news/vietnam-likely-to-scrap-visas-for-uk-france-australia-and-more.html'>&rarr; View more about exemption 15 days visa.</a></p>";
		messageBox("INFO", "About Vietnam visa for "+nation+" nationality", msg);
	}
}

function genVisitOptions()
{
	var p = {};
	p["passport_holder"] = $(".passport_holder :selected").val();
	p["visa_type"] = $(".visa_type :selected").val();
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-visit-purposes.html",
		data: p,
		dataType: "json",
		success: function(result) {
			var visitPurposes = document.getElementById("visit_purpose");
			if (visitPurposes.length > 0) {
				for (var i=(visitPurposes.length-1); i>=0; i--) {
					visitPurposes.remove(i);
				}
			}
			
			for (var i=0; i<result.length; i++) {
				var option = document.createElement("option");
				if (result[i] == "") {
					option.text = "Please select...";
				} else {
					option.text = result[i];
				}
				option.value = result[i];
				visitPurposes.add(option);
			}
		},
		async: false
	});
}

function checkArrivalDate()
{
	// var arrival_date = new Date($('.arrival_date').val());
	// var current_date	= new Date();
	// if (arrival_date.getTime() < current_date.getTime()) {
	// 	$('.arrival_date').val($('.arrival_date').val());
	// 	return false;
	// } else {
	// 	return true
	// }
	var arrivalyear = $("#arrivalyear").val();
	var arrivalmonth = $("#arrivalmonth").val();
	var arrivaldate = $("#arrivaldate").val();
	var current_arrival_date = $("#arrivaldate").val();
	
	if (arrivalyear != "" && arrivalmonth != "") {
		var days_in_month = daysInMonth((arrivalmonth - 1), arrivalyear);
		
		var arrival_date = document.getElementById("arrivaldate");
		if (arrival_date.length > 0) {
			for (var i=(arrival_date.length-1); i>=1; i--) {
				arrival_date.remove(i);
			}
		}
		for (var i=1; i<=days_in_month; i++) {
			var option = document.createElement("option");
			option.text = i;
			option.value = i;
			arrival_date.add(option);
		}
		
		if (current_arrival_date != "" && parseInt(current_arrival_date) <= days_in_month) {
			$("#arrivaldate").val(current_arrival_date);
		}
		else {
			$("#arrivaldate").val("");
		}
	}
	
	if (arrivalyear != "" && arrivalmonth != "" && arrival_date != "") {
		$(".arrival_date_t").html($("#arrivalmonth :selected").text()+"/"+$("#arrivaldate :selected").text()+"/"+$("#arrivalyear :selected").text());
	} else {
		$(".arrival_date_t").html("Please select...");
	}
}

function checkExitDate()
{
	var arrival_date = new Date($('.arrival_date').val());
	var exit_date = new Date($('.exit_date').val());
	if (arrival_date.getTime() > exit_date.getTime()) {
		$('.exit_date').val($('.arrival_date').val());
		return false;
	} else {
		return true;
	}
}

// function checkTravelDays()
// {
// 	var arrival_date	= new Date($(".arrival_year").val(),$(".arrival_month").val()-1,$(".arrival_date").val());
// 	var exit_date		= new Date($(".exit_year").val(),$(".exit_month").val()-1,$(".exit_date").val());
// 	var type_of_visa	= $(".visa_type :selected").val();
// 	var max_travel_days = 30;
	
// 	if (type_of_visa == "1ms") {
// 		max_travel_days = 30;
// 	}
// 	if (type_of_visa == "3ms") {
// 		max_travel_days = 90;
// 	}
// 	if (type_of_visa == "1mm") {
// 		max_travel_days = 30;
// 	}
// 	if (type_of_visa == "3mm") {
// 		max_travel_days = 90;
// 	}
// 	if (type_of_visa == "6mm") {
// 		max_travel_days = 180;
// 	}
// 	if (type_of_visa == "1ym") {
// 		max_travel_days = 365;
// 	}
	
// 	var day_diff = Math.round((exit_date-arrival_date)/(1000*60*60*24));
	
// 	return ((day_diff > max_travel_days) ? max_travel_days : 0);
// }

function checkProcessingTime()
{
	var arrival_date = $("#arrivalyear").val()+'-'+$("#arrivalmonth").val()+'-'+$("#arrivaldate").val();
	
	if (arrival_date != "") {
		var date			= new Date();
		var current_date	= new Date(date.getFullYear(), date.getMonth(), date.getDate());
		var arrival_date	= new Date(arrival_date);
		if (arrival_date.getTime() <= current_date.getTime()) {
			if (!$("#processing_time_normal").is(':disabled')) {
				$("#processing_time_normal").attr("disabled", true);
				$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
			}
			if (!$("#processing_time_urgent").is(':disabled')) {
				$("#processing_time_urgent").attr("disabled", true);
				$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
			}
		}
		else {
			$.ajax({
				type: "POST",
				url: BASE_URL + "/apply-e-visa/ajax-detect-rush-case.html",
				data: {
					arrival_year: arrival_date.getFullYear(),
					arrival_month: arrival_date.getMonth()+1,
					arrival_date: arrival_date.getDate(),
					visit_purpose: $(".visit_purpose").val()
				},
				success: function(result) {
					if (parseInt(result) >= 3) {
						$("#processing_time_normal").attr('disabled', false);
						$("#processing_time_normal").parent().css('color', '#000');
						$("#processing_time_urgent").attr('disabled', false);
						$("#processing_time_urgent").parent().css('color', '#000');
						$("#processing_time_emergency").attr('disabled', false);
						$("#processing_time_emergency").parent().css('color', 'red');
						if (!$("#processing_time_normal").is(":checked")) {
							$("#processing_time_normal").prop("checked", true);
						}
					} else if (parseInt(result) == 2) {
						$("#processing_time_normal").attr('disabled', true);
						$("#processing-time-normal-note").addClass('display-none');
						$("#processing_time_normal").parent().css('color', '#999');
						$("#processing_time_urgent").attr('disabled', false);
						$('#processing-time-urgent-note').removeClass('display-none');
						$("#processing_time_urgent").parent().css('color', '#000');
						$("#processing_time_emergency").attr('disabled', false);
						$("#processing_time_emergency").parent().css('color', 'red');
						if (!$("#processing_time_urgent").is(":checked")) {
							$("#processing_time_urgent").prop("checked", true);
						}
					} else {
						$("#processing_time_normal").attr('disabled', true);
						$("#processing_time_urgent").attr('disabled', true);
						$("#processing_time_emergency").attr('disabled', true);
						$("#processing_time_normal").prop("checked", false);
						$("#processing_time_urgent").prop("checked", false);
						$("#processing_time_emergency").prop("checked", false);
						$("#processing_time_normal").parent().css('color', '#999');
						$("#processing_time_urgent").parent().css('color', '#999');
						$("#processing_time_emergency").parent().css('color', '#999');
					}
				},
				async:false
			});
		}
	}
}

function detectHolidayCase()
{
	var isHoliday = false;
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-detect-holiday.html",
		data: {
			arrival_year: $(".arrival_year").val(),
			arrival_month: $(".arrival_month").val(),
			arrival_date: $(".arrival_date").val()
		},
		success: function(result) {
			isHoliday = result;
		},
		async:false
	});
	
	return isHoliday;
}

function detectEmergencyCase()
{
	var isEmergency = false;
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-detect-emergency.html",
		data: {
			arrival_year: $(".arrival_year").val(),
			arrival_month: $(".arrival_month").val(),
			arrival_date: $(".arrival_date").val()
		},
		success: function(result) {
			isEmergency = result;
		},
		async:false
	});
	
	return isEmergency;
}

function onPurposeChanged()
{
	$(".visit_purpose_t").html($(".visit_purpose :selected").text());
}

function onArrivalPortChanged()
{
	$(".arrival_port_t").html($(".arrival_port :selected").text());
}

function onRushChanged()
{
	var sf_included = false;
	var is_holiday = false;
	
	$(".processing-option").hide();
	$(".processing_time").each(function(index) {
		if ($(this).is(":checked") && $(this).val() == "Normal") {
			$(".processing_note_t").html("Normal (2 working days)");
		}
		if ($(this).is(":checked") && $(this).val() == "Urgent") {
			$(".processing_note_t").html("Urgent (4 working hours)");
		}
		if ($(this).is(":checked") && $(this).val() == "Emergency") {
			$(".processing_note_t").html("Emergency (maximum 30 minutes)");
		}
		if ($(this).is(":checked") && $(this).val() == "Holiday") {
			$(".processing_note_t").html("Holiday Vietnam visa");
			$("#full_package").prop("checked", false);
			$(".full_package_group").hide();
			is_holiday = true;
		} else {
			$(".full_package_group").show();
		}
		if ($(this).is(":checked")) {
			$("#"+$(this).attr("note-id")).show();
		}
	});
	
	sf_included = (is_holiday || $("#full_package").is(":checked"));
	
	if (sf_included) {
		$(".stamping_fee_included").show();
		$(".stamping_fee_excluded").hide();
	} else {
		$(".stamping_fee_included").hide();
		$(".stamping_fee_excluded").show();
	}
	
	$(".full_package_group_none").hide();
}

function onPrivateLetterChanged()
{
	if ($("#private_visa").is(":checked")) {
		$("#private_visa_li").show();
	} else {
		$("#private_visa_li").hide();
	}
}

function onServiceChanged()
{
	if ($("#full_package").is(":checked")) {
		$("#fast_checkin").prop("checked", false);
		$(".cb_fast_checkin").hide();
	} else {
		$(".cb_fast_checkin").show();
	}
	if ($("#car_pickup").is(":checked")) {
		$(".car-select").show();
	} else {
		$(".car-select").hide();
	}
}

function calServiceFees()
{
	var passport_holder		= $(".passport_holder").val();
	var group_size			= parseInt($(".group_size").val());
	var visa_type			= $(".visa_type").val();
	var visit_purpose		= $(".visit_purpose").val();
	var processing_time 	= $("input[name='processing_time']:checked").val();
	var service_fee  		= 0;
	var rush_fee     		= 0;
	var private_fee			= 0;
	var checkin_fee			= 0;
	var package_checkin_fee	= 0;
	var car_fee				= 0;
	var car_type			= $(".car_type").val();
	var num_seat			= parseInt($(".num_seat").val());
	var service_type		= 0;
	var arrival_port		= "Ha Noi";
	
	if ($("#fast_checkin").is(":checked")) {
		service_type = 1;
	}
	if ($(".arrival_port").val() != "") {
		arrival_port = $(".arrival_port").val();
	}
	
	var p = {};
	p['passport_holder']= passport_holder;
	p['booking_type_id']= 2;
	p['group_size']		= group_size;
	p['visa_type']		= visa_type;
	p['visit_purpose']	= visit_purpose;
	p['arrival_port']	= arrival_port;
	p['processing_time']= processing_time;
	p['service_type']	= service_type;
	p['car_type']		= car_type;
	p['num_seat']		= num_seat;
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-e-visa/ajax-cal-service-fees.html",
		data: p,
		dataType: "json",
		success: function(result) {
			private_fee			= parseFloat(result[0][0]);
			package_checkin_fee	= parseFloat(result[0][1]);
			checkin_fee			= parseFloat(result[0][2]);
			car_fee				= parseFloat(result[0][3]);
			service_fee			= parseFloat(result[0][4]);
			rush_fee			= parseFloat(result[0][5]);
			stamp_fee			= parseFloat(result[0][6]);
			discount			= parseFloat(result[0][7]);
			discount_unit		= result[0][8];
			discount_member		= result[0][9];
			var total = 0;
			
			if ($("#private_visa").is(":checked")) {
				$(".private_visa_t").html(private_fee+" $");
				total += private_fee;
			}
			
			var serviceList = "";
			var serviceCnt  = 1;
			if ($("#fast_checkin").is(":checked")) {
				serviceList += "<div class='clearfix'><label>"+(serviceCnt++)+". Fast check-in</label><span class='price'>"+checkin_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(checkin_fee*group_size)+" $</span></div>";
				total += checkin_fee * group_size;
			}
			if ($("#car_pickup").is(":checked")) {
				serviceList += "<div class='clearfix'><label>"+(serviceCnt++)+". Car pick-up</label><span class='price'>("+car_type+", "+num_seat+" seats)"+" = "+car_fee+" $</span></div>";
				total += car_fee;
			}
			$(".extra_services").html(serviceList);
			if (serviceList != "") {
				$("#extra_service_li").show();
			} else {
				$("#extra_service_li").hide();
			}
			
			var serviceList = "";
			var serviceCnt  = 1;
			if ($("#full_package").is(":checked")) {
				serviceList += "<div class='clearfix'><label>"+(serviceCnt++)+". Government fee</label><span class='price'>"+stamp_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(stamp_fee*group_size)+" $</span></div>";
				serviceList += "<div class='clearfix'><label>"+(serviceCnt++)+". Fast check-in</label><span class='price'>"+package_checkin_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(package_checkin_fee*group_size)+" $</span></div>";
				total += (stamp_fee + package_checkin_fee) * group_size;
			}
			$(".full_package_services").html(serviceList);
			if (serviceList != "") {
				$("#full_package_li").show();
			} else {
				$("#full_package_li").hide();
			}
			
			var total_visa_price_txt = service_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(service_fee*group_size)+" $";
			
			$("#processing_time_li").hide();
			$(".processing_time").each(function(index) {
				if($(this).is(":checked") && $(this).val() == "Urgent") {
					$(".processing_t").html(rush_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(rush_fee*group_size)+" $");
					$("#processing_time_li").show();
					$('.tl_process').html('Urgent fee: ');
				}
				if($(this).is(":checked") && $(this).val() == "Emergency") {
					$(".processing_t").html(rush_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(rush_fee*group_size)+" $");
					$("#processing_time_li").show();
					$('.tl_process').html('Emergency fee: ')
				}
				if($(this).is(":checked") && $(this).val() == "Holiday") {
					$(".processing_t").html(rush_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(rush_fee*group_size)+" $");
					$("#processing_time_li").show();
					$('.tl_process').html('Holiday fee: ')
				}

			});
			
			total += (service_fee + rush_fee + stamp_fee) * group_size;
			
			if (visa_type == "6mm" || visa_type == "1ym") {
				$("#promotion_li").hide();
			} else {
				discount_fee = 0;
				var discount_temp = discount;
				var tlt_code = 'Promotion code';
				if (discount_unit == "USD") {
					discount_fee = parseFloat(discount);
				} else {
					if (discount_member > discount) {
						discount_temp = discount_member;
						tlt_code = 'Member discount';
					}
					discount_fee = (service_fee*group_size) * parseFloat(discount_temp)/100;
				}
				if (discount_fee > 0) {
					$("#promotion_li").show();
					$(".promotion_t").html("- "+discount_fee.toFixed(2)+" $ "+"("+tlt_code+")");
					total = total - discount_fee.toFixed(2);
				}
			}

			$(".stamping_fee").html(stamp_fee + " $ x "+group_size+" person = "+stamp_fee*group_size+" $");
			$(".service_fee").html(service_fee + " $ x "+group_size+" person = "+service_fee*group_size+" $");
			
			if (service_fee > 0) {
				$(".total_visa_price").html(total_visa_price_txt);
				$(".total_price").html(total.toFixed(2)+' $');
			} else {
				$(".total_visa_price").html("...");
				$(".total_price").html("...");
			}
		}
	});
}
