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

// Frontpage
Route::get('/', 'HomeController@showFrontpage');

// Permalink for search
Route::get('/search/{hash}', 'HomeController@showSearch');

// Permalink for geo data set and comments
Route::group(array('prefix' => '/geodata'), function() {

	// Permalink for all comments of a geo data set
	Route::get('/{geodata}/', 'HomeController@showGeodata');

	// Permalink for specific comment of a geo data set
	Route::get('/{geodata}/comment/{comment}', 'HomeController@showComment');

});

// External API
Route::get('/api/v1/search', function() {
	// TODO: Implement external API
});

// Internal API for backbone communication
Route::group(array('prefix' => '/api/internal'), function() {

	// Get basemaps
	Route::get('/basemaps', 'BasedataApiController@getBasemaps');

	// Geodata related stuff
	Route::get('/doc/{page}', 'BasedataApiController@getDoc')->where('page', '[\w\d-]+');

	// Get language files
	Route::get('/language/{language}', 'BasedataApiController@getLanguage')->where('language', '[a-z]{2}'); // TODO: Are those regexp case insensitive?

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
		Route::post('/check/{what}', 'UserApiController@postCheck');
		
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
		Route::get('/{id}/comments', 'GeodataApiController@getComments')->where('id', '\d+');
		
		// Add geodata / comment
		Route::post('/add', 'GeodataApiController@postAdd');

		// Parse metadata
		Route::post('/metadata', 'GeodataApiController@postMetadata');

		// Get list of geodata
		Route::post('/list/{junk?}', 'GeodataApiController@postList')->where('junk', '(|junk)');

		// Add geodata / comment
		Route::post('/keywords', 'GeodataApiController@postKeywords');
		
		// Permalinks for search
		Route::group(array('prefix' => '/search'), function() {

			// Save search
			Route::post('/save', 'GeodataApiController@postSearchSave');

			// Load search
			Route::post('/load/{id}', 'GeodataApiController@getSearchLoad');
			
		});

	});

});
