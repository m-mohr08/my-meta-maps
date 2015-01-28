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
	'specUse' => 'The specified data can be used.',
	
	//variables for \js\controllers\commentController.js

	'searchShare' => 'Share searchresults',
	'permLink' => 'Permalink will be generated...',
	'noPerm' => 'Were not able to generate permalink',
	'tryAgain' => 'Please try again',
	'manyClicks' => 'Sorry you clicked too often.',
	'try15' => 'Please try again in 15 seconds ;)',
	'succededAddComm' => 'Your comment was successfully added.',
	'failedLoadGeodata' => 'The comments on this set of geo data could not be loaded.',
	'bboxInvalid' => 'The given dataset is invalid. The reason could be that we currently only support WGS84 as CRS.',
	
	//variables for \js\views\commentView.js
	
	'failedLoadMeta' =>	'An error occurred when downloading the metadata. Please try it again.',

	//variables for \js\views\ApplicationView.js

	'paramNoLoad' => 'Unable to load search parameters',
	'noLoad' => 'Unable to load geodata',

	//variables for \js\router.js

	'providerFail' => 'Login via chosen provider failed',

	//variables for \js\helpers.js

	'basemaps' => 'Basemaps',
	'overlays' => 'Overlays',
	'userGeo' => 'Userdefined geometry',
	'loading' => 'Loading data...',
);
