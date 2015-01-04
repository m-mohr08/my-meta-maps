InfoAndHelpSiteView = Backbone.View.extend({

	initialize: function(){

		this.render();
	},

	render: function() {

		var that = this;
		
		$.get(this.getPageTemplate(), function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
	},

	getPageTemplate: function() {
		console.log('Error: Called abstract method!');
		return null;
	}
});

InfoSiteView = InfoAndHelpSiteView.extend({

	getPageTemplate: function() {
		return '/js/templates/infoSiteTemplate.html';
	}
});

HelpSiteView = InfoAndHelpSiteView.extend({

	getPageTemplate: function() {
		return 'js/templates/helpSiteTemplate.html';
	}
});

var infoSiteView = new InfoSiteView({ el: $("#infoSiteContainer") });
var helpSiteView = new HelpSiteView({ el: $("#helpSiteContainer") });