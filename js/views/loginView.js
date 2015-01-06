LoginView = Backbone.View.extend({

	initialize: function(){

		this.render();
	},

	render: function() {

		var that = this;
		
		$.get('/js/templates/loginTemplate.html', function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
	},
	
	events: {
    	"click #loginBtn": "login"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	register: function(event) {
		
		console.log('Try to register');
				
		// Creates details of a comment with typed in values
		var inputLogin = readInputLogin();
		
	}
});

var loginView = new LoginView({ el: $("#loginContainer") });