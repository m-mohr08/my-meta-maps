<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

use \GeoMetadata\GmRegistry;

App::before(function($request)
{
	// Set the locale for all requests
	App::setLocale(Language::current());
	
	// Set the proxy for the default stream context to be used in OpAuth
	$proxy = Config::get('remote.proxy.host');
	if (!empty($proxy)) {
		stream_context_set_default(array(
			'http' => array(
				'proxy' => $proxy,
				'request_fulluri' => true
			)
		));
	}
	
	// Set up GeoMetadata
//	GmRegistry::registerService(new \GeoMetadata\Service\Kml());
	GmRegistry::registerService(new \GeoMetadata\Service\Microformats2());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcCatalogueService());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcWebCoverageService());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcWebFeatureService());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcSensorObservationService());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapService());
	GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapTileService());

	GmRegistry::setLogger(array('Log', 'debug'));
	GmRegistry::setProxy(Config::get('remote.proxy.host'), Config::get('remote.proxy.port'));
});

App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Dump database queries for debugging purposes
|--------------------------------------------------------------------------
*/
if (Config::get('database.debug')) {
	Event::listen('illuminate.query', function($sql){
		echo $sql . PHP_EOL;
	});
}