<!DOCTYPE html>
<html lang="de">

	<head>

		<title>My Meta Maps</title>
    
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
	    
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<!-- For formValidation-plugin -->
		<link href="plugins/jQuery-Plugin-For-Easy-Client-Side-Form-Validation-bValidator/css/formValidator.css" rel="stylesheet">
	    
	    <!-- For rating-plugin -->
	    <link href="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/css/rating-plugin.css" rel="stylesheet" type="text/css"/>
	    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet"
	          type="text/css"/>
	    
	    <!-- For rating-plugin; loaded in header, otherwise it doesnt works -->
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	    <script type="text/javascript" src="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/jquery.barrating.js"></script>
    	<script type="text/javascript" src="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/rating-views.js"></script>
	    
	    <!-- Placed here, otherwise plugin doesnt works -->
	    <base href="http://giv-geosoft2b.uni-muenster.de/mmm_dev/"> <!-- Do it in a generic way -->
		
		<!--
		<link href="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/css/examples.css" rel="stylesheet" type="text/css"/>
    	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet"
          type="text/css"/> 
         Überschneidet sich dieses css mit dem von Bootstrap ??? -->        
		
		<!-- Plugin for rating; loaded in header (?!) 
    	<script type="text/javascript" src="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/jquery.barrating.js"></script>
    	<script type="text/javascript" src="plugins/Minimal-jQuery-Rating-Widget-Plugin-Bar-Rating/magic.js"></script>
    	-->

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
							<img src="img/logo.png" alt="My Meta Maps">
						</a>
					</div>
					<!-- End: Logo -->
					<!-- Div/row for navbar-collapse - beginning -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<!-- Start: Language Chooser -->
						<ul class="nav navbar-nav navbar-left">
							<div class="navbar-form btn-group" role="group">
								<a href="#" class="btn btn-default active" role="button"><img src="img/flags/en.png" alt="English"></a>
								<a href="#" class="btn btn-default" role="button"><img src="img/flags/de.png" alt="Deutsch"></a>
								<a href="#" class="btn btn-default" role="button"><img src="img/flags/nl.png" alt="Nederlands"></a>
							</div>
						</ul>
						<!-- End: Language Chooser -->
						<ul class="nav navbar-nav navbar-right">
							<!-- Start: Add geodata/comment -->
							<form class="navbar-form navbar-left">
								<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalKommentar" id="commentBtn"> Kommentar erstellen &nbsp;
									<span class="glyphicon glyphicon-plus-sign"></span>
								</button>
							</form>
							<!-- End: Add geodata/comment -->
							<!-- Start: Account navigation -->
							<form class="navbar-form navbar-left">
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-default disabled"> <span class="glyphicon glyphicon-user"></span>&nbsp; Account </button>&nbsp;
									<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalAnmelden" id="loginBtn"> Anmelden &nbsp;
										<span class="glyphicon glyphicon-log-in"></span>
									</button>
									<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalRegistrieren" id="registerBtn"> Registrieren&nbsp;
										<span class="glyphicon glyphicon-edit"></span>
									</button>
								</div>
							</form>	
							<!-- End: Account navigation -->
							<!-- Start: Help navigation -->
							<form class="navbar-form navbar-right">
								<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#ModalHilfe" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button>
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

		<!-- Header - beginning --> 
		<!-- Müsste später durch ein template ersetzt werden, um Benutzerhilfe nur beim ersten Start anzuzeigen 
			und Einstellungen der Filter speichern zu können -->
		<header class="container">

			<!-- Div for the alert for user-help - beginning -->
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span>
				</button>
				<strong>Benutzerhilfe</strong> &nbsp; 
				Klicke oben auf <button type="submit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalHilfe" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button> für weitere Informationen
			</div>
			<!-- Div for the alert for user-help - ending -->
			<hr>
			<!-- Div for the filters - beginning -->
			<div class="row clearfix">
				<div class="col-md-3 column">
					<div class="input select rating-d">
					    <label for="example-d">Räumlicher Filter</label>
						<select id="example-d" name="rating">
					 	   <option value="5">5</option>
						   <option value="10">10</option>
						   <option value="20">20</option>
						   <option value="50">50</option>
						   <option value="100">100</option>
						   <option value="200">200</option>
						</select>
				    </div>
				</div>
				<div class="col-md-3 column">
					<div class="input-group">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Zeitlicher Filter <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Kalender</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 column">
					<div class="input select rating-f">
			            <label for="example-f">Filter für Bewertung</label>
			            <select id="example-f" name="rating">
			                <option value="1">1</option>
			                <option value="2">2</option>
			                <option value="3">3</option>
			                <option value="4">4</option>
			                <option value="5">5</option>
			            </select>
			        </div>
				</div>
				<div class="col-md-3 column">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Stichwortsuche">
						<div class="input-group-btn">
							<button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span> </button>&nbsp;
						</div>
					</div>
				</div>
			</div>
			<!-- Div for the filters - ending -->
			<hr>		
		</header>
		<!-- Header - ending -->

		<!-- Section - beginning -->
		<!-- Müsste später durch ein template ersetzt werden -->
		<section class="container">	
			<!-- Div for map/comments - beginning -->
			<div class="row clearfix" id="mapComments">
				<!-- Div for map - beginning -->
				<div class="col-md-8 column">
					<h2>
						Karte
					</h2>
					<p>
						Hier kommt die Karte hin.
					</p>
				</div>
				<!-- Div for map - ending -->
				<!-- Div for comments-header - beginning -->

				<div class="col-md-4 column">
					<h3 class="text-info">
						Kommentare ...
					</h3>
					<br>
					<div>
						<div class="row clearfix">
							<div class="col-md-12 column">
								<div class="tabbable" id="tabs-664988">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#commentWithGeo" data-toggle="tab">... mit räuml. Bezug</a>
										</li>
										<li>
											<a href="#commentWithOutGeo" data-toggle="tab">... ohne räuml. Bezug</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="commentWithGeo">
											<!-- Div for comments - beginning -->
											<div style="overflow-y: auto; max-height: 400px">
												<div class="row clearfix">
													<div class="col-md-12 column">
														<div class="panel panel-info">
															<!-- Unordered list for comments -->
															<ul class="list-group">
																<li class="list-group-item">Geodatensatz ??? - noch nicht klickbar</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
																<li class="list-group-item">Geodatensatz ???</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<!-- Div for comments - ending -->
										</div>
										<div class="tab-pane" id="commentWithOutGeo">
											<div class="tab-pane active" id="commentWithGeo">
												<!-- Div for comments - beginning -->
												<div style="overflow-y: auto; max-height: 400px">
													<div class="row clearfix">
														<div class="col-md-12 column">
															<div class="panel panel-info">
																<!-- Unordered list for comments -->
																<ul class="list-group">
																	<li class="list-group-item">Geodatensatz xyz - noch nicht klickbar</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																	<li class="list-group-item">Geodatensatz xyz</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
												<!-- Div for comments - ending -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Div for comments-header - ending -->

			</div>
			<!-- Div for map/comments - ending -->
		</section>
		<!-- Section - ending -->

		<br> <!-- Spacing to the footer/navbar on the bottom -->

		<footer>
			<nav class="navbar navbar-default" role="navigation">
				<ul class="nav navbar-nav navbar-right">
					<form class="navbar-form navbar-right">
						<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalImpressum"> Impressum&nbsp;
							<span class="glyphicon glyphicon-info-sign"></span>
						</button>
					</form>
				</ul>
			</nav>
		</footer>


		<!-- Modals; will shown if a certain button is clicked -->
		<!-- Manche müssen wir noch zu templates ändern oder durch andere Möglichkeiten ersetzen -->
		<!-- Vielleicht kann man auch nur ein Modal für alle 'bereit stellen' -->

		<!-- Modal for login -->
		<div class="modal fade" id="ModalAnmelden" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
						<h4 class="modal-title" id="meinModalLabel">Anmelden</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Benutzername / Email-Adresse</label>
								<input type="text" class="form-control" id="usernameLogin" />
							</div>
							<div class="form-group">
								<label>Passwort</label>
								<input type="password" class="form-control" id="passwordLogin" />
								<br>
								<button type="button" class="btn btn-primary" data-dismiss="modal" id="loginModalBtn">Anmelden</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for register -->
		<!-- Erfolgsmeldung fehlt noch -->
		<div class="modal fade" id="ModalRegistrieren" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
						<h4 class="modal-title" id="meinModalLabel">Registrieren</h4>
					</div>
					<div class="modal-body">
						
						<form action="" id="form-direct-a">

							<label for="nameInput">Name</label>
							<input class="form-control" name="nameInput" id="inputName" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
			
						</form>
			
						<form action="" id="form-row">
							
							<div class="row form-group">
								<label for="mailInput">E-Mail-Adresse</label>
								<input class="form-control" name="mailInput" id="inputName" type="text" data-bvStrict="email" data-bvEmpty="@">
								<div class="help-block error-message">Dies ist keine E-Mail-Adresse</div>
							</div>
							
							<div class="row form-group">
								<label for="passwordInput">Passwort</label>
								<input class="form-control" name="passwordInput" id="inputPassword" type="password" data-bvStrict="reg:^.{5,}">
								<span class="help-block error-message">Passwort muss mindestens aus 5 Zeichen bestehen</span>
							</div>
							
							<div class="row form-group">
								<label for="passRepeatInput">Passwort wiederholen</label>
								<input class="form-control" name="passRepeatInput" id="inputPassRepeat" type="password" data-bvStrict="same:passwordInput">
								<span class="help-block error-message">Passwörter stimmen nicht überein</span>
							</div>
							
							<button type="submit" class="btn btn-primary">Registrieren</button>
							
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for info-site -->
		<div class="modal fade" id="ModalImpressum" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
						<h4 class="modal-title" id="meinModalLabel">Impressum</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<p>My Meta Maps wurde von Studenten des Instituts für Geoinformatik der WWU Münster entwickelt.<p>
								<p>Das Team besteht aus:</p>
								<ul class="list-group">
									<li class="list-group-item">
										Clara Rendel
										<a href="mailto:c_rend02@uni-muenster.de" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span></a>
									</li>
									<li class="list-group-item">
										Christopher Rohtermundt
										<a href="mailto:c_roht01@uni-muenster.de" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span></a>
									</li>
									<li class="list-group-item">
										Matthias Mohr
										<a href="mailto:m_mohr08@uni-muenster.de" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span></a>
									</li>
									<li class="list-group-item">
										Michael Rieping
										<a href="mailto:m_riep03@uni-muenster.de" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span></a>
									</li>
									<li class="list-group-item">
										Milan Köster
										<a href="mailto:m_koes18@uni-muenster.de" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span></a>
									</li>
								</ul>
							</div>
							<div class="form-group">
								<label >Lizenz</label>
								<p>Copyright 2014 C. Rendel, C. Rohtermundt, M. Mohr, M. Rieping, M. Köster</p>
								<p>Licensed under the Apache License, Version 2.0 (the "License");
								you may not use this file except in compliance with the License.
								You may obtain a copy of the License at <a href="http://www.apache.org/licenses/LICENSE-2.0">http://www.apache.org/licenses/LICENSE-2.0</a>.</p>
								<p>Unless required by applicable law or agreed to in writing, software
								distributed under the License is distributed on an "AS IS" BASIS,
								WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
								See the License for the specific language governing permissions and
								limitations under the License.</p>
							</div>
							<div class="form-group">
								<label>Adresse der öffentlichen Datenschnittstelle</label>
								<p>http://giv-geosoft2b.uni-muenster.de/mmm/api/v1/</p>
							</div>
							<div class="form-group">
								<label>Genutzte Bibliotheken</label>
								<ul class="list-group">
									<!-- Server -->
									<li class="list-group-item">
										<a href="http://laravel.com" target="_blank">Laravel</a>
									</li>
									<li class="list-group-item">
										<a href="http://www.webmapcenter.de/imp/webseite/" target="_blank">IMP - INSPIRE Metadata Parser</a>
									</li>
									<li class="list-group-item">
										<a href="http://www.easyrdf.org" target="_blank">EasyRDF</a>
									</li>
									<li class="list-group-item">
										<a href="https://github.com/indieweb/php-mf2" target="_blank">php-mf2</a>
									</li>
									<li class="list-group-item">
										<a href="https://geophp.net" target="_blank">GeoPHP</a>
									</li>
									<!-- Client -->
									<li class="list-group-item">
										<a href="http://getbootstrap.com" target="_blank">Bootstrap</a>
									</li>
									<li class="list-group-item">
										<a href="http://jquery.com" target="_blank">jQuery</a>
									</li>
									<li class="list-group-item">
										<a href="http://backbonejs.org" target="_blank">Backbone.js</a>
									</li>
									<li class="list-group-item">
										<a href="http://underscorejs.org" target="_blank">Underscore.js</a>
									</li>
									<li class="list-group-item">
										<a href="http://openlayers.org" target="_blank">OpenLayers</a>
									</li>
								</ul>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for user-help -->
		<div class="modal fade" id="ModalHilfe" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
						<h4 class="modal-title" id="meinModalLabel">Benutzerhilfe</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">

							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for comments -->
		<div class="modal fade" id="ModalKommentar" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
						<h4 class="modal-title" id="meinModalLabel">Kommentar erstellen</h4>
					</div>
					<div class="modal-body">
			
						<form action="" id="form-direct-b">

							<label for="titleInput">Titel</label>
							<input class="form-control" name="titleInput" id="inputTitle" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
							
							<!-- Füge was passendes in bvalidator.jquery.js hinzu, sodass es verplfichtend wird -->
							<label for="titleInput">URL*</label>
							<input class="form-control" name="URLInput" id="inputURL" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
							
							<!-- Füge was passendes in bvalidator.jquery.js hinzu, sodass es verplfichtend wird -->
							<!-- In textArea ändern -->
							<label for="titleInput">Freitext*</label>
							<input class="form-control" name="textInput" id="inputText" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
			
						</form>
						
						<div class="input select rating-f">
							<label for="example-i">Bewertung</label>
						    <select id="example-i" name="rating">
						    	<option value="1">1</option>
						        <option value="2">2</option>
						        <option value="3">3</option>
						        <option value="4">4</option>
						        <option value="5">5</option>
							</select>
						</div>
						
						<br>
						
						<form action="" id="form-row-other">
							
							<!-- Ändere in bvalidator.jquery.js '.validation(date) ... ', damit dies hier optional wird -->
							<div class="row form-group">
								<label for="startPointInput">Zeitpunkt - Start</label>
								<input class="form-control" name="startPointInput" id="inputStartPoint" type="text" data-bvStrict="date:dd-mm-yyyy" data-bvSwitch="dd-mm-yyyy">
								<div class="help-block error-message">Falsches Format</div>
							</div>
							
							<div class="row form-group">
								<label for="endPointInput">Zeitpunkt - Ende</label>
								<input class="form-control" name="endPointInput" id="inputEndPoint" type="text" data-bvStrict="date:dd-mm-yyyy" data-bvSwitch="dd-mm-yyyy">
								<div class="help-block error-message">Falsches Format</div>
							</div>
							
						</form>
							
						<button type="submit" class="btn btn-primary">Erstellen</button>
						
					</div>
					<div class="modal-footer">
						<div class="row clearfix">
							<div class="col-md-2 column">
								<label for="exampleInputEmail1">*Verpflichtend</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal for Users -->
		<div id="User">

		</div>

		<!-- Modals ending -->

		<!-- Load at the end to load the site faster -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		
		<!-- For formValidator-plugin -->
		<script type="text/javascript" src="plugins/jQuery-Plugin-For-Easy-Client-Side-Form-Validation-bValidator/bvalidator.jquery.js"></script>
		<script type="text/javascript" src="plugins/jQuery-Plugin-For-Easy-Client-Side-Form-Validation-bValidator/validator-views.js"></script>
		<script type="text/javascript" src="plugins/jQuery-Plugin-For-Easy-Client-Side-Form-Validation-bValidator/magic.js"></script>

	</body>

</html>