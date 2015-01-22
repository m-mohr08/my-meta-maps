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

trait BoundingBoxContainerTrait {
	
	private $boundingBox = array();

	/**
	 * Returns a new instance of a class implementing the BoundingBox interface and 
	 * which is is compatible with the implementation of the layer or metadata based class.
	 * 
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	public abstract function deliverBoundingBox();
	
	public function getCoordinateReferenceSystems() {
		return array_keys($this->getBoundingBox());
	}

	public function hasBoundingBox($crs = null) {
		$result = $this->getBoundingBox($crs);
		return !empty($result);
	}

	public function getBoundingBox($crs = null){
		if ($crs !== null) {
			return isset($this->boundingBox[$crs]) ? $this->boundingBox[$crs] : null;
		}
		else {
			return $this->boundingBox;
		}
	}
	
	public function removeBoundingBox($crs) {
		if ($this->hasBoundingBox($crs)) {
			unset($this->boundingBox[$crs]);
		}
	}
	
	public function addBoundingBox(BoundingBox $bbox = null) {
		if ($bbox === null) {
			return;
		}
		$crs = $bbox->getCoordinateReferenceSystem();
		$this->boundingBox[$crs] = $bbox;
	}
	
	public function createBoundingBox($west, $south, $east, $north, $crs = '') {
		$bbox = $this->deliverBoundingBox()->set($west, $south, $east, $north);
		$bbox->setCoordinateReferenceSystem($crs);
		$this->addBoundingBox($bbox);
		return $bbox;
	}

	public function copyBoundingBox($bbox = null) {
		if ($bbox === null) {
			return null;
		}
		if (is_array($bbox)) {
			foreach ($bbox as $box) {
				if ($box !== null) { // Double check this to prevent an endless loop
					$this->copyBoundingBox($box);
				}
			}
			return $this->getBoundingBox();
		}
		else if ($bbox instanceof BoundingBox && $bbox->defined()) {
			return $this->createBoundingBox($bbox->getWest(), $bbox->getSouth(), $bbox->getEast(), $bbox->getNorth(), $bbox->getCoordinateReferenceSystem());
		}
	}

}