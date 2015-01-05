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
		
	}
});

var loginView = new LoginView({ el: $("#loginContainer") });