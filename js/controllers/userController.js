/*
* Send a POST-request to the server to save a registration
*/
function userRegisterController(model, inputRegister) {

	model.save(inputRegister, {
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
		success: function () {
			Debug.log('Registration succeded');
			FormErrorMessages.remove('#form-register');
        	$('#ModalRegister').modal('hide');
			MessageBox.addSuccess('Sie haben sich erfolgreich registriert und können sich nun anmelden.');
		},
	
		error: function (data, response) {
			Debug.log('Registration failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-register', response.responseJSON);
		}
	});
};

/*
* Send a GET-request to the server to logout a user
*/
function userLogoutController() {
	var model = new UserLogout();
	model.fetch({
		success: function(){
			Debug.log('Logout succeded');
			MessageBox.addSuccess('Sie haben sich erfolgreich abgemeldet.');
			AuthUser.setUser();
		},
		error: function(){
			Debug.log('Logout failed');
			MessageBox.addError('Die Abmeldung ist leider fehlgeschlagen.');
		}
	});
}

/*
* Send a POST-request to the server to login a user
*/
function userLoginController(model, inputLogin) {
	
	model.save(inputLogin, {
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
		success: function (model, response) {
			Debug.log('Login succeded');
			FormErrorMessages.remove('#form-login');
        	$('#ModalLogin').modal('hide');
			MessageBox.addSuccess('Sie haben sich erfolgreich angemeldet.');
			AuthUser.setUser(response.user.name);
			if (config.locale !== response.user.language) {
				registeredUserChangedLanguage();
			}
		},
	
		error: function () {
			Debug.log('Login failed');
			Progress.stop('.modal-progress');
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
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
		success: function (model) {
			Debug.log('Change general user data succeded');
			FormErrorMessages.remove('#form-changeGeneral');
			$('#ModalUserAccountGeneral').modal('hide');
			MessageBox.addSuccess('Ihr Profiländerungen wurden erfolgreich übernommen.');
			// Änderung des Benutzernamens weiterleiten
			AuthUser.setUser(model.get('name'));
			// Bei Änderung der Sprache die Seite neuladen
			if (config.locale !== model.get('language')) {
				registeredUserChangedLanguage();
			}
		},
	
		error: function (model, response) {
			Debug.log('Change general user data failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-changeGeneral', response.responseJSON);
		}
	});
};

/*
* Send a POST-request to the server to login a user
*/
function userChangePasswordController(model, inputChangePassword) {
	
	model.save(inputChangePassword, {
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
		success: function () {
			Debug.log('Change password succeded');
			FormErrorMessages.remove('#form-changePassword');
			$('#ModalUserAccountPassword').modal('hide');
			MessageBox.addSuccess('Ihr neues Passwort wurde erfolgreich übernommen.');
		},
	
		error: function (data, response) {
			Debug.log('Change password failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-changePassword', response.responseJSON);
		}
	});
};

/**
 * Called when the language of a registered user should be changed on the page.
 */
function registeredUserChangedLanguage() {
	window.location.href = '/';
}

/*
 * Send POST-request to the server to check user data
 */
function userCheckDataController(model, id, key) {
	
	var inputCheckData = {};
	inputCheckData[key] = $("#" + id).val();
	
	model.save(inputCheckData, {
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
		success: function () {
			Debug.log('User data has not already been taken.');
			responseJSON = {};
			responseJSON[key] = 'This name/email can been taken.';
			FormErrorMessages.applyPartially('#form-register', responseJSON, true);
		},
	
		error: function (data, response) {
			Debug.log('User data has already been taken.');
			FormErrorMessages.applyPartially('#form-register', response.responseJSON, false);
		}
	});
};
