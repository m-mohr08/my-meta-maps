<div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Anmelden</h4>
			</div>
			
			<div class="modal-body">
						
				<form id="form-login" onsubmit="return false">
					
					<div class="row form-group form-group-marginSides">
						<label for="identifier">E-Mail-Adresse / Benuzername</label>
						<input class="form-control" name="identifier" id="inputUsername" type="text">
						<div class="error-message"></div>
					</div>
							
					<div class="row form-group form-group-marginSides">
						<label for="password">Passwort</label>
						<input class="form-control" name="password" id="inputPasswordLogin" type="password">
						<span class="error-message"></span>
					</div>
					
					<div class="row checkbox form-group-marginSides">
						<label for="remember">
							<input type="checkbox" name="remember" id="remember"> Angemeldet bleiben?
						</label>
					</div>
						
					<button type="submit" class="btn btn-primary" id="loginBtn">Anmelden</button>
							
				</form>
	
			</div>
		</div>
	</div>
</div>