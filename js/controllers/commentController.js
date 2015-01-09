/*
* Send a POST-request to the server to get comments
*/
function commentsShowController(model) {
	
	var details = {
			"q" : $("#SearchTerms").val(),
			"bbox" : getBoundingBox,
			"radius" : $("#spatialFilter").val(),
			"startDate": $("#filterStartTime").val(),
			"endDate": $("#filterEndTime").val(),		
			"minrating": $("#ratingFilter").val(),
			"metadata" : $('#includeMetadata').is(':checked')
		};
		
		console.log('Rating: ' + details.minrating);
	
	model.save(details, {
		
        success: function (data, response) {
			var commentShowView = new CommentShowView(response);
        },
        
        error: function() {
			MessageBox.addError('Die Kommentare konnten nicht angezeigt werden.');
		}
   });
};

function getBoundingBox () {
	
	return null;
}

/*
* Send a POST-request to the server
*/
function commentAddFirstStepController(model, details) {
	
	model.save(details, {
		
        success: function (data) {
        	console.log('Try to validate URL');
        	
        	FormErrorMessages.remove('#form-comment-firstStep');
        	
        	$('#ModalAddComment').modal('hide');

        	var view = new CommentAddViewStep2();
			view.setMetadata(data.toJSON());
        },
        
        error: function(data, response) {
        	console.log('Can not validate URL');

        	FormErrorMessages.apply('#form-comment-firstStep', response.responseJSON);
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
			
			FormErrorMessages.remove('#form-comment-secondStep');
		},
	
		// In case of failed adding of comment
		error: function (data, response) {
			
			console.log("Adding comment failed");
			
			FormErrorMessages.apply('#form-comment-secondStep', response.responseJSON);
		}
	});
};