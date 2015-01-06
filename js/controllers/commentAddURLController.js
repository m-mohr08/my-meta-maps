/*
* Send a POST-request to the server
*/
function commentAddURLController(modelURL, details, view) {
	
	modelURL.save(details, {
		
        success: function (data) {
        	
        	console.log('Try to validate URL');
        	
        	FormErrorMessages.remove('#form-comment');
        	
        	jsonMetadata = data.toJSON();
        	
        	$('#ModalAddComment').modal('hide');
        	
        	// Call openSecondStep in commentAddView - not implemented
        	view.openSecondStep(details, view);
			
        },
        
        error: function() {
        	
        	console.log('Can not validate URL');
		}
   });
};