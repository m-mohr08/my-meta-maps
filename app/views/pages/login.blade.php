<div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form class="modal-content" id="form-login" onsubmit="return false">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('client.close')</span></button>
				<h4 class="modal-title" id="meinModalLabel">@lang('misc.login')</h4>
			</div>
			
			<div class="modal-body">
					
				<div class="row form-group form-group-marginSides">
					<label for="identifier">@lang('misc.mailname')</label>
					<input class="form-control" name="identifier" id="inputUsername" type="text">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="password">@lang('misc.pw')</label>
					<input class="form-control" name="password" id="inputPasswordLogin" type="password">
					<span class="error-message"></span>
				</div>

				<div class="row checkbox form-group-marginSides">
					<label for="remember">
						<input type="checkbox" name="remember" id="remember"> @lang('misc.stay')
					</label>
				</div>

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="loginBtn">@lang('misc.login')</button>
				<div class="modal-progress"></div>
			</div>

		</form>
	</div>
</div>