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
 * Bounding Box implementation for My Meta Maps that ONLY ACCEPTS WGS84 BOUNDING BOXES. All other
 * bboxes will be rejected.
 */
trait GmGeodataBoundingBoxTrait {

	use \GeoMetadata\Model\BoundingBoxContainerTrait;

	/**
	 * Returns a new instance of a class implementing the BoundingBox interface and 
	 * which is is compatible with the corresponding layer or metadata implementation.
	 * 
	 * @return \GmGeodataBoundingBox
	 */
	public function deliverBoundingBox() {
		return new GmGeodataBoundingBox();
	}

	/**
	 * Creates a new bbox by calling deliverBoundingBox() and setting all given data to the new object.
	 * 
	 * The newly created object will be added to the list of bboxes and finally it's returned to be used.
	 * The new object might replace a previously existing bbox with the same CRS.
	 *
	 * Note: Only accepts CRS names that are a synonym for WGS84. Giving other CRS names will let the method return null.
	 * 
	 * @see \GeoMetadata\Model\BoundingBoxContainer::addBoundingBox()
	 * @see \GeoMetadata\Model\BoundingBoxContainer::deliverBoundingBox()
	 * @param double $west Western edge of the bbox
	 * @param double $south Southern edge of the bbox
	 * @param double $east Eastern edge of the bbox
	 * @param double $north Northern edge of the bbox
	 * @param string $crs CRS name (can be an empty string)
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	public function createBoundingBox($west, $south, $east, $north, $crs = null) {
		if (Geodata::isWgs84($crs)) {
			$bbox = new GmGeodataBoundingBox();
			$bbox->set($west, $south, $east, $north);
			$bbox->setCoordinateReferenceSystem($crs);
			$this->bbox = $bbox->toWkt();
			return $bbox;
		}
		return null;
	}

	/**
	 * Removed the bbox associated to the given CRS name from the list of bboxes.
	 * 
	 * Note: Only accepts CRS names that are a synonym for WGS84. All other CRS names have no effect.
	 * 
	 * @param string $crs CRS name
	 */
	public function removeBoundingBox($crs) {
		if (Geodata::isWgs84($crs)) {
			$this->bbox = null;
		}
	}

	/**
	 * Returns a bounding box filled with the coordinates parsed from the WKT compatible string.
	 * 
	 * @param string $wkt WKT
	 * @return BoundingBox|null
	 */
	private function fromWkt($wkt) {
		$bbox = $this->deliverBoundingBox();
		if ($bbox->fromWkt($wkt)) {
			return $bbox;
		}
		return null;
	}

	/**
	 * Returns the stored bbox for the given CRS.
	 * If you specify null as CRS you'll get the complete list of bboxes.
	 *
	 * Note: Only accepts CRS names that are a synonym for WGS84. All other CRS names will return null.
	 * 
	 * @param string $crs CRS name
	 * @return BoundingBox|array|null
	 */
	public function getBoundingBox($crs = null) {
		if ($crs !== null) {
			if (Geodata::isWgs84($crs)) {
				return $this->fromWkt($this->bbox);
			}
			return null;
		}
		else {
			$bbox = $this->fromWkt($this->bbox);
			$list = array();
			if ($bbox !== null) {
				$bbox->setCoordinateReferenceSystem('EPSG:4326'); // Set one of the WGS84 CRS, we don't know which exactly it was, but that doesn't really care.
				$list[$bbox->getCoordinateReferenceSystem()] = $bbox;
			}
			return $list;
		}
	}

	/**
	 * Adds a bbox to the list of bboxes.
	 * 
	 * If there is already a bbox for the CRS associated to the bbox, the new bbox will replace
	 * the previously stored bbox.
	 *
	 * You can specify null as CRS which will do nothing. It's just more convenient than
	 * aloways checking for null before calling this method.
	 * 
	 * Note: Only accepts bboxes with a CRS name that is an synonym for WGS84. All other bboxes will be rejected.
	 * 
	 * @param \GeoMetadata\Model\BoundingBox $bbox BBox to be added
	 */
	public function addBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		if ($bbox  !== null && Geodata::isWgs84($bbox->getCoordinateReferenceSystem())) {
			$this->bbox = $bbox->toWkt();
		}
	}
	
}