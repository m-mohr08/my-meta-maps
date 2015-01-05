function createDetailsForComment() {
	
	var details = {
		
		"url" : $("#inputURL").val(),
		"text" : $("#inputText").val(),
		"startDate": $("#inputStartDate").val(),
		"endDate": $("#inputEndDate").val(),		
		"rating": $("#ratingComment").val(),
		"title" : $("#inputTitle").val()
		
	};
	
	return details;
}

function validateURL(url) {
	
	return (url.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/) != null && url.length != 0);
}

function validateDatesRelation (startDate, endDate) {
	
	var dateStart = startDate.split("/");
	var dateEnd = endDate.split("/");
	
	if(startDate === '' & endDate === '') {
		return true;
	}
	
	else if(startDate === '' & endDate != '') {
		return false;
	}
	
	else if(startDate != '' & endDate === '') {
		return false;
	}
	
	else if(dateStart[2] > dateEnd[2]) {
		return false;
	}
	
	else if((dateStart[1] > dateEnd[1]) & (dateStart[2] === dateEnd[2])) {
		return false;
	}
	
	else if((dateStart[0] >= dateEnd[0]) & (dateStart[1] === dateEnd[1])) {
		return false;
	}
	
	else {
		return true;
	}
}

function readInputForRegister() {
	
	var inputRegister = {
		
		"name" : $("#inputNameForRegister").val(),
		"email" : $("#inputMailForRegister").val(),
		"password" : $("#inputPasswordRegister").val(),
		"password_confirmation" : $("#inputPasswordRepeat").val()
		
	};
	
	return inputRegister;
}

function validateEmail(email) {
	
	return (email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) != null && email.length != 0);
}

function checkPasswords(password, passwordRepeat) {
	
	return (password === passwordRepeat);
}
