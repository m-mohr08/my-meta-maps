<div class="modal fade" id="ModalUserAccountPassword" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form class="modal-content" id="form-changePassword" onsubmit="return false">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('client.close')</span></button>
				<h4 class="modal-title" id="meinModalLabel">@lang('misc.pwchange')</h4>
			</div>

			@if(Auth::user())
			
			<div class="modal-body">
					
				@if(Auth::user()->password !== null)
				<div class="row form-group form-group-marginSides">
					<label for="old_password">@lang('misc.oldpw')</label>
					<input class="form-control" name="old_password" id="inputChangeOldPassword" type="password">
					<div class="error-message"></div>
				</div>
				@endif

				<div class="row form-group form-group-marginSides">
					<label for="password">@lang('misc.newpw')</label>
					<input class="form-control" name="password" id="inputChangePassword" type="password">
					<div class="error-message"></div>
				</div>

				<div class="row form-group form-group-marginSides">
					<label for="password_confirmation">@lang('misc.pwagain')</label>
					<input class="form-control" name="password_confirmation" id="inputChangePasswordRepeat" type="password">
					<div class="error-message"></div>
				</div>
				
			</div>
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="changePasswordBtn">@lang('misc.save')</button>
				<div class="modal-progress"></div>
			</div>

			@else
			<div class="modal-body">
				<div class="row form-group form-group-marginSides">
					@lang('misc.loginAgain')
				</div>
			</div>
			@endif
			
		</form>
	</div>
</div>