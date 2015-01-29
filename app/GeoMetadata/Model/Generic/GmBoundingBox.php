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

namespace GeoMetadata\Model\Generic;

use GeoMetadata\GmRegistry;

/**
 * Default bounding box implementation to be used by GeoMetadata to hold information about the bboxes of the metadata or layers.
 */
class GmBoundingBox implements \GeoMetadata\Model\BoundingBox {
	
	protected $north;
	protected $east;
	protected $south;
	protected $west;
	protected $crs;
	
	/**
	 * Creates a new instance of this class.
	 * 
	 * @return \static
	 */
	public static function create() {
		return new static();
	}
	
	/**
	 * Returns the coordinate reference system that belongs to this bounding box.
	 * 
	 * This is optional and might return null, which is normally indicating that we use WGS84.
	 * 
	 * @return string
	 */
	public function getCoordinateReferenceSystem() {
		return $this->crs;
	}
	/**
	 * Sets the coordinate reference system that belongs to this bounding box.
	 * 
	 * Might return null, which is normally indicating that WGS84 is used.
	 * 
	 * @param string $crs Coordinate reference system
	 */
	public function setCoordinateReferenceSystem($crs) {
		$this->crs = $crs;
	}
	
	/**
	 * Returns the value for the northern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getNorth() {
		return $this->north;
	}
	
	/**
	 * Sets the value for the northern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setNorth($north) {
		$this->north = (double) $north;
		return $this;
	}

	/**
	 * Returns the value for the eastern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getEast() {
		return $this->east;
		
	}
	/**
	 * Sets the value for the eastern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setEast($east) {
		$this->east = (double) $east;
		return $this;
	}

	/**
	 * Returns the value for the southern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getSouth() {
		return $this->south;
		
	}

	/**
	 * Sets the value for the southern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setSouth($south) {
		$this->south = (double) $south;
		return $this;
	}

	/**
	 * Returns the value for the western edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getWest() {
		return $this->west;
	}

	/**
	 * Sets the value for the western edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setWest($west) {
		$this->west = (double) $west;
		return $this;
	}

	/**
	 * Convenience method to set all edges of bounding box with one method call.
	 * 
	 * This is the same as calling setWest(), setSouth(), setEast() and setNorth() in a row.
	 * 
	 * @param double $west Western edge of the bbox
	 * @param double $south Southern edge of the bbox
	 * @param double $east Eastern edge of the bbox
	 * @param double $north Northern edge of the bbox
	 */
	public function set($west, $south, $east, $north) {
		$this->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
	}

	/**
	 * Returns an array containing two enumerated arrays.  The first array is containing the lower 
	 * (minimum) bounds and the second array is containing the upper (maximum) bounds. Both arrays
	 * contain an x/y pair (in this order). x is the longitude value, y is the latitude value.
	 * 
	 * @return array
	 */
	public function getArray() {
		return array(
			'west' =>$this->west, 
			'south' => $this->south,
			'east' => $this->east, 
			'north' => $this->north
		);
	}
	
	/**
	 * Returns the bounding box as WKT Polygon representation.
	 * 
	 * @return string
	 */
	public function toWkt() {
		// TODO: Replace this with geoPHP
		if ($this->defined()) {
			return "POLYGON(({$this->west} {$this->north},{$this->west} {$this->south},{$this->east} {$this->south},{$this->east} {$this->north},{$this->west} {$this->north}))";
		}
		else {
			return '';
		}
	}

	/**
	 * Sets the bounding box by taking the bounding box of the geometry that is parsed based on the
	 * given WKT compatible string.
	 * 
	 * @param string $wkt WKT
	 */
	public function fromWkt($wkt) {
		if (empty($wkt) || !class_exists('\geoPHP', false)) { // Avoid dependency to geoPHP for external usage
			return false;
		}
		try {
			$geometry = \geoPHP::load($wkt, "wkt");
			if ($geometry != null) {
				$bbox = $geometry->getBBox();
				$this->set($bbox['minx'], $bbox['miny'], $bbox['maxx'], $bbox['maxy']);
				return true;
			}
		}
		catch (Exception $e) {
			GmRegistry::log($e);
		}
		return false;
	}
	
	/**
	 * Returns a WKT representation of the bbox.
	 * 
	 * @see GmBoundingBox::toWkt()
	 * @return string
	 */
	public function __toString() {
		return $this->toWkt();
	}

	/**
	 * Returns whether the bounding box is fully defined or not.
	 * 
	 * The bbox is fully defined, when there are at least all edges (north, south, west, east) given.
	 * We don't care whether there is a CRS set or not.
	 * 
	 * @return boolean true if all edges are set, false if not.
	 */
	public function defined() {
		return (is_numeric($this->west) && is_numeric($this->south) && is_numeric($this->east) && is_numeric($this->north));
	}

	/**
	 * Merges the given bounding box with this one and calculates the bounding box of this merged
	 * geometry which is then set as the bounding box for this instance.
	 * 
	 * Undefined instances will be ignored. If the CRS of this instance and the other instance are 
	 * different than the other instance is ignored, too. If this instance has no CRS set, the 
	 * CRS of the other object will be used and set.
	 * 
	 * @see BoundingBox::defined()
	 * @param \GeoMetadata\Model\BoundingBox $other Bounding Box
	 */
	public function union(\GeoMetadata\Model\BoundingBox $other) {
		if (!$other->defined()) {
			// The other bbox is not valid/fully set. We can skip this.
			return;
		}
		if ($this->getCoordinateReferenceSystem() === null && !$this->defined()) {
			// This is an empty bounding box, we can do the union (which is more or less a copy)
			$this->setCoordinateReferenceSystem($other->getCoordinateReferenceSystem());
		}
		else if ($this->getCoordinateReferenceSystem() != $other->getCoordinateReferenceSystem()) {
			// CRS differ from BBoxes, throw error
			GmRegistry::log('Cannot union two bounding boxes with different CRS.');
			return;
		}
		// Grow the bbox
		if (!is_numeric($this->west) || $other->getWest() < $this->west) { // Search minimum
			$this->west = $other->getWest();
		}
		if (!is_numeric($this->north) || $other->getNorth() > $this->north) { // Search maximum
			$this->north = $other->getNorth();
		}
		if (!is_numeric($this->east) || $other->getEast() > $this->east) { // Search maximum
			$this->east = $other->getEast();
		}
		if (!is_numeric($this->south) || $other->getSouth() < $this->south) { // Search minimum
			$this->south = $other->getSouth();
		}
	}

}