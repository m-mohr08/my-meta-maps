/*
* Send a GET-request to the server
*/
function commentController(model, view) {
	
	model.fetch({
		
        success: function (model) {
            
        	var commentJSON = model.toJSON();
			var commentList = [];
			
			if (typeof json.geodata !== 'undefined') {
				
				commentList = json.geodata;
				
			}
			else if (typeof json.geodata_junk !== 'undefined') {
				
				commentList = json.geodata_junk;
			}
			
			view.showComments(commentList);
			
        },
        
        error: function() {
        	
			view.addError();
		}
   });
};