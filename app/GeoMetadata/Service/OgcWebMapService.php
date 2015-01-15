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
	
	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		$parent = $this->selectOne(array('wms:Capability', 'wms:Layer'), null, false);
		$this->parseBoundingBoxFromNode($parent, $model);
	}
	
	protected function parseBoundingBoxFromNode(\SimpleXMLElement $parent, \GeoMetadata\Model\BoundingBoxContainer $model) {
		$bboxes = array_merge(
			$this->selectMany(array('wms:LatLonBoundingBox'), $parent, false), // only before v1.3.0
			$this->selectMany(array("wms:BoundingBox[@CRS='EPSG:4326' or @CRS='CRS:84']"), $parent, false)
		);
		foreach ($bboxes as $bbox) {
			if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
				if ($this->isWmsVersion('1.3.0') && isset($bbox['CRS']) && GmRegistry::getEpsgCodeNumber($bbox['CRS']) == 4326) {
					// In WMS version 1.3.0 with EPSG:4326 (NOT CRS:84) and some other CRS the lon/lat values order is changed.
					// See http://www.esri.de/support/produkte/arcgis-server-10-0/korrekte-achsen-reihenfolge-fuer-wms-dienste
					// and http://viswaug.wordpress.com/2009/03/15/reversed-co-ordinate-axis-order-for-epsg4326-vs-crs84-when-requesting-wms-130-images/
					$model->createBoundingBox($bbox['miny'], $bbox['minx'], $bbox['maxy'], $bbox['maxx']);
				}
				else {
					$model->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
				}
				// We found a bbox, skip other methods and return
				return true;
			}
		}

		$crs = $this->selectMany(array('wms:CRS'), $parent);
		if ($this->isWgs84($crs) && !empty($parent->EX_GeographicBoundingBox)) {
			$bbox = $parent->EX_GeographicBoundingBox->children();
			if ($bbox->count() >= 4) {
				$model->createBoundingBox($this->n2s($bbox->westBoundLongitude), $this->n2s($bbox->southBoundLatitude), $this->n2s($bbox->eastBoundLongitude), $this->n2s($bbox->northBoundLatitude));
				return true;
			}
		}
		return false;
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
		return $this->selectMany(array('wms:Service', 'wms:KeywordList', 'wms:Keyword'));
	}

	protected function parseLanguage() {
		return null; // Not supported
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		$nodes = $this->selectMany(array('wms:Capability', 'wms:Layer', 'wms:Layer'), null, false);
		foreach ($nodes as $node) {
			$name = $this->n2s($node->Name);
			if (!empty($name)) {
				$title = $this->n2s($node->Title);
				$layer = $model->createLayer($name, $title);
				if (!$this->parseBoundingBoxFromNode($node, $layer)) {
					// Inheritance of bbox from global WMS bbox if not an own bbox is provided by the layer
					$layer->setBoundingBox($model->getBoundingBox());
				}
			}
		}
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