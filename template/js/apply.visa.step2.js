$(document).ready(function() {
	$(".birthdate").change(function(){
		checkBirthDate($(this).attr("applicant-num"));
	});
	$(".nationality").change(function(){
		updatePanel();
		var val = $(this).val();
		var dr = $('option:selected', this).attr('document_required');
		if (dr == 1) {
			$('.nation-document').html(val.toUpperCase());
			$('#myModal').modal('show');
		}
		
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
	$(".flight_booking").change(function(){
		onDisplayFlightInfo();
	});
	
	$(".btn-next").click(function(){
		clearFormError();
		
		var err = 0;
		var msg = new Array();
		var applicants = $("#group_size").val();
		
		for (var i=1; i<=applicants; i++) {
			if ($("#fullname_"+i).val() == "") {
				$("#fullname_"+i).addClass("error");
				err++;
				var txt = "Full name is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#fullname_"+i).removeClass("error");
			}
			if ($("#gender_"+i).val() == "") {
				$("#gender_"+i).addClass("error");
				err++;
				var txt = "Gender is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#gender_"+i).removeClass("error");
			}
			if ($("#birthdate_"+i).val() == "") {
				$("#birthdate_"+i).addClass("error");
				err++;
				var txt = "Date of birth is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#birthdate_"+i).removeClass("error");
			}
			if ($("#birthmonth_"+i).val() == "") {
				$("#birthmonth_"+i).addClass("error");
				err++;
				var txt = "Date of birth is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#birthmonth_"+i).removeClass("error");
			}
			if ($("#birthyear_"+i).val() == "") {
				$("#birthyear_"+i).addClass("error");
				err++;
				var txt = "Date of birth is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#birthyear_"+i).removeClass("error");
			}
			if ($("#nationality_"+i).val() == "") {
				$("#nationality_"+i).addClass("error");
				err++;
				var txt = "Nationality is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#nationality_"+i).removeClass("error");
			}
			if ($("#passportnumber_"+i).val() == "") {
				$("#passportnumber_"+i).addClass("error");
				err++;
				var txt = "Passport number is required.";
				if (msg.indexOf(txt) == -1) {
					msg.push(txt);
				}
			} else {
				$("#passportnumber_"+i).removeClass("error");
			}
		}
		
		if ($("#flight_booked").is(":checked")) {
			if ($("#flightnumber").val() == "") {
				$("#flightnumber").addClass("error");
				err++;
				msg.push("Flight number is required.");
			} else {
				$("#flightnumber").removeClass("error");
			}
			if ($("#arrivaltime").val() == "") {
				$("#arrivaltime").addClass("error");
				err++;
				msg.push("Arrival time is required.");
			} else {
				$("#arrivaltime").removeClass("error");
			}
		} else {
			$("#flightnumber").removeClass("error");
			$("#arrivaltime").removeClass("error");
		}
		
		if ($("#contact_fullname").val() == "") {
			$("#contact_fullname").addClass("error");
			err++;
			msg.push("Contact fullname is required.");
		} else {
			$("#contact_fullname").removeClass("error");
		}
		if ($("#contact_email").val() == "" || !isEmail($("#contact_email").val())) {
			$("#contact_email").addClass("error");
			err++;
			msg.push("Contact email is required.");
		} else {
			$("#contact_email").removeClass("error");
		}
		if ($("#contact_phone").val() == "") {
			$("#contact_phone").addClass("error");
			err++;
			msg.push("Contact phone number is required.");
		} else {
			$("#contact_phone").removeClass("error");
		}
		if (!$("#information_confirm").is(":checked")) {
			$("#information_confirm").parent().addClass("error");
			err++;
			msg.push("Please check \"I would like to confirm the above information is correct.\"");
		} else {
			$("#information_confirm").parent().removeClass("error");
		}
		if (!$("#terms_conditions_confirm").is(":checked")) {
			$("#terms_conditions_confirm").parent().addClass("error");
			err++;
			msg.push("Please check \"I have read and agreed Terms and Condition.\"");
		} else {
			$("#terms_conditions_confirm").parent().removeClass("error");
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

function checkBirthDate(applicant_num)
{
	var birth_year = $(".birthyear_"+applicant_num).val();
	var birth_month = $(".birthmonth_"+applicant_num).val();
	var current_birth_date = $(".birthdate_"+applicant_num).val();
	
	if (birth_year != "" && birth_month != "") {
		var days_in_month = daysInMonth((birth_month - 1), birth_year);
		
		var birth_date = document.getElementById("birthdate_"+applicant_num);
		if (birth_date.length > 0) {
			for (var i=(birth_date.length-1); i>=1; i--) {
				birth_date.remove(i);
			}
		}
		for (var i=1; i<=days_in_month; i++) {
			var option = document.createElement("option");
			option.text = i;
			option.value = i;
			birth_date.add(option);
		}
		
		if (current_birth_date != "" && parseInt(current_birth_date) <= days_in_month) {
			$(".birthdate_"+applicant_num).val(current_birth_date);
		}
		else {
			$(".birthdate_"+applicant_num).val("");
		}
	}
}

function onDisplayFlightInfo()
{
	if ($("#flight_booked").is(":checked")) {
		$("#flight_table").show();
	} else {
		$("#flight_table").hide();
	}
}

function updatePanel()
{
	onPrivateLetterChanged();
	onServiceChanged();
	calServiceFees();
}

function onPrivateLetterChanged()
{
	if ($("#private_visa").val() == 1) {
		$("#private_visa_li").show();
		$(".private-visa-note").show();
	} else {
		$("#private_visa_li").hide();
		$(".private-visa-note").hide();
	}
}

function onServiceChanged()
{
	var is_holiday = ($("#processing_time").val() == "Holiday");
	var is_full_package = $("#full_package").is(":checked");
	var sf_included = (is_holiday || is_full_package);
	
	if (is_holiday) {
		 $("#full_package").prop("checked", false);
		 $(".full-package-group").hide();
	} else {
		$(".full-package-group").show();
	}
	
	if (sf_included) {
		$("#fast_checkin").prop("checked", false);
		$(".fast-checkin-group").hide();
	} else {
		$(".fast-checkin-group").show();
	}
	
	if (parseInt($("#car_pickup").val()) == 1) {
		$(".car-select").show();
		$(".car-pickup-note").show();
	} else {
		$(".car-select").hide();
		$(".car-pickup-note").hide();
	}
	
	if (parseInt($("#fast_checkin").val()) == 1) {
		$(".fast-checkin-note").show();
	} else {
		$(".fast-checkin-note").hide();
	}
	
	if (parseInt($("#full_package").val()) == 1) {
		$(".full-package-note").show();
	} else {
		$(".full-package-note").hide();
	}
	
	if (sf_included) {
		$(".stamping_fee_included").show();
		$(".stamping_fee_excluded").hide();
	} else {
		$(".stamping_fee_included").hide();
		$(".stamping_fee_excluded").show();
	}
}

function calServiceFees()
{
	var group_size			= $("#group_size").val();
	var visa_type			= $("#visa_type").val();
	var visit_purpose		= $("#visit_purpose").val();
	var processing_time 	= $("#processing_time").val();
	var service_fee  		= 0;
	var rush_fee     		= 0;
	var private_fee			= 0;
	var checkin_fee			= 0;
	var package_checkin_fee	= 0;
	var car_fee				= 0;
	var car_type			= "Economic Car";//$(".car_type").val();
	var num_seat			= parseInt($("#num_seat").val());
	var service_type		= 0;
	var arrival_port		= $("#arrival_port").val();
	
	if (parseInt($("#fast_checkin").val()) == 1) {
		service_type = 1;
	}
	
	var nationalities = new Array();
	for (var i=1; i<=group_size; i++) {
		nationalities.push($("#nationality_"+i).val());
	}
	
	var p = {};
	p['nationalities']	= nationalities;
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
			
			var total = 0;
			
			if (parseInt($("#private_visa").val()) == 1) {
				$(".private_visa_t").html(private_fee+" $");
				total += private_fee;
			}
			
			var serviceList = "";
			var serviceCnt  = 1;
			if (parseInt($("#fast_checkin").val()) == 1) {
				serviceList += "<div class='clearfix'><label>"+(serviceCnt++)+". Fast check-in</label><span class='price'>"+checkin_fee+" $ x "+group_size+" "+((group_size>1)?"people":"person")+" = "+(checkin_fee*group_size)+" $</span></div>";
				total += checkin_fee * group_size;
			}
			if (parseInt($("#car_pickup").val()) == 1) {
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
			if (parseInt($("#full_package").val()) == 1) {
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
			
			//total += (service_fee + rush_fee) * group_size;
			/*
			if (service_fee > 0) {
				$(".total_price").html(total+" $");
			} else {
				$(".total_price").html("...");
			}
			*/
		}
	});
	
	var p = {};
	p['nationalities']	= nationalities;
	p['group_size']		= group_size;
	p['visa_type']		= visa_type;
	p['visit_purpose']	= visit_purpose;
	p['arrival_port']	= arrival_port;
	p['processing_time']= processing_time;
	p['private_visa']	= $("#private_visa").val();
	p['full_package']	= $("#full_package").val();
	p['fast_checkin']	= $("#fast_checkin").val();
	p['car_pickup']		= $("#car_pickup").val();
	p['car_type']		= car_type;
	p['num_seat']		= num_seat;
	
	$(".total_price").html("Loading...");
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-service-fees-step2.html",
		data: p,
		dataType: "json",
		success: function(result) {
			var discount = (result[4] > result[2]) ? result[4] : result[2];
			discount_fee = result[3] * (discount/100);
			$(".total_price").html(result[0].toFixed(2)+" $");
			if (discount_fee != 0)
			$("#promotion_li").show();
			$(".promotion_t").html("- "+discount_fee.toFixed(2)+" $");
		}
	});
	
	$(".service-fee-detail").html("Loading...");
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-service-fees-detail.html",
		data: p,
		dataType: "json",
		success: function(result) {
			$(".total_visa_price_t").html(result[0]);
			$(".service-fee-detail").html(result[1]);
		}
	});
}

function _calServiceFees()
{
	var group_size			= $("#group_size").val();
	var visa_type			= $("#visa_type").val();
	var visit_purpose		= $("#visit_purpose").val();
	var processing_time 	= $("#processing_time").val();
	var private_visa		= $("#private_visa").val();
	var fast_checkin		= $("#fast_checkin").val();
	var car_pickup			= $("#car_pickup").val();
	var car_type			= $("#car_type").val();
	var num_seat			= $("#num_seat").val();
	var arrival_port		= $("#arrival_port").val();
	var full_package		= $("#full_package").val();
	var totalservicefee		= 0;
	var total				= 0;
	
	var nationalities = new Array();
	for (var i=1; i<=group_size; i++) {
		nationalities.push($("#nationality_"+i).val());
	}
	
	var p = {};
	p['nationalities']	= nationalities;
	p['group_size']		= group_size;
	p['visa_type']		= visa_type;
	p['visit_purpose']	= visit_purpose;
	p['arrival_port']	= arrival_port;
	p['processing_time']= processing_time;
	p['private_visa']	= private_visa;
	p['full_package']	= full_package;
	p['fast_checkin']	= fast_checkin;
	p['car_pickup']		= car_pickup;
	p['car_type']		= car_type;
	p['num_seat']		= num_seat;
	
	$(".total_price").html("Loading...");
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-service-fees-step2.html",
		data: p,
		dataType: "html",
		success: function(result) {
			$(".total_price").html(result+ " $");
		}
	});
	
	$(".service-fee-detail").html("Loading...");
	$.ajax({
		type: "POST",
		url: BASE_URL + "/apply-visa/ajax-cal-service-fees-detail.html",
		data: p,
		dataType: "html",
		success: function(result) {
			$(".service-fee-detail").html(result);
		}
	});
}
