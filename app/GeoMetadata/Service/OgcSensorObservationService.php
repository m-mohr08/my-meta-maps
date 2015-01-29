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
 * Parser for OGC SOS.
 * Code: sos
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 */
class OgcSensorObservationService extends OgcWebServicesCommon {

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	public function getSupportedNamespaces() {
		return 'http://www.opengis.net/sos/1.0';
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'OGC SOS';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'sos';
	}

	/**
	 * Parses and returns the minimum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getBeginTime()
	 * @see \GeoMetadata\Model\Metadata::setBeginTime()
	 */
	protected function parseBeginTime() {
		return $this->parseTime('beginTime', function($a, $b) { return $a < $b; } );
	}

	/**
	 * Parses and returns the maximum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getEndTime()
	 * @see \GeoMetadata\Model\Metadata::setEndTime()
	 */
	protected function parseEndTime() {
		return $this->parseTime('endTime', function($a, $b) { return $a > $b; } );
	}
	
	private function parseTime($key, $comparator) {
		$result = null;
		foreach($this->getLayers() as $content) {
			if ($content instanceof \GeoMetadata\Model\ExtraDataContainer) {
				$time = $content->getData($key);
				if ($time !== null && ($result === null || call_user_func($comparator, $time, $result))) {
					$result = $time;
				}
			}
		}
		return $result;
	}

	/**
	 * Returns the node(s) that contain the data for the individual layers of the geo dataset.

	 * @return array Array containing SimpleXMLElement nodes
	 */
	protected function findLayerNodes() {
		return $this->selectMany(array('sos:Contents', 'sos:ObservationOfferingList', 'sos:ObservationOffering'), null, false);
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
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // SOS
		$this->registerNamespace('gml', 'http://www.opengis.net/gml'); // GML
	}
	
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$gmlAttributes = $this->selectAttributes($node, $this->getNamespace('gml'));
		return empty($gmlAttributes['id']) ? null : $gmlAttributes['id'];
	}
	
	protected function parseTitleFromContents(\SimpleXMLElement $node) {
		$gmlNode = $node->children($this->getNamespace('gml'));
		if (!empty($gmlNode->description)) {
			return $this->n2s($gmlNode->description);
		}
		else if (!empty($gmlNode->name)) {
			return $this->n2s($gmlNode->name);
		}
		else {
			return null;
		}
	}
	
	protected function parseExtraDataFromContents(\SimpleXMLElement $node) {
		$sosNode = $node->children($this->getNamespace('sos'));
		$data = array();
		// Time
		if (!empty($sosNode->time) && $sosNode->count() > 0) {
			foreach (array('begin', 'end') as $when) {
				$gmlNode = $sosNode->time->children($this->getNamespace('gml'));
				$position = $this->selectOne(array("gml:{$when}Position|gml:{$when}"), $gmlNode);
				if (isIso8601Date($position)) {
					$data[$when . 'Time'] = new \DateTime($position);
				}
			}
		}
		return $data;
	}
	
	protected function parseBoundingBoxFromContents(\SimpleXMLElement $node) {
		$list = array();
		$gmlNs = $this->getNamespace('gml');
		$gmlNode = $node->children($gmlNs);
		if (!empty($gmlNode->boundedBy)) { // boundedBy
			$bbNode = $gmlNode->boundedBy->children($gmlNs);
			if (!empty($bbNode->Envelope)) { // Envelope
				$envelopeAttrs = $this->selectAttributes($bbNode->Envelope); // Seems we don't need a ns prefix here
				$envNode = $bbNode->Envelope->children($gmlNs);
				if (!empty($envNode->lowerCorner) && !empty($envNode->upperCorner)) { // lower/upperCorner
					$crs = isset($envelopeAttrs['srsName']) ? $envelopeAttrs['srsName'] : '';
					$list[] = $this->parseCoords(strval($envNode->lowerCorner), strval($envNode->upperCorner), $crs, false, true); // Reverse axis order in GML
				}
			}
		}
		return $list;
	}

}
