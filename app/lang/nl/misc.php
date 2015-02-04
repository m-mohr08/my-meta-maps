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
	'clicktop' => 'Nieuw op My Meta Maps? Wij verklaren je graag hoe je de eerste stappen kunt maken. Tik alleen maar op ',
	'furtherInfo' => '.',
	
	//variables for \app\views\pages\help.blade.php
	'headline' => 'De user-hulp geeft je de antwoorden van veelgestelde vragen en de bediening van My Meta Maps.',
	'whatIsMMMTitle' => 'Was ist My Meta Maps?',
	'whatIsMMM' => 'My Meta Maps ist ein Web-Verzeichnis, das auf Basis von aggregierten Metadaten und Benutzerrezensionen das leichte Auffinden von Geodaten ermöglicht.',
	'howtoReg' => 'Hoe kan ik me registreren?',
	'howtoLogin' => 'Hoe meld ik me aan?',
	'howtoChangeUserdata' => 'Wie ändere ich meinen Daten?',
	'howtoComm' => 'Hoe kan je een commentaar toevoegen?',
	'whichFilter' => 'Welk filter zijn er?',
	'howtoSeeComments' => 'Wie kann ich die Kommentare zu einem Geodatensatz sehen?',
	'howtoShare' => 'Teile My Meta Maps mit anderen',
	'howtoLoginViaOAuth' => 'Melde dich über einen Drittanbieter an',
	'howtoChangeGeneral' => 'Wie ändere ich mein Profil?',
	'howtoChangePassword' => 'Wie ändere ich mein Passwort?',
	'filterInfoTitle' => 'Informationen zu den Filtern',
	'filterInfo' => 'Grundsätzlich beziehen sich die Filter auf die Kommentare zu Geodatensätzen. Falls du aber bei der Stichwortsuche die Metadaten miteinbeziehen möchtest,
	 kannst du dies über die passende Checkbox tun.',
	'spatialFilter' => 'Ruijmtelijk filter',
	'timeFilter' => 'Temporeel filter',
	'rateFilter' => 'Filter naar beoordeling',
	'keywordSearch' => 'Trefwoordzoek',
	'buttonReg' => 'Je kan je op My Meta Maps door een click op de volgende knopje registreren:',
	'buttonLogin' => 'Om je na de registratie inteloggen, click je boven op het knopje:','loginViaOAuth' => 'Alternativ kannst du dich sowohl über Facebook, GitHub, Google oder Twitter anmelden. Dir wird anschließend automatisch eine Account bei My Meta Maps erstellt.',
	'changeGeneral' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um die Daten ihres Profils zu ändern.
	 Du kannst sowohl deinen Benutzernamen als auch deine Email-Adresse ändern und zudem deine bevorzugte Sprache auswählen.',
	'changePassword' => 'Oben rechts befindet sich ein Button mit ihrem Profilnamen. Dort kannst du zu einer Ansicht gelangen, um dein Passwort zu ändern.',
	'buttonComment' => 'Oben rechts befindet sich die Schaltfläche zur Erstellung eines Kommentares',
	'noRegNec' => 'Es ist nicht nötig registriert oder angemeldet zu sein, um einen Kommentar hinzuzufügen.',
	'addCommentSteps' => 'Das Hinzufügen eines Kommentares erfolgt in zwei Schritten:',
	'addCommentStepOne' => 'Gebe die URL des Geodatensatzes ein und wähle das passende Datenformat aus. Falls es hier zu Problemen kommt, werden dir diese beschrieben.',
	'addCommentStepTwo' => 'Hier kannst du zum einen den Titel für den Geodatensatz festlegen, falls zu diesem noch keine Kommentare existieren, einen Layer, falls vorhanden, auswählen,
	 einen Fließtext eingeben, eine Geometrie erstellen und sowohl einen Zeitraum als auch eine Bewertung festlegen.',
	'addCommentNote' => 'Beachte: Der Fließtext ist verplfichtend. Beim Hinzufügen einer Geometrie kannst du zwischen Punkt, Linie und Polygon auswählen, allerdings auch nur eine Geometrie hinzufügen.',
	'addCommentTipp' => 'Tipp: In der Ansicht zu den Kommentaren eines Geodatensatzes kannst du direkt zu diesem Geodatensatz eine Kommentar erstellen und umgehst somit den ersten Schritt.',
	'buttonComment' => 'Boven vindt je ook het knopje om een commentaar toetevoegen:',
	'noRegNec' => 'Het is niet nodig geregistreerd of angemeeld te zijn om een commentaar toetevoegen.',
	'acceptedFormats' => 'De volgende gegevens-formaten worden van My Meta Maps geaccepteerd:',
	'surrounding' => 'Met de ruimtelijk filter kan je gegevens binnen een gekozen afstand om het middelpunt van de kaart selecteren.',
	'searchDist' => 'De zoek is mogelijk in trappen van 5 km tot 500 km.',
	'timeFiltDef' => 'met de temporeel filter kan je gegevens van vastgelegde perioden selecteren.',
	'timeStartEnd' => 'Je kan een tijdstipbegin en een einde vastleggen.',
	'rateDef' => 'Met de beoordelingsfilter kan je gegevens met vastgelegde beoordelingen selecteren.',
	'rateScale' => 'De beoordelingen gaan van 1 tot 5 sterren.',
	'keyDef' => 'Met de trefwoordzoek kan je naar worden uit commentaren zoeken.','seeComments' => 'Unten links kannst du eine Liste mit Geodatensätzen sehen, zu denen es - passend zu den Filtern - Kommentare gibt. Durch einen Klick gelangst du zur Ansicht mit den Kommentaren.
	 Dir wird zudem angezeigt, wie viele Kommentare es zu den jeweiligen Geodatensätzen gibt. Falls die Filter Kommentare herausselektieren,
	 passt sich diese Zahl an und in der Ansicht mit den Kommentaren werden auch nur noch die selektierten angezeigt.',
	'commentsFurtherInfos' => 'Du siehts zunächst eine Liste mit zum einen allgemeine Kommentaren und zum anderen zu den jeweiligen Layern.
	 Durch Klick auf das jeweilige Element lassen sich die jeweiligen Kommentare anzeigen. Hier siehst du zudem von wem der Kommentar stammt, die Bewertung und den Zeitraum des Kommentares.
	 Rechts kannst du außerdem allgemeine und Metadaten und auf einer Karte die Bounding Box zu dem Geodatensatz sehen.',
	'shareMMM' => 'Sowohl in der Liste mit den Geodatensätzen als auch in der Ansicht mit den Kommentaren zu einem Geodatensatz wirst du dieses Symbol sehen ',
	'shareMMMFurtherInfos' => 'Damit kannst du sowohl deine gefilterte Liste an Geodatensätzen, die Liste an Kommentaren zu einem bestimmten Geodatensatz als auch nur einen einzelnden Kommentar teilen.',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Over My Meta Maps',
	'license' => 'Licentie',
	'contact' => 'Contact',
	'intro' => 'My Meta Maps werd ontwikkeld van studenten van het instituut voor geoinformatie van de WWU Münster',
	'team' => 'Het team bestaat uit:',
	'pubAdress' => 'Adres van de openbaare gegevens-interface',
	'libs' => 'Gebruikte bibliotheken',

	//variables for \app\views\pages\addCommentFirstStep.blade.php
	'url' => 'URL',
	'createComm' => 'Commentaar cre&eumlren',
	'dataFormat' => 'Gegevens formaat',
	'chooseFormat' => 'Kies een gegevens formaat',
	'create' => 'Cre&eumlren',

	//variables for \app\views\pages\addCommentSecondStep.blade.php
	'enterData' => 'Gegevens ingeven',
	'commNoLay' => 'Commentaar niet aan een layer toewijzen',
	'title' => 'Titel*',
	'freetext' => 'Jou commentaar',
	'spatial' => 'Ruimtelijke indeling van het commentaar',
	'timerange' => 'Tijdsbestek',
	'rating' => 'Evaluatie',
	'addMeta' => 'Aanvullend meta gegevens',
	'lang' => 'Taal',
	'explane' => 'Beschrijving',
	'tags' => 'Tags',
	'copyright' => 'Copyright',

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
	'startingDate' => 'Begin',
	'endingDate' => 'Einde',
	'author' => 'Autuer',
	'generalData' => 'Algemeene gegevens',
	'layer' => 'Layer:',
	'permlink' => 'Permanent link',
	'unknown' => 'Onbekend',

	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	'anonym' => 'Anoniem',
	'rate' => 'Beoordeling:',
	'stars' => 'Sterren',
	'notSpec' => 'Niet gespecificeerd',
	'geoData' => 'Geogegevens voorhanden',

	//variables for \app\views\pages\show GeodataBit.blade.php
	'noSearch' => 'De gegevens stemmen niet met je zoekworden overeen.',

	//variables for \app\views\emails\auth\reminder.blade.php
	'pwReset' => 'Wachtwoord opnieuw instellen',
	'resetForm' => 'Om het wachtwoord opnieuw intestellen, full het formulier uit alsjeblieft:',
	'expire' => 'De link loopt af in',
	'minutes' => 'minuten',

	//variables for \app\views\oauth-alert.de.blade.php
	'hint' => 'Tip:',
	'extAuth' => 'Je bent nu over een extern aanbieder aangemeld. Daroom hebben we je een My Meta Maps-account aangelegd. De account-gegevens kunt je hier wijzigen. Je gegevens bij de externe aanbieder blijven ongewijzigd!',
);
