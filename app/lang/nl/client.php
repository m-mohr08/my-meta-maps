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
	'generalComm' => 'Algemeene commentaaren',
	
	//variables for \js\controllers\userController.js
	
	'succededRegister' => 'Je hebt je succesvol geregistreerd en je kunt zich nu aanmelden.',
	'succededLogout' => 'Je hebt je met succes afgemeld.',
	'failedLogout' => 'De logout is helaas niet gelukt.',
	'succededLogin' => 'Je hebt je met succes aangemeld.',
	'failedLogin' => 'De gegevens van de inschrijving zijn niet correct.',
	'succededChangeGeneral' => 'De wijziging van het profiel werd met succes overgenomen.',
	'succededChangePW' => 'Je nieuwe wachtwoord werd succesvol toegepast.',
	
	//variables for \js\controllers\commentController.js
	
	'searchShare' => 'Zoekresultaat delen',
	'permLink' => 'Permalink wordt gegenereerd...',
	'noPerm' => 'Permalink werd helaas niet gegenereerd.',
	'tryAgain' => 'Verzoek het opnieuw alsjeblieft',
	'manyClicks' => 'Je hebt te vaak geklikt.',
	'try15' => 'Verzoek het na 15 seconden opnieuw alsjeblieft ;)',
	'succededAddComm' => 'Je commentaar werd met succes toegevoegd.',
	'failedLoadGeodata' => 'De reacties op deze set van geo-gegevens kunnen niet worden geladen.',
	
	//variables for \js\views\commentView.js
	
	'failedLoadMeta' =>	'Er is een fout opgetreden bij het downloaden van de metagegevens. Probeer het opnieuw alsjeblieft.',

	//variables for \js\views\ApplicationView.js

	'paramNoLoad' => 'Die Parameter der Suche konnten leider nicht geladen werden',
	'noLoad' => 'Die Geodaten konnten nicht geladen werden.',
);
