@if(Auth::user()->oauth)
<div class="row form-group form-group-marginSides alert alert-info">
	<strong>@lang('misc.hint')</strong> @lang('misc.extAuth')
</div>
@endif