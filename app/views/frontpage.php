<!DOCTYPE html>
<html lang="de">

	<head>

		<title>My Meta Maps</title>
    
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
	    
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">

		<!-- For the Map -->
		<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
		<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
		<script src="js/mapscript.js" type="text/javascript"></script>
		<script src="css/mapstyle.css" type="text/css"></script>

		<!-- For formValidator-plugin -->
		<link href="js/plugins/formValidator/css/formValidator.css" rel="stylesheet">
		
		<!-- For the datePicker-plugin -->
		<link rel="stylesheet" href="js/plugins/datePicker/prettify.css">
	    <link rel="stylesheet" href="js/plugins/datePicker/datepicker.min.css">
	    <link rel="stylesheet" href="js/plugins/datePicker/docs.css">
	    
	    <!-- For barRating-plugin -->
	    <link href="js/plugins/barRating/css/rating-plugin.css" rel="stylesheet" type="text/css"/>
	    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" type="text/css"/>
	    
	    <!-- For barRating-plugin; loaded in header, otherwise it doesnt works -->
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	    <script type="text/javascript" src="js/plugins/barRating/jquery.barrating.js"></script>
    	<script type="text/javascript" src="js/plugins/barRating/rating-views.js"></script>

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
		
		<div class="buttons">
            <button class="blue-pill deactivated rating-enable" style="display: none;">enable</button>
        </div>
	
		<!-- Header - beginning --> 
		<!-- Müsste später durch ein template ersetzt werden, um Benutzerhilfe nur beim ersten Start anzuzeigen 
			und Einstellungen der Filter speichern zu können -->
		<header class="row clearfix" style="margin-left: 30px; margin-right: 30px">

			<!-- Div for the alert for user-help - beginning -->
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span>
				</button>
				<strong>Benutzerhilfe</strong> &nbsp; 
				Klicke oben auf <button type="submit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalHilfe" id="helpBtn"><span class="glyphicon glyphicon-question-sign"></span></button> für weitere Informationen
			</div>
			<!-- Div for the alert for user-help - ending -->

			<!-- Div for the filters - beginning -->
			<div class="row clearfix">
				<div class="col-md-3 column">
					<div class="input select rating-d">
						<select id="example-d" name="rating">
					 	   <option value="5">5</option>
						   <option value="10">10</option>
						   <option value="20">20</option>
						   <option value="50">50</option>
						   <option value="100">100</option>
						   <option value="200">200</option>
						   <option value="200">500</option>
						</select>
				    </div>
				</div>
				<div class="col-md-2 column">
					<div class="input select rating-f" style="margin-left: 12px">
			            <select id="example-f" name="rating">
			                <option value="1">1</option>
			                <option value="2">2</option>
			                <option value="3">3</option>
			                <option value="4">4</option>
			                <option value="5">5</option>
			            </select>
			        </div>
				</div>
				<div class="col-md-2 column">
			    	<div class="form-group">
			        	<div class="input-group">
			            	<input class="form-control" type="text" placeholder="Startzeitpunkt" datepicker data-trigger="#show-datepicker-start">
								<span id="show-datepicker-start" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			            </div>
			        </div> 
			    </div>
			    <div class="col-md-2 column">
			    	<div class="form-group">
			        	<div class="input-group">
			            	<input class="form-control" type="text" placeholder="Endzeitpunkt" datepicker data-trigger="#show-datepicker-end">
								<span id="show-datepicker-end" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			            </div>
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
			<!-- Div for the filters - beginning -->
			</div>
			<hr>		
		</header>
		<!-- Header - ending -->

		<!-- Section - beginning -->
		<!-- Müsste später durch ein template ersetzt werden -->
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
					    <li class="active"><a href="#commentWithGeo" data-toggle="tab">... mit räuml. Bezug</a></li>
					    <li><a href="#commentWithOutGeo" data-toggle="tab">... ohne räuml. Bezug</a></li>
					</ul>
					
					<div class="tab-content">
						<!-- Tab for comments with spatial reference -->		
						<div class="tab-pane active" id="commentWithGeo">
							<div style="overflow-y: auto; max-height: 400px">
								<div class="panel panel-primary">
									<!-- Unordered list for comments with spatial reference-->
									<!-- Durch template ersetzen -->
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
						<!-- Tab for comments with spatial reference -->
						<div class="tab-pane" id="commentWithOutGeo">
							<div class="tab-pane active" id="commentWithGeo">
								<div style="overflow-y: auto; max-height: 400px">
									<div class="panel panel-primary">
										<!-- Unordered list for comments -->
										<!-- Durch template ersetzen -->
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
											<li class="list-group-item">Geodatensatz xyz</li>
											<li class="list-group-item">Geodatensatz xyz</li>
											<li class="list-group-item">Geodatensatz xyz</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
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
		
		<div id="addCommentContainer">
			<!-- Has to be empty -->
		</div>
		
		<!-- Lässt sich dies irgendwie extrahieren ??? -->
		<script type="text/template" id="addCommentTemplate">
	 		 <!-- Modal for comments -->
			<div class="modal fade" id="ModalAddComment" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
							<h4 class="modal-title" id="meinModalLabel">Kommentar erstellen</h4>
						</div>
						
						<div class="modal-body">
							
							<form action="" id="form-direct-a">
	
								<label for="titleInput">Titel</label>
								<input class="form-control" name="titleInput" id="inputTitle" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
								
							</form>
											
							<form action="" id="form-row-adding">
								
								<div class="row form-group">
									<label for="URLInput">URL*</label>
									<input class="form-control" name="URLInput" id="inputURL" type="text" data-bvStrict="URL" data-bvSwitch="">
									<div class="help-block error-message">Bitte füge eine (valide) URL eines Geodatensatzes hinzu</div>
								</div>
								
								<div class="row form-group">
									<label for="textInput">Freitext*</label>
									<textarea class="form-control" rows="3" name="textInput" id="inputText" type="text" data-bvStrict="notEmpty" data-bvSwitch=""></textarea>
									<div class="help-block error-message">Bitte füge einen Freitext hinzu</div>
								</div>
					
							</form>
							
							<div class="input select rating-f">
								<label for="example-h">Bewertung</label>
							    <select id="example-h" name="rating">
							    	<option value="1">1</option>
							        <option value="2">2</option>
							        <option value="3">3</option>
							        <option value="4">4</option>
							        <option value="5">5</option>
								</select>
							</div>
							
							<br>
							
							<form action="" id="form-row-other">
								
								<div class="row form-group">
									<label for="startPointInput">Zeitpunkt - Start</label>
									<input class="form-control" name="startPointInput" id="inputStartPoint" type="text" data-bvStrict="date:dd-mm-yyyy|empty" data-bvSwitch="dd-mm-yyyy">
									<div class="help-block error-message">Falsches Format</div>
								</div>
								
								<div class="row form-group">
									<label for="endPointInput">Zeitpunkt - Ende</label>
									<input class="form-control" name="endPointInput" id="inputEndPoint" type="text" data-bvStrict="date:dd-mm-yyyy|empty" data-bvSwitch="dd-mm-yyyy">
									<div class="help-block error-message">Falsches Format</div>
								</div>
								
							</form>
								
							<button type="submit" class="btn btn-primary" id="addCommentBtn">Erstellen</button>&nbsp;&nbsp;&nbsp;
							<button type="submit" class="btn btn-info disabled" id="addedCommentBtn">Erstellten Kommentar anschauen</button>
							
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
		</script>

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
						
						<form action="" id="form-direct-b">
							<div class="row form-group">
								<label for="nameInput">Name</label>
								<input class="form-control" name="nameInput" id="inputName" type="text" data-bvStrict="true" data-bvTransform="noSpaces">
							</div>
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
							
						</form>
						
						<button type="submit" class="btn btn-primary">Registrieren</button>
						
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

		<!-- Modal for Users -->
		<div id="ModalUser">

		</div>

		<!-- Modals ending -->


		<!-- Load at the end to load the site faster -->
		
		<!-- Libaries (jQuery in head) -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>	
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone-min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
		
		<!-- For formValidator-plugin -->
		<script type="text/javascript" src="js/plugins/formValidator/bvalidator.jquery.js"></script>
		<script type="text/javascript" src="js/plugins/formValidator/validator-views.js"></script>
		
		<!-- For the datePicker-plugin -->
		<script type="text/javascript" src="js/plugins/datePicker/prettify.js"></script>
		<script type="text/javascript" src="js/plugins/datePicker/main.js"></script>
	    <script type="text/javascript" src="js/plugins/datePicker/datepicker.min.js"></script>
	    <script type="text/javascript" src="js/plugins/datePicker/datePicker-views.js"></script>
		
		<!-- Comment-MVC -->
		<script type="text/javascript" src="js/models/commentModel.js"></script>
		<script type="text/javascript" src="js/views/commentView.js"></script>
		<script type="text/javascript" src="js/controllers/commentController.js"></script>
		
		<script type="text/javascript" src="js/helpers.js"></script>

	</body>

</html>