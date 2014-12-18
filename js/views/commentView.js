/*
* View for CommentAdd
*/
CommentAddView = Backbone.View.extend({ 

	initialize: function(){
            this.render();
        },
        
    render: function(){
    	var template = _.template( $("#addCommentTemplate").html(), {} );
            this.$el.html( template );
    },
    
    events: {
    	"click #addCommentBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
				
		// Creates details of a comment with typed in values
		var details = createDetails();
		
		if(validateURL(details.URL) === false || details.text === '' 
			|| validateDateFormat(details.startDate) === false || validateDateFormat(details.endDate) === false
			|| validateDatesRelation(details.startDate, details.endDate) === false) {
			// do nothing; the formValidator will do this for you ;)
		}
		
		else {
			
			console.log('Details of added comment are: ' + JSON.stringify(details));
			
			// Creates a new CommentAdd-Model
			var caModel = new CommentAdd();
			
			// Call commentController with caModel and details
			commentController(caModel, details);
		}
	}
});

var CommentAddView = new CommentAddView({ el: $("#addCommentContainer") });