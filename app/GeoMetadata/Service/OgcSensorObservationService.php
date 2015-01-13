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
	
	private $gmlNsPrefix;
	private $sosNsPrefix;

	public function getSupportedNamespaceUri() {
		return 'http://www.opengis.net/sos/1.0';
	}

	public function getName() {
		return 'OGC SOS';
	}

	public function getCode() {
		return 'sos';
	}
	
	protected function parseBeginTime() {
		return $this->parseTime('beginTime');
	}

	protected function parseEndTime() {
		return $this->parseTime('endTime');
	}
	
	private function parseTime($key) {
		$result = null;
		foreach($this->getContents() as $content) {
			$time = $content->getData($key);
			if ($time !== null && ($result === null || $time > $result)) {
				$result = $time;
			}
		}
		return $result;
	}
	
	protected function findLayerNodes() {
		return $this->selectMany(array('Contents', 'ObservationOfferingList', 'ObservationOffering'), null, false, $this->sosNsPrefix, true);
	}
	
	protected function parseContents() {
		// Some server use a prefix without specifying it, so we take 'sos' as default.
		$this->sosNsPrefix = $this->getUsedNamespacePrefix($this->getUsedNamespaceUri(), 'sos');
		$this->gmlNsPrefix = $this->getUsedNamespacePrefix('http://www.opengis.net/gml', 'gml');
		
		return parent::parseContents();
	}
	
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$gmlAttributes = $this->getAttrsAsArray($node, $this->gmlNsPrefix, true);
		return empty($gmlAttributes['id']) ? null : $gmlAttributes['id'];
	}
	
	protected function parseTitleFromContents(\SimpleXMLElement $node) {
		$gmlNode = $node->children($this->gmlNsPrefix, true);
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
	
	protected function parseExtraDataFromContente(\SimpleXMLElement $node) {
		$sosNode = $node->children($this->sosNsPrefix, true);
		$data = array();
		// Time
		if (!empty($sosNode->time)) {
			// GML is a nuightmare. Let's do some regexp instead to parse some common formats.
			$xml = $sosNode->time->asXml();
			$regexNs = preg_quote($this->gmlNsPrefix, '~');
			foreach(array('begin', 'end') as $when) {
				$regexp = "<(({$regexNs}:)?TimePeriod)>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g3>)\s*)*<(\g2{$when}(?:Position)?)>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g5>)\s*|\s*<[^/>]+>\s*)*([^<>\s]+(?:[T\s][^<>\s]+)?)\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g7>)\s*|\s*</[^>]+>\s*)*</\g4>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g8>)\s*)*</\g1>";
				if (preg_match("~{$regexp}~is", $xml, $matches) && isIso8601Date($matches[6])) {
					$data[$when . 'Time'] = new \Carbon\Carbon($matches[6]);
				}
			}
		}
		return $data;
	}
	
	protected function parseBoundingBoxFromContents(\SimpleXMLElement $node) {
		$gmlNode = $node->children($this->gmlNsPrefix, true);
		if (!empty($gmlNode->boundedBy)) {
			$bbNode = $gmlNode->boundedBy->children($this->gmlNsPrefix, true);
			if (!empty($bbNode->Envelope)) {
				$envelopeAttrs = $this->getAttrsAsArray($bbNode->Envelope); // Seems we don't need a ns prefix here
				if (isset($envelopeAttrs['srsName']) && $this->isWgs84($envelopeAttrs['srsName'])) {
					$envNode = $bbNode->Envelope->children($$this->gmlNsPrefix, true);
					if (!empty($envNode->lowerCorner) && !empty($envNode->upperCorner)) {
						return $this->parseCoords(strval($envNode->lowerCorner), strval($envNode->upperCorner));
					}
				}
			}
		}
		return null;
	}

}
