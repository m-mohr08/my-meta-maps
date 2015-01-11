/*
* Send a POST-request to the server to get geodata
*/
function geodataShowController(model, mapview) {
	
	var details = {
		"q" : $("#SearchTerms").val(),
		"bbox" : mapview.getBoundingBox(),
		"radius" : $("#spatialFilter").val(),
		"start": $("#filterStartTime").val(),
		"end": $("#filterEndTime").val(),		
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
		
		before: function() {
			Progress.start('.modal-progress');
		},
		
        success: function (model, response) {
        	Debug.log('Try to validate URL');
        	FormErrorMessages.remove('#form-comment-firstStep');
        	$('#ModalAddComment').modal('hide');
			ContentView.register(new CommentAddViewStep2({metadata: response.geodata}));
        },
        
        error: function(model, response) {
        	Debug.log('Can not validate URL');
			Progress.stop('.modal-progress');
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
		success: function (model, response) {
			Debug.log("Adding comment was successful: " + JSON.stringify(response.responseJSON));
			FormErrorMessages.remove('#form-comment-secondStep');
			router.navigate('', {trigger: true}); // Redirect to frontpage
			MessageBox.addSuccess('Ihr Kommentar wurde erfolgreich hinzugefügt.');
		},
	
		// In case of failed adding of comment
		error: function (model, response) {
			Debug.log("Adding comment failed");
			FormErrorMessages.apply('#form-comment-secondStep', response.responseJSON);
		}
	});
};

/*
* Send a POST-request to the server to get comments to a geodata
*/
function commentsToGeodataController(model) {
	
	var details = {
		"q" : 'Wald',
		"bbox" : null,
		"radius" : null,
		"startDate": null,
		"endDate": null,		
		"minrating": null,
		"metadata" : null
	};

	model.save(details, {
		
        success: function (data, response) {
        	Debug.log('Showing comments to geodata succeded');
        	$('#ModalCommentsToGeodata').modal('show');
			var commentsToGeodataShowView = new CommentsShowView(response);
			var metadataToGeodataShowView = new MetadataShowView(response);
        },
        
        error: function() {
        	Debug.log('Showing comments to geodata failed');
			MessageBox.addError('Die Kommentare zu diesem Geodatensatz konnten nicht geladen werden.');
		}
   });
};