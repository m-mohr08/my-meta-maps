/*
* Send a POST-request (because no id is specified) to the server
*/
function commentAddController(model, details) {
	
	model.save(details, {
		
		success: function () {
			successComment();
		},
	
		error: function () {
			failComment();
		}
	});
};

/*
* In case of successfull adding of comment
* Change the color of adding-button to 'success disabled'
* and of the 'comment-info'-button from 'disabled' to 'info'  
*/
function successComment() {
	
	console.log("Adding comment was successfull");
	
	// success-alert an einem bestimmten Platz erstellen; fehlt noch
}

/*
* In case of failed adding of comment
* Change the color of adding-button to 'danger'
*/
function failComment() {
		
	console.log("Adding comment failed");
};