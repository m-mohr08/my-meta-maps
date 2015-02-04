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
	'profilChange' => 'Edit profil',
	'pwchange' => 'Change password',
	'guest' => 'Guest',
	'login' => 'Login',
	'imprint' => 'Imprint',
	'help' => 'Help',
	'userinfo' => 'User Guide',
	'clicktop' => 'If you are new to My Meta Maps and are wondering how to get started click ',
	'furtherInfo' => '.',

	//variables for \app\views\pages\help.blade.php
	'headline' => 'The help contains the FAQ and how to use My Meta Maps',
	'whatIsMMMTitle' => 'Was ist My Meta Maps?',
	'whatIsMMM' => 'My Meta Maps ist ein Web-Verzeichnis, das auf Basis von aggregierten Metadaten und Benutzerrezensionen das leichte Auffinden von Geodaten ermöglicht.',
	'howtoReg' => 'How to register?',
	'howtoLogin' => 'How to login?',
	'howtoComm' => 'How to add a comment?',
	'howtoChangeUserdata' => 'Wie ändere ich meinen Daten?',
	'whichFilter' => 'Which filters are available?',
	'howtoSeeComments' => 'Wie kann ich die Kommentare zu einem Geodatensatz sehen?',
	'howtoShare' => 'Teile My Meta Maps mit anderen',
	'howtoLoginViaOAuth' => 'Melde dich über einen Drittanbieter an',
	'howtoChangeGeneral' => 'Wie ändere ich mein Profil?',
	'howtoChangePassword' => 'Wie ändere ich mein Passwort?',
	'filterInfoTitle' => 'Informationen zu den Filtern',
	'filterInfo' => 'Grundsätzlich beziehen sich die Filter auf die Kommentare zu Geodatensätzen. Falls du aber bei der Stichwortsuche die Metadaten miteinbeziehen möchtest,
	 kannst du dies über die passende Checkbox tun.',
	'spatialFilter' => 'Spatial filter',
	'timeFilter' => 'Filter by time',
	'rateFilter' => 'Filter by rating',
	'keywordSearch' => 'Search for keywords',
	'commentsFurtherInfosTitle' => 'Was sehe ich nun?',
	'buttonReg' => 'In order to register on My Meta Maps you just have to click the button:',
	'buttonLogin' => 'After the registration you can login via the following button on the upper right side:',
	'loginViaOAuth' => 'Alternativ kannst du dich sowohl über Facebook, GitHub, Google oder Twitter anmelden. Dir wird anschließend automatisch eine Account bei My Meta Maps erstellt.',
	'changeGeneral' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um die Daten ihres Profils zu ändern.
	 Du kannst sowohl deinen Benutzernamen als auch deine Email-Adresse ändern und zudem deine bevorzugte Sprache auswählen.',
	'changePassword' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um dein Passwort zu ändern.',
	'buttonComment' => 'Also in the upper right side you can find the button for adding a comment:',
	'noRegNec' => 'It is not necessary to be registrated or logged in to add a comment.',
	'addCommentSteps' => 'Das Hinzufügen eines Kommentares erfolgt in zwei Schritten:',
	'addCommentStepOne' => 'Gebe die URL des Geodatensatzes ein und wähle das passende Datenformat aus. Falls es hier zu Problemen kommt, werden dir diese beschrieben.',
	'addCommentStepTwo' => 'Hier kannst du zum einen den Titel für den Geodatensatz festlegen, falls zu diesem noch keine Kommentare existieren, einen Layer, falls vorhanden, auswählen,
	 einen Fließtext eingeben, eine Geometrie erstellen und sowohl einen Zeitraum als auch eine Bewertung festlegen.',
	'addCommentNote' => 'Beachte: Der Fließtext ist verplfichtend. Beim Hinzufügen einer Geometrie kannst du zwischen Punkt, Linie und Polygon auswählen, allerdings auch nur eine Geometrie hinzufügen.',
	'addCommentTipp' => 'Tipp: In der Ansicht zu den Kommentaren eines Geodatensatzes kannst du direkt zu diesem Geodatensatz eine Kommentar erstellen und umgehst somit den ersten Schritt.',
	'acceptedFormats' => 'My Meta Maps accepts the following data-formats:',
	'surrounding' => 'The spatial filter allows you to select datasets within a radius arround the center of the map',
	'searchDist' => 'The search is possible in predefined steps from 5 km to 500 km.',
	'timeFiltDef' => 'The timefilter allows you to select datasets within defined timeranges.',
	'timeStartEnd' => 'To define the timerange you have to set a starting date and an ending date.',
	'rateDef' => 'The rating-filter allows you to select datasets with a defined rating.',
	'rateScale' => 'The ratings can reach from 1 to 5 stars.',
	'keyDef' => 'The keyword-search allows you to search for words that are contained in comments.','seeComments' => 'Unten links kannst du eine Liste mit Geodatensätzen sehen, zu denen es - passend zu den Filtern - Kommentare gibt. Durch einen Klick gelangst du zur Ansicht mit den Kommentaren.
	 Dir wird zudem angezeigt, wie viele Kommentare es zu den jeweiligen Geodatensätzen gibt. Falls die Filter Kommentare herausselektieren,
	 passt sich diese Zahl an und in der Ansicht mit den Kommentaren werden auch nur noch die selektierten angezeigt.',
	'commentsFurtherInfos' => 'Du siehts zunächst eine Liste mit zum einen allgemeine Kommentaren und zum anderen zu den jeweiligen Layern.
	 Durch Klick auf das jeweilige Element lassen sich die jeweiligen Kommentare anzeigen. Hier siehst du zudem von wem der Kommentar stammt, die Bewertung und den Zeitraum des Kommentares.
	 Rechts kannst du außerdem allgemeine und Metadaten und auf einer Karte die Bounding Box zu dem Geodatensatz sehen.',
	'shareMMM' => 'Sowohl in der Liste mit den Geodatensätzen als auch in der Ansicht mit den Kommentaren zu einem Geodatensatz wirst du dieses Symbol sehen ',
	'shareMMMFurtherInfos' => 'Damit kannst du sowohl deine gefilterte Liste an Geodatensätzen, die Liste an Kommentaren zu einem bestimmten Geodatensatz als auch nur einen einzelnden Kommentar teilen.',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Imprint',
	'license' => 'License',
	'contact' => 'Contact',
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
	'startingDate' => 'Beginning',
	'endingDate' => 'Ending',
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
