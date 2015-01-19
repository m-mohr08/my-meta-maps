<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Client Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are send to the client as JSON file to 
	| be used as javascript language phrases at client-side.
	|
	*/
	'close' => 'Close',
	'noComm' => 'There are not general comments available.',
	'commentAddQuickError' => 'Adding comment failed',
	
	//variables for \js\controllers\userController.js
	
	'succededRegister' => 'You have successfully registered and can sign up now.',
	'succededLogout' => 'You have successfully logged out.',
	'failedLogout' => 'The logout has failed unfortunately.',
	'succededLogin' => 'You have successfully logged in.',
	'failedLogin' => 'The credentials are incorrect.',
	'succededChangeGeneral' => 'Your profile changes were successfully applied.',
	'succededChangePW' => 'Your new password was successfully applied.',
	
	//variables for \js\controllers\commentController.js
	
	'succededAddComm' => 'Your comments was successfully added.',
	'failedLoadGeodata' => 'The comments on this set of geo data could not be loaded.',
	
	//variables for \js\views\commentView.js
	
	'failedLoadMeta' =>	'An error occurred when downloading the metadata. Please try it again.',

);
