<?php
/* 
 * Copyright 2014 Matthias Mohr
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

	public function detect($source) {
		// We don't parse the XML here as the regexp matching the root tags is much faster and we don't ask for validity anyway.
		return preg_match('~<((?:WMS|WMT_MS)_Capabilities)(?:\s[^>]+)?>.+</\1>~is', $source);
	}

	public function getName() {
		return 'OGC WMS';
	}

	public function getCode() {
		return 'wms';
	}

	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		// Metadata, but no language, no copyright, no creation and modification
		$model->setTitle($this->selectOne(array('Service', 'Title')));
		$model->setDescription($this->selectOne(array('Service', 'Abstract')));
		$model->setKeywords($this->selectMany(array('Service', 'KeywordList', 'Keyword')));
		$model->setAuthor($this->selectHierarchyAsOne(array('Service', 'ContactInformation')));
		$license = $this->selectOne(array('*', 'Service', 'AccessConstraints'));
		if (!empty($license) && strtolower($license) != 'none') {
			$model->setLicense($license);
		}
		
		// Boundingbox
		$bboxes = $this->getParser()->xpath("//*[local-name()='Capability']/*[local-name()='Layer']/*[local-name()='LatLonBoundingBox']|//*[local-name()='Capability']/*[local-name()='Layer']/*[local-name()='BoundingBox'][@CRS='EPSG:4326' or @CRS='CRS:84']");
		foreach ($bboxes as $bbox) {
			if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
				$model->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
				break;
			}
		}
		if ($model->getBoundingBox() == null) {
			// TODO: Add support for EX_GeographicBoundingBox
		}

		// Layer
		$nodes = $this->selectMany(array('Capability', 'Layer', 'Layer'), null, false);
		foreach ($nodes as $node) {
			$name = (string) $node->Name;
			if (!empty($name)) {
				$title = (string) $node->Title;
				$layer = $model->createLayer($name, $title, null);
				
				if (is_object($node->LatLonBoundingBox)) {
					$bbox = $node->LatLonBoundingBox->attributes();
					if (isset($bbox['minx']) && isset($bbox['miny']) && isset($bbox['maxx']) && isset($bbox['maxy'])) {
						$layer->createBoundingBox($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
					}
				}
				else {
					// TODO: Add support for EX_GeographicBoundingBox
				}
				// Inheritance of bbox from global WMS bbox
				if ($layer->getBoundingBox() == null) {
					$layer->setBoundingBox($model->getBoundingBox());
				}
			}
		}
		
		return true;
	}

}