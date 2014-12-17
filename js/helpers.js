function readInput(id) {
  	var input = document.getElementById(id).value;
  	return input;
}

function createDetails() {
	
	var details = {
		
		"title" : readInput('inputTitle'),
		"URL" : readInput('inputURL'),
		"text" : readInput('inputText'),
		"startDate": readInput('inputStartDate'),
		"endDate": readInput('inputEndDate'),		
		"rating": readInput('ratingComment')
		
	};
	
	var wantRating = checkCheckBox();
	
	if(wantRating === false) {
		details.rating = 0;
	}
	
	return details;
}

function validateURL(url) {
	
	return (url.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/) != null && url.length != 0);
}

function validateDateFormat(date) {
	
	if(date === '') {
		
		return true;
	}
	
	else {
		
		// from formValidator-plugin
		var mask = regex = 'dd/mm/yyyy';
		var matches = day = month = year = null;
	
		regex = regex.replace('mm', '[01][0-9]');
		regex = regex.replace('m', '[1]?[0-9]');
		regex = regex.replace('dd', '[0123][0-9]');
		regex = regex.replace('d', '[0123]?[0-9]');
		regex = regex.replace('yyyy', '[0-9]{4}');
		regex = regex.replace('yy', '[0-9]{2}');
		var pattern = '^' + regex + '$';
		var re = new RegExp(pattern, '');
	
		return (!!date.match(re));
	}
}

function validateDatesRelation (startDate, endDate) {
	
	var dateStart = startDate.split("/");
	var dateEnd = endDate.split("/");
	
	if(dateStart[2] > dateEnd[2]) {
		return false;
	}
	
	else if(dateStart[1] > dateEnd[1]) {
		return false;
	}
	
	else if(dateStart[0] >= dateEnd[0]) {
		return false;
	}
	
	else {
		return true;
	}
}

function checkCheckBox() {
	
    var input = document.getElementById('checkBoxRating');
    
    var output;

    function checkInput() {
        if (input.checked) {
            output = true;
        } else {
            output = false;
        }
    };
    
    input.onchange = checkInput;
    checkInput();
    
    return output;
};