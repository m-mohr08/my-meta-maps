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

function readInputForRegister() {
	
	var inputRegister = {
		
		"name" : $("#inputNameForRegister").val(),
		"email" : $("#inputMailForRegister").val(),
		"password" : $("#inputPasswordRegister").val(),
		"password_confirmation" : $("#inputPasswordRepeat").val()
		
	};
	
	return inputRegister;
}

function readInputLogin() {
	
	var inputLogin = {
		
		"identifier" : $("#inputUsername").val(),
		"password" : $("#inputPasswordLogin").val(),
		"remember" : $("#remember").val()
		
	};
	
	return inputLogin;
}
