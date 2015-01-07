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