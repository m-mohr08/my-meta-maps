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

namespace GeoMetadata\Service;

class OgcWebServicesContext extends OgcWebServices {

	public function getName() {
		return 'OGC OWS Context';
	}

	public function getCode() {
		return 'owc';
	}

	public function getSupportedNamespaceUri() {
		return 'http://www.opengis.net/owc/1.0';
	}

	protected function parseAbstract() {
		
	}

	protected function parseAuthor() {
		
	}

	protected function parseBeginTime() {
		
	}

	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		
	}

	protected function parseCopyright() {
		
	}

	protected function parseEndTime() {
		
	}

	protected function parseKeywords() {
		
	}

	protected function parseLanguage() {
		
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		
	}

	protected function parseLicense() {
		
	}

	protected function parseTitle() {
		
	}

}