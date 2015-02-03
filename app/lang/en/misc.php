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
	'howtoReg' => 'Wie registriere ich mich?',
	'howtoLogin' => 'Wie melde ich mich an?',
	'howtoComm' => 'Wie füge ich ein Kommentar hinzu?',
	'whichFilter' => 'Welche Filter gibt es?',
	'spatialFilter' => 'Räumlicher Filter',
	'timeFilter' => 'Zeitlicher Filter',
	'rateFilter' => 'Filter nach Bewertung',
	'keywordSearch' => 'Stichwortsuche',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Imprint',
	'license' => 'License',
	'intro' => 'My Meta Maps has been developed by students of the institute for geoinformatics of the WWU Münster.',
	'team' => 'The team consists of',
	'pubAdress' => 'Link of the public data interface',
	'libs' => 'Used libraries',

	//variables for \app\views\pages\addCommentFirstStep.blade.php
	'url' => 'URL',
	'createComm' => 'Create comment',
	'dataFormat' => 'Data format',
	'chooseFormat' => 'Please choose data format',
	'create' => 'Create',

	//variables for \app\views\pages\addCommentSecondStep.blade.php
	'enterData' => 'Enter data',
	'commNoLay' => 'Don´t allocate comment to a Layer',
	'title' => 'Title',
	'freetext' => 'Your comment',
	'spatial' => 'Spatial allocation of the comment',
	'timerange' => 'Timerange',
	'rating' => 'Rating',
	'addMeta' => 'Additional metadata',
	'lang' => 'Language',
	'explane' => 'Explanation',
	'tags' => 'Tags',
	'copyright' => 'Copyright',

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
	'noComm' => 'There are no general comments',
	'noCommLayer' => 'There are no comments to this layer.',
	'adress' => 'Address',
	'dataFormatComm' => 'Data format',
	'comments' => 'Comments',
	'total' => 'total',
	'map' => 'Map',
	'metadata' => 'Metadata',
	'description' => 'Description',
	'startingDate' => 'Starting date:',
	'endingDate' => 'Ending date:',
	'author' => 'Author',
	'generalData' => 'General data',
	'layer' => 'Layer:',
	'permlink' => 'Permanent link',
	'unknown' => 'Unknown',

	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	'anonym' => 'Anonym',
	'rate' => 'Rating:',
	'stars' => 'Stars',
	'notSpec' => 'Not specified',
	'geoData' => 'Geodata available',

	//variables for \app\views\pages\show GeodataBit.blade.php
	'noSearch' => 'No data matches your search.',

	//variables for \app\views\emails\auth\reminder.blade.php
	'pwReset' => 'Password Reset',
	'resetForm' => 'To reset your password, complete this form:',
	'expire' => 'This link will expire in',
	'minutes' => 'minutes',

	//variables for \app\views\oauth-alert.de.blade.php
	'hint' => 'Note:',
	'extAuth' => 'You authentificated via an external provider. For that case we created a My Meta Maps account for you. You can change your account data here. Your data at the external provider stays untouched.',
);
