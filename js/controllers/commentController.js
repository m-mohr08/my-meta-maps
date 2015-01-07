/*
* Send a POST-request to the server to get comments
*/
function commentController(model, view) {
	
	model.save({
		
        success: function (data) {
            
        	var commentJSON = data.toJSON();
			var commentList = commentJSON.geodata;
			
			view.showComments(commentList);
			
        },
        
        error: function() {
        	
			view.addError();
		}
   });
};