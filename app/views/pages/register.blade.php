<div class="modal fade" id="ModalRegister" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form class="modal-content" id="form-register" onsubmit="return false">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('client.close')</span></button>
				<h4 class="modal-title" id="meinModalLabel">@lang('misc.register')</h4>
			</div>
			<div class="modal-body">
				
				@include('oauth')
							
				<div class="row form-group form-group-marginSides">
					<label for="name">@lang('misc.user')</label>
					<input class="form-control" name="name" id="inputNameForRegister" type="text" onchange="userCheckDataController(new UserCheckData(), 'inputNameForRegister', 'form-register', 'name')">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="email">@lang('misc.mail')</label>
					<input class="form-control" name="email" id="inputMailForRegister" type="text" placeholder="@" onchange="userCheckDataController(new UserCheckData(), 'inputMailForRegister', 'form-register', 'email')">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="password">@lang('misc.pw')</label>
					<input class="form-control" name="password" id="inputPasswordRegister" type="password">
					<span class="error-message"></span>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="password_confirmation">@lang('misc.pwagain')</label>
					<input class="form-control" name="password_confirmation" id="inputPasswordRepeat" type="password">
					<span class="error-message"></span>
				</div>
					
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="registerBtn">@lang('misc.register')</button>
				<div class="modal-progress"></div>
			</div>

		</form>
	</div>
</div>