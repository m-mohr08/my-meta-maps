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

trait GmGeodataBoundingBoxTrait {
	
	public function createBoundingBox($west, $south, $east, $north) {
		$bbox = new GmGeodataBoundingBox();
		$bbox->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
		$this->bbox = $bbox->toWkt();
		return $this->bbox;
	}

	public function getBoundingBox() {
		$bbox = new GmGeodataBoundingBox();
		if ($bbox->fromWkt($this->bbox)) {
			return $bbox;
		}
		else {
			return null;
		}
	}

	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		$this->bbox = $bbox !== null ? $bbox->toWkt() : null;
	}

	public function copyBoundingBox(\GeoMetadata\Model\BoundingBox $bbox) {
		if ($bbox !== null && $bbox->defined()) {
			return $this->createBoundingBox($bbox->getWest(), $bbox->getSouth(), $bbox->getEast(), $bbox->getNorth());
		}
		else {
			return null;
		}
	}
	
}