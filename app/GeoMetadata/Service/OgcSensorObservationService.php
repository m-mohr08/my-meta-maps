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
		$beginTime = null;
		foreach($this->getContents() as $content) {
			if ($content['beginTime'] !== null && ($beginTime === null || $content['beginTime'] > $beginTime)) {
				$beginTime = $content['beginTime'];
			}
		}
		return $beginTime;
	}

	protected function parseEndTime() {
		$endTime = null;
		foreach($this->getContents() as $content) {
			if ($content['endTime'] !== null && ($endTime === null || $content['endTime'] > $endTime)) {
				$endTime = $content['endTime'];
			}
		}
		return $endTime;
	}
	
	protected function parseContents() {
		$data = array();

		// Some server use a prefix without specifying it, so we take 'sos' as default.
		$nsPrefix = $this->getUsedNamespacePrefix($this->getUsedNamespaceUri(), 'sos');
		$gmlNsPrefix = $this->getUsedNamespacePrefix('http://www.opengis.net/gml', 'gml');
		$nodes = $this->selectMany(array('Contents', 'ObservationOfferingList', 'ObservationOffering'), null, false, $nsPrefix, true);
		foreach($nodes as $node) {
			$gmlAttributes = $this->getAttrsAsArray($node, $gmlNsPrefix, true);
			$gmlNode = $node->children($gmlNsPrefix, true);
			$sosNode = $node->children($nsPrefix, true);
			
			// Title
			$title = null;
			if (!empty($gmlNode->description)) {
				$title = $this->n2s($gmlNode->description);
			}
			else if (!empty($gmlNode->name)) {
				$title = $this->n2s($gmlNode->name);
			}
			
			// Entry stub
			$entry = array(
				'id' => empty($gmlAttributes['id']) ? null : $gmlAttributes['id'],
				'title' => $title,
				'bbox' => array(),
				'beginTime' => null,
				'endTime' => null
			);

			// Bounding Box
			if (!empty($gmlNode->boundedBy)) {
				$bbNode = $gmlNode->boundedBy->children($gmlNsPrefix, true);
				if (!empty($bbNode->Envelope)) {
					$envelopeAttrs = $this->getAttrsAsArray($bbNode->Envelope); // Seems we don't need a ns prefix here
					if (isset($envelopeAttrs['srsName']) && $this->isWgs84($envelopeAttrs['srsName'])) {
						$envNode = $bbNode->Envelope->children($gmlNsPrefix, true);
						if (!empty($envNode->lowerCorner) && !empty($envNode->upperCorner)) {
							$bbox = $this->parseCoords(strval($envNode->lowerCorner), strval($envNode->upperCorner));
							if (count($bbox) == 4) {
								$entry['bbox'] = $bbox;
							}
						}
					}
				}
			}
			
			// Time
			if (!empty($sosNode->time)) {
				// GML is a nuightmare. Let's do some regexp instead to parse some common formats.
				$xml = $sosNode->time->asXml();
				$regexNs = preg_quote($gmlNsPrefix, '~');
				foreach(array('begin', 'end') as $when) {
					$regexp = "<(({$regexNs}:)?TimePeriod)>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g3>)\s*)*<(\g2{$when}(?:Position)?)>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g5>)\s*|\s*<[^/>]+>\s*)*([^<>\s]+(?:[T\s][^<>\s]+)?)\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g7>)\s*|\s*</[^>]+>\s*)*</\g4>\s*(?:\s*<([\w-:]+)[^>]*(?:/>|>[^<>]*</\g8>)\s*)*</\g1>";
					if (preg_match("~{$regexp}~is", $xml, $matches) && isIso8601Date($matches[6])) {
						$entry[$when . 'Time'] = new \Carbon\Carbon($matches[6]);
					}
				}
			}

			$data[] = $entry;
		}
		return $data;
	}

}
