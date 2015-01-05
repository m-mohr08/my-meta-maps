RegisterView = Backbone.View.extend({

	initialize: function(){

		this.render();
	},

	render: function() {

		var that = this;
		
		$.get('/js/templates/registerTemplate.html', function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
	},
	
	events: {
    	"click #registerBtn": "register"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	register: function(event) {
				
		// Creates details of a comment with typed in values
		var inputRegister = readInputForRegister();
		
		if(inputRegister.name.length < 5 || validateEmail(inputRegister.email) === false || 
			inputRegister.password.length < 5 || checkPasswords(inputRegister.password, inputRegister.password_confirmation === false)) {
				
				// do nothing; the formValidator will do this for you ;)
		}
		
		else {
			
			var userRegister = new UserRegister();
			
			userRegisterController(userRegister, inputRegister);
		}
	}
});

var registerView = new RegisterView({ el: $("#registerContainer") });