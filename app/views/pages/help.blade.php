<!-- Headline of userinfo -->
<h1>@lang('misc.headline')</h1>
<!-- End of headline -->
	<!-- Beginning howto registration -->
	<h2>@lang('misc.howtoReg')</h2>
		<div class='pos_left'>
			@lang('misc.buttonReg') <a href="javascript:router.register();" class="btn btn-primary" id="registerBtn">@lang('misc.register')&nbsp;<span class="glyphicon glyphicon-edit"></span></a> 
		</div>
	<!-- End of howto registration -->
	<!-- Beginning howto sign in -->
	<h2>@lang('misc.howtoLogin')</h2>
		<div class='pos_left'>
			@lang('misc.buttonLogin') <a href="javascript:router.loginout();" class="btn btn-primary" id="loginBtn"><span id="logBtnText">@lang('misc.login')</span>&nbsp;<span class="glyphicon glyphicon-log-in" id="loginBtnIcon"></span></a>
		</div>
	<!-- End of howto sign in -->
	<!-- Beginning howto comment -->
	<h2>@lang('misc.howtoComm')</h2>
		<div class='pos_left'>
			@lang('misc.buttonComment') <a href="javascript:router.addComment();" class="btn btn-primary" id="commentBtn">@lang('misc.addComment')&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></a><br>
			@lang('misc.noRegNec')<br>
			@lang('misc.acceptedFormats')<br>
			<!-- Beginning format-list -->
			<div class="list-group">
				<a href="http://www.opengeospatial.org/standards/kml" class="list-group-item" target="_blank">KML</a>
				<a href="http://microformats.org/wiki/microformats-2" class="list-group-item" target="_blank">microformats2</a>
				<a href="http://www.opengeospatial.org/standards/cat" class="list-group-item" target="_blank">OGC Catalogue Service</a>
				<a href="http://www.opengeospatial.org/standards/wcs" class="list-group-item" target="_blank">OGC WCS</a>
				<a href="http://www.opengeospatial.org/standards/wfs" class="list-group-item" target="_blank">OGC WFS</a>
				<a href="http://www.opengeospatial.org/standards/sos" class="list-group-item" target="_blank">OGC SOS</a>
				<a href="http://www.opengeospatial.org/standards/wms" class="list-group-item" target="_blank">OGC WMS</a>
				<a href="http://www.opengeospatial.org/standards/wmts" class="list-group-item" target="_blank">OGC WMTS</a>
			</div>
			<!-- Ending format-list -->
		</div>
	<!-- End of howto comment -->
	<!-- Beginning howto filter -->
	<h2>@lang('misc.whichFilter')</h2>
		<!-- Beginning spatial filter -->
		<h3>@lang('misc.spatialFilter')</h3>
			<div class='pos_left'>
				@lang('misc.surrounding')<br>
				@lang('misc.searchDist')
			</div>
		<!-- End of spatial filter -->
		<!-- Beginning time filter -->
		<h3>@lang('misc.timeFilter')</h3>
			<div class='pos_left'>
				@lang('misc.timeFiltDef')<br>
				@lang('misc.timeStartEnd')
			</div>
		<!-- End of time filter -->
		<!-- Beginning rate-filter -->
		<h3>@lang('misc.rateFilter')</h3>
			<div class='pos_left'>
				@lang('misc.rateDef')<br>
				@lang('misc.rateScale') 
			</div>
		<!-- End of rate-filter -->
		<!-- Begin of keyword-search -->	
		<h3>@lang('misc.keywordSearch')</h3>
			<div class='pos_left'>
				@lang('misc.keyDef')
			</div>
		<!-- End of keyword-search -->
	<!-- End of howto filter -->