/*
* Send a POST-request to the server to save a registration
*/
function userRegisterController(model, inputRegister) {
	
	model.save(inputRegister, {
		
		// In case of successfull registration
		success: function () {
			
		},
	
		// In case of failed registration
		error: function () {
			
			alert('The registration failed - try it later again');
		}
	});
};