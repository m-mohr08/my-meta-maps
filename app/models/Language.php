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

/**
 * Class that handles general Language/I18N/I10N related tasks.
 */
class Language {
	
	// Don't translate this
	private static $list = array(
		'de' => 'Deutsch',
		'en' => 'English',
		'nl' => 'Nederlands'
	);
	
	/**
	 * Returns a list of supported languages.
	 * 
	 * ISO 639-1 code is used as key and the value is the language name in the corresponding language.
	 * 
	 * @return array
	 */
	public static function listing() {
		return self::$list;
	}
	
	/**
	 * Checks whether the given ISO 639-1 code is supported as traslation for this program.
	 * 
	 * @param string $code ISO 639-1 code
	 * @return boolean
	 */
	public static function valid($code) {
		$code = strtolower($code);
		return isset(self::$list[$code]);
	}
	
	/**
	 * Checks whether the currently chosen language is the specified language.
	 * 
	 * @param string $code ISO 639-1 code to check against the currently chosen language.
	 * @return boolean
	 */
	public static function is($code) {
		return (self::current() == strtolower($code));
	}
	
	/**
	 * Returns the currently chosen language as ISO 639-1 code.
	 * 
	 * @return string
	 */
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
	
	/**
	 * Changes the language for the currently active user to the language specified
	 * 
	 * For authenticated users the language is stored permanently. 
	 * For guests the langauge is stored for the session only.
	 * 
	 * @param type $language
	 * @return boolean true on success, false on failure.
	 */
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