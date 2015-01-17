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

use GeoMetadata\GmRegistry;

class OgcWebMapService extends OgcWebServices {
	
	private $cache = array();

	public function getSupportedNamespaces() {
		return 'http://www.opengis.net/wms';
	}
	
	protected function registerNamespaces() {
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // WMS
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
		return $this->selectOne(array('wms:Service', 'wms:Abstract'));
	}

	protected function parseAuthor() {
		return $this->selectNestedText(array('wms:Service', 'wms:ContactInformation'), $this->getNamespace('wms'));
	}
	
	private function isWmsVersion($version) {
		if (!isset($this->cache['version'][$version])) {
			$wmsNode = $this->xpath(array("wms:WMS_Capabilities[@version='{$version}']"));
			$this->cache['version'][$version] = !empty($wmsNode);
		}
		return $this->cache['version'][$version];
	}
	
	protected function parseBoundingBox() {
		$parent = $this->selectOne(array('wms:Capability', 'wms:Layer'), null, false);
		return $this->parseBoundingBoxFromNode($parent);
	}
	
	protected function parseBoundingBoxFromNode(\SimpleXMLElement $parent) {
		$isVersion130 = $this->isWmsVersion('1.3.0');

		$list = array();
		
		$bboxes = $this->selectMany(array("wms:BoundingBox"), $parent, false);
		foreach ($bboxes as $bbox) {
			if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
				$crs = isset($bbox['CRS']) ? $bbox['CRS'] : '';
				if ($isVersion130 && GmRegistry::getEpsgCodeNumber($crs) == 4326) {
					// In WMS version 1.3.0 with EPSG:4326 (NOT CRS:84) and some other CRS the lon/lat values order is changed.
					// See http://www.esri.de/support/produkte/arcgis-server-10-0/korrekte-achsen-reihenfolge-fuer-wms-dienste
					// and http://viswaug.wordpress.com/2009/03/15/reversed-co-ordinate-axis-order-for-epsg4326-vs-crs84-when-requesting-wms-130-images/
					$list[] = $this->createBoundingBox($bbox['miny'], $bbox['minx'], $bbox['maxy'], $bbox['maxx'], $crs);
				}
				else {
					$list[] = $this->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy'], $crs);
				}
			}
		}
		if (!empty($list)) {
			return $list;
		}

		if (!empty($parent->EX_GeographicBoundingBox)) {
			$bbox = $parent->EX_GeographicBoundingBox->children();
			if ($bbox->count() >= 4) {
				$list[] = $this->createBoundingBox(
					$this->n2s($bbox->westBoundLongitude),
					$this->n2s($bbox->southBoundLatitude),
					$this->n2s($bbox->eastBoundLongitude),
					$this->n2s($bbox->northBoundLatitude),
					'CRS:84'
				);
				return $list;
			}
		}

		if (!$isVersion130) { // only before v1.3.0
			$latlonBBox = $this->selectOne(array('wms:LatLonBoundingBox'), $parent, false);
			if (isset($latlonBBox['minx']) && isset($latlonBBox['miny']) && isset($latlonBBox['maxx']) && isset($latlonBBox['maxy'])) {
				$list[] = $this->createBoundingBox($latlonBBox['minx'], $latlonBBox['miny'], $latlonBBox['maxx'], $latlonBBox['maxy'], 'EPSG:4326');
			}
		}

		return $list;
	}

	protected function parseBeginTime() {
		// TODO: There is a <Dimension name="time" ...> tag for layers which we should use for this data.
		return null; // Not supported
	}

	protected function parseEndTime() {
		// TODO: There is a <Dimension name="time" ...> tag for layers which we should use for this data.
		return null; // Not supported
	}

	protected function parseKeywords() {
		return $this->selectMany(array('wms:Service', 'wms:KeywordList', 'wms:Keyword'));
	}

	protected function parseLayers() {
		$nodes = $this->selectMany(array('wms:Capability', 'wms:Layer', 'wms:Layer'), null, false);
		$layers = array();
		foreach ($nodes as $node) {
			$id = $this->n2s($node->Name);
			if (!empty($id)) {
				$layer = $this->createLayer($id, $this->n2s($node->Title));
				$bboxes = $this->parseBoundingBoxFromNode($node);
				if (empty($bboxes)) {
					// Inheritance of bbox from global WMS bbox if not an own bbox is provided by the layer.
					$bboxes = $this->getBoundingBox();
				}
				$layer->copyBoundingBox($bboxes);
				$layers[] = $layer;
			}
		}
		return $layers;
	}

	protected function parseLicense() {
		$license = $this->selectOne(array('wms:Service', 'wms:AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	protected function parseTitle() {
		return $this->selectOne(array('wms:Service', 'wms:Title'));
	}

}