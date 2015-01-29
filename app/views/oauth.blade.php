@if(Config::get("laravel-opauth::enable"))
<div class="row form-group form-group-marginSides col-md-12">
	@if(Config::get("laravel-opauth::opauth.Strategy.Facebook.app_id"))
	<div class="col-md-3"><a href="/auth/social/facebook" class="btn btn-social btn-facebook">Facebook</a></div>
	@endif
	@if(Config::get("laravel-opauth::opauth.Strategy.GitHub.client_id"))
	<div class="col-md-3"><a href="/auth/social/github" class="btn btn-social btn-github">GitHub</a></div>
	@endif
	@if(Config::get("laravel-opauth::opauth.Strategy.Google.client_id"))
	<div class="col-md-3"><a href="/auth/social/google" class="btn btn-social btn-google">Google</a></div>
	@endif
	@if(Config::get("laravel-opauth::opauth.Strategy.Twitter.key"))
	<div class="col-md-3"><a href="/auth/social/twitter" class="btn btn-social btn-twitter">Twitter</a></div>
	@endif
</div>
<div class="row form-group form-group-marginSides col-md-12 divider-or">
	<hr><span>or</span>
</div>
@endif