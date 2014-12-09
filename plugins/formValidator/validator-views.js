$(function(){
				$('#form-row').bValidator();

				$('#form-row-other').bValidator();

				$('#form-direct-a').bValidator({
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
				
				$('#form-direct-b').bValidator({
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