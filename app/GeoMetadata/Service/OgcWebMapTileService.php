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

class OgcWebMapTileService extends OgcWebServicesCommon {

	// WMTS doesn't necessarily use the "normal" OGC way with &request=GetCapabilities&servcie=wmts
	// Therefore the capabilities xml file will be our url for metadata and service
	public function getServiceUrl($url) {
		return $url;
	}
	public function getMetadataUrl($url) {
		return $url;
	}
	
	public function getSupportedNamespaceUri() {
		return 'http://www.opengis.net/wmts/1.0';
	}

	public function getName() {
		return 'OGC WMTS';
	}

	public function getCode() {
		return 'wmts';
	}
	
	protected function findLayerNodes() {
		$nodes = $this->selectOne(array('Contents', 'Layer'), null, false);
		return $nodes->children($this->getOwsNamespacePrefix(), true);
	}

}