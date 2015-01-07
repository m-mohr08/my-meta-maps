RegisterView = ModalView.extend({

	getPageTemplate: function() {
		return '/js/templates/registerTemplate.html';
	},
	
	events: {
    	"click #registerBtn": "register"
    },

	register: function(event) {
		console.log('Try to register');

		// Creates details of a comment with typed in values
		var inputRegister = {
			"name" : $("#inputNameForRegister").val(),
			"email" : $("#inputMailForRegister").val(),
			"password" : $("#inputPasswordRegister").val(),
			"password_confirmation" : $("#inputPasswordRepeat").val()
		};

		var userRegister = new UserRegister();
		userRegisterController(userRegister, inputRegister);
	}
});

LoginView = ModalView.extend({

	getPageTemplate: function() {
		return '/js/templates/loginTemplate.html';
	},
	
	events: {
    	"click #loginBtn": "login"
    },

	register: function(event) {
		console.log('Try to login');
		// Creates details of a comment with typed in values
		var inputLogin = {
			"identifier" : $("#inputUsername").val(),
			"password" : $("#inputPasswordLogin").val(),
			"remember" : $("#remember").val()
		};
		// TODO
	}
});

ProfileView = ModalView.extend({
	getPageTemplate: function() {
		return '/js/templates/userAccountTemplate.html';
	}
});