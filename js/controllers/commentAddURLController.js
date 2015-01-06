/*
* Send a POST-request to the server
*/
function commentAddURLController(modelURL, details) {
	
	modelURL.save(details, {
		
        success: function (data) {
        	console.log('Try to validate URL');
        	
        	FormErrorMessages.remove('#form-comment');
        	
        	$('#ModalAddComment').modal('hide');

        	var view = new CommentAddViewStep2();
			view.setMetadata(data.toJSON());
        },
        
        error: function() {
        	console.log('Can not validate URL');

        	FormErrorMessages.apply('#form-comment');
		}
   });
};