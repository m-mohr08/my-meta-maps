<?php

Validator::extend('checkHash', function($attribute, $value, $parameters) {
	if (!Hash::check($value, $parameters[0])) {
		return false;
	}
	return true;
});

Validator::extend('checkLanguage', function($attribute, $value, $parameters) {
	if (in_array($value, Config::get('app.locales'))) {
		return true;
	}
	return false;
});

