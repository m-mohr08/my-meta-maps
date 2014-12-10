/*
* View for CommentAdd
*/
var CommentAddView = Backbone.View.extend({ 

	events: {
		// 'keyup #idDesURLFeldes': '???', 
		'click #addCommentBtn': 'createComment'
	},

	initialize: function(){
	
		// needed to execute the functions
		_.bindAll(this, 'succesComment', 'failComment', 'createComment');
	},

	/*
	* In case of successfull adding of comment
	* Change the color of adding-button to 'success disabled'
	* and of the 'comment-info'-button from 'disabled' to 'info'  
	*/
	successComment: function() {
	
		changeClass('addCommentBtn', 'btn btn-succes disabled');
		changeClass('addedCommentBtn', 'btn btn-info');
	},

	/*
	* In case of failed adding of comment
	* Change the color of adding-button to 'danger'
	*/
	failComment: function() {
		
		changeClass('addCommentBtn', 'btn btn-danger');
	},

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event){
		
		// Creates details of a comment with typed in values
		var details = createDetails();
		// Creates a new CommentAdd-Model
		var caModel = new CommentAdd();
		
		// Call commentController with caModel and details
		commentController(caModel, details);
	}
});