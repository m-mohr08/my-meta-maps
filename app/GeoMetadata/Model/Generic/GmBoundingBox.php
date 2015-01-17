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

class GmBoundingBox implements \GeoMetadata\Model\BoundingBox {
	
	protected $north;
	protected $east;
	protected $south;
	protected $west;
	protected $crs;
	
	public static function create() {
		return new static();
	}

	public function getCoordinateReferenceSystem() {
		return $this->crs;
	}

	public function setCoordinateReferenceSystem($crs) {
		$this->crs = $crs;
	}
	
	public function getNorth() {
		return $this->north;
	}

	public function setNorth($north) {
		$this->north = (double) $north;
		return $this;
	}
	
	public function getEast() {
		return $this->east;
		
	}

	public function setEast($east) {
		$this->east = (double) $east;
		return $this;
	}
	
	public function getSouth() {
		return $this->south;
		
	}

	public function setSouth($south) {
		$this->south = (double) $south;
		return $this;
	}
	
	public function getWest() {
		return $this->west;
	}

	public function setWest($west) {
		$this->west = (double) $west;
		return $this;
	}
	
	public function set($west, $south, $east, $north) {
		$this->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
	}

	public function getArray() {
		return array(
			'west' =>$this->west, 
			'south' => $this->south,
			'east' => $this->east, 
			'north' => $this->north
		);
	}
	
	public function toWkt() {
		// TODO: Replace this with geoPHP
		if ($this->defined()) {
			return "POLYGON(({$this->west} {$this->north},{$this->west} {$this->south},{$this->east} {$this->south},{$this->east} {$this->north},{$this->west} {$this->north}))";
		}
		else {
			return '';
		}
	}

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
	
	public function __toString() {
		return $this->toWkt();
	}
	
	public function defined() {
		return (is_numeric($this->west) && is_numeric($this->south) && is_numeric($this->east) && is_numeric($this->north));
	}

	public function union(\GeoMetadata\Model\BoundingBox $other) {
		if ($other === null || !$other->defined()) {
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