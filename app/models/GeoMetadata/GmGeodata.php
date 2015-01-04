<?php

use \Carbon\Carbon;

class GmGeodata extends Geodata implements GeoMetadata\Model\Metadata {

	// Attributes for the interface - not stored in DB
	private $gmLayer = array();
	private $gmExtra = array();

	public function createObject() {
		return new static();
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function getServiceCode(){
		return $this->datatype;
	}

	public function setServiceCode($service){
		$this->datatype = $service;
	}

	public function getLayers(){
		return $this->gmLayer;
	}

	public function addLayer(\GeoMetadata\Model\Layer $layer){
		$this->gmLayer[] = $layer;
	}

	public function createLayer($id, $title = null){
		$layer = new GmGeodataLayer($id, $title);
		$this->gmLayer[] = $layer;
		return $layer;
	}

	public function removeLayer(\GeoMetadata\Model\Layer $layer){
		App::debug("Removing layers not supported by Geodata model.");
		return false;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getBoundingBox(){
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
	
	public function createBoundingBox($west, $north, $east, $south) {
		$bbox = new GeoMetadata\Model\Generic\GmBoundingBox();
		$bbox->setWest($west)->setNorth($north)->setEast($east)->setSouth($south);
		$this->bbox = $bbox->toWkt();
	}

	public function getDescription(){
		return $this->abstract;
	}

	public function setDescription($description){
		$this->abstract = $description;
	}

	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($language){
		$this->language = $language;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getCopyright(){
		return $this->copyright;
	}

	public function setCopyright($copyright){
		$this->copyright = $copyright;
	}

	public function getLicense() {
		return $this->license;
	}

	public function setLicense($license) {
		$this->license = $license;
	}

	public function getCreationTime(){
		return $this->creation;
	}

	public function setCreationTime(\DateTime $creation = null){
		$this->creation = $creation !== null ? Carbon::instance($creation) : null;
	}

	public function getModifiedTime(){
		return $this->modified;
	}

	public function setModifiedTime(\DateTime $modified = null){
		$this->modified = $modified !== null ? Carbon::instance($modified) : null;
	}
	
	public function setData($key, $value) {
		$this->gmExtra[$key] = $value;
	}
	
	public function getData($key) {
		if (isset($this->gmExtra[$key])) {
			return $this->gmExtra[$key];
		}
		else {
			return null;
		}
	}

}
