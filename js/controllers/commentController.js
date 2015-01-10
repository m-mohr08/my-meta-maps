/*
* Send a POST-request to the server to get comments
*/
function geodataShowController(model, mapview) {
	
	var details = {
		"q" : $("#SearchTerms").val(),
		"bbox" : mapview.getBoundingBox(),
		"radius" : $("#spatialFilter").val(),
		"startDate": $("#filterStartTime").val(),
		"endDate": $("#filterEndTime").val(),		
		"minrating": $("#ratingFilter").val(),
		"metadata" : $('#includeMetadata').is(':checked')
	};

	model.save(details, {
		
        success: function (data, response) {
			var geodataShowView = new GeodataShowView(response);
			mapview.addGeodataToMap(response);
        },
        
        error: function() {
			MessageBox.addError('Die Geodaten konnten nicht geladen werden.');
		}
   });
};

/**
 * Executes the search if the MapView is active.
 */
function executeSearch() {
	if (ContentView.active instanceof MapView) {
		ContentView.active.doSearch();
	}
}

/**
 * Executes the search if the MapView is active.
 * @param object form element, e.g. this.form
 */
function resetSearch(form) {
	if (ContentView.active instanceof MapView) {
		ContentView.active.resetSearch(form);
	}
}

/*
* Send a POST-request to the server
*/
function commentAddFirstStepController(model, details) {
	
	model.save(details, {
		
        success: function (data) {
        	Debug.log('Try to validate URL');
        	
        	FormErrorMessages.remove('#form-comment-firstStep');
        	
        	$('#ModalAddComment').modal('hide');

        	var view = new CommentAddViewStep2();
			view.setMetadata(data.toJSON());
        },
        
        error: function(data, response) {
        	Debug.log('Can not validate URL');
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
			Debug.log('Details of added comment are: ' + JSON.stringify(details));
			Debug.log("Adding comment was successfull");
			FormErrorMessages.remove('#form-comment-secondStep');
		},
	
		// In case of failed adding of comment
		error: function (data, response) {
			Debug.log("Adding comment failed");
			FormErrorMessages.apply('#form-comment-secondStep', response.responseJSON);
		}
	});
};