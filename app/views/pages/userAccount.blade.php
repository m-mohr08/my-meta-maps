<div class="modal fade" id="ModalUserAccountGeneral" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form class="modal-content" id="form-changeGeneral" onsubmit="return false">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Profil ändern</h4>
			</div>
				
			@if(Auth::user())
			
			<div class="modal-body">

				<div class="row form-group form-group-marginSides">
					<label for="name">Benutzername</label>
					<input class="form-control" name="name" id="inputChangeUsername" type="text" value="{{{ Auth::user()->name }}}">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="email">E-Mail-Adresse</label>
					<input class="form-control" name="email" id="inputChangeMail" type="text" value="{{{ Auth::user()->email }}}">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="language">Sprache</label>
					<select class="form-control" name="language" id="inputChangeLanguage">
						@foreach (Language::listing() as $code => $name)
						<option value="{{ $code }}" @if(Language::is($code)) selected="selected" @endif >{{ $name }}</option>
						@endforeach
					</select>
					<div class="error-message"></div>
				</div>

			</div>
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="changeGeneralDataBtn">Speichern</button>
				<div class="modal-progress"></div>
			</div>

			@else
			<div class="modal-body">
				<div class="row form-group form-group-marginSides">
					Sie sind nicht mehr angemeldet. Bitte melden Sie sich erneut an, um Ihre Profildaten zu ändern.
				</div>
			</div>
			@endif
			
		</form>
	</div>
</div>