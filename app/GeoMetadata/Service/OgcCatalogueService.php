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

class OgcCatalogueService extends CachedParser {
	
	use Traits\HttpGetTrait;

	// This is an XML based OGC service, but as we only query single datasets and not the
	// GetCapabilities and additionally use an external parser (IMP) we have such a difference in
	// the classes, that we extend CachedParser and not OGcWebServices this time.

	public function getName() {
		return 'OGC Catalogue Service';
	}

	public function getCode() {
		return 'csw';
	}

	protected function createParser($source) {
		// We don't use IMP class as we don't need the fancy JSON/PDF/HTML stuff, we just need plain PHP
		// and we get this straight from the parser. THis is nothing different from what IMP does directly.
		$parser = new Parser();
		try {
			return $parser->parseXML($source);
		} catch (Exception $e) {
			return null;
		}
	}

	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$records = $this->getParser();
		// TODO: Implementation
		dd($records);
	}

	public function getMetadataUrl($url) {
		return $url;
	}

	public function getServiceUrl($url) {
		return $url;
	}

}