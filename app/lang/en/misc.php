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

	//variables for frontpage.blade.php
	'register' => 'Register',
	'addComment' => 'Add comment',
	'guest' => 'Guest',
	'profilChange' => 'Edit profil',
	'pwchange' => 'Change password',
	'login' => 'Login',
	'imprint' => 'Imprint',
	'help' => 'Help',
	'userinfo' => 'User Guide',
	'clicktop' => 'If you are new to My Meta Maps and are wondering how to get started click ',
	'furtherInfo' => '.',


	//variables for \app\views\pages\help.blade.php
	'headline' => 'The help contains the FAQ and how to use My Meta Maps',


	//variables for \app\views\pages\about.blade.php

	'intro' => 'My Meta Maps has been developed by students of the institute for geoinformatics of the WWU Münster.',
	'team' => 'The team consists of',
	'pubAdress' => 'Link of the public data interface',
	'libs' => 'Used libraries',


	//variables for \app\views\pages\addCommentFirstStep.blade.php

	'createComm' => 'Create comment',
	'dataFormat' => 'Data format',
	'chooseFormat' => 'Please choose data format',
	'create' => 'Create',


	//variables for \app\views\pages\addCommentSecondStep.blade.php
	
	'enterData' => 'Enter data',
	'commNoLay' => 'Don´t allocate comment to a Layer',
	'title' => 'Title*',
	'freetext' => 'Text*',
	'timerange' => 'Timerange',
	'rating' => 'Rating',
	'addMeta' => 'Additional metadata',


	//variables for \app\views\pages\login.blade.php

	'mailname' => 'Email address / Username',
	'pw' => 'Password',
	'stay' => 'Stay logged in?',


	//variables for \app\views\pages\map.blade.php

	'setFilter' => 'Set filter',
	'reset' => 'Reset',
	'metaUse' => 'Include metadata for search',
	'search' => 'Search keyword',
	'searchTerm' => 'Search term(s)',
	'startEnd' => 'Choose start and endpoint',
	'buffer' => 'Set a radius in km',
	'rateHigh' => 'Rating higher than or equal to ...?',
	'geodata' => 'Geodatasets',
	'share' => 'Share',

	//variables for \app\views\pages\password.blade.php

	'oldpw' => 'Old password', 
	'newpw' => 'New password',
	'pwagain' => 'Repeat new password',
	'save' => 'Save',
	'loginAgain' => 'You are not logged in. Please log in again to change your password.',
	

	//variables for \app\views\pages\register.blade.php

	'user' => 'Username',
	'mail' => 'Email address',
	

	//variables for \app\views\pages\userAccount.blade.php

	'lang' => 'Language',
	'loginAgainAcc' => 'You are no longer logged in. Please log in again to change your account data.',
	
	//variables for \app\views\pages\showCommentsToGeodata.blade.php
	
	'noCommLayer' => 'There are no comments to this layer.',
	'adress' => 'Address',
	'dataFormatComm' => 'Data format',
	'comments' => 'Comments',
	'total' => 'total',
	'map' => 'Map',
	'metadata' => 'Metadata',
	'description' => 'Description',
	'startingDate' => 'Starting date',
	'endingDate' => 'Ending date',
	'author' => 'Author',
	'license' => 'license',
	'generalData' => 'General data',
		
	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	
	'anonym' => 'Anonym',
);
