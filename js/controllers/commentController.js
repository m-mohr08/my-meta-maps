/*
* Send a POST-request to the server to get comments
*/
function commentController(model, view) {
	
	model.save({
		
        success: function (data) {
            
        	var commentJSON = data.toJSON();
			var commentList = [];
			
			if (typeof commentJSON.geodata !== 'undefined') {
				
				commentList = commentJSON.geodata;
				
			}
			else if (typeof commentJSON.geodata_junk !== 'undefined') {
				
				commentList = commentJSON.geodata_junk;
			}
			
			view.showComments(commentList);
			
        },
        
        error: function() {
        	
			view.addError();
		}
   });
};