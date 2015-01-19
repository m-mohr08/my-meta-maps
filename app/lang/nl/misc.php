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
	'register' => 'Registreer',
	'addComment' => 'Commentaar toevoegen',
	'profilChange' => 'Profiel wijzigen',
	'pwchange' => 'Wachtwoord wijzigen',
	'guest' => 'Gast',
	'login' => 'Aanmelden',
	'imprint' => 'Over My Meta Maps',
	'help' => 'Hulp',
	'userinfo' => 'User-hulp',
	'clicktop' => 'Nieuw op My Meta Maps? Wij verklaren jou graag hoe je de eerste stappen kan maken. Tik alleen maar op ',
	'furtherInfo' => '.',
	

	//variables for \app\views\pages\help.blade.php
	'headline' => 'De user-hulp geeft je de antwoorden van veelgestelde vragen en de bediening van My Meta Maps.',


	//variables for \app\views\pages\about.blade.php

	'intro' => 'My Meta Maps werd ontwikkeld van studenten van het instituut voor geoinformatie van de WWU Münster',
	'team' => 'Het team bestaat uit:',
	'pubAdress' => 'Adres van de openbaare gegevens-interface',
	'libs' => 'Gebruikte bibliotheken',


	//variables for \app\views\pages\addCommentFirstStep.blade.php

	'createComm' => 'Commentaar cre&eumlren',
	'dataFormat' => 'Gegevens formaat',
	'chooseFormat' => 'Kies een gegevens formaat',
	'create' => 'Cre&eumlren',


	//variables for \app\views\pages\addCommentSecondStep.blade.php
	
	'enterData' => 'Gegevens ingeven',
	'commNoLay' => 'Commentaar niet aan een Layer toewijzen',
	'title' => 'Titel*',
	'freetext' => 'Vrijtekst*',
	'timerange' => 'Tijdsbestek',
	'rating' => 'Evaluatie',
	'addMeta' => 'Aanvullend meta gegevens',


	//variables for \app\views\pages\login.blade.php

	'mailname' => 'E-mailadres / Usernaam',
	'pw' => 'Wachtwoord',
	'stay' => 'Aangemeld blijven?',


	//variables for \app\views\pages\map.blade.php

	'setFilter' => 'Filter instellen',
	'reset' => 'Opnieuw instellen',
	'metaUse' => 'Ook in meta-gegevens zoeken',
	'search' => 'Trefwoord',
	'searchTerm' => 'Trefwoord term',
	'startEnd' => 'Kies een tijdstip begin en een einde',
	'buffer' => 'Leg een omgeving in km vast',
	'rateHigh' => 'Evaluatie groter dan of even groot ...?',
	'geodata' => 'Geogegevens',
	'share' => 'Delen',


	//variables for \app\views\pages\password.blade.php

	'oldpw' => 'Het oude wachtwoord', 
	'newpw' => 'Het nieuwe wachtwoord',
	'pwagain' => 'Het nieuwe wachtwoord herhalen',
	'save' => 'Opslaan',
	'loginAgain' => 'Je bent niet meer aangemeld. Meld je opnieuw aan alsjeblieft, om je wachtwoord te wijzigen.',
	

	//variables for \app\views\pages\register.blade.php

	'user' => 'Usernaam',
	'mail' => 'E-mailadres',
	

	//variables for \app\views\pages\userAccount.blade.php

	'lang' => 'Taal',
	'loginAgainAcc' => 'Je bent niet meer aangemeld. Meld je opnieuw aan alsjeblieft, om je profiel te wijzigen.',
	
	//variables for \app\views\pages\showCommentsToGeodata.blade.php
	
	'noComm' => 'Er zijn geen algemeene opmerkingen.',
	'noCommLayer' => 'Er zijn nog geen reacties op deze laag.',
	'adress' => 'Adres',
	'dataFormatComm' => 'Gegevens formaat',
	'comments' => 'Commentaaren',
	'total' => 'Geheel',
	'map' => 'Kaart',
	'metadata' => 'Meta-gegevens',
	'description' => 'Beschrijving',
	'startingDate' => 'Aanvang datum',
	'endingDate' => 'Eind datum',
	'author' => 'Autuer',
	'license' => 'Licentie',
	'generalData' => 'Algemeene gegevens',
		
	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	
	'anonym' => 'Anoniem',

	//variables for \app\views\pages\show GeodataBit.blade.php

	'noSearch' => 'Es entsprechen leider keine Daten der Suchanfrage.',

	//variables for \app\views\emails\auth\reminder.blade.php

	'pwReset' => 'Password Reset',
	'resetForm' => 'To reset your password, complete this form:',
	'expire' => 'This link will expire in',
	'minutes' => 'Minuten',

	//variables for \app\views\oauth-alert.de.blade.php

	'hint' => 'Hinweis:',
	'extAuth' => 'Sie haben sich über einen externen Anbieter authentifiziert. In diesem Zuge haben wir Ihnnen einen My Meta Maps-Account eingerichtet, dessen Daten Sie hier ändern können. Ihre Daten beim externen Anbieter bleiben unberührt!',
	
);
