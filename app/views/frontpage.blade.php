<!DOCTYPE html>
<html lang="de">

	<head>

		<title>My Meta Maps</title>
    
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
	    
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/style.css" type="text/css">

	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

		<!-- For the Map -->
		<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
		<link rel="stylesheet" href="/css/mapstyle.css" type="text/css">
		<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
		
		<!-- For the datePicker-plugin -->
	    <link rel="stylesheet" href="/js/plugins/datePicker/datepicker.min.css" type="text/css"/>
	    
	    <!-- For barRating-plugin -->
	    <link rel="stylesheet" href="/js/plugins/barRating/css/rating-plugin.css" type="text/css"/>
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" type="text/css"/>

	</head>

	<body>

		<!-- Navbar - beginning -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- Div/row for navbar-header - beginning -->
			<div class="row clearfix">
				<div class="col-md-12 column">
					<!-- Start: Logo -->
					<div class="navbar-header">
						<a class="navbar-brand logo" href="#">
							<img src="/img/logo.png" alt="My Meta Maps">
						</a>
					</div>
					<!-- End: Logo -->
					<!-- Div/row for navbar-collapse - beginning -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<!-- Start: Language Chooser -->
						<ul class="nav navbar-nav navbar-left">
							<div class="navbar-form btn-group" role="group">
								<a href="#/en" class="btn btn-default active" role="button"><img src="/img/flags/en.png" alt="English"></a>
								<a href="#/de" class="btn btn-default" role="button"><img src="/img/flags/de.png" alt="Deutsch"></a>
								<a href="#/nl" class="btn btn-default" role="button"><img src="/img/flags/nl.png" alt="Nederlands"></a>
							</div>
						</ul>
						<!-- End: Language Chooser -->
						<ul class="nav navbar-nav navbar-right">
							<!-- Start: Add geodata/comment -->
							<form class="navbar-form navbar-left">
								<a href="javascript:router.addComment();" class="btn btn-primary" id="commentBtn"> Kommentar erstellen &nbsp;
									<span class="glyphicon glyphicon-plus-sign"></span>
								</a>
							</form>
							<!-- End: Add geodata/comment -->
							<!-- Start: Account navigation -->
							<form class="navbar-form navbar-left">
								<div class="btn-group" role="group">
									<a href="javascript:router.profile();" class="btn btn-default disabled" id="userAccountBtn"><span class="glyphicon glyphicon-user"></span>&nbsp; Gast</a>
									<a href="javascript:router.login();" class="btn btn-primary" id="loginBtn"> Anmelden&nbsp;<span class="glyphicon glyphicon-log-in"></span></a>
									<a href="javascript:router.register();" class="btn btn-primary" id="registerBtn"> Registrieren&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
								</div>
							</form>	
							<!-- End: Account navigation -->
							<!-- Start: Help navigation -->
							<form class="navbar-form navbar-right">
								<a href="#/about" class="btn btn-primary"> Impressum&nbsp; <span class="glyphicon glyphicon-info-sign"></span></a>
								<a href="#/help" class="btn btn-danger" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></a>
							</form>
							<!-- End Help navigation -->
						</ul>
					</div>	
					<!-- Div/row for navbar-collapse - ending -->
				</div>
			</div>
			<!-- Div/row for navbar-header - ending -->
		</nav>
		<!-- Navbar - ending -->

		<!-- Spacing to the navbar -->
		<div id="spacing" style="height: 70px;">&nbsp;</div>
		
		<div class="buttons">
            <button class="blue-pill deactivated rating-enable" style="display: none;">enable</button>
        </div>
	
		<!-- Header - beginning --> 
		<header class="row clearfix box-spacing">

			<!-- Div for the alert for user-help - beginning -->
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span>
				</button>
				<strong>Benutzerhilfe</strong> &nbsp; 
				Klicke oben auf <button type="submit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalHelp" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button> für weitere Informationen
			</div>
			<!-- Div for the alert for user-help - ending -->
				
		</header>
		<!-- Header - ending -->

		<!-- Section - beginning -->
		<section id="content" class="row clearfix box-spacing">

		</section>
		<!-- Section - ending -->

		<!-- Containers for modals; will shown if a certain button is clicked -->
		<div id="modal">
			
		</div>
		<!--  Modals ending -->


		<!-- Load at the end to load the site faster -->
		
		<!-- Load this first to have all functions before loading other scripts -->
		<script type="text/javascript" src="/js/helpers.js"></script>
		
		<!-- Libaries (jQuery in head) -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>	
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone-min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
		
		<!-- Basic Views -->
		<script type="text/javascript" src="/js/views/ApplicationView.js"></script>
		
		<!-- Comment-MVC -->
		<script type="text/javascript" src="/js/models/commentModel.js"></script>
		<script type="text/javascript" src="/js/views/commentView.js"></script>
		<script type="text/javascript" src="/js/controllers/commentController.js"></script>
		
		<!-- User-MVC -->
		<script type="text/javascript" src="/js/models/userModel.js"></script>
		<script type="text/javascript" src="/js/views/userViews.js"></script>
		<script type="text/javascript" src="/js/controllers/userController.js"></script>
		
		<!-- Router -->
		<script type="text/javascript" src="/js/router.js"></script>

	</body>

</html>