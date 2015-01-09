/*
 * View for CommentsShow; showing comments
 */
CommentShowView = ContentView.extend({

	initialize: function(){
		
		this.createCollection();
		this.render();
	},

	render: function() {
		
		//For each model that is created in the collection, append the item to the html file
		_(this.collection.models).each(function(model){
			this.appendItem(model);
		}, this);

		var that = this;
		
		$.get(this.getPageTemplate(), function(data) {
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
		
		this.getComments(that);
		
	},

	createCollection: function() {
		this.collection = new CommentsShowList();
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showComment';
	},

	getBitTemplate: function() {
		return '/api/internal/doc/showCommentBit';
	},
	
	getComments: function(that) {
		console.log('Try to get comments');
			
		that = that || this;
		
		var commentsShow = new CommentsShow();
		
		that.collection.add(commentsShow);
		
		commentsShowController(commentsShow, that);
	},

	showComments: function(list) {
		console.log('Try to show comments');
		
		//In case of an empty data list print out error message
		if(typeof list !== 'object' || list.length === 0) {
			console.log('Comment-list is empty');
			this.addError();
		}
		
		//If data list contains elements, append them to the list
		else {
			console.log('Comment-list is not empty - try to load bitTemplate');
			
			$.get(this.getBitTemplate(), function(data) {
				var template = _.template(data, {list: list});
				$('#resultList', this.el).html(template);
				makeClickable(this.el);
			}, 'html');
		}
	},

	addError: function() {
		console.log('Comments can not be displayed!');
		
		$.get(this.getBitTemplate(), function(){
			$('#resultList', this.el).html("<tr><td>Comments can not be displayed.</td></tr>");
		}, 'html');
	}
});

var commentShowView = new CommentShowView( {el: $("#showComments") });


/*
 * View for CommentAddFirstStep
 */
CommentAddViewStep1 = ModalView.extend({ 

	getPageTemplate: function() {
		return '/api/internal/doc/addCommentFirstStep';
	},
    
    events: {
    	"click #addCommentBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
		console.log('Try to add comment');
				
		// Creates primary details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"datatype" : $("#inputDataType").val()
		};
			
		// Creates a new CommentAdd-Model
		commentAddFirstStepController(new CommentAddFirstStep(), details);
	}
});

/*
 * View for CommentAddSecondStep; will only shown after CommentAddViewStep1
 */
CommentAddViewStep2 = ContentView.extend({ 

	metadata: null,

	getPageTemplate: function() {
		return '/api/internal/doc/addCommentSecondStep';
	},
	
	onLoaded: function() {
        $('#ratingComment').barrating({ showSelectedRating:false });
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
				
		// Creates further details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"text" : $("#inputText").val(),
			"startDate": $("#inputStartDate").val(),
			"endDate": $("#inputEndDate").val(),		
			"rating": $("#ratingComment").val(),
			"title" : $("#inputTitle").val()
		};

		// Creates a new CommentAdd-Model
		commentAddSecondStepController(new CommentAddSecondStep, details);
	}
});