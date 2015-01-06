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

var FormErrorMessages = {

	errorClass: 'invalid',
	
	apply: function(form, json) {
		this.remove(form);
		var that = this;
		$.each(json, function(field, message) {
			var elm = $(form).find("*[name='" + field + "']").parent(".form-group");
			elm.addClass(that.errorClass);
			elm.find('.error-message').text(message);
		});
	},
	
	remove: function(form) {
		$(form).find("." + this.errorClass).removeClass(this.errorClass);
	}
	
};