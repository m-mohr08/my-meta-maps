/*
 * View for GeodataShow; showing geodata
 */
GeodataShowView = ContentView.extend({
	
	el: function() {
		return $('#showGeodata');
	},

	getPageContent: function() {
		return this.options.geodata; 
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showGeodataBit';
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
		Debug.log('Try to get metadata');
				
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

	getPageTemplate: function() {
		return '/api/internal/doc/addCommentSecondStep';
	},

	getPageContent: function () {
		return this.options.metadata;
	},

	initialize: function () {
		if (typeof this.options.metadata.url === undefined) {
			MessageBox.addError('Es ist ein Fehler beim Laden der Metadaten aufgetreten. Bitte versuchen Sie erneut.');
		}
		else {
			this.render();
		}
	},
	
	onLoaded: function() {
        $('#ratingComment').barrating({ showSelectedRating:false });
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

/*
 * View for CommentsToGeodata
 */
CommentsShowView = ContentView.extend({
	
	el: function() {
		return $('#showCommentsToGeodata');
	},

	getPageContent: function() {
		return this.options.geodata.comments; 
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showCommentsToGeodataBit';
	}
});

/*
 * View for MetadataToGeodata
 */
MetadataShowView = ContentView.extend({
	
	el: function() {
		return $('#showMetadataToGeodata');
	},

	getPageContent: function() {
		return this.options.geodata.metadata; 
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showMetadataToGeodataBit';
	}
});