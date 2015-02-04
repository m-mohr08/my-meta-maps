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
	'register' => 'Registrieren',
	'addComment' => 'Kommentar hinzufügen',
	'profilChange' => 'Profil ändern',
	'pwchange' => 'Passwort ändern',
	'guest' => 'Gast',
	'login' => 'Anmelden',
	'imprint' => 'Impressum',
	'help' => 'Hilfe',
	'userinfo' => 'Benutzerhilfe',
	'clicktop' => 'Neu bei My Meta Maps? Wir erklären Ihnen gerne wie sie erfolgreich die ersten Schritte machen können. Klicken Sie einfach auf ',
	'furtherInfo' => '.',
	
	//variables for \app\views\pages\help.blade.php
	'headline' => 'Die Benutzerhilfe beantwortet Ihnen die wichtigsten Fragen zur Bedienung von My Meta Maps',
	'howtoReg' => 'Wie registriere ich mich?',
	'howtoLogin' => 'Wie melde ich mich an?',
	'howtoComm' => 'Wie füge ich ein Kommentar hinzu?',
	'whichFilter' => 'Welche Filter gibt es?',
	'spatialFilter' => 'Räumlicher Filter',
	'timeFilter' => 'Zeitlicher Filter',
	'rateFilter' => 'Filter nach Bewertung',
	'keywordSearch' => 'Stichwortsuche',
	'buttonReg' => 'Die Registrierung auf My Meta Maps erfolgt über einen Klick auf die Schaltfläche',
	'buttonLogin' => 'Um sich nach der Registrierung einzuloggen klicken Sie oben rechts auf die Schaltfläche',
	'buttonComment' => 'Ebenfalls oben rechts befindet sich die Schaltfläche zur Erstellung eines Kommentares',
	'noRegNec' => 'Es ist nicht nötig registriert oder angemeldet zu sein um ein Kommentar hinzuzufügen.',
	'acceptedFormats' => 'Folgende Datenformate werden von My meta Maps akzeptiert:',
	'surrounding' => 'Der Umkreisfilter ermöglicht die selektierte Anzeige von Datensätzen in einem gewählten Umkreis um den Kartenmittelpunkt.',
	'searchDist' => 'Die Suche ist in festgelegten Stufen von 5km bis 500km möglich.',
	'timeFiltDef' => 'Der zeitliche Filter ermöglicht die Filterung von Datensätzen von bestimmten Zeiträumen.',
	'timeStartEnd' => 'Für die Einstellung des Zeitraumes können Sie einen Start- und einen Endzeitpunkt festlegen.',
	'rateDef' => 'Der Bewertungsfilter ermöglicht die selektierte Anzeige von Datensätzen mit bestimmten Bewertungen.',
	'rateScale' => 'Die Bewertungen reichen von 1 bis 5 Sternen.',
	'keyDef' => 'Die Stichwortsuche ermöglicht die Suche nach Wörtern die in einem Kommentar hinterlegt wurden.',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Impressum',
	'license' => 'Lizenz',
	'intro' => 'My Meta Maps wurde von Studenten des Instituts für Geoinformatik der WWU Münster entwickelt.',
	'team' => 'Das Team besteht aus:',
	'pubAdress' => 'Adresse der öffentlichen Datenschnittstelle',
	'libs' => 'Genutzte Bibliotheken',

	//variables for \app\views\pages\addCommentFirstStep.blade.php
	'url' => 'URL',
	'createComm' => 'Kommentar erstellen',
	'dataFormat' => 'Datenformat',
	'chooseFormat' => 'Bitte Datenformat wählen',
	'create' => 'Erstellen',

	//variables for \app\views\pages\addCommentSecondStep.blade.php
	'enterData' => 'Daten eingeben',
	'commNoLay' => 'Kommentar keinem Layer zuordnen',
	'title' => 'Titel',
	'freetext' => 'Ihr Kommentar',
	'spatial' => 'Räumliche Zuordnung des Kommentars',
	'timerange' => 'Zeitraum',
	'rating' => 'Bewertung',
	'addMeta' => 'Zusätzliche Metadaten',
	'lang' => 'Sprache',
	'explane' => 'Beschreibung',
	'tags' => 'Tags',
	'copyright' => 'Copyright',

	//variables for \app\views\pages\login.blade.php
	'mailname' => 'E-Mail-Adresse / Benuzername',
	'pw' => 'Passwort',
	'stay' => 'Angemeldet bleiben?',
	
	//variables for \app\views\pages\map.blade.php
	'setFilter' => 'Filter einstellen',
	'reset' => 'Zurücksetzen',
	'metaUse' => 'Metadaten einbeziehen',
	'search' => 'Suchbegriffe',
	'searchTerm' => 'Suchbegriff(e)',
	'startEnd' => 'Wähle Start- und Endzeitpunkt',
	'buffer' => 'Lege einen Umkreis in km fest',
	'rateHigh' => 'Bewertung größer oder gleich ... ?',
	'geodata' => 'Geodatensätze',
	'share' => 'Teilen',

	//variables for \app\views\pages\password.blade.php
	'oldpw' => 'Altes Passwort', 
	'newpw' => 'Neues Passwort',
	'pwagain' => 'Neues Passwort wiederholen',
	'save' => 'Speichern',
	'loginAgain' => 'Sie sind nicht mehr angemeldet. Bitte melden Sie sich erneut an, um Ihr Passwort zu ändern.',

	//variables for \app\views\pages\register.blade.php
	'user' => 'Benutzername',
	'mail' => 'E-Mail-Adresse',
	
	//variables for \app\views\pages\userAccount.blade.php
	'lang' => 'Sprache',
	'loginAgainAcc' => 'Sie sind nicht mehr angemeldet. Bitte melden Sie sich erneut an, um Ihre Profildaten zu ändern.',
	
	//variables for \app\views\pages\showCommentsToGeodata.blade.php
	'noComm' => 'Es liegen keine allgemeinen Kommentare vor.',
	'noCommLayer' => 'Zu diesem Layer liegen noch keine Kommentare vor.',
	'adress' => 'Adresse',
	'dataFormatComm' => 'Datenformat',
	'comments' => 'Kommentare',
	'total' => 'gesamt',
	'map' => 'Karte',
	'metadata' => 'Metadaten',
	'description' => 'Beschreibung',
	'startingDate' => 'Anfangsdatum:',
	'endingDate' => 'Enddatum:',
	'author' => 'Autor',
	'generalData' => 'Allgemeine Daten',
	'layer' => 'Layer:',
	'permlink' => 'Permalink',
	'unknown' => 'Unbekannt',

	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	'anonym' => 'Anonym',
	'rate' => 'Bewertung:',
	'stars' => 'Sterne',
	'notSpec' => 'Keine Angabe',
	'geoData' => 'Geodaten vorhanden',

	//variables for \app\views\pages\show GeodataBit.blade.php
	'noSearch' => 'Es entsprechen leider keine Daten der Suchanfrage.',

	//variables for \app\views\emails\auth\reminder.blade.php
	'pwReset' => 'Passwort zurücksetzen',
	'resetForm' => 'Um das Passwort zurückzusetzen, fülle folgendes Formular aus',
	'expire' => 'Der Link läuft ab in',
	'minutes' => 'Minuten',

	//variables for \app\views\oauth-alert.de.blade.php
	'hint' => 'Hinweis:',
	'extAuth' => 'Sie haben sich über einen externen Anbieter angemeldet. In diesem Zuge haben wir Ihnen einen My Meta Maps-Account eingerichtet, dessen Daten Sie hier ändern können. Ihre Daten beim externen Anbieter bleiben unberührt!',
);
