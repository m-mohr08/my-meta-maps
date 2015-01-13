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

use \GeoMetadata\Model\Generic\GmBoundingBox, \GeoMetadata\Model\Generic\GmLayer;

abstract class OgcWebServicesCommon extends OgcWebServices {
	
	private $owsPrefix = null;
	private $contents = null;
	
	public function getName() {
		return 'OGC OWS Common';
	}

	public function getCode() {
		return 'ows';
	}

	public function getSupportedNamespaceUri() {
		return $this->getOwsNamespaceUri();
	}

	protected function getOwsNamespaceUri() {
		return array('http://www.opengis.net/ows/1.0', 'http://www.opengis.net/ows/1.1');
	}

	protected function getOwsNamespacePrefix() {
		if ($this->owsPrefix === null) {
			$this->owsPrefix = $this->getUsedNamespacePrefix($this->getOwsNamespaceUri(), 'ows');
		}
		return $this->owsPrefix;
	}

	public function verify($source) {
		return (parent::verify($source) && $this->checkServiceType());
	}
	
	protected function checkServiceType() {
		$docCode = $this->selectOne(array('ServiceIdentification', 'ServiceType'), null, true, $this->getOwsNamespacePrefix(), true);
		$parserCode = preg_quote($this->getCode(), '~');
		return (preg_match('~^\s*(OGC[:\s]?)?'.$parserCode.'\s*$~i', $docCode) == 1); // There might be a "OGC" prefix in front in some implementations.
	}

	protected function parseAbstract() {
		return $this->selectOne(array('ServiceIdentification', 'Abstract'), null, true, $this->getOwsNamespacePrefix(), true);
	}

	protected function parseAuthor() {
		return $this->selectHierarchyAsOne(array('ServiceProvider'), null, $this->getOwsNamespacePrefix(), true);
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
		return $this->selectMany(array('ServiceIdentification', 'Keywords', 'Keyword'), null, true, $this->getOwsNamespacePrefix(), true);
	}

	protected function parseLanguage() {
		// Language tag can appear in several areas, just try to parse one of them...
		// The format of this language tag is according to RFC 4646. We expect ISO 639-1, which is not always compatible.
		// TODO: We need to implement a conversion for the language from RFC 4646 to ISO 639-1 and we might need to check where the language really is located.
		return $this->selectOne(array('Language'), null, true, $this->getOwsNamespacePrefix(), true);
	}

	protected function parseLicense() {
		$license = $this->selectOne(array('ServiceIdentification', 'AccessConstraints'), null, true, $this->getOwsNamespacePrefix(), true);
		if (!empty($license) && strtolower($license) != 'none') {
			return $license;
		}
		else {
			return null;
		}
	}

	protected function parseTitle() {
		return $this->selectOne(array('ServiceIdentification', 'Title'), null, true, $this->getOwsNamespacePrefix(), true);
	}

	protected function parseBoundingBox(\GeoMetadata\Model\Metadata &$model) {
		// There is no bounding box in the metadata for the complete dataset.
		// We are calculation a bounding box by joining all bboxes of the layers.
		$bbox = new GmBoundingBox();
		foreach($this->getContents() as $content) {
			if (empty($content['bbox'])) {
				$bbox->union($content['bbox']);
			}
		}
		$model->copyBoundingBox($bbox);
	}

	protected function parseLayer(\GeoMetadata\Model\Metadata &$model) {
		foreach($this->getContents() as $content) {
			$model->copyLayer($content);
		}
	}
	
	protected function getContents() {
		if ($this->contents === null) {
			$this->contents = $this->parseContents();
		}
		return $this->contents;
	}
	
	protected function parseContents() {
		// Version 1.0.0 of OWS Common doesn't specify anything for the contents.
		// This implementation parses for contents of version 1.1.0 and ignores the contents section in version 1.0.0.
		$data = array();

		$nodes = $this->findLayerNodes();
		foreach($nodes as $node) {
			$layer = new GmLayer();
			$layer->setId($this->parseIdentifierFromContents($node));
			$layer->setTitle($this->parseTitleFromContents($node));
			$layer->setBoundingBox($this->parseBoundingBoxFromContents($node));
			$data = $this->parseExtraDataFromContente($node);
			foreach($data as $key => $value) {
				$layer->setData($key, $value);
			}
			$data[] = $layer;
		}
		return $data;
	}
	
	protected function findLayerNodes() {
		$nodes = $this->selectMany(array('Contents', 'DatasetSummary'), null, false, $this->getOwsNamespacePrefix(), true);
		if (empty($nodes)) {
			// Can you tell me why some servers use DatasetDescriptionSummary instead of the DatasetSummary tag as specified by the OGC?
			$nodes = $this->selectMany(array('Contents', 'DatasetDescriptionSummary'), null, false, $this->getOwsNamespacePrefix(), true);
		}
		return $nodes;
	}
	
	protected function parseIdentifierFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getOwsNamespacePrefix(), true);
		return $this->n2s($children->Identifier);
	}
	
	protected function parseTitleFromContents(\SimpleXMLElement $node) {
		$children = $node->children($this->getOwsNamespacePrefix(), true);
		return $this->n2s($children->Title);
	}
	
	protected function parseExtraDataFromContente(\SimpleXMLElement $node) {
		$children = $node->children($this->getOwsNamespacePrefix(), true);
		return $this->n2s($children->Identifier);
	}
	
	protected function parseBoundingBoxFromContents(\SimpleXMLElement $node) {
		$result = $this->parseCoords(
			$this->selectOne(array('WGS84BoundingBox', 'LowerCorner'), $node, true, $this->getOwsNamespacePrefix(), true),
			$this->selectOne(array('WGS84BoundingBox', 'UpperCorner'), $node, true, $this->getOwsNamespacePrefix(), true)
		);

		if (empty($result)) {
			$crs = $this->selectOne(array('BoundingBox', 'crs'), $node, true, $this->getOwsNamespacePrefix(), true);
			if ($this->isWgs84($crs)) {
				$result = $this->parseCoords(
					$this->selectOne(array('BoundingBox', 'LowerCorner'), $node, true, $this->getOwsNamespacePrefix(), true),
					$this->selectOne(array('BoundingBox', 'UpperCorner'), $node, true, $this->getOwsNamespacePrefix(), true)
				);
			}
		}
		
		return $result;
	}
		
	protected function parseCoords($min, $max) {
		$regex = '~(-?\d*\.?\d+)\s+(-?\d*\.?\d+)~';
		if (preg_match($regex, $min, $minMatch) && preg_match($regex, $max, $maxMatch)) {
			$bbox = new GmBoundingBox();
			$bbox->setWest($minMatch[1])->setSouth($maxMatch[2])->setEast($minMatch[2])->setNorth($maxMatch[1]);
		}
		else {
			return null;
		}
	}

}