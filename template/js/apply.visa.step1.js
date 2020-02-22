function validateEmail(email) 
{
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}
$(document).ready(function() {
	$(".passport_holder").change(function(){
		genVisaTypeOptions();
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
	$(".exit_port").change(function(){
		updatePanel();
	});
	$(".arrival_month").change(function(){
		checkArrivalDate();
		checkProcessingTime();
		updatePanel();
	});
	$(".arrival_date").change(function(){
		checkArrivalDate();
		checkProcessingTime();
		updatePanel();
	});
	$(".arrival_year").change(function(){
		checkArrivalDate();
		checkProcessingTime();
		updatePanel();
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
	
	$(".btn-apply-code").click(function(){
		var p = {};
		p['visa_type'] = $('#visa_type').val();
		p['processing_time'] = $("input[name='processing_time']:checked").val();
	    p['code'] = $('.promotion-input').val();
		
	    $('.promotion-error').hide();
	    
	    $.ajax({
			type: "POST",
			url: BASE_URL + "/apply-visa/apply-code.html",
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
	
	$(".btn-next").click(function(){
		
		var err = 0;
		var msg = new Array();
		
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
		
		if ($(".arrival_port :selected").val() == "") {
			$(".arrival_port").addClass("error");
			err++;
			msg.push("Arrival airport is required.");
		} else {
			$(".arrival_port").removeClass("error");
		}
		
		if ($("#arrivaldate").val() == "") {
			$("#arrivaldate").addClass("error");
			err++;
			var txt = "Arrival date is required.";
			if (msg.indexOf(txt) == -1) {
				msg.push(txt);
			}
		} else {
			$("#arrivaldate").removeClass("error");
		}
		if ($("#arrivalmonth").val() == "") {
			$("#arrivalmonth").addClass("error");
			err++;
			var txt = "Arrival date is required.";
			if (msg.indexOf(txt) == -1) {
				msg.push(txt);
			}
		} else {
			$("#arrivalmonth").removeClass("error");
		}
		if ($("#arrivalyear").val() == "") {
			$("#arrivalyear").addClass("error");
			err++;
			var txt = "Arrival date is required.";
			if (msg.indexOf(txt) == -1) {
				msg.push(txt);
			}
		} else {
			$("#arrivalyear").removeClass("error");
		}
		
		if (err == 0) {
			// Check date time
			var date		= new Date();
			var currentDate	= new Date(date.getFullYear(), date.getMonth(), date.getDate());
			var arrivalDate	= new Date($("#arrivalyear").val(),$("#arrivalmonth").val()-1,$("#arrivaldate").val());
			if (arrivalDate.getTime() < currentDate.getTime()) {
				$("#arrivaldate").addClass("error");
				$("#arrivalmonth").addClass("error");
				$("#arrivalyear").addClass("error");
				msg.push("Arrival date must be greater than current date!");
				err++;
			}
		}
		if (err == 0) {
			$('#frmApply').submit();
		}
		else {
			showErrorMessage(msg);
			return false;
		}
	});
	
	updatePanel();
	checkProcessingTime();
});

function updatePanel() {
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
	var group_size = parseInt($(".group_size").val());
	var num_seat = 24;
	if (group_size <= 4) {
		num_seat = 4;
	} else if (group_size <= 7) {
		num_seat = 7;
	} else if (group_size <= 16) {
		num_seat = 16;
	}
	if ($(".num_seat").val() < num_seat) {
		$(".num_seat").val(num_seat);
	}
	$(".num_seat option").each(function() {
		if ($(this).val() < num_seat) {
			$(this).attr("disabled", true);
		} else {
			$(this).attr("disabled", false);
		}
	});
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
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(28 days stay, multiple entry/exit)");
	}
	if (type_of_visa == "3mm") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(80-85 days stay, multiple entry/exit)");
	}
	if (type_of_visa == "6mm") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(less than 180 days stay, multiple entry/exit)");
	}
	if (type_of_visa == "1ym") {
		$(".visa_type_t").html($(".visa_type :selected").text()+"<br/>(1 year stay, multiple entry/exit)");
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
			
			for (var i=0; i<result.length; i++) {
				var option = document.createElement("option");
				option.text = result[i];
				option.value = result[i].match(/\b(\w)/g).join('');
				visaTypes.add(option);
			}
			
			$(".visa_type").trigger("change");
		},
		async: false
	});
	
	var nation  = $(".passport_holder :selected").val();
	var free15d = ["United Kingdom", "France", "Germany", "Spain", "Italy"];
	var isFree  = (free15d.indexOf(nation) != -1);
	
	if (isFree && ($("#visa_type").val() == "1ms")) {
		var msg = "<h3>VIETNAM VISA FOR "+nation.toUpperCase()+" NATIONALITY</h3>";
			msg += "<p>Vietnam has been exemption 15 days visa for traveler from "+nation.toUpperCase()+". If you stay in Vietnam more than 15 days or wish to get visa to Vietnam, please ignore this message.</p>";
			msg += "<p><a target='_blank' href='https://www.vietnamevisa.net/news/view/something-change-for-vietnam-visa-on-arrival-from-jul-2015.html'>&rarr; View more about exemption 15 days visa.</a></p>";
		messageBox("INFO", "About Vietnam visa for "+nation+" nationality", msg);
	}
	else {
		var p = {};
		p["nationality"] = nation;
		$.ajax({
			type: "POST",
			url: BASE_URL + "/apply-visa/ajax-detect-special-nationality.html",
			data: p,
			dataType: "json",
			success: function(result) {
				if (result[0]) {
					var msg = "<h3>VIETNAM VISA FOR "+result[1]+" NATIONALITY</h3>";
						msg += "<p>We are informed that your nationality is categorized as the special nation on the list of the Vietnam Immigration Department.</p>";
						msg += "<p>In order to process your visa, please contact us via email address <a href='mailto:visa@vietnamevisa.net'>visa@vietnamevisa.net</a> and supply us your:</p>";
						msg += "<ul>";
						msg += "<li>Passport scan (personal information page)</li>";
						msg += "<li>Business invitation letter or booking tour voucher of travel agency in Vietnam</li>";
						msg += "<li>Flight ticket</li>";
						msg += "<li>Hotel booking or staying address in Vietnam</li>";
						msg += "</ul>";
						msg += "<p>The Vietnam Immigration Department will check your status within 2 days. Then we will inform the result for you. If your visa application is approved, we will send you the notification including the visa letter.</p>";
					messageBox("INFO", "About Vietnam visa for "+result[1]+" nationality", msg);
				}
			}
		});
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

function checkProcessingTime()
{
	var arrivalyear = $("#arrivalyear").val();
	var arrivalmonth = $("#arrivalmonth").val();
	var arrivaldate = $("#arrivaldate").val();
	
	if (arrivalyear != "" && arrivalmonth != "" && arrivaldate != "") {
		var date			= new Date();
		var current_date	= new Date(date.getFullYear(), date.getMonth(), date.getDate());
		var arrival_date	= new Date($("#arrivalyear").val(),$("#arrivalmonth").val()-1,$("#arrivaldate").val());
		if (arrival_date.getTime() < current_date.getTime()) {
			if (!$("#processing_time_normal").is(":disabled")) {
				$("#processing_time_normal").attr("disabled", true);
				$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
			}
			if (!$("#processing_time_urgent").is(":disabled")) {
				$("#processing_time_urgent").attr("disabled", true);
				$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
			}
			if (!$("#processing_time_emergency").is(":disabled")) {
				$("#processing_time_emergency").attr("disabled", true);
				$("#processing_time_emergency").parent().find("strong").css("color", "#ccc");
			}
			if (!$("#processing_time_holiday").is(":disabled")) {
				$("#processing_time_holiday").attr("disabled", true);
				$("#processing_time_holiday").parent().find("strong").css("color", "#ccc");
			}
		}
		else {
			$.ajax({
				type: "POST",
				url: BASE_URL + "/apply-visa/ajax-detect-rush-case.html",
				data: {
					arrival_year: $("#arrivalyear").val(),
					arrival_month: $("#arrivalmonth").val(),
					arrival_date: $("#arrivaldate").val(),
					visa_type: $(".visa_type :selected").val(),
					visit_purpose: $("#visit_purpose").val()
				},
				success: function(result) {
					if (result == -1) {
						if (!$("#processing_time_normal").is(":disabled")) {
							$("#processing_time_normal").attr("disabled", true);
							$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_urgent").is(":disabled")) {
							$("#processing_time_urgent").attr("disabled", true);
							$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_emergency").is(":disabled")) {
							$("#processing_time_emergency").attr("disabled", true);
							$("#processing_time_emergency").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_holiday").is(":disabled")) {
							$("#processing_time_holiday").attr("disabled", true);
							$("#processing_time_holiday").parent().find("strong").css("color", "#ccc");
						}
					} else  if (result == 3) {
						if (!$("#processing_time_normal").is(":disabled")) {
							$("#processing_time_normal").attr("disabled", true);
							$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_urgent").is(":disabled")) {
							$("#processing_time_urgent").attr("disabled", true);
							$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_emergency").is(":disabled")) {
							$("#processing_time_emergency").attr("disabled", true);
							$("#processing_time_emergency").parent().find("strong").css("color", "#ccc");
						}
						if ($("#processing_time_holiday").is(":disabled")) {
							$("#processing_time_holiday").attr("disabled", false);
							$("#processing_time_holiday").parent().find("strong").css("color", "inherit");
						}
						if ($("#processing_time_holiday").parent().parent().is(":hidden")) {
							$("#processing_time_holiday").parent().parent().show();
						}
						if (!$("#processing_time_holiday").is(":checked")) {
							$("#processing_time_holiday").prop("checked", true);
						}
					} else if (result == 2) {
						if (!$("#processing_time_normal").is(":disabled")) {
							$("#processing_time_normal").attr("disabled", true);
							$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_urgent").is(":disabled")) {
							$("#processing_time_urgent").attr("disabled", true);
							$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
						}
						if ($("#processing_time_emergency").is(":disabled")) {
							$("#processing_time_emergency").attr("disabled", false);
							$("#processing_time_emergency").parent().find("strong").css("color", "inherit");
						}
						if (!$("#processing_time_emergency").is(":checked")) {
							$("#processing_time_emergency").prop("checked", true);
						}
						if (!$("#processing_time_holiday").is(":disabled")) {
							$("#processing_time_holiday").attr("disabled", true);
							$("#processing_time_holiday").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_holiday").parent().parent().is(":hidden")) {
							$("#processing_time_holiday").parent().parent().hide();
						}
					} else {
						if ($("#processing_time_normal").is(":disabled")) {
							$("#processing_time_normal").attr("disabled", false);
							$("#processing_time_normal").parent().find("strong").css("color", "inherit");
						}
						if ($("#processing_time_urgent").is(":disabled")) {
							$("#processing_time_urgent").attr("disabled", false);
							$("#processing_time_urgent").parent().find("strong").css("color", "inherit");
						}
						if ($("#processing_time_emergency").is(":disabled")) {
							$("#processing_time_emergency").attr("disabled", false);
							$("#processing_time_emergency").parent().find("strong").css("color", "inherit");
						}
						if (!$("#processing_time_holiday").is(":disabled")) {
							$("#processing_time_holiday").attr("disabled", true);
							$("#processing_time_holiday").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_holiday").parent().parent().is(":hidden")) {
							$("#processing_time_holiday").parent().parent().hide();
						}
						if ($("#processing_time_holiday").is(":checked")) {
							if ($("#processing_time_normal").length) {
								$("#processing_time_normal").prop("checked", true);
							} else {
								$("#processing_time_urgent").prop("checked", true);
							}
						}
					}
					var datee			= new Date('2019-08-19 00:00:00');
					if (String(datee) == String(arrival_date)) { 
						if (!$("#processing_time_normal").is(':disabled')) {
							$("#processing_time_normal").attr("disabled", true);
							$("#processing_time_normal").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_urgent").is(':disabled')) {
							$("#processing_time_urgent").attr("disabled", true);
							$("#processing_time_urgent").parent().find("strong").css("color", "#ccc");
						}
						if (!$("#processing_time_emergency").is(':disabled')) {
							$("#processing_time_emergency").attr("disabled", true);
							$("#processing_time_emergency").parent().find("strong").css("color", "#ccc");
						}
						if ($("#processing_time_holiday").is(':disabled')) {
							$("#processing_time_holiday").attr("disabled", false);
							$("#processing_time_holiday").parent().find("strong").css("color", "inherit");
						}
						if ($("#processing_time_holiday").parent().parent().is(':hidden')) {
							$("#processing_time_holiday").parent().parent().show();
						}
						if (!$("#processing_time_holiday").is(':checked')) {
							$("#processing_time_holiday").prop("checked", true);
						}
					}
				},
				async:false
			});
		}
	}
	else {
		if (!$("#processing_time_holiday").parent().parent().is(":hidden")) {
			$("#processing_time_holiday").parent().parent().hide();
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
			arrivalyear: $("#arrivalyear").val(),
			arrivalmonth: $("#arrivalmonth").val(),
			arrivaldate: $("#arrivaldate").val()
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
			arrivalyear: $("#arrivalyear").val(),
			arrivalmonth: $("#arrivalmonth").val(),
			arrivaldate: $("#arrivaldate").val()
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
	$(".exit_port_t").html($(".exit_port :selected").text());
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
	var typeofvisa			= $(".visa_type").val();
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
	p['group_size']		= group_size;
	p['visa_type']		= typeofvisa;
	p['visit_purpose']	= visit_purpose;
	p['arrival_port']	= arrival_port;
	p['processing_time']= processing_time;
	p['service_type']	= service_type;
	p['car_type']		= car_type;
	p['num_seat']		= num_seat;
	
	$(".total_price").html("...");
	
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-service-fees.html",
		data: p,
		dataType: "json",
		success: function(result) {
			private_fee			= parseFloat(result[0]);
			package_checkin_fee	= parseFloat(result[1]);
			checkin_fee			= parseFloat(result[2]);
			car_fee				= parseFloat(result[3]);
			service_fee			= parseFloat(result[4]);
			rush_fee			= parseFloat(result[5]);
			stamp_fee			= parseFloat(result[6]);
			discount			= parseFloat(result[7]);
			discount_unit		= result[8];
			discount_member		= result[9];
			
			var total = 0;
			
			if ($("#private_visa").is(":checked")) {
				$(".private_visa_t").html(private_fee+" $");
				total += private_fee;
			}
			$('#note-letter-fee').html(private_fee+" $");
			
			var service_list = "";
			var service_cnt  = 1;
			if ($("#fast_checkin").is(":checked")) {
				service_list += "<div><label>"+(service_cnt++)+". Airport fast check-in</label><span class='price'>"+checkin_fee+" $ x "+group_size+" applicant"+((group_size>1)?"s":"")+" = "+(checkin_fee*group_size)+" $</span></div>";
				total += checkin_fee * group_size;
			}
			if ($("#car_pickup").is(":checked")) {
				service_list += "<div><label>"+(service_cnt++)+". Car pick-up</label><span class='price'>("+car_type+", "+num_seat+" seats)"+" = "+car_fee+" $</span></div>";
				total += car_fee;
			}
			$(".extra_services").html(service_list);
			if (service_list != "") {
				$("#extra_service_li").show();
			} else {
				$("#extra_service_li").hide();
			}
			
			var service_list = "";
			var service_cnt  = 1;
			if ($("#full_package").is(":checked")) {
				service_list += "<div><label>"+(service_cnt++)+". Visa stamping fee</label><span class='price'>"+stamp_fee+" $ x "+group_size+" applicant"+((group_size>1)?"s":"")+" = "+(stamp_fee*group_size)+" $</span></div>";
				service_list += "<div><label>"+(service_cnt++)+". Airport fast check-in</label><span class='price'>"+package_checkin_fee+" $ x "+group_size+" applicant"+((group_size>1)?"s":"")+" = "+(package_checkin_fee*group_size)+" $</span></div>";
				total += (stamp_fee + package_checkin_fee) * group_size;
			}
			$(".full_package_services").html(service_list);
			if (service_list != "") {
				$("#full_package_li").show();
			} else {
				$("#full_package_li").hide();
			}
			
			var total_visa_price_txt = service_fee+" $ x "+group_size+" applicant"+((group_size>1)?"s":"")+" = "+(service_fee*group_size)+" $";
			    
			if (processing_time == "Urgent" || processing_time == "Emergency" || processing_time == "Holiday") {
				$(".processing_t").html(rush_fee+" $ x "+group_size+" person"+((group_size>1)?"s":"")+" = "+(rush_fee*group_size)+" $");
				$("#processing_time_li").show();
			} else {
				$(".processing_t").html();
				$("#processing_time_li").hide();
			}
			
			total += (service_fee + rush_fee) * group_size;
			
			if (typeofvisa == "6mm" || typeofvisa == "1ym") {
				$("#promotion_li").hide();
				$("#vipsave_li").hide();
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
					$("#vipsave_li").hide();
					$("#promotion_li").show();
					$(".promotion_t").html("- "+discount_fee.toFixed(2)+" $ "+"("+tlt_code+")");
					total = total - discount_fee.toFixed(2);
				}
				else {
					var vipdiscount = $("#vip_discount").val();
					if (vipdiscount != 0) {
						var vipsave = (service_fee*group_size) * parseFloat(vipdiscount)/100;
						if (vipsave) {
							$("#vipsave_li").show();
							$(".vipsave_t").html("- "+vipsave+" $");
							total = total - vipsave;
						}
					}
				}
			}
			if (typeofvisa == 'e-1ms') {
				total += 25 * group_size;
				$('.stamping_fee_note').hide();
				$('.processing_fee_note').hide();
				$('.total_visa_stamping_price').html('25 $ x '+group_size+' applicants = '+25*group_size+' $');
				$("#processing_time_emergency").attr("disabled", true);
				$("#processing_time_emergency").parent().find("strong").css("color", "#ccc");
			} else {
				$('.total_visa_stamping_price').html('');
				$('.stamping_fee_note').show();
				$('.processing_fee_note').show();
			}
			
			$(".total_visa_price").html(total_visa_price_txt);
			$(".total_price").html(total.toFixed(2)+" $");

		}
	});
}
