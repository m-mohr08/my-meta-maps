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

class OgcWebServicesCommon extends OgcWebServices {
	
	public function getName() {
		return 'OGC OWS Common';
	}

	public function getCode() {
		return 'ows';
	}

	public function getNamespaceUri() {
		return $this->getOwsNamespaceUri();
	}

	protected function getOwsNamespaceUri() {
		return array('http://www.opengis.net/ows/1.0', 'http://www.opengis.net/ows/1.1');
	}

	public function verify($source) {
		return (parent::verify($source) && $this->checkServiceType());
	}
	
	protected function checkServiceType() {
		$docCode = $this->selectOne(array('ServiceIdentification', 'ServiceType'));
		$parserCode = preg_quote($this->getCode(), '~');
		return (preg_match('~^\s*(OGC[:\s]?)?'.$parserCode.'\s*$~i', $docCode) == 1); // There might be a "OGC" prefix in front in some implementations.
	}

	protected function parseAbstract() {
		return $this->selectOne(array('ServiceIdentification', 'Abstract'));
	}

	protected function parseAuthor() {
		return $this->selectHierarchyAsOne(array('ServiceProvider'), $this->getOwsNamespaceUri());
	}

	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		// TODO
//		$model->createBoundingBox($west, $north, $east, $south);
//		$this->selectOne(array('DatasetDescriptionSummary', 'WGS84BoundingBox'));
	}

	protected function parseCopyright() {
		return null; // Not supported
	}

	protected function parseBeginTime() {
		return null; // Not supported
	}

	protected function parseEndTime() {
		return null;
	}

	protected function parseKeywords() {
		return $this->selectMany(array('ServiceIdentification', 'Keywords', 'Keyword'));
	}

	protected function parseLanguage() {
		// Language tag can appear in several areas, just try to parse one of them...
		// The format of this language tag is according to RFC 4646. We expect ISO 639-1, which is not always compatible.
		// TODO: We need to implement a conversion for the language from RFC 4646 to ISO 639-1 and we might need to check where the language really is located.
		return $this->selectOne(array('Language'));
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		// TODO
	}

	protected function parseLicense() {
		$license = $this->selectOne(array('ServiceIdentification', 'AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	protected function parseTitle() {
		return $this->selectOne(array('ServiceIdentification', 'Title'));
	}

}