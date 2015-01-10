/*
 * View for CommentsShow; showing comments
 */
CommentShowView = ContentView.extend({
	
	el: function() {
		return $('#showComments');
	},

	getPageContent: function() {
		return this.options.geodata; 
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showCommentBit';
	}
});



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
		Debug.log('Try to add comment');
				
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
		Debug.log('Try to add comment');
				
		// Creates further details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"datatype" : $("#inputDataType").val(),
			"layer" : null,
			"text" : $("#inputText").val(),
			"geometry" : null,
			"startDate": $("#inputStartDate").val(),
			"endDate": $("#inputEndDate").val(),		
			"rating": $("#ratingComment").val(),
			"title" : $("#inputTitle").val()
		};

		// Creates a new CommentAdd-Model
		commentAddSecondStepController(new CommentAddSecondStep, details);
	}
});