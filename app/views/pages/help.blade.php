<!-- Headline of userinfo -->
<h1>@lang('misc.headline')</h1>
<!-- End of headline -->
	<!-- Beginning howto registration -->
	<h2>Wie registriere ich mich?</h2>
		<div class='pos_left'>
			Text für Registrierung mit Bildchen<br>
			<a href="javascript:router.register();" class="btn btn-primary" id="registerBtn">@lang('misc.register')&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
		</div>
	<!-- End of howto registration -->
	<!-- Beginning howto sign in -->
	<h2>Wie melde ich mich an?</h2>
		<div class='pos_left'>
			Text für Login mit Bildchen<br>
			<a href="javascript:router.loginout();" class="btn btn-primary" id="loginBtn"><span id="logBtnText">@lang('misc.login')</span>&nbsp;<span class="glyphicon glyphicon-log-in" id="loginBtnIcon"></span></a>
		</div>
	<!-- End of howto sign in -->
	<!-- Beginning howto comment -->
	<h2>Wie füge ich ein Kommentar hinzu?</h2>
		<div class='pos_left'>
			Text für Kommentierung eventuell mit Bildchen<br>
			<a href="javascript:router.addComment();" class="btn btn-primary" id="commentBtn">@lang('misc.addComment')&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></a>
		</div>
	<!-- End of howto comment -->
	<!-- Beginning howto filter -->
	<h2>Welche Filter gibt es?</h2>
		<!-- Beginning spatial filter -->
		<h3>Räumlicher Filter</h3>
			<div class='pos_left'>
				Der räumliche Filter ermöglicht die selektierte Anzeige von Datensätzen in einem gewählten Umkreis um den Kartenmittelpunkt.
			</div>
		<!-- End of spatial filter -->
		<!-- Beginning time filter -->
		<h3>Zeitlicher Filter</h3>
			<div class='pos_left'>
				Der zeitliche Filter ermöglicht die Filterung von Datensätzen von bestimmten Zeiträumen
			</div>
		<!-- End of time filter -->
		<!-- Beginning rate-filter -->
		<h3>Filter nach Bewertung</h3>
			<div class='pos_left'>
				Der Bewertungsfilter ermöglicht die selektierte Anzeige von Datensätzen mitbestimmten Bewertungen
			</div>
		<!-- End of rate-filter -->
		<!-- Begin of keyword-search -->	
		<h3>Stichwortsuche</h3>
			<div class='pos_left'>
				Die Stichwortsuche ermöglicht die Suche nach Wörtern die in einem Kommentar hinterlegt wurden.
			</div>
		<!-- End of keyword-search -->
	<!-- End of howto filter -->