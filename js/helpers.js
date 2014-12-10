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
		"URL" : readInput('inputURL');,
		// ODER ist $("#inputURL").val() ??? möglich ???
		"text" : readInput('inputText');,
		// "geometry": ..., fehlt noch
		"startPoint": readInput('inputStartPoint');
		"endPoint": readInput('inputEndPoint');
		"rating": readInput('example-i'); // ggf. andere Funktion, falls notwendig
		"title" : readInput('inputTitle');
		
	}
}

/**
 * COOKIES
 */

/*
 * Function to change the class of an element, for ex. a button
 */
function changeClass(id, newClass) {
    
    var property = document.getElementById(id);
    
    property.className = newClass;  
}

/*
 * Function to set cookies;
 * ex.: setCookie("Autor", "Christian Wenz", null, (new Date()).getTime() + 1000*3600*24).toGMTString())
 */
function setCookie(name, value, domain, deadlines, path, secure){

   var ck = name + "=" + unescape(value);
   ck += (domain) ? "; domain=" + domain : "";
   ck += (deadlines) ? "; deadline=" + deadlines : "";
   ck += (path) ? "; path=" + path : "";

   ck += (secure) ? "; secure" : "";
   document.cookie = ck;
}

/*
 * Function to delete cookies; deadline will be set back
 */
function deleteCookie(name, domain, path) {

   var ck = "name=; deadline = Thu, 01-Jan-70 00:00:01 GMT"; // ggf. ändern
   ck += (domain) ? "domain=" + domain : "";
   ck += (path) ? "path=" + path : "";
   document.cookie = ck;
}

/*
 * Function to read cookies
 */
function getCookie(name) {

   var i = 0;  //searchposition in the cookie
   var search = name + "=";
   while (i < document.cookie.length) {
      if (document.cookie.substring(i, i + search.length) == search) {
	  
         var end = document.cookie.indexOf(";", i + search.length);
         end = (end > –1) ? end : document.cookie.length;
         var ck = document.cookie.substring(i + search.length, end);
         
		 return unescape(ck);
      }
	  
      i++;
   }
   
   return "";
}