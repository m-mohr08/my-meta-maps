function readInput(id) {
  	var input = document.getElementById(id).value;
  	return input;
}

function createDetails() {

	var details = {
		
		"title" : readInput('inputTitle'),
		"URL" : readInput('inputURL'),
		"text" : readInput('inputText'),
		"startPoint": readInput('inputStartPoint'),
		"endPoint": readInput('inputEndPoint'),
		// "rating": readInput('example-i') funktioniert noch nicht
		
	};
}

function changeClass(id, newClass) {
    
    var property = document.getElementById(id);
    
    property.className = newClass;  
}