/**
 * Toggles the check state of a group of boxes
 *
 * Checkboxes must have an id attribute in the form cb0, cb1...
 * @param The number of box to 'check'
 * @param An alternative field name
 */
function checkAll(n, fldName)
{
	if (!fldName) {
		fldName = 'cb';
	}
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i<n; i++) {
		cb = eval('f.' + fldName + '' + i);
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxchecked.value = n2;
	} else {
		document.adminForm.boxchecked.value = 0;
	}
}

function itemTask(id, task)
{
	var f = document.adminForm;
	cb = eval('f.' + id);
	if (cb) {
		for (i=0; true; i++) {
			cbx = eval('f.cb' + i);
			if (!cbx) {
				break;
			}
			cbx.checked = false;
		}
		cb.checked = true;
		f.boxchecked.value = 1;
		submitButton(task);
	}
	return false;
}

function isChecked(isItChecked)
{
	if (isItChecked == true){
		document.adminForm.boxchecked.value++;
	}
	else {
		document.adminForm.boxchecked.value--;
	}
}

/**
 * Default function.  Usually would be overriden by the component
 */
function submitButton(pressButton)
{
	submitForm(pressButton);
}

/**
 * Submit the admin form
 */
function submitForm(pressButton)
{
	if (pressButton) {
		document.adminForm.task.value=pressButton;
	}
	if (typeof document.adminForm.onsubmit == "function") {
		document.adminForm.onsubmit();
	}
	document.adminForm.submit();
}
