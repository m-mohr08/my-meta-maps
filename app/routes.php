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
Route::get('/', function() {
	return View::make('frontpage');
});

// Permalink for search
Route::get('/search/{hash}', function($hash) {
	App::abort(501);
});

// Permalink for geo data set and comments
Route::group(array('prefix' => '/geodata'), function() {
	// Permalink for all comments of a geo data set
	Route::get('/{geodata}/', function($geodata) {
		App::abort(501);
	});

	// Permalink for specific comment of a geo data set
	Route::get('/{geodata}/comment/{comment}', function($geodata, $comment) {
		App::abort(501);
	});
});


// Permalink for search
Route::get('/language/{language}', function($language) {
	App::abort(501);
});

// External API
Route::get('/api/v1/search', function() {
	App::abort(501);
});

// Internal API for backbone communication
Route::group(array('prefix' => '/api/internal'), function() {

	// Authentification: login, logout, password reset, register
	Route::group(array('prefix' => '/auth'), function() {
		// TODO
	});

	// User related tasks
	Route::group(array('prefix' => '/user'), function() {
		// TODO
	});

	// Get language files
	Route::get('/language/{language}', function($language) {
		App::abort(501);
	});

	// Get basemaps
	Route::get('/basemaps', function() {
		App::abort(501);
	});

	// Geodata related stuff
	Route::group(array('prefix' => '/geodata'), function() {
		// TODO
	});

	// Geodata related stuff
	Route::get('/doc/{page}', function($page) {
		// Todo: return as JSON
		return View::make("pages.{$page}");
	})->where('page', '[\w\d-]+');
});
