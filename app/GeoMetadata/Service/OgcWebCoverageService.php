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

class OgcWebCoverageService extends OgcWebServicesCommon {
	
	public function getSupportedNamespaces() {
		return array('http://www.opengis.net/wcs/2.0', 'http://www.opengis.net/wcs/1.1.1', 'http://www.opengis.net/wcs/1.1');
	}
	
	protected function registerNamespaces() {
		$this->registerNamespace(parent::getCode(), parent::getUsedNamespace(parent::getSupportedNamespaces())); // OWS
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // WCS
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'OGC WCS';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'wcs';
	}
	
	protected function findLayerNodes() {
		return $this->selectMany(array('wcs:Contents', 'wcs:CoverageSummary'), null, false);
	}
	
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getNamespace('wcs'));
		if (!empty($children->CoverageId)) {
			return $this->n2s($children->CoverageId);
		}
		else if (!empty($children->Identifier)) {
			return $this->n2s($children->Identifier);
		}
		else {
			return null;
		}
	}

}