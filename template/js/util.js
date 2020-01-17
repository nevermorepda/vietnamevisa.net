
function isExistObjectHTML(ob_id)
{
	if(document.getElementById(ob_id)!=null){
		return true;
	}
	return false;
}

function setValueHTML(ob_id, value)
{
	if(isExistObjectHTML(ob_id)){
		document.getElementById(ob_id).value = value;
	}
}

function clearFormError()
{
	$("form input:text").removeClass("error");
	$("form input:password").removeClass("error");
	$("form select").removeClass("error");
	$("form textarea").removeClass("error");
}

function isEmail(emailStr)
{
	var emailPat = /^(.+)@(.+)$/;
	var matchArray = emailStr.match(emailPat);
	if (matchArray == null) {
		return false;
	}
	return true;
}

function daysInMonth(m, y) // m is 0 indexed: 0-11
{
	switch (m) {
		case 1 :
			return (y % 4 == 0 && y % 100) || y % 400 == 0 ? 29 : 28;
		case 8 : case 3 : case 5 : case 10 :
			return 30;
		default :
			return 31;
	}
}

function confirmBox(title, message, callback, params)
{
	if (!$("#confirm-dialog").length) {
		$("body").append('<div id="confirm-dialog" class="modal-warning modal fade" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Modal title</h4></div><div class="modal-body"><p>&hellip;</p></div><div class="modal-footer"><button type="button" class="btn btn-default btn-confirm-dialog-ok">OK</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></div></div></div></div>');
	}
	
	$("#confirm-dialog").find(".modal-title").html(title);
	$("#confirm-dialog").find(".modal-body").html(message);
	
	$("#confirm-dialog").find(".btn-confirm-dialog-ok").click(function(event) {
		var fn = window[callback];
		if (!(params instanceof Array)) {
			params = [params];
		}
		if (typeof fn === "function") {
			fn.apply(null, params);
		}
		$("#confirm-dialog").modal("hide");
	});
	
	$("#confirm-dialog").modal();
}

function showErrorMessage(arrMsg)
{
	var errorMsg = "<p>Your information containning errors. Please review and correct the field(s) marked in red then submit again.</p>";
	if (arrMsg.length > 0) {
		errorMsg += "<ul class='error'>";
		for (var m=0; m<arrMsg.length; m++) {
			errorMsg += "<li>"+arrMsg[m]+"</li>";
		}
		errorMsg += "</ul>";
	}
	messageBox("ERROR", "Error", errorMsg);
}

function messageBox(type, title, message)
{
	$("#dialog").removeClass("modal-error");
	$("#dialog").removeClass("modal-info");
	$("#dialog").removeClass("modal-warning");
	
	if (type == "INFO") {
		$("#dialog").addClass("modal-info");
	} else if (type == "WARNING") {
		$("#dialog").addClass("modal-warning");
	} else {
		$("#dialog").addClass("modal-error");
	}
	
	$("#dialog").find(".modal-title").html(title);
	$("#dialog").find(".modal-body").html(message);
	$("#dialog").modal('show');
}