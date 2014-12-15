$(function(){
				
	$('#form-row-comment-a').bValidator();

	$('#form-row-comment-b').bValidator();

	$('#form-direct-comment').bValidator({
		
		onFocusHideError: 	true,
		domType: 			'direct',	
		onValid: 			function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is valid');
		},
		onInvalid:       	function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is invalid');
		},
		beforeSubmit: 		function(form, event) {
		alert('Form is valid');
					},
		onSubmitFail:       function(form, event) {
		alert('Form is NOT valid');
		},
		onFocusIn: function(form, element) {
		console.log('Input focused in');
		},
			onFocusOut: function(form, element) {
		console.log('Input focused out');
		},
		onKeyUp: function(form, element) {
		console.log('Key pressed over input');
		}
	});
				
	$('#form-row-register').bValidator();
				
	$('#form-direct-register').bValidator({
		
		onFocusHideError: 	true,
		domType: 			'direct',	
		onValid: 			function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is valid');
		},
		onInvalid:       	function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is invalid');
		},
		beforeSubmit: 		function(form, event) {
		alert('Form is valid');
					},
		onSubmitFail:       function(form, event) {
		alert('Form is NOT valid');
		},
		onFocusIn: function(form, element) {
		console.log('Input focused in');
		},
			onFocusOut: function(form, element) {
		console.log('Input focused out');
		},
		onKeyUp: function(form, element) {
		console.log('Key pressed over input');
		}
	});
				
	$('#form-direct-login').bValidator({
		
		onFocusHideError: 	true,
		domType: 			'direct',	
		onValid: 			function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is valid');
		},
		onInvalid:       	function(form, element) {
		console.log('Input with name ' + element.attr('name') + ' is invalid');
		},
		beforeSubmit: 		function(form, event) {
		alert('Form is valid');
					},
		onSubmitFail:       function(form, event) {
		alert('Form is NOT valid');
		},
		onFocusIn: function(form, element) {
		console.log('Input focused in');
		},
			onFocusOut: function(form, element) {
		console.log('Input focused out');
		},
		onKeyUp: function(form, element) {
		console.log('Key pressed over input');
		}
	});
});