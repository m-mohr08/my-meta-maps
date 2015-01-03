CommentView = Backbone.View.extend({

	initialize: function(){
		
		this.createCollection();

		this.render();

		var that = this;
		$(document).ready(function() {
			that.getComments(null, that);
		});
	},

	render: function() {
		
		//For each model that is created in the collection, append the item to the html file
		_(this.collection.models).each(function(model){
			this.appendItem(model);
		}, this);

		var that = this;
		
		$.get(this.getPageTemplate(), function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
	},

	createCollection: function() {
		console.log('Error: Called abstract method!');
	},

	getPageTemplate: function() {
		console.log('Error: Called abstract method!');
		return null;
	},

	getBitTemplate: function() {
		console.log('Error: Called abstract method!');
		return null;
	},

	createModel: function(value) {
		console.log('Error: Called abstract method!');
		return null;
	},
	
	getComments: function(event, that) {
		
		that = that || this;
		var model = that.createModel();
		that.collection.add(model);
		
		commentController(model, that);
	},

	showComments: function(list) {
		
		//In case of an empty data list print out error message
		if(typeof list !== 'object' || list.length === 0){
			this.addError();
		}
		
		//If data list contains elements, append them to the list
		else {
			$.get(this.getBitTemplate(), function(data){
				var template = _.template(data, {list: list});
				$('#resultList', this.el).html(template);
			}, 'html');
		}
	},

	addError: function() {
		
		console.log('Comments can not be displayed!');
	}
});

CommentWithSpatialView = CommentView.extend({

	createCollection: function() {
		this.collection = new CommentsWSList();
	},

	getPageTemplate: function() {
		return '/js/templates/commentWithSpatialTemplate.html';
	},

	getBitTemplate: function() {
		return '/js/templates/commentWithSpatialTemplate_bit.html';
	},

	createModel: function(value) {
		
		var model = new CommentsWithSpatial();
		return model;
	}
});

CommentNoSpatialView = CommentView.extend({

	createCollection: function() {
		this.collection = new CommentsNSList();
	},

	getPageTemplate: function() {
		return 'js/templates/commentNoSpatialTemplate.html';
	},

	getBitTemplate: function() {
		return '/js/templates/commentNoSpatialTemplate_bit.html';
	},

	createModel: function(value) {
		
		var model = new CommentsNoSpatial();
		return model;
	}
});

var CommentWithSpatialView = new CommentWithSpatialView({ el: $("#commentWithGeo") });
var CommentNoSpatialView = new CommentNoSpatialView({ el: $("#commentWithOutGeo") });