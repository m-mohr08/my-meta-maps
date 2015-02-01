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

/**
 * Parser for OGC WMTS.
 * Code: wmts
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 */
class OgcWebMapTileService extends OgcWebServicesCommon {

	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * WMTS doesn't necessarily use the "normal" OGC way with '&request=GetCapabilities&servcie=wmts'.
	 * Therefore the capabilities xml file will be our url for metadata and service.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		return $url;
	}

	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url) {
		return $url;
	}

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	public function getSupportedNamespaces() {
		return 'http://www.opengis.net/wmts/1.0';
	}

	/**
	 * Define the namespaces you want to use in XPath expressions.
	 * 
	 * You should register all namespaces with a prefix using the registerNamespace() method.
	 * 
	 * @see XmlParser::registerNamespace()
	 */
	protected function registerNamespaces() {
		$this->registerNamespace(parent::getCode(), parent::getUsedNamespace(parent::getSupportedNamespaces())); // OWS
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // WMTS
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'OGC WMTS';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'wmts';
	}

	/**
	 * Returns the node(s) that contain the data for the individual layers of the geo dataset.

	 * @return array Array containing SimpleXMLElement nodes
	 */
	protected function findLayerNodes() {
		return $this->selectMany(array('wmts:Contents', 'wmts:Layer'), null, false);
	}

}