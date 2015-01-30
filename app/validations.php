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

// First paramter: Geometry format, e.g. wkt, kml, geojson, ... (see GeoPHP for format adapters)
// Secong paremter: Geometry type, e.g. Polygon, Point, ... (see GeoPHP for Geometry classes)
Validator::extend('geometry', function($attribute, $value, $parameters) {
	if (empty($parameters[0])) {
		$parameters[0] = 'wkt';
	}
	if (empty($parameters[1])) {
		$parameters[1] = 'Geometry';
	}
	try {
		$result = geoPHP::load($value);
		return is_a($result, $parameters[1]);
	} catch (Exception $e) {
		Log::debug($e);
		return false;
	}
});

Validator::extend('date8601', function($attribute, $value, $parameters) {
	return isIso8601Date($value);
});

/**
 * Checks whether the date is compatible to ISO 8601 standard or not.
 * 
 * @param string $value Value to check against ISO 8601.
 * @return boolean
 */
function isIso8601Date($value) {
	// regexp taken from https://gist.github.com/philipashlock/8830168
	$regexp = '/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/';
	return (preg_match($regexp, $value) === 1);
}