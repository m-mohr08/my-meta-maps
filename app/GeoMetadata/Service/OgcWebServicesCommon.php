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

abstract class OgcWebServicesCommon extends OgcWebServices {
	
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

	protected function parseCopyright() {
		return null; // Not supported
	}

	protected function parseBeginTime() {
		return null; // Not supported
	}

	protected function parseEndTime() {
		return null; // Not supported
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

	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		// There is no bounding box in the metadata for the complete dataset.
		// We are calculation a bounding box by joining all bboxes of the layers.
		$bbox = array();
		$contents = $this->parseContents();
		foreach($contents as $content) {
			if (empty($content['bbox'])) {
				continue; // No bbox, go to next entry
			}
			if (!isset($bbox['west']) || $content['bbox']['west'] < $bbox['west']) { // Search minimum
				$bbox['west'] = $content['bbox']['west'];
			}
			if (!isset($bbox['north']) || $content['bbox']['north'] > $bbox['north']) { // Search maximum
				$bbox['north'] = $content['bbox']['north'];
			}
			if (!isset($bbox['east']) || $content['bbox']['east'] < $bbox['east']) { // Search minimum
				$bbox['east'] = $content['bbox']['east'];
			}
			if (!isset($bbox['south']) || $content['bbox']['south'] > $bbox['south']) { // Search maximum
				$bbox['south'] = $content['bbox']['south'];
			}
		}
		if (count($bbox) == 4) {
			$model->createBoundingBox($bbox['west'], $bbox['south'], $bbox['east'], $bbox['north']);
		}
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		$contents = $this->parseContents();
		foreach($contents as $content) {
			$layer = $model->createLayer($content['id'], $content['title']);
			if (count($content['bbox']) == 4) {
				$layer->createBoundingBox($content['bbox']['west'], $content['bbox']['south'], $content['bbox']['east'], $content['bbox']['north']);
			}
		}
	}
	
	protected function parseContents() {
		// Version 1.0.0 of OWS Common doesn't specify anything for the contents.
		// This implementation parses for version 1.1.0 and ignores everything from version 1.0.0.
		$data = array();

		$nodes = $this->selectMany(array('Contents', 'DatasetSummary'), null, false);
		if (empty($nodes)) {
			// Can you tell me why some servers use DatasetDescriptionSummary instead of the DatasetSummary tag as specified by the OGC?
			$nodes = $this->selectMany(array('Contents', 'DatasetDescriptionSummary'), null, false);
		}
		foreach($nodes as $node) {
			$entry = array(
				'id' => $this->selectOne(array('Identifier'), $node),
				'title' => $this->selectOne(array('Title'), $node),
				'bbox' => array()
			);

			$bbox = $this->parseCoords(
				$this->selectOne(array('WGS84BoundingBox', 'LowerCorner'), $node),
				$this->selectOne(array('WGS84BoundingBox', 'UpperCorner'), $node)
			);
			if (count($bbox) == 4) {
				$entry['bbox'] = $bbox;
			}
			
			if (empty($entry['bbox'])) {
				$crs = $this->selectOne(array('BoundingBox', 'crs'), $node);
				if ($this->isWgs84($crs)) {
					$bbox = $this->parseCoords(
						$this->selectOne(array('BoundingBox', 'LowerCorner'), $node),
						$this->selectOne(array('BoundingBox', 'UpperCorner'), $node)
					);
					if (count($bbox) == 4) {
						$entry['bbox'] = $bbox;
					}
				}
			}

			$data[] = $entry;
		}
		return $data;
	}
		
	protected function parseCoords($min, $max) {
		$regex = '~(-?\d*\.?\d+)\s+(-?\d*\.?\d+)~';
		if (preg_match($regex, $min, $minMatch) && preg_match($regex, $max, $maxMatch)) {
			return array(
				'west' => $minMatch[1], // minx
				'north' => $maxMatch[1], // maxx
				'east' => $minMatch[2], // miny
				'south' => $maxMatch[2] // maxy
			);
		}
		else {
			return array();
		}
	}

}