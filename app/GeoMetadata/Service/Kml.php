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
 * Parser for KML.
 * Code: kml
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 */
class Kml extends XmlParser {
	
	const ATOM_NAMESPACE = 'http://www.w3.org/2005/Atom';
	const ATOM_PREFIX = 'atom';
	
	use Traits\HttpGetTrait, Traits\SimpleFillModelTrait;
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'kml';
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'KML';
	}
	
	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		return $url;
	}

	public function getMetadataUrl($url) {
		return $url;
	}

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	protected function getSupportedNamespaces() {
		return array('http://www.opengis.net/kml/2.2');
	}

	/**
	 * Define the namespaces you want to use in XPath expressions.
	 * 
	 * You should register all namespaces with a prefix using the registerNamespace() method.
	 * 
	 * @see XmlParser::registerNamespace()
	 */
	protected function registerNamespaces() {
		$this->registerNamespace(self::ATOM_PREFIX, self::ATOM_NAMESPACE); // Atom
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // KML
	}
	
	protected function parseAuthor() {
		// When the Atom namespace is not set we can't find the author
		$ns = $this->getUsedNamespace(self::ATOM_NAMESPACE);
		if (!empty($ns)) {
			return $this->selectOne(array('kml:Document', 'atom:author'));
		}
		else {
			return null;
		}
	}

	protected function parseAbstract() {
		return $this->selectOne(array('kml:Document', 'kml:description'));
	}

	protected function parseTitle() {
		return $this->selectOne(array('kml:Document', 'kml:name'));
	}

	protected function parseBoundingBox() {
		// There is no required bbox entry in KML, so we need to check several options
		// 1. LatLonBox
		// 2. LatLonAltBox
		// 3. <viewFormat>BBOX=[bboxWest],[bboxSouth],[bboxEast],[bboxNorth]</viewFormat>
		// TODO: Implementation for 1-3
		// 4. Iterate over all coordinates-nodes (which should work always, but could be quite slow)
		return $this->parseBoundingBoxFromCoordinates();
	}

	private function parseBoundingBoxFromCoordinates() {
		$bbox = array();
		$minx = null; // west
		$miny = null; // south
		$maxx = null; // east
		$maxy = null; // north
		$nodes = $this->selectMany(array('kml:coordinates'));
		foreach($nodes as $node) {
			$coordinates = preg_split('/\s+/', $node);
			foreach($coordinates as $coordinate) {
				$parts = explode(',', $coordinate);
				if(count($parts) >= 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
					// We ignore the altitude
					if ($minx === null || $parts[0] < $minx) {
						$minx = $parts[0];
					}
					if ($miny === null || $parts[1] < $miny) {
						$miny = $parts[1];
					}
					if ($maxx === null || $parts[0] > $maxx) {
						$maxx = $parts[0];
					}
					if ($maxy === null || $parts[1] > $maxy) {
						$maxy = $parts[1];
					}
				}
			}
		}
		if ($minx !== null && $miny !== null && $maxx !== null && $maxy !== null) {
			$bbox[] = $this->createBoundingBox($minx, $miny, $maxx, $maxy, 'EPSG:4326'); // KML is always WGS84
		}
		return $bbox;
	}
	
}