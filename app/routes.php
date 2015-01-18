<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

// Redirect to the language version currently chosen
Route::get('/', function() {
	return Redirect::to('/' . Language::current());
});

// Frontpage in the language chosen
Route::get('/{language}', 'HomeController@getFrontpage')->where('language', '[a-z]{2}');

Route::any('auth/social/{strategy}/{action?}', ['as' => 'auth.social', function ($strategy, $action = 'request') {
	$app = app('opauth');
	if ($strategy == 'callback') {
		$c = new HomeController();
		return $c->oauth($app);
	}
	else {
		$app->run();
	}
}])->where(['strategy' => '.*']);

// Permalink for geo data set and comments
Route::group(array('prefix' => '/geodata'), function() {

	// Permalink for all comments of a geo data set
	Route::get('/{geodata}', 'HomeController@getGeodata');

	// Permalink for specific comment of a geo data set
	Route::get('/{geodata}/comment/{comment}', 'HomeController@getComment');

	// Permalink for search
	Route::get('/search/{hash}', 'HomeController@getSearch');

});

// External API
Route::get('/api/v1/search', 'ExternalApiController@getSearchApi');

// Internal API for backbone communication
Route::group(array('prefix' => '/api/internal'), function() {

	// Geodata related stuff
	Route::get('/doc/{page}', 'BasedataApiController@getDoc')->where('page', '[\w\d-]+');

	// Get language files
	Route::get('/config', 'BasedataApiController@getConfig');

	// All user based things, like authentification, registering, changing data, ...
	Route::group(array('prefix' => '/user'), function() {
		
		// Login
		Route::post('/login/{method}', 'UserApiController@postLogin');
		
		// Logout
		Route::get('/logout', 'UserApiController@getLogout');
		
		// Logout
		Route::get('/keepalive', 'UserApiController@getKeepalive');

		// Logout
		Route::post('/register', 'UserApiController@postRegister');

		// Change user data
		Route::post('/change/{what}', 'UserApiController@postChange');

		// Check user data
		Route::post('/check', 'UserApiController@postCheck');
		
		Route::group(array('prefix' => '/remind'), function() {
		
			// Remind/Reset password
			Route::post('/request', 'UserApiController@postRemindRequest');

			// Remind/Reset password
			Route::post('/reset', 'UserApiController@postRemindReset');
		
		});
		
	});

	// Geodata related stuff
	Route::group(array('prefix' => '/geodata'), function() {
	
		// Add geodata / comment
		Route::post('/{id}/comments', 'GeodataApiController@postComments')->where('id', '\d+');
		
		// Add geodata / comment
		Route::post('/add', 'GeodataApiController@postAdd');

		// Parse metadata
		Route::post('/metadata', 'GeodataApiController@postMetadata');

		// Get list of geodata
		Route::post('/list', 'GeodataApiController@postList');

		// Add geodata / comment
		Route::post('/keywords', 'GeodataApiController@postKeywords');
		
		// Permalinks for search
		Route::group(array('prefix' => '/search'), function() {

			// Save search
			Route::post('/save', 'GeodataApiController@postSearchSave');

			// Load search
			Route::get('/load/{id}', 'GeodataApiController@getSearchLoad');
			
		});

	});

});
