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

class GmBoundingBox implements \GeoMetadata\Model\BoundingBox {
	
	protected $north;
	protected $east;
	protected $source;
	protected $west;
	
	public static function create() {
		return new static();
	}
	
	public function getNorth() {
		return $this->north;
	}

	public function setNorth($north) {
		$this->north = $north;
		return $this;
	}
	
	public function getEast() {
		return $this->east;
		
	}

	public function setEast($east) {
		$this->east = $east;
		return $this;
	}
	
	public function getSouth() {
		return $this->south;
		
	}

	public function setSouth($south) {
		$this->south = $south;
		return $this;
	}
	
	public function getWest() {
		return $this->west;
	}

	public function setWest($west) {
		$this->west = $west;
		return $this;
	}

	public function getArray() {
		return array(array($this->west, $this->south), array($this->east, $this->north));
	}
	
	public function toWkt() {
		// TODO: Replace this with geoPHP
		if ($this->defined()) {
			return "POLYGON(({$this->west} {$this->north},{$this->west} {$this->south},{$this->east} {$this->south},{$this->east} {$this->north},{$this->west} {$this->north}))";
		}
		else {
			return null;
		}
	}

	public function fromWkt($wkt) {
		if (empty($wkt)) {
			return null;
		}
		try {
			$geometry = geoPHP::load($wkt, "wkt");
			if ($geometry != null) {
				$bbox = $geometry->getBBox();
				$this->setWest($bbox['minx'])->setSouth($bbox['miny'])->setEast($bbox['maxx'])->setNorth($bbox['maxy']);
				return true;
			}
		}
		catch (Exception $e) {
			Log::info($e);
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