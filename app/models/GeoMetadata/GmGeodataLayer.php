<?php

class GmGeodataLayer extends Layer implements GeoMetadata\Model\Layer  {
	
	private $extra;

	public function __construct($name = null, $title = null, BoundingBox $boundingBox = null) {
		parent::__construct();
		$this->setId($name);
		$this->setTitle($title);
		$this->setBoundingBox($boundingBox);
		$this->extra = array();
	}
	
	public function createBoundingBox($west, $north, $east, $south) {
		$bbox = new GeoMetadata\Model\Generic\GmBoundingBox();
		$bbox->setWest($west)->setNorth($north)->setEast($east)->setSouth($south);
		$this->bbox = $bbox->toWkt();
	}

	public function getBoundingBox() {
		if (empty($this->bbox)) {
			return null;
		}
		$geometry = geoPHP::load($this->bbox, "wkt");
		if ($geometry != null) {
			$c = $geometry->getBBox();
			$bbox = new GeoMetadata\Model\Generic\GmBoundingBox();
			$bbox->setWest($c['minx'])->setNorth($c['miny'])->setEast($c['maxx'])->setSouth($c['maxy']);
			return $bbox;
		}
		return null;
	}

	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		$this->bbox = $bbox !== null ? $bbox->toWkt() : null;
	}

	public function getId() {
		return $this->name;
	}

	public function setId($id) {
		$this->name = $id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setData($key, $value) {
		$this->extra[$key] = $value;
	}
	
	public function getData($key) {
		if (isset($this->extra[$key])) {
			return $this->extra[$key];
		}
		else {
			return null;
		}
	}

}