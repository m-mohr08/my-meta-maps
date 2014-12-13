/*
 * Function to read and return a value typed in a input-field
 */
function readInput(id) {

  	var input = document.getElementById(id).value;
  	return input;
}

/*
 * Function to create the details of a comment wanted to add with typed in values
 */
function createDetails() {

	var details = {
		
		"URL" : readInput('inputURL'),
		// ODER ist $("#inputURL").val() ??? möglich ???
		"text" : readInput('inputText'),
		// "geometry": ..., fehlt noch
		"startPoint": readInput('inputStartPoint'),
		"endPoint": readInput('inputEndPoint'),
		"rating": readInput('example-i'), // ggf. andere Funktion, falls notwendig
		"title" : readInput('inputTitle'),
		
	};
}

/*
 * Function to change the class of an element, for ex. a button
 */
function changeClass(id, newClass) {
    
    var property = document.getElementById(id);
    
    property.className = newClass;  
}

