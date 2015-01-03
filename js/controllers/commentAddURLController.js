/*
* Send a POST-request to the server
*/
function commentAddURLController(modelURL, modelAdd, details) {
	
	modelURL.save(details, {
		
        success: function (data) {
        	
        	console.log('Try to validate URL');
        	
        	var json = data.toJSON();
            
        	var isNew = json.geodata.isNew;
        	
        	if(isNew === true) {
        		
        		console.log('This URL is new');
        		
        		if(details.title === '') {
        			
        			console.log('Title must not be empty for a new URL');
        			alert('This is a new geodata - please enter a title');
        		}
        		
        	}
        	
        	else {
        		
        		console.log('This URL is not new');
        		
        		if(details.title != '') {
        			
        			console.log('Title can not specify by a user');
        		
        			details.title = json.geodata.metadata.title;
        			
        			alert('Your URL was added already - the title of your comment will be: ' + json.geodata.metadata.title);
        			
					// Call commentController with caModel and details
					commentAddController(modelAdd, details);
        		} 
        		
        		else {
        			
        			console.log('Title is empty - it will be assinged automatically');
     
        			details.title = json.geodata.metadata.title;
        			
        			alert('You did not enter a title - the title of your comment will be: ' + json.geodata.metadata.title);
        			
					// Call commentController with caModel and details
					commentAddController(modelAdd, details);
        		}
        	}
			
        },
        
        error: function() {
        	
        	console.log('Can not validate URL');
		}
   });
};