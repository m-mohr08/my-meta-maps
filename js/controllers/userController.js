/*
* Send a POST-request to the server to save a registration
*/
function userRegisterController(model, inputRegister) {
	
	model.save(inputRegister, {
		
		// In case of successfull registration
		success: function () {
			console.log('Registration succeded');
			FormErrorMessages.remove('#form-register');
        	$('#ModalRegister').modal('hide');
			MessageBox.addSuccess('Sie haben sich erfolgreich registriert und können sich nun anmelden.');
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
function userLogoutController() {
	var model = new UserLogout();
	model.fetch({
		success: function(){
			console.log('Logout succeded');
			MessageBox.addSuccess('Sie haben sich erfolgreich abgemeldet.');
			AuthUser.setUser();
		},
		error: function(){
			console.log('Logout failed');
			MessageBox.addError('Die Abmeldung ist leider fehlgeschlagen.');
		}
	});
}

/*
* Send a POST-request to the server to login a user
*/
function userLoginController(model, inputLogin) {
	
	model.save(inputLogin, {
		
		// In case of successfull login
		success: function (model, response) {
			console.log('Login succeded');
			FormErrorMessages.remove('#form-login');
        	$('#ModalLogin').modal('hide');
			MessageBox.addSuccess('Sie haben sich erfolgreich angemeldet.');
			AuthUser.setUser(response.user.name);
		},
	
		// In case of failed login
		error: function () {
			console.log('Login failed');
			var msg = 'Die Anmeldedaten sind nicht korrekt.';
			var errorMessages = {
				identifier: msg,
				password: msg
			};
			FormErrorMessages.apply('#form-login', errorMessages);
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