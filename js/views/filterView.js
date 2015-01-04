FilterView = Backbone.View.extend({

	initialize: function(){

		this.render();
	},

	render: function() {

		var that = this;
		
		$.get('/js/templates/filterTemplate.html', function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
	}
});

var filterView = new FilterView({ el: $("#filterContainer") });