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

class OgcSensorObservationService extends OgcWebServicesCommon {

	public function getSupportedNamespaces() {
		return 'http://www.opengis.net/sos/1.0';
	}

	public function getName() {
		return 'OGC SOS';
	}

	public function getCode() {
		return 'sos';
	}
	
	protected function parseBeginTime() {
		return $this->parseTime('beginTime', function($a, $b) { return $a < $b; } );
	}

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
	
	protected function findLayerNodes() {
		return $this->selectMany(array('sos:Contents', 'sos:ObservationOfferingList', 'sos:ObservationOffering'), null, false);
	}
	
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
		$gmlNs = $this->getNamespace('gml');
		$gmlNode = $node->children($gmlNs);
		if (!empty($gmlNode->boundedBy)) { // boundedBy
			$bbNode = $gmlNode->boundedBy->children($gmlNs);
			if (!empty($bbNode->Envelope)) { // Envelope
				$envelopeAttrs = $this->selectAttributes($bbNode->Envelope); // Seems we don't need a ns prefix here
				$envNode = $bbNode->Envelope->children($gmlNs);
				if (!empty($envNode->lowerCorner) && !empty($envNode->upperCorner)) { // lower/upperCorner
					$crs = isset($envelopeAttrs['srsName']) ? $envelopeAttrs['srsName'] : '';
					return $this->parseCoords(strval($envNode->lowerCorner), strval($envNode->upperCorner), $crs, false, true); // Reverse axis order in GML
				}
			}
		}
		return null;
	}

}
