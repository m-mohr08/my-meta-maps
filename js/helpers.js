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
	
	return details;
}

function validateURL(url) {
	
	return (url.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/) != null && url.length != 0);
}