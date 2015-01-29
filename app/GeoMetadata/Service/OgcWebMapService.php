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

/**
 * Parser for OGC WMS.
 * Code: wms
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 */
class OgcWebMapService extends OgcWebServices {
	
	private $cache = array();

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	public function getSupportedNamespaces() {
		return 'http://www.opengis.net/wms';
	}

	/**
	 * Define the namespaces you want to use in XPath expressions.
	 * 
	 * You should register all namespaces with a prefix using the registerNamespace() method.
	 * 
	 * @see XmlParser::registerNamespace()
	 */
	protected function registerNamespaces() {
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // WMS
	}

	/**
	 * Checks whether the given service data is of this type.
	 * 
	 * We don't parse the XML here as the regexp matching the root tags is much faster and we don't
	 * ask for validity anyway. Additionally the first versions of WMS had no xml namespace URI
	 * required so we can't detect it with the normal verification process.
	 * 
	 * @param string $source String containing the data to parse.
	 * @return boolean true if content can be parsed, false if not.
	 */
	public function verify($source) {
		return preg_match('~<((?:[\w\d]:)?(?:WMS|WMT_MS)_Capabilities)(?:\s[^>]+)?>.+</\1>~is', $source);
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'OGC WMS';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'wms';
	}

	/**
	 * Parses and returns the description/abstract.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAbstract()
	 * @see \GeoMetadata\Model\Metadata::setAbstract()
	 */
	protected function parseAbstract() {
		return $this->selectOne(array('wms:Service', 'wms:Abstract'));
	}

	/**
	 * Parses and returns the author/service provider.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAuthor()
	 * @see \GeoMetadata\Model\Metadata::setAuthor()
	 */
	protected function parseAuthor() {
		return $this->selectNestedText(array('wms:Service', 'wms:ContactInformation'), $this->getNamespace('wms'));
	}
	
	/**
	 * Checks whether the parsed WMS data is specified in the given version or not.
	 * 
	 * The version numbers must match exactly. "1.3.0" is NOT equal to "1.3".
	 * 
	 * @param string $version Version number to check for
	 * @return boolean true if the version numbers match, false if not.
	 */
	private function isWmsVersion($version) {
		if (!isset($this->cache['version'][$version])) {
			$wmsNode = $this->xpath(array("wms:WMS_Capabilities[@version='{$version}']"));
			$this->cache['version'][$version] = !empty($wmsNode);
		}
		return $this->cache['version'][$version];
	}

	/**
	 * Parses and returns the service wide bounding boxes with their respective CRS of the geo dataset.
	 * 
	 * @return array An array containing BoundingBox based objects
	 * @see \GeoMetadata\Model\BoundingBox
	 * @see \GeoMetadata\Model\BoundingBoxContainer
	 * @see SimpleFillModelTrait::createEmptyBoundingBox()
	 */
	protected function parseBoundingBox() {
		$parent = $this->selectOne(array('wms:Capability', 'wms:Layer'), null, false);
		return $this->parseBoundingBoxFromNode($parent);
	}
	
	/**
	 * Parses the bounding box from a node where the bounding boxed might be contained in.
	 * 
	 * This method tries different approaches specified in the WMS specification to get a bbox. 
	 * 
	 * @see OgcWebMapService::parseBoundingBox()
	 * @param \SimpleXMLElement $parent Parent node to use for searching bboxes
	 * @return array List of BoundingBox objects.
	 */
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

	/**
	 * Parses and returns the minimum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getBeginTime()
	 * @see \GeoMetadata\Model\Metadata::setBeginTime()
	 */
	protected function parseBeginTime() {
		// TODO: There is a <Dimension name="time" ...> tag for layers which we should use for this data.
		return null; // Not supported
	}

	/**
	 * Parses and returns the maximum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getEndTime()
	 * @see \GeoMetadata\Model\Metadata::setEndTime()
	 */
	protected function parseEndTime() {
		// TODO: There is a <Dimension name="time" ...> tag for layers which we should use for this data.
		return null; // Not supported
	}

	/**
	 * Parses and returns the keywords/tags.
	 * 
	 * @return array
	 * @see \GeoMetadata\Model\Metadata::getKeywords()
	 * @see \GeoMetadata\Model\Metadata::setKeywords()
	 * @see \GeoMetadata\Model\Metadata::addKeyword()
	 */
	protected function parseKeywords() {
		return $this->selectMany(array('wms:Service', 'wms:KeywordList', 'wms:Keyword'));
	}

	/**
	 * Parses and returns the layers (or similar things) of the geo dataset.
	 * 
	 * @return array An array containing Layer based objects
	 * @see \GeoMetadata\Model\LayerContainer
	 * @see SimpleFillModelTrait::createLayer()
	 */
	protected function parseLayers() {
		$nodes = $this->selectMany(array('wms:Capability', 'wms:Layer', 'wms:Layer'), null, false);
		$layers = array();
		foreach ($nodes as $node) {
			$id = $this->n2s($node->Name);
			if (!empty($id)) {
				$layer = $this->createLayer($id, $this->n2s($node->Title));
				// TODO: Implement inheritance of bboxes from the bboxes provided in Capability/Layer.
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

	/**
	 * Parses and returns the licensing information.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getLicense()
	 * @see \GeoMetadata\Model\Metadata::setLicense()
	 */
	protected function parseLicense() {
		$license = $this->selectOne(array('wms:Service', 'wms:AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	/**
	 * Parses and returns the title.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getTitle()
	 * @see \GeoMetadata\Model\Metadata::setTitle()
	 */
	protected function parseTitle() {
		return $this->selectOne(array('wms:Service', 'wms:Title'));
	}

}