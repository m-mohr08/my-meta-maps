<?php
/* 
 * Copyright 2014/15 Matthias Mohr
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Language {
	
	// Don't translate this
	private static$list = array(
		'de' => 'Deutsch',
		'en' => 'English',
		'nl' => 'Nederlands'
	);
	
	public static function listing() {
		return self::$list;
	}
	
	public static function valid($code) {
		$code = strtolower($code);
		return isset(self::$list[$code]);
	}
	
	public static function is($code) {
		return (self::current() == strtolower($code));
	}
	
	public static function current() {
		$language = null;
		if (Auth::user() !== null) {
			$language = Auth::user()->language;
		}
		if ($language === null) {
			// Load language from session or default to default language of app.
			$language = Session::get('language', Config::get('app.locale'));
		}
		return strtolower($language);
	}
	
	public static function change($language) {
		if (!self::valid($language)) {
			return false;
		}
		if (Auth::user()) {
			$user = Auth::user();
			$user->language = strtolower($language);
			$user->save();
		}
		else {
			Session::put('language', strtolower($language));
		}
		App::setLocale($language);
		return true;
	}
	
}