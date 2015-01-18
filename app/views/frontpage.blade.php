<!DOCTYPE html>
<html lang="de">

	<head>

		<title>My Meta Maps</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="http://openlayers.org/en/v3.1.1/css/ol.css" type="text/css">
		<link rel="stylesheet" href="/js/plugins/datePicker/datepicker.min.css" type="text/css">
		<link rel="stylesheet" href="/js/plugins/barRating/css/rating-plugin.css" type="text/css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" type="text/css">
		<link rel="stylesheet" href="/css/style.css" type="text/css">

		<script type="text/javascript" src="/api/internal/config"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="http://openlayers.org/en/v3.1.1/build/ol.js" type="text/javascript"></script>
		<script type="text/javascript" src="/js/helpers.js"></script>

	</head>

	<body>
		<div id="container">
			<!-- Navbar - beginning -->
			<div id="nav" class="navbar navbar-default navbar-fixed-top" role="navigation">
				<!-- Div/row for navbar-header - beginning -->
				<div class="row clearfix">
					<div class="col-md-12 column">
						<!-- Start: Logo -->
						<div class="navbar-header">
							<a class="navbar-brand logo" href="#"><img src="/img/logo.png" alt="My Meta Maps"></a>
							<button type="button" class="navbar-toggle glyphicon glyphicon-chevron-down"  data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
							</button>
						</div>
						<!-- End: Logo -->
						<!-- Div/row for navbar-collapse - beginning -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<!-- Start: Language Chooser -->
							<ul class="nav navbar-nav navbar-left">
								<div class="navbar-form btn-group" role="group">
									@foreach (Language::listing() as $code => $name)
									<a href="/{{ $code }}" class="btn btn-default @if(Language::is($code)) active @endif " role="button"><img src="/img/flags/{{ $code }}.png" alt="{{ $name }}"></a>
									@endforeach
								</div>
							</ul>
							<!-- End: Language Chooser -->
							<ul class="nav navbar-nav navbar-right">
								<!-- Start: Add geodata/comment -->
								<div class="navbar-form navbar-left">
									<a href="javascript:router.addComment();" class="btn btn-primary" id="commentBtn">@lang('misc.addComment')&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></a>
								</div>
								<!-- End: Add geodata/comment -->
								<!-- Start: Account navigation -->
								<div class="navbar-form navbar-left">
									<div id="" class="btn-group" role="group">
										<div class="btn-group" role="group">
											<a class="btn btn-default dropdown-toggle disabled" id="userAccountBtn" data-toggle="dropdown" aria-expanded="true">
												<span class="glyphicon glyphicon-user"></span>&nbsp;<span id="userAccountName" data-id="{{ Auth::id() }}">
													@if(Auth::user()) {{{ Auth::user()->name }}} @endif
												</span>&nbsp;<span class="caret"></span>
											</a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="userAccountBtn">
												<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:router.profile();">@lang('misc.profilChange')</a></li>
												<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:router.password();">@lang('misc.pwchange')</a></li>
											</ul>
										</div>
										<a href="javascript:router.register();" class="btn btn-primary" id="registerBtn">@lang('misc.register')&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
										<a href="javascript:router.loginout();" class="btn btn-primary" id="loginBtn"><span id="logBtnText">@lang('misc.login')</span>&nbsp;<span class="glyphicon glyphicon-log-in" id="loginBtnIcon"></span></a>
									</div>
								</div>	
								<!-- End: Account navigation -->
								<!-- Start: Help navigation -->

								<div class="navbar-form navbar-right">
									<a href="#/about" class="btn btn-primary">@lang('misc.imprint')&nbsp; <span class="glyphicon glyphicon-info-sign"></span></a>
									<a href="#/help" class="btn btn-danger" id="helpBtn">@lang('misc.help')&nbsp;<span class="glyphicon glyphicon-question-sign"></span></a>
								</div>
								<!-- End Help navigation -->
							</ul>
						</div>	
						<!-- Div/row for navbar-collapse - ending -->
					</div>
				</div>
				<!-- Div/row for navbar-header - ending -->
			</div>
			<!-- Navbar - ending -->

			<!-- Messages box - beginning --> 
			<div id="messages" class="row clearfix box-spacing">

				@if (empty($_COOKIE['message-user-help']))
				<!-- Div for the alert for user-help - beginning -->
				<div id="message-user-help" class="alert alert-warning alert-dismissible">
					<button onclick="MessageBox.dismissPermanently('message-user-help');" type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('client.close')</span></button>
					<strong>@lang('misc.userinfo')</strong><hr>
					@lang('misc.clicktop') <a href="#/help" class="btn btn-danger btn-xs">@lang('misc.help')&nbsp;<span class="glyphicon glyphicon-question-sign"></span></a> @lang('misc.furtherInfo')
				</div>
				<!-- Div for the alert for user-help - ending -->
				@endif

			</div>
			<!-- Messages box - ending -->

			<!-- Content area - beginning -->
			<div id="content" class="row clearfix box-spacing hundred"></div>
			<!-- Content area - ending -->

			<!-- Containers for modals; will shown if a certain button is clicked -->
			<div id="modal"></div>
			<!--  Modals ending -->

		</div>

		<!-- Load suitable libraries at the end to load the site faster -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>	
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone-min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="/js/models/ApplicationModel.js"></script>

		<script type="text/javascript" src="/js/models/commentModel.js"></script>
		<script type="text/javascript" src="/js/controllers/commentController.js"></script>

		<script type="text/javascript" src="/js/views/ApplicationView.js"></script>
		<script type="text/javascript" src="/js/views/commentView.js"></script>

		<script type="text/javascript" src="/js/models/userModel.js"></script>
		<script type="text/javascript" src="/js/views/userViews.js"></script>
		<script type="text/javascript" src="/js/controllers/userController.js"></script>

		<script type="text/javascript" src="/js/router.js"></script>

	</body>

</html>