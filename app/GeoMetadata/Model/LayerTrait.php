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

namespace GeoMetadata\Model;

trait LayerTrait {

	private $layers;
	
	protected abstract function createLayerObject($id, $title, $boundingBox);

	public function getLayers(){
		return $this->layers;
	}

	public function addLayer(Layer $layer){
		$this->layers[] = $layer;
	}

	public function createLayer($id, $title = null){
		$layer = $this->createLayerObject($id, $title, null);
		$this->layers[] = $layer;
		return $layer;
	}

	public function copyLayer(Layer $layer) {
		if ($layer !== null) {
			$newLayer = $this->createLayer($layer->getId(), $layer->getTitle());
			$newLayer->copyBoundingBox($layer->getBoundingBox());
			return $newLayer;
		}
		else {
			return null;
		}
	}

	public function removeLayer(Layer $layer){
		foreach ($this->layers as $key => $value) {
			if ($value === $layer) {
				unset($this->layers[$key]);
				return true;
			}
		}
		return false;
	}

}