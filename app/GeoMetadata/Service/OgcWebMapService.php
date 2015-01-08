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

class OgcWebMapService extends OgcWebServices {

	public function getNamespaceUri() {
		return 'http://www.opengis.net/wms';
	}

	public function verify($source) {
		// We don't parse the XML here as the regexp matching the root tags is much faster and we don't ask for validity anyway.
		// Additionally the first versions of WMS had no xml namespace URI required so we can't detect it with the normal verification process.
		return preg_match('~<((?:WMS|WMT_MS)_Capabilities)(?:\s[^>]+)?>.+</\1>~is', $source);
	}

	public function getName() {
		return 'OGC WMS';
	}

	public function getCode() {
		return 'wms';
	}

	protected function parseAbstract() {
		return $this->selectOne(array('Service', 'Abstract'));
	}

	protected function parseAuthor() {
		return $this->selectHierarchyAsOne(array('Service', 'ContactInformation'));
	}

	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		$bboxes = $this->getParser()->xpath("//*[local-name()='Capability']/*[local-name()='Layer']/*[local-name()='LatLonBoundingBox']|//*[local-name()='Capability']/*[local-name()='Layer']/*[local-name()='BoundingBox'][@CRS='EPSG:4326' or @CRS='CRS:84']");
		foreach ($bboxes as $bbox) {
			if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
				$model->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
				break;
			}
		}
		if ($model->getBoundingBox() == null) {
			$crs = $this->selectOne(array('Capability', 'Layer', 'CRS'));
			if ($this->isWgs84($crs)) {
				$west = $this->selectOne(array('Capability', 'Layer', 'EX_GeographicBoundingBox', 'westBoundLongitude'));
				$east = $this->selectOne(array('Capability', 'Layer', 'EX_GeographicBoundingBox', 'eastBoundLongitude'));
				$north = $this->selectOne(array('Capability', 'Layer', 'EX_GeographicBoundingBox', 'northBoundLongitude'));
				$south = $this->selectOne(array('Capability', 'Layer', 'EX_GeographicBoundingBox', 'southBoundLongitude'));
				if (!$west != null && $east != null && $north != null && $south != null) {
					$model->createBoundingBox($west, $north, $east, $south);
				}
			}
		}
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
		return $this->selectMany(array('Service', 'KeywordList', 'Keyword'));
	}

	protected function parseLanguage() {
		return null; // Not supported
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		$nodes = $this->selectMany(array('Capability', 'Layer', 'Layer'), null, false);
		foreach ($nodes as $node) {
			$name = (string) $node->Name;
			if (!empty($name)) {
				$title = (string) $node->Title;
				$layer = $model->createLayer($name, $title);
				
				if (is_object($node->LatLonBoundingBox)) {
					$bbox = $this->getAttrsAsArray($node->LatLonBoundingBox);
					if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
						$layer->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
					}
				}
				else {
					$parentCrs = $this->selectOne(array('Capability', 'Layer', 'CRS'));
					// TODO: Check whether this works with $node specified as parent...
					$layerCrs = $this->selectOne(array('CRS'), $node);
					if ($this->isWgs84($parentCrs) || $this->isWgs84($layerCrs)) {
						$west = $this->selectOne(array('EX_GeographicBoundingBox', 'westBoundLongitude'), $node);
						$east = $this->selectOne(array('EX_GeographicBoundingBox', 'eastBoundLongitude'), $node);
						$north = $this->selectOne(array('EX_GeographicBoundingBox', 'northBoundLongitude'), $node);
						$south = $this->selectOne(array('EX_GeographicBoundingBox', 'southBoundLongitude'), $node);
						if (!$west != null && $east != null && $north != null && $south != null) {
							$layer->createBoundingBox($west, $north, $east, $south);
						}
					}
				}
				// Inheritance of bbox from global WMS bbox
				if ($layer->getBoundingBox() == null) {
					$layer->setBoundingBox($model->getBoundingBox());
				}
			}
		}
	}

	protected function parseLicense() {
		$license = $this->selectOne(array('Service', 'AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	protected function parseTitle() {
		return $this->selectOne(array('Service', 'Title'));
	}

}