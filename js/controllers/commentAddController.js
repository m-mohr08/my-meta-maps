/*
* Send a POST-request (because no id is specified) to the server to save a comment
*/
function commentAddController(model, details) {
	
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