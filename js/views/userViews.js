/**
 * View for register an user 
 * Extend ModalView
 */
RegisterView = ModalView.extend({

	/**
	 * Return url for the template of the registration
	 * 
	 * @return {String} url for the template of the registration
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/register';
	},
	
	events: {
    	"click #registerBtn": "register"
    },

	/**
	 * Called if a user want to register
	 * Call the method userRegisterController from the file userController.js 
	 */
	register: function(event) {
		Debug.log('Trying to register');

		// Creates details of a registration with typed in values
		var inputRegister = {
			"name" : $("#inputNameForRegister").val(),
			"email" : $("#inputMailForRegister").val(),
			"password" : $("#inputPasswordRegister").val(),
			"password_confirmation" : $("#inputPasswordRepeat").val()
		};

		userRegisterController(new UserRegister(), inputRegister);
	}
});

/**
 * View for login as an user 
 * Extend ModalView
 */
LoginView = ModalView.extend({

	/**
	 * Return url for the template of the login
	 * 
	 * @return {String} url for the template of the login
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/login';
	},
	
	events: {
    	"click #loginBtn": "login"
    },

	/**
	 * Called if a user want to login
	 * Call the method userLoginController from the file userController.js 
	 */
	login: function(event) {
		Debug.log('Try to login');
		
		// Creates details of a login with typed in values
		var inputLogin = {
			credentials: {
				identifier : $("#inputUsername").val(),
				password : $("#inputPasswordLogin").val(),
				remember : $("#remember").is(":checked")
			}
		};
		
		userLoginController(new UserLogin(), inputLogin);
	}
});

/**
 * View for change general user data as an registered user
 * Extend ModalView
 */
ProfileView = ModalView.extend({
	
	/**
	 * Return url for the template of the profil of a registred user
	 * 
	 * @return {String} url for the template of the profil of a registred user
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/userAccount';
	},
	
	/**
	 * Return true
	 * 
	 * @return {boolean} true  
	 */
	noCache: function(url) {
		// The templates contain the user data, therefore we shouldn't cache them!
		return true;
	},
	
	events: {
		"click #changeGeneralDataBtn": "changeGeneral"
	},
	
	/**
	 * Called if a user want to change the profil
	 * Call the method userChangeGeneralController from the file userController.js 
	 */
	changeGeneral: function(event) {
		Debug.log('Try to change general user data');
		
		// Creates details of a change of general user data with typed in values
		var inputChangeGeneral = {
			name: $("#inputChangeUsername").val(),
			email: $("#inputChangeMail").val(),
			language: $("#inputChangeLanguage").val()
		};
		
		userChangeGeneralController(new UserChangeGeneral(), inputChangeGeneral);
	},

});

/**
 * View for change the password as an registered user
 * Extend ModalView
 */
PasswordView = ModalView.extend({
	
	/**
	 * Return url for the template of the formular to change the password
	 * 
	 * @return {String} url for the template of the formular to change the password
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/password';
	},
	
	events: {
		"click #changePasswordBtn": "changePassword"
	},
	
	/**
	 * Called if a user want to change the password
	 * Call method userChangePasswordControlle from the file userController.js
	 * 
	 * @param {Object} event
	 */
	changePassword: function(event) {
		Debug.log('Try to change password of user');
		
		var oldPw = null;
		// No old password needed when authenticated with oauth
		if ($("#inputChangeOldPassword").size() > 0) {
			oldPw = $("#inputChangeOldPassword").val();
		}
		
		// Creates details of a change of password of a user with typed in values
		var inputChangePassword = {
			old_password: oldPw,
			password: $("#inputChangePassword").val(),
			password_confirmation: $("#inputChangePasswordRepeat").val()
		};
		
		userChangePasswordController(new UserChangePassword(), inputChangePassword);
	}
});