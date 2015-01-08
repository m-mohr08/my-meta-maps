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

/*
* Send a POST-request to the server
*/
function commentAddFirstStepController(modelURL, details) {
	
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

/*
* Send a POST-request (because no id is specified) to the server to save a comment
*/
function commentAddSecondStepController(model, details) {
	
	model.save(details, {
		
		// In case of successfull adding of comment
		success: function () {
			
			console.log('Details of added comment are: ' + JSON.stringify(details));
			
			console.log("Adding comment was successfull");
		},
	
		// In case of failed adding of comment
		error: function () {
			
			console.log("Adding comment failed");
		}
	});
};