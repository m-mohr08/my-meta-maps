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
		
	}
});

var registerView = new RegisterView({ el: $("#registerContainer") });