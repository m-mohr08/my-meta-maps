<!DOCTYPE html>
<html lang="de">
	
	<head>

		<title>My Meta Maps</title>
		
		<base href="http://giv-geosoft2b.uni-muenster.de/mmm_dev/"> <!-- Do it in a generic way -->

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<link rel="shortcut icon" href="#"> <!-- Hier können wir noch ein Schortcut unseres Logo hinzufügen -->

	</head>

	<body>

		<!-- Navbar - beginning -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- Div/row for navbar-header - beginning -->
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="navbar-header">
						<a class="navbar-brand">
							<img src="img/logo.png">
						</a>
						<b class="navbar-text">My Meta Maps</b> 
					</div>	
					<!-- Div/row for navbar-collapse - beginning -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<!-- Unordered list for navbar-header of navbar-collapse - beginning -->
						<ul class="nav navbar-nav navbar-header">
							<a class="navbar-brand" href="#">
								<img src="img/flags/en.png">
							</a>
							<a class="navbar-brand" href="#">
								<img src="img/flags/de.png">
							</a>
							</a>
							<a class="navbar-brand" href="#">
								<img src="img/flags/nl.png">
							</a>
						</ul>
						<!-- Unordered list for navbar-header of navbar-collapse - ending -->
						<!-- Unordered list for navbar-left of navbar-collapse - beginning -->
						<ul class="nav navbar-nav navbar-left">
							<form class="navbar-form navbar-left">
								<button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#ModalHilfe" id="helpBtn"> ? </button>&nbsp;
							</form>
						</ul>
						<!-- Unordered list for navbar-left of navbar-collapse - ending -->
						<!-- Unordered list for navbar-right of navbar-collapse - beginning -->
						<ul class="nav navbar-nav navbar-right">
							<form class="navbar-form navbar-left">
								<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ModalKommentar" id="commentBtn"> Kommentar erstellen &nbsp;
									<span class="glyphicon glyphicon-plus-sign"></span>
								</button>
							</form>
							<form class="navbar-form navbar-left">
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-default disabled"> <span class="glyphicon glyphicon-user"></span>&nbsp; Account </button>&nbsp;
									<button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#ModalAnmelden" id="loginBtn"> Anmelden &nbsp;
										<span class="glyphicon glyphicon-log-in"></span>
									</button>
								</div>
							</form>
							<form class="navbar-form navbar-left">
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#ModalRegistrieren" id="registerBtn"> Registrieren&nbsp;
										<span class="glyphicon glyphicon-edit"></span>
									</button>
								</div>
							</form>	
						</ul>
						<!-- Unordered list for navbar-right of navbar-collapse - ending -->
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
				Klicke oben auf <button type="submit" class="btn-sm btn-warning disabled"> ? </button>&nbsp; für weitere Informationen
			</div>
			<!-- Div for the alert for user-help - ending -->
			
			<!-- Div for the filters - beginning -->
			<div class="row clearfix">
				<div class="col-md-3 column">
					<div class="input-group">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Räumlicher Filter <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Auswahl</a></li>
							</ul>
						</div>
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
					<div class="input-group">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Numerischer Filter <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Slider</a></li>
							</ul>
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
			</div>
			<!-- Div for the filters - beginning -->
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
						Kommentare mit ...
					</h3>
					<br>
					<div>
						<div class="row clearfix">
							<div class="col-md-12 column">
								<div class="tabbable" id="tabs-664988">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#commentWithGeo" data-toggle="tab">.. räumlichen Bezug</a>
										</li>
										<li>
											<a href="#commentWithOutGeo" data-toggle="tab">... ohne räumlichen Bezug</a>
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
					<li>
						<a href="https://github.com/m-mohr/my-meta-maps" target="_blank">GitHub-Projekt</a>
					</li>
					<li>
						<a href="www.icondrawer.com " target="_blank">icondrawer.com</a>
					</li>
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
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" id="loginModalBtn">Anmelden</button>
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
						<form role="form">
							<div class="form-group">
								<label>Benutzername (optional)</label>
								<input type="text" class="form-control" id="usernameRegister" />
							</div>
							<div class="form-group">
								<label>Email-Adresse</label>
								<input type="email" class="form-control" id="mailAdress" />
							</div>
							<div class="form-group">
								<label>Passwort</label>
								<input type="password" class="form-control" id="passwordRegister" />
							</div>
							<div class="form-group">
								<label>Passwort wiederholen</label>
								<input type="password" class="form-control" id="passwordRepeat" />
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="registerModalBtn">Registrieren</button>
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
								<label>Team-Name</label>
								 <p>My Meta Maps wurde von Studenten des Instituts für Geoinformatik der WWU Münster entwickelt.<p>
                                 <p>Das Team besteht aus:</p>
                                 <ul class="list-group">
                                     <li class="list-group-item">Clara Rendel</li>
                                     <li class="list-group-item">Michael Rieping</li>
                                     <li class="list-group-item">Christopher Rohtermundt</li>
                                     <li class="list-group-item">Milan Köster</li>
                                     <li class="list-group-item">Matthias Mohr</li>
                                 </ul>
							</div>
							<div class="form-group">
								<label >Lizenzen</label>
								<ul class="list-group">
									<li class="list-group-item">...</li>
								</ul>
							</div>
							<div class="form-group">
								<label >Adresse der öffentliche Datenschnittstelle</label>
								<p>...</p>
							</div>
							<div class="form-group">
								<label >Genutzte Bibliotheken</label>
								<ul class="list-group">
									<li class="list-group-item">
										<a href="http://getbootstrap.com/" target="_blank">Bootstrap</a>
									</li>
									<li class="list-group-item">
										<a href="http://jquery.com/" target="_blank">JQuery</a>
									</li>
									<li class="list-group-item">
										<a href="http://backbonejs.org/" target="_blank">Backbone.js</a>
									</li>
									<li class="list-group-item">
										<a href="http://underscorejs.org/" target="_blank">Underscore.js</a>
									</li>
									<li class="list-group-item">
										<a href="http://openlayers.org/" target="_blank">OpenLayers</a>
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
						<form role="form">
							<div class="form-group">
								<label>URL des Geodatensatzes*</label>
								<input type="url" class="form-control" id="geoURL" />
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Freitext*</label>
								<br>
								<form action="textarea.htm">
									<textarea name="user_eingabe" cols="75" rows="10"></textarea> <!-- Größe muss noch angepasst werden -->
								</form>
							</div>
							<div class="btn-group" id="ratingModal"> <!-- Sterne dienen nur als Platzhalter -->
								<label for="exampleInputEmail1">Bewertung (optional)</label>
								<br>
								<button type="submit" class="btn-sm btn-primary"><span class="glyphicon glyphicon-star-empty"></span>&nbsp; </button>
								<button type="submit" class="btn-sm btn-primary"><span class="glyphicon glyphicon-star-empty"></span>&nbsp; </button>
								<button type="submit" class="btn-sm btn-primary"><span class="glyphicon glyphicon-star-empty"></span>&nbsp; </button>
								<button type="submit" class="btn-sm btn-primary"><span class="glyphicon glyphicon-star-empty"></span>&nbsp; </button>
								<button type="submit" class="btn-sm btn-primary"><span class="glyphicon glyphicon-star-empty"></span>&nbsp; </button>						
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div class="row clearfix">
							<div class="col-md-2 column">
								<label for="exampleInputEmail1">*Verpflichtend</label>
							</div>
							<div class="col-md-10 column">
								<button type="button" class="btn btn-primary" >Erstellen</button>
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

	</body>

</html>