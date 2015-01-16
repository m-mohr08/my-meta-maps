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

/**
 * Bounding Box implementation for My Meta Maps that only accepts WGS84 bounding boxes.
 */
trait GmGeodataBoundingBoxTrait {

	use \GeoMetadata\Model\BoundingBoxTrait;

	protected function createBoundingBoxObject() {
		return new GmGeodataBoundingBox();
	}
	
	public function createBoundingBox($west, $south, $east, $north, $crs = null) {
		if (Geodata::isWgs84($crs)) {
			$bbox = new GmGeodataBoundingBox();
			$bbox->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
			$bbox->setCoordinateReferenceSystem($crs);
			$this->bbox = $bbox->toWkt();
			return $bbox;
		}
		return null;
	}
	
	public function removeBoundingBox($crs) {
		if (Geodata::isWgs84($crs)) {
			$this->bbox = null;
		}
	}
	
	private function fromWkt($bbox) {
		$bbox = new GmGeodataBoundingBox();
		if ($bbox->fromWkt($bbox)) {
			return $bbox;
		}
		return null;
	}

	public function getBoundingBox($crs = null) {
		if ($crs !== null) {
			if (Geodata::isWgs84($crs)) {
				return $this->fromWkt($this->bbox);
			}
			return null;
		}
		else {
			$bbox = $this->fromWkt($this->bbox);
			$crs = array();
			if ($bbox !== null) {
				$crs['EPSG:4326'] = $bbox; // Set one of the WGS84 CRS, we don't know which exactly it was, but that doesn't really care.
			}
			return $crs;
		}
	}

	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		if ($bbox  !== null && Geodata::isWgs84($bbox->getCoordinateReferenceSystem())) {
			$this->bbox = $bbox->toWkt();
		}
	}
	
}