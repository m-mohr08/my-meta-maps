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

class Kml extends XmlParser {
	
	use Traits\HttpGetTrait;

	public function getCode() {
		return 'kml';
	}

	public function getName() {
		return 'KML';
	}

	public function getServiceUrl($url) {
		return $url;
	}

	public function getMetadataUrl($url) {
		return $url;
	}

	protected function getSupportedNamespaces() {
		return array('http://www.opengis.net/kml/2.2');
	}

	protected function registerNamespaces() {
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // KML
	}
	
	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		// TODO: Implementation
	}

}