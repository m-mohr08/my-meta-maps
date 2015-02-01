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

use \GeoMetadata\GmRegistry;

/**
 * Parser for OGC OWS Common.
 * Code: ows
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 * 
 * Note: This is currently only used as base class for other implementations, but might be used to parse 
 * OGC OWS Common datasets aswell.
 */
class OgcWebServicesCommon extends OgcWebServices {
	
	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'OGC OWS Common';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'ows';
	}

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	public function getSupportedNamespaces() {
		return array('http://www.opengis.net/ows/1.0', 'http://www.opengis.net/ows/1.1', 'http://www.opengis.net/ows/2.0');
	}

	/**
	 * Define the namespaces you want to use in XPath expressions.
	 * 
	 * You should register all namespaces with a prefix using the registerNamespace() method.
	 * 
	 * @see XmlParser::registerNamespace()
	 */
	protected function registerNamespaces() {
		$this->registerNamespace($this->getCode(), $this->getUsedNamespace()); // OWS
	}

	/**
	 * Checks whether the given service data is of this type.
	 * 
	 * @param string $source String containing the data to parse.
	 * @return boolean true if content can be parsed, false if not.
	 */
	public function verify($source) {
		return (parent::verify($source) && $this->checkServiceType());
	}
	
	/**
	 * Checks whether the ServiceType specified in the metadata suits to this parser.
	 * 
	 * @return boolean
	 */
	protected function checkServiceType() {
		$docCode = $this->selectOne(array('ows:ServiceIdentification', 'ows:ServiceType'));
		$parserCode = preg_quote($this->getCode(), '~');
		return (preg_match('~^\s*(urn:ogc:service:|OGC[:\s]?)?'.$parserCode.'\s*$~i', $docCode) == 1); // There might be a "OGC" prefix in front in some implementations.
	}

	/**
	 * Parses and returns the description/abstract.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAbstract()
	 * @see \GeoMetadata\Model\Metadata::setAbstract()
	 */
	protected function parseAbstract() {
		return $this->selectOne(array('ows:ServiceIdentification', 'ows:Abstract'));
	}

	/**
	 * Parses and returns the author/service provider.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAuthor()
	 * @see \GeoMetadata\Model\Metadata::setAuthor()
	 */
	protected function parseAuthor() {
		return $this->selectNestedText(array('ows:ServiceProvider'), $this->getNamespace('ows'));
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
		return $this->selectMany(array('ows:ServiceIdentification', 'ows:Keywords', 'ows:Keyword'));
	}

	/**
	 * Parses and returns the language of the geo dataset.
	 * 
	 * This should be an ISO 639-1 based language code.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getLanguage()
	 * @see \GeoMetadata\Model\Metadata::setLanguage()
	 */
	protected function parseLanguage() {
		// Language tag can appear in several areas, just try to parse one of them...
		// The format of this language tag is according to RFC 4646. We expect ISO 639-1, which is not always compatible.
		// TODO: We need to implement a conversion for the language from RFC 4646 to ISO 639-1 and we might need to check where the language really is located.
		return $this->selectOne(array('ows:Language'));
	}

	/**
	 * Parses and returns the licensing information.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getLicense()
	 * @see \GeoMetadata\Model\Metadata::setLicense()
	 */
	protected function parseLicense() {
		$license = $this->selectOne(array('ows:ServiceIdentification', 'ows:AccessConstraints'));
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
		return $this->selectOne(array('ows:ServiceIdentification', 'ows:Title'));
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
		// There is no bounding box in the metadata for the complete dataset.
		// We are calculation a bounding box by joining all bboxes of the layers.
		$growingBBoxes = array();
		foreach($this->getLayers() as $content) {
			$layerBBoxes = $content->getBoundingBox();
			foreach($layerBBoxes as $crs => $bbox) {
				if (!isset($growingBBoxes[$crs])) {
					$growingBBoxes[$crs] = $this->createEmptyBoundingBox();
				}
				$growingBBoxes[$crs]->union($bbox);
			}
		}
		return $growingBBoxes;
	}

	/**
	 * Parses and returns the layers (or similar things) of the geo dataset.
	 * 
	 * @return array An array containing Layer based objects
	 * @see \GeoMetadata\Model\LayerContainer
	 * @see SimpleFillModelTrait::createLayer()
	 */
	protected function parseLayers() {
		// Version 1.0.0 of OWS Common doesn't specify anything for the contents.
		// This implementation parses for contents of version 1.1.0 and ignores the contents section in version 1.0.0.
		// Version 2.0.x is not supported as of yet.
		$data = array();

		$nodes = $this->findLayerNodes();
		foreach($nodes as $node) {
			$layer = $this->createLayer($this->parseIdentifierFromContents($node), $this->parseTitleFromContents($node));
			$layer->copyBoundingBox($this->parseBoundingBoxFromContents($node));
			// Not all models implement the ExtraDataContainerTrait, check this
			if ($layer instanceof \GeoMetadata\Model\ExtraDataContainer) {
				$extra = $this->parseExtraDataFromContents($node);
				foreach($extra as $key => $value) {
					$layer->setData($key, $value);
				}
			}
			$data[] = $layer;
		}
		return $data;
	}
	
	/**
	 * Returns the node(s) that contain the data for the individual layers of the geo dataset.
	 * 
	 * Usually the nodes containing the layer data are childs from the 'Contents' node as specified
	 * in the OGC OWS Common specification. They can be parsed by calling 
	 * XmlParser::selectMany(..., ..., false) for example.
	 * 
	 * @see \GeoMetadata\Service\XmlParser::selectMany()
	 * @return array Array containing SimpleXMLElement nodes (as returned by XmlParser::selectMany() )
	 */
	protected function findLayerNodes() {
		$nodes = $this->selectMany(array('ows:Contents', 'ows:DatasetSummary'), null, false);
		if (empty($nodes)) {
			// Can you tell me why some servers use DatasetDescriptionSummary instead of the DatasetSummary tag as specified by the OGC?
			$nodes = $this->selectMany(array('ows:Contents', 'ows:DatasetDescriptionSummary'), null, false);
		}
		return $nodes;
	}
	
	/**
	 * Parses and returns the unique identifier from the specified layer node.
	 * 
	 * @param \SimpleXMLElement $node Node of the layer to use
	 * @return string
	 */
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getNamespace('ows'));
		return $this->n2s($children->Identifier);
	}
	
	/**
	 * Parses and returns the title from the specified layer node.
	 * 
	 * @param \SimpleXMLElement $node Node of the layer to use
	 * @return string
	 */
	protected function parseTitleFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getNamespace('ows'));
		return $this->n2s($children->Title);
	}

	/**
	 * Parses and returns extra data from the specified layer node.
	 * 
	 * Extra data might contain data we need to gather as global data, e.g. bounding boxes or time
	 * extents, but are not needed for the layer as of now.
	 * 
	 * Returns an array with key value pairs.
	 * 
	 * @see \GeoMetadata\Model\ExtraDataContainer
	 * @param \SimpleXMLElement $node Node of the layer to use
	 * @return array
	 */
	protected function parseExtraDataFromContents(\SimpleXMLElement $node) {
		return array();
	}

	/**
	 * Parses and returns the bounding boxes with their respective CRS from the specified layer node.
	 * 
	 * @param \SimpleXMLElement $node Node of the layer to use
	 * @return array An array containing BoundingBox based objects
	 * @see \GeoMetadata\Model\BoundingBox
	 * @see \GeoMetadata\Model\BoundingBoxContainer
	 * @see SimpleFillModelTrait::createEmptyBoundingBox()
	 */
	protected function parseBoundingBoxFromContents(\SimpleXMLElement $node) {
		$result = array();
		
		$bboxes = $this->selectMany(array('ows:BoundingBox'), $node, false);
		foreach ($bboxes as $bbox) {
			$attrs = $bbox->attributes(); // Namespace seems to be not needed here
			$lc = $this->n2s($bbox->LowerCorner);
			$uc = $this->n2s($bbox->UpperCorner);
			if (!empty($lc) && !empty($uc)){
				$result[] = $this->parseCoords($lc, $uc, $this->n2s($attrs->crs), true); // Axis order depends on the CRS
			}
		}

		if (empty($result)) {
			$result[] = $this->parseCoords(
				$this->selectOne(array('ows:WGS84BoundingBox', 'ows:LowerCorner'), $node),
				$this->selectOne(array('ows:WGS84BoundingBox', 'ows:UpperCorner'), $node),
				'CRS:84' // Axis order does not depend on the CRS
			);
		}
		
		return $result;
	}
	
	/**
	 * Parses and returns a bounding box with the respective CRS from the specified data.
	 * 
	 * @param string $min Coordinate with the minimum bounds
	 * @param string $max Coordinate with the maximum bounds
	 * @param string $crs Coordinate reference system of the coordinates
	 * @param boolean $checkInverseAxisOrder Specifies whether we should check for inverse axis order by CRS and parse the coordinates using inverse axis order if needed.
	 * @param boolean $forceChangeAxisOrder Specifies whether we should force to parse the coordinates using inverse axis order.
	 * @return BoundingBox
	 * @see SimpleFillModelTrait::createEmptyBoundingBox()
	 * @see GmRegistry::isInversedAxisOrderEpsgCode()
	 */
	protected function parseCoords($min, $max, $crs = '', $checkInverseAxisOrder = false, $forceChangeAxisOrder = false) {
		$regex = '~(-?\d*\.?\d+)\s+(-?\d*\.?\d+)~';
		if (preg_match($regex, $min, $minMatch) && preg_match($regex, $max, $maxMatch)) {
			$bbox = $this->createEmptyBoundingBox();
			$bbox->setCoordinateReferenceSystem($crs);
			$x = 1; $y = 2;
			if ($forceChangeAxisOrder || ($checkInverseAxisOrder && GmRegistry::isInversedAxisOrderEpsgCode($crs))) {
				$x = 2; $y = 1;
			}
			$bbox->set($minMatch[$x], $minMatch[$y], $maxMatch[$x], $maxMatch[$y]);
			return $bbox;
		}
		else {
			return null;
		}
	}

}