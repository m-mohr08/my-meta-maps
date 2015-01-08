RegisterView = ModalView.extend({

	getPageTemplate: function() {
		return '/js/templates/registerTemplate.html';
	},
	
	events: {
    	"click #registerBtn": "register"
    },

	register: function(event) {
		console.log('Trying to register');

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

LoginView = ModalView.extend({

	getPageTemplate: function() {
		return '/js/templates/loginTemplate.html';
	},
	
	events: {
    	"click #loginBtn": "login"
    },

	login: function(event) {
		console.log('Try to login');
		
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

ProfileView = ModalView.extend({
	
	getPageTemplate: function() {
		return '/js/templates/userAccountTemplate.html';
	},
	
	events: {
		"click #changeGeneralDataBtn": "changeGeneral"
	},
	
	changeGeneral: function(event) {
		console.log('Try to change general user data');
		
		// Creates details of a change of general user data with typed in values
		var inputChangeGeneral = {
			name: $("#inputChangeUsername").val(),
			email: $("#inputChangeMail").val(),
			language: $("#inputChangeLanguage").val()
		};
		
		userChangeGeneralController(new UserChangeGeneral(), inputChangeGeneral);
	},

});

PasswordView = ModalView.extend({
	
	getPageTemplate: function() {
		return '/js/templates/passwordTemplate.html';
	},
	
	events: {
		"click #changePasswordBtn": "changePassword"
	},
	
	changePassword: function(event) {
		console.log('Try to change password of user');
		
		// Creates details of a change of password of a user with typed in values
		var inputChangePassword = {
			old_password: $("#inputChangeOldPassword").val(),
			password: $("#inputChangePassword").val(),
			password_confirmation: $("#inputChangePasswordRepeat").val()
		};
		
		userChangePasswordController(new UserChangePassword(), inputChangePassword);
	}
});