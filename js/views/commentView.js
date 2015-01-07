CommentView = ContentView.extend({

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
		this.collection = new CommentsWSList();
	},

	getPageTemplate: function() {
		return '/js/templates/showCommentTemplate.html';
	},

	getBitTemplate: function() {
		return '/js/templates/showCommentTemplate_bit.html';
	},

	createModel: function(value) {
		
		var model = new CommentsWithSpatial();
		return model;
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


/*
* View for CommentAdd - Step 1
*/
CommentAddViewStep1 = ModalView.extend({ 

	getPageTemplate: function() {
		return '/js/templates/addCommentTemplate.html';
	},
    
    events: {
    	"click #addCommentBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
		console.log('Try to add comment');
				
		// Creates details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"datatype" : $("#inputDataType").val()
		};
			
		// Creates a new CommentAdd-Model
		commentAddURLController(new CommentAddURL(), details);
	}
});

/*
* View for CommentAdd
*/
CommentAddViewStep2 = ContentView.extend({ 

	metadata: null,

	getPageTemplate: function() {
		return '/js/templates/addCommentSecondStepTemplate.html';
	},
	
	setMetadata: function(json) {
		this.metadata = json;
	},
    
    events: {
    	"click #addCommentSecondBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
		console.log('Try to add comment');
				
		// Creates details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"text" : $("#inputText").val(),
			"startDate": $("#inputStartDate").val(),
			"endDate": $("#inputEndDate").val(),		
			"rating": $("#ratingComment").val(),
			"title" : $("#inputTitle").val()
		};

		// Creates a new CommentAdd-Model
		commentAddController(new CommentAdd(), details);
	}
});