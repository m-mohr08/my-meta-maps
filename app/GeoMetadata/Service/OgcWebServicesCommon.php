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

abstract class OgcWebServicesCommon extends OgcWebServices {
	
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

	public function getSupportedNamespaces() {
		return array('http://www.opengis.net/ows/1.0', 'http://www.opengis.net/ows/1.1', 'http://www.opengis.net/ows/2.0');
	}
	
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
	
	protected function checkServiceType() {
		$docCode = $this->selectOne(array('ows:ServiceIdentification', 'ows:ServiceType'));
		$parserCode = preg_quote($this->getCode(), '~');
		return (preg_match('~^\s*(urn:ogc:service:|OGC[:\s]?)?'.$parserCode.'\s*$~i', $docCode) == 1); // There might be a "OGC" prefix in front in some implementations.
	}

	protected function parseAbstract() {
		return $this->selectOne(array('ows:ServiceIdentification', 'ows:Abstract'));
	}

	protected function parseAuthor() {
		return $this->selectNestedText(array('ows:ServiceProvider'), $this->getNamespace('ows'));
	}

	protected function parseKeywords() {
		return $this->selectMany(array('ows:ServiceIdentification', 'ows:Keywords', 'ows:Keyword'));
	}

	protected function parseLanguage() {
		// Language tag can appear in several areas, just try to parse one of them...
		// The format of this language tag is according to RFC 4646. We expect ISO 639-1, which is not always compatible.
		// TODO: We need to implement a conversion for the language from RFC 4646 to ISO 639-1 and we might need to check where the language really is located.
		return $this->selectOne(array('ows:Language'));
	}

	protected function parseLicense() {
		$license = $this->selectOne(array('ows:ServiceIdentification', 'ows:AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	protected function parseTitle() {
		return $this->selectOne(array('ows:ServiceIdentification', 'ows:Title'));
	}

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
	
	protected function findLayerNodes() {
		$nodes = $this->selectMany(array('ows:Contents', 'ows:DatasetSummary'), null, false);
		if (empty($nodes)) {
			// Can you tell me why some servers use DatasetDescriptionSummary instead of the DatasetSummary tag as specified by the OGC?
			$nodes = $this->selectMany(array('ows:Contents', 'ows:DatasetDescriptionSummary'), null, false);
		}
		return $nodes;
	}
	
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getNamespace('ows'));
		return $this->n2s($children->Identifier);
	}
	
	protected function parseTitleFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getNamespace('ows'));
		return $this->n2s($children->Title);
	}
	
	protected function parseExtraDataFromContents(\SimpleXMLElement $node) {
		return array();
	}
	
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