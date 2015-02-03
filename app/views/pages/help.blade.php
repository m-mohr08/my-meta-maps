<!-- Headline of userinfo -->
<h1>@lang('misc.headline')</h1>
<!-- End of headline -->
	<!-- Beginning howto registration -->
	<h2>@lang('misc.howtoReg')</h2>
		<div class='pos_left'>
			Die Registrierung auf My Meta Maps erfolgt über einen Klick auf die Schaltfläche <a href="javascript:router.register();" class="btn btn-primary" id="registerBtn">@lang('misc.register')&nbsp;<span class="glyphicon glyphicon-edit"></span></a> 
		</div>
	<!-- End of howto registration -->
	<!-- Beginning howto sign in -->
	<h2>@lang('misc.howtoLogin')</h2>
		<div class='pos_left'>
			Um sich einzuloggen klicken Sie oben rechts auf die Schaltfläche <a href="javascript:router.loginout();" class="btn btn-primary" id="loginBtn"><span id="logBtnText">@lang('misc.login')</span>&nbsp;<span class="glyphicon glyphicon-log-in" id="loginBtnIcon"></span></a>
		</div>
	<!-- End of howto sign in -->
	<!-- Beginning howto comment -->
	<h2>@lang('misc.howtoComm')</h2>
		<div class='pos_left'>
			Text für Kommentierung eventuell mit Bildchen<br>
			<a href="javascript:router.addComment();" class="btn btn-primary" id="commentBtn">@lang('misc.addComment')&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></a>
		</div>
	<!-- End of howto comment -->
	<!-- Beginning howto filter -->
	<h2>@lang('misc.whichFilter')</h2>
		<!-- Beginning spatial filter -->
		<h3>@lang('misc.spatialFilter')</h3>
			<div class='pos_left'>
				Der räumliche Filter ermöglicht die selektierte Anzeige von Datensätzen in einem gewählten Umkreis um den Kartenmittelpunkt.
			</div>
		<!-- End of spatial filter -->
		<!-- Beginning time filter -->
		<h3>@lang('misc.timeFilter')</h3>
			<div class='pos_left'>
				Der zeitliche Filter ermöglicht die Filterung von Datensätzen von bestimmten Zeiträumen
			</div>
		<!-- End of time filter -->
		<!-- Beginning rate-filter -->
		<h3>@lang('misc.rateFilter')</h3>
			<div class='pos_left'>
				Der Bewertungsfilter ermöglicht die selektierte Anzeige von Datensätzen mitbestimmten Bewertungen
			</div>
		<!-- End of rate-filter -->
		<!-- Begin of keyword-search -->	
		<h3>@lang('misc.keywordSearch')</h3>
			<div class='pos_left'>
				Die Stichwortsuche ermöglicht die Suche nach Wörtern die in einem Kommentar hinterlegt wurden.
			</div>
		<!-- End of keyword-search -->
	<!-- End of howto filter -->