/*
* Send a GET-request to the server
*/
function commentAddURLController(model, details) {
	
	model.fetch({
		
        success: function (model) {
        	
        	console.log('Try to validate URL');
            
        	var isNew = model.get(geodata.isNew);
        	
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
        			
        			alert('Your URL was added already - the title of your comment will be: ' + model.get(geodata.metadata.title));
        		
        			details.title = model.get(geodata.metadata.title);
        		} 
        		
        		else {
        			
        			console.log('Title will be assinged automatically');
     
        			details.title = model.get(geodata.metadata.title);
        		}
        	}
			
        },
        
        error: function() {
        	
        	console.log('Can not validate URL');
		}
   });
};