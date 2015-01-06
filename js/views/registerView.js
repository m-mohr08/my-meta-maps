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
			
		console.log('Try to register');
				
		// Creates details of a comment with typed in values
		var inputRegister = readInputForRegister();
			
		var userRegister = new UserRegister();
			
		userRegisterController(userRegister, inputRegister);
		}
	}
});

var registerView = new RegisterView({ el: $("#registerContainer") });