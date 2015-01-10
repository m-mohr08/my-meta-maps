<div class="modal fade" id="ModalRegister" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Registrieren</h4>
			</div>
			<div class="modal-body">
			
				<form id="form-register" onsubmit="return false">
							
					<div class="row form-group form-group-marginSides">
						<label for="name">Benutzername</label>
						<input class="form-control" name="name" id="inputNameForRegister" type="text" onchange="userCheckDataController(new UserCheckData(), 'inputNameForRegister', 'name')">
						<div class="error-message"></div>
					</div>
							
					<div class="row form-group form-group-marginSides">
						<label for="email">E-Mail-Adresse</label>
						<input class="form-control" name="email" id="inputMailForRegister" type="text" placeholder="@" onchange="userCheckDataController(new UserCheckData(), 'inputMailForRegister', 'email')">
						<div class="error-message"></div>
					</div>
					
					<div class="row form-group form-group-marginSides">
						<label for="password">Passwort</label>
						<input class="form-control" name="password" id="inputPasswordRegister" type="password">
						<span class="error-message"></span>
					</div>
							
					<div class="row form-group form-group-marginSides">
						<label for="password_confirmation">Passwort wiederholen</label>
						<input class="form-control" name="password_confirmation" id="inputPasswordRepeat" type="password">
						<span class="error-message"></span>
					</div>
						
					<button type="submit" class="btn btn-primary" id="registerBtn">Registrieren</button>
							
				</form>
						
			</div>
		</div>
	</div>
</div>