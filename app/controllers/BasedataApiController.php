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
	
	public function getDoc($page) {
		// $page is checked in routes file for being only alphanumeric with dashes
		return View::make("pages.{$page}");
	}
	
	public function getConfig() {
		// Get config
		$config = array(
			'debug' => Config::get('app.debug'),
			'locale' => Language::current(),
			'datepicker' => array(
				'format' => Config::get('view.datepicker.format'),
			),
			'datatypes' => array()
		);
		foreach (\GeoMetadata\GmRegistry::getServices() as $service) {
			$config['datatypes'][$service->getCode()] = $service->getName();
		}
		// Load Language phrases
		$phrases = Lang::getLoader()->load($config['locale'], 'client');
		// Build JavaScript
		$js = 'var config = ' . json_encode($config) . ';' . PHP_EOL;
		$js .= 'var phrases = ' . json_encode($phrases) . ';';
		return Response::make($js);
	}
	
}
