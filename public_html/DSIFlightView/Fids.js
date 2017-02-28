// "idForm" is an identifier corresponding to a Form element.
// "idTxtDate" is an identifier corresponding to a Textbox element.
// "idFinalDate" is an identifier corresponding to an input element whose 
//	value can be assigned a text value.
//
// If value in the Textbox identified by "idTxtDate" is of valid format MM/DD/YYYY format, then
// * The value of the input element identified by "idFinalDate" is assigned
// 	an equivalent value in the format YYYYMMDD.
// * Returns true.
//
// Otherwise,
// * Display an alert box explaining why the value in "txtDate" is invalid.
// * Returns false.
//
//
// A valid  [M]M/[D]D/YYYY format is defined as follows...
// * M is a numerical digit
// * [M] is an optional numerical digit
// * D is a numerical digit
// * [D] is an optional numerical digit
// * Y is a numerical digit
// * / is the slash character
//
// * [M]M represents a one or two-digit number within the range 1 <= MM <= 12
// * [D]D represents a one or two-digit number within the range 1 <= DD <= 31
// * YYYY represents a four-digit number that is greater than the local year
//
// 
function fidsDateTextboxSubmit(idForm, idTxtDate, idFinalDate) {
	var bResult = false;
	
	var valueArray;
	var month, day, year;
	var today, yearCurr;
	var isValidMonth, isValidDay, isValidYear;
	var oTxtDate;
	var oForm;
	var oFinalDate;
	
	oForm = document.getElementById(idForm);
	oTxtDate = document.getElementById(idTxtDate);
	oFinalDate = document.getElementById(idFinalDate);

	if (!oForm) {
		alert("Cannot find form element: " + idForm);

	} else if (!oTxtDate) {
		alert("Cannot find date textbox: " + idTxtDate);

	} else if (!oFinalDate) {
		alert("Cannot find date final: " + idFinalDate);

	} else {
		
		valueArray = oTxtDate.value.split('/');
	
		if (valueArray.length == 3) {
			
			month = valueArray[0];
			day = valueArray[1];
			year = valueArray[2];
			today = new Date();
			yearCurr = today.getFullYear();
		
			isValidMonth = (!isNaN(month) && 1 <= month && month <= 12);
			isValidDay = (!isNaN(day) && 1 <= day && day <= 31);
			isValidYear = (!isNaN(year) && yearCurr <= year && year <= yearCurr+1);		
		
			if (!isValidMonth) {
				alert("The month should have a value between 1 and 12.");

			} else if (!isValidDay) {
				alert("The day should have a value between 1 and 31.");

			} else if (!isValidYear) {
				alert("The year should have a value between " + yearCurr + " and " + (yearCurr+1) + ".");

			} else {
				// Everything is valid.
				// Convert value to YYYYMMDD
				oFinalDate.value = year;
				if (month.length < 2) {
					oFinalDate.value += "0";
				}
				oFinalDate.value += month;
				if (day.length < 2) {
					oFinalDate.value += "0";
				}
				oFinalDate.value += day;
				bResult = true;	
			} 
			
		} else {
			alert("The date must be in the format MM/DD/YYYY\n\nPlease enter the date again.");
		}
		
	
	}
	
	return bResult;
}


// "idForm" is an identifier corresponding to a Form element.
// "idFinalDate" is an identifier corresponding to an input element whose 
//	value can be assigned a text value.
//
// Assigns the value of the input element identified by "idFinalDate"
//    to the local date in the format YYYYMMDD.
// Then submits the Form object identified by "idForm".
//
function fidsDateSelectionToday(idForm,idFinalDate) {
	var now = new Date();
	var oFinalDate = document.getElementById(idFinalDate);
	var oForm = document.getElementById(idForm);
	
	if (!oFinalDate) {
		alert("Cannot find final date element: " + idFinalDate);
	
	} else if (!oForm) {
		alert("Cannot find form: " + idForm);
		
	} else {
		oFinalDate.value = now.getFullYear();
		
		var month;
		month = now.getMonth() + 1;
		if (month < 10) {
			oFinalDate.value += "0";
		}
		oFinalDate.value += month;
		
		var day;
		day = now.getDate();
		if (day < 10) {
			oFinalDate.value += "0";
		}
		oFinalDate.value += day;
		
		oForm.submit();
	}
}



// "oTxtDate" is a Textbox object
// "ymdValue" is a String
//
// "ymdValue" represents a date-time in the YYYYMMDD format.
//
// If "ymdValue" is of valid format, then
// * Replace the value of the HTML input field represented by "idTxtDate" with
//   the "ymdValue" date-time value in the format MM/DD/YYYY
//
// Otherwise,
// * Replace the value of the HTML input field represented by "idTxtDate"
//   with a date-time value representing the local date-time in the format MM/DD/YYYY
//
function fidsFillDateTextbox(oTxtDate, ymdValue) {
	var year, month, date;
	var useToday = true;
	
	if (oTxtDate) {
		// Check if "ymdValue" has valid format.
		if (ymdValue.length == 8) {
			year = ymdValue.substring(0,4);
			month = ymdValue.substring(4,6);
			day = ymdValue.substring(6,8);
			useToday = isNaN(year) || isNaN(month) || isNaN(day);
		}
		
		if (useToday) {
			var today = new Date();
			year = today.getFullYear();
			month = today.getMonth() + 1; 
			day = today.getDate();
		}
		
		oTxtDate.value = month + "/" + day + "/" + year;
	}
}