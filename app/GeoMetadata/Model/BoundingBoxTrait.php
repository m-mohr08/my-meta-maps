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

trait BoundingBoxTrait {
	
	private $boundingBox;

	protected abstract function createBoundingBoxObject();

	public function getBoundingBox(){
		return $this->boundingBox;
	}
	
	public function setBoundingBox(BoundingBox $bbox = null) {
		$this->boundingBox = $bbox;
	}
	
	public function createBoundingBox($west, $south, $east, $north) {
		$this->boundingBox = $this->createBoundingBoxObject()->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
		return $this->boundingBox;
	}

	public function copyBoundingBox(BoundingBox $bbox = null) {
		if ($bbox !== null && $bbox->defined()) {
			return $this->createBoundingBox($bbox->getWest(), $bbox->getSouth(), $bbox->getEast(), $bbox->getNorth());
		}
		else {
			return null;
		}
	}

}