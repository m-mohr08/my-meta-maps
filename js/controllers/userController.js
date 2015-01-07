/*
* Send a POST-request to the server to save a registration
*/
function userRegisterController(model, inputRegister) {
	
	model.save(inputRegister, {
		
		// In case of successfull registration
		success: function () {
			
			FormErrorMessages.remove('#form-register');
			
			// TODO
		},
	
		// In case of failed registration
		error: function (data, response) {
			
			console.log('Registration failed');
			
			FormErrorMessages.apply('#form-register', response.responseJSON);
			
		}
	});
};

/*
* Send a POST-request to the server to login a user
*/
function userLoginController(model, inputLogin) {
	
	model.save(inputLogin, {
		
		// In case of successfull login
		success: function () {
			
			FormErrorMessages.remove('#form-login');
			
			// TODO
		},
	
		// In case of failed login
		error: function (data, response) {
			
			console.log('Login failed');
			
			FormErrorMessages.apply('#form-login', response.responseJSON);
			
		}
	});
};

/*
* Send a POST-request to the server to login a user
*/
function userChangeGeneralController(model, inputChangeGeneral) {
	
	model.save(inputChangeGeneral, {
		
		// In case of successfull login
		success: function () {
			
			FormErrorMessages.remove('#form-changeGeneral');
			
			// TODO
		},
	
		// In case of failed login
		error: function (data, response) {
			
			console.log('Login failed');
			
			FormErrorMessages.apply('#form-changeGeneral', response.responseJSON);
			
		}
	});
};

/*
* Send a POST-request to the server to login a user
*/
function userChangePasswordController(model, inputChangePassword) {
	
	model.save(inputChangePassword, {
		
		// In case of successfull login
		success: function () {
			
			FormErrorMessages.remove('#form-changePassword');
			
			// TODO
		},
	
		// In case of failed login
		error: function (data, response) {
			
			console.log('Login failed');
			
			FormErrorMessages.apply('#form-changePassword', response.responseJSON);
			
		}
	});
};