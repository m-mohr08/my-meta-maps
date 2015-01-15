/**
 * View for register an user 
 * Extend ModalView
 */
RegisterView = ModalView.extend({

	getPageTemplate: function() {
		return '/api/internal/doc/register';
	},
	
	events: {
    	"click #registerBtn": "register"
    },

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

	getPageTemplate: function() {
		return '/api/internal/doc/login';
	},
	
	events: {
    	"click #loginBtn": "login"
    },

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
	
	getPageTemplate: function() {
		return '/api/internal/doc/userAccount';
	},
	
	events: {
		"click #changeGeneralDataBtn": "changeGeneral"
	},
	
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
	
	getPageTemplate: function() {
		return '/api/internal/doc/password';
	},
	
	events: {
		"click #changePasswordBtn": "changePassword"
	},
	
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