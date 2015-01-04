<!DOCTYPE html>
<html lang="de">

	<head>

		<title>My Meta Maps</title>
    
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/style.css" type="text/css">
	    
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">

	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

		<!-- For the Map -->
		<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
		<link rel="stylesheet" href="/css/mapstyle.css" type="text/css">
		<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
		<script src="/js/mapscript.js" type="text/javascript"></script>

		<!-- For formValidator-plugin -->
		<link rel="stylesheet" href="/js/plugins/formValidator/css/formValidator.css" type="text/css"/>
		
		<!-- For the datePicker-plugin -->
	    <link rel="stylesheet" href="/js/plugins/datePicker/datepicker.min.css" type="text/css"/>
	    
	    <!-- For barRating-plugin -->
	    <link rel="stylesheet" href="/js/plugins/barRating/css/rating-plugin.css" type="text/css"/>
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" type="text/css"/>

	</head>

	<body onload="drawmap()">

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
								<a href="#" class="btn btn-default active" role="button"><img src="/img/flags/en.png" alt="English"></a>
								<a href="#" class="btn btn-default" role="button"><img src="/img/flags/de.png" alt="Deutsch"></a>
								<a href="#" class="btn btn-default" role="button"><img src="/img/flags/nl.png" alt="Nederlands"></a>
							</div>
						</ul>
						<!-- End: Language Chooser -->
						<ul class="nav navbar-nav navbar-right">
							<!-- Start: Add geodata/comment -->
							<form class="navbar-form navbar-left">
								<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddComment" id="commentBtn"> Kommentar erstellen &nbsp;
									<span class="glyphicon glyphicon-plus-sign"></span>
								</button>
							</form>
							<!-- End: Add geodata/comment -->
							<!-- Start: Account navigation -->
							<form class="navbar-form navbar-left">
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-default disabled"> <span class="glyphicon glyphicon-user"></span>&nbsp; Account </button>&nbsp;
									<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalLogin" id="loginBtn"> Anmelden &nbsp;
										<span class="glyphicon glyphicon-log-in"></span>
									</button>
									<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalRegister" id="registerBtn"> Registrieren&nbsp;
										<span class="glyphicon glyphicon-edit"></span>
									</button>
								</div>
							</form>	
							<!-- End: Account navigation -->
							<!-- Start: Help navigation -->
							<form class="navbar-form navbar-right">
								<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#ModalHelp" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button>
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
		<header class="row clearfix" style="margin-left: 30px; margin-right: 30px">

			<!-- Div for the alert for user-help - beginning -->
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span>
				</button>
				<strong>Benutzerhilfe</strong> &nbsp; 
				Klicke oben auf <button type="submit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalHelp" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button> für weitere Informationen
			</div>
			<!-- Div for the alert for user-help - ending -->
			
			<div id="filterContainer">
				
			</div>

			<hr>	
				
		</header>
		<!-- Header - ending -->

		<!-- Section - beginning -->
		<section class="row clearfix" style="margin-left: 30px; margin-right: 30px">	
			<!-- Div for map/comments - beginning -->
			<div class="row clearfix" id="mapComments">
				<!-- Div for map - beginning -->
				<div class="col-md-8 column">
					<p>
						<div id="map"></div>
					</p>
				</div>
				<!-- Div for map - ending -->
				
				<!-- Div for comments - beginning -->
				<div class="col-md-4 column">
					<h3 class="text-info">
						Kommentare ...
					</h3>
					<br>
					
					<!-- Tabs for comments with and woithout spatial reference -->
					<ul class="nav nav-tabs nav-justified">
					    <li class="active"><a href="#commentWithGeo" data-toggle="tab">... mit räumlichem Bezug</a></li>
					    <li><a href="#commentWithOutGeo" data-toggle="tab">... ohne räumlichen Bezug</a></li>
					</ul>
					<div class="tab-content commentScrollBox">
						
						<!-- Tab for comments with spatial reference -->		
						<div role="tabpanel" class="tab-pane active list-group" id="commentWithGeo">
						
						<!-- Tab for comments without spatial reference -->
						<div role="tabpanel" class="tab-pane list-group" id="commentWithOutGeo">
						
					</div>
				</div>
				<!-- Div for comments - ending -->
			</div>
			<!-- Div for map/comments - ending -->
		</section>
		<!-- Section - ending -->

		<br> <!-- Spacing to the footer/navbar on the bottom -->

		<footer>
			<nav class="navbar navbar-default" style="margin-bottom: 0px" role="navigation">
				<ul class="nav navbar-nav navbar-right">
					<form class="navbar-form navbar-right">
						<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalInfo"> Impressum&nbsp;
							<span class="glyphicon glyphicon-info-sign"></span>
						</button>
					</form>
				</ul>
			</nav>
		</footer>


		<!-- Containers for modals; will shown if a certain button is clicked -->
		
		<div id="addCommentContainer">
			
		</div>
		
		<div id="loginContainer">
			
		</div>		
		
		<div id="registerContainer">
			
		</div>
		
		<div id="infoSiteContainer">
			
		</div>
		
		<div id="helpSiteContainer">
			
		</div>
		
		<div id="userAccountContainer">
			
		</div>

		<!--  Modals ending -->


		<!-- Load at the end to load the site faster -->
		
		<!-- Load this first to have all functions before loading other scripts -->
		<script type="text/javascript" src="/js/helpers.js"></script>
		
		<!-- Libaries (jQuery in head) -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>	
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone-min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
		
		<!-- Comment-MVC's -->
		<script type="text/javascript" src="/js/models/commentModel.js"></script>
		<script type="text/javascript" src="/js/views/commentView.js"></script>
		<script type="text/javascript" src="/js/views/commentAddView.js"></script>
		<script type="text/javascript" src="/js/controllers/commentController.js"></script>
		<script type="text/javascript" src="/js/controllers/commentAddController.js"></script>
		<script type="text/javascript" src="/js/controllers/commentAddURLController.js"></script>
		
		<!-- View for info and help-site -->
		<script type="text/javascript" src="/js/views/infoAndHelpSiteView.js"></script>
		
		<!-- View for login -->
		<script type="text/javascript" src="/js/views/loginView.js"></script>
		
		<!-- View for register -->
		<script type="text/javascript" src="/js/views/registerView.js"></script>
		
		<!-- View for filter -->
		<script type="text/javascript" src="/js/views/filterView.js"></script>

	</body>

</html>