/*
* Send a POST-request (because no id is specified) to the server
*/
function commentController(model, details) {
	
	model.save(details, {
		
		success: function (model) {
			successComment();
		},
	
		error: function() {
			failComment();
		}
	});
};