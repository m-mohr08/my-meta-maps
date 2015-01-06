/*
* Send a POST-request to the server to save a registration
*/
function userRegisterController(model, inputRegister) {
	
	model.save(inputRegister, {
		
		// In case of successfull registration
		success: function () {
			
		},
	
		// In case of failed registration
		error: function (data, response) {
			
			console.log('Registration failed');
			
			if (typeof response.responseJSON.name !== 'undefined' && typeof response.responseJSON.email !== 'undefined') {
				
			}
			
			else if (typeof response.responseJSON.name !== 'undefined') {
				
				
			}
			
			else if (typeof response.responseJSON.email !== 'undefined') {
				
				
			}
			
			
		}
	});
};