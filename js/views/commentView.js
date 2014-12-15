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
		
		console.log( "Titel des erstellten Kommentar:" + $("#inputTitle").val());
		
		// Creates details of a comment with typed in values
		var details = createDetails();
		// Creates a new CommentAdd-Model
		var caModel = new CommentAdd();
		
		// Call commentController with caModel and details
		commentController(caModel, details);
	}
});

var CommentAddView = new CommentAddView({ el: $("#addCommentContainer") });