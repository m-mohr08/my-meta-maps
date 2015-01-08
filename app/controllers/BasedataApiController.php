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
 * This controller handles the internal API requests related to the basedata of the app, like language phrases, basemaps and html documents/pages.
 * Request is always a GET request. Reponse can be either JSON or HTML based.
 */
class BasedataApiController extends BaseApiController {
	
	public function getBasemaps() {
		$basemaps = Basemap::active()->get(array('url', 'name'));
		$json = array(
			'basemaps' => $basemaps
		);
		return $this->getJsonResponse($json);
	}
	
	public function getDoc($page) {
		// $page is checked in routes file for being only alphanumeric with dashes
		return View::make("pages.{$page}");
	}
	
	public function getLanguage($language) {
		if (!Language::valid($language)) {
			return $this->getNotFoundResponse();
		}
		$loader = Lang::getLoader();
		$phrases = $loader->load($language, 'client');
		if (empty($phrases)) {
			return $this->getNotFoundResponse();
		}
		else {
			// Set the current language to the one requested
			Language::change($language);
			// Return the language
			$json = array(
				'language' => $language,
				'phrases' => $phrases
			);
			return $this->getJsonResponse($json);
		}
	}
	
}
