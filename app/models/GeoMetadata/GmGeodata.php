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

use \Carbon\Carbon;

/**
 * Extends the geodata model with the ability to be used as model in GeoMatadata Parser.
 */
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
		Log::warning("Removing layers not supported by Geodata model.");
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
			$bbox->setWest($c['minx'])->setSouth($c['miny'])->setEast($c['maxx'])->setNorth($c['maxy']);
			return $bbox;
		}
		return null;
	}
	
	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		$this->bbox = $bbox !== null ? $bbox->toWkt() : null;
	}
	
	public function createBoundingBox($west, $south, $east, $north) {
		$bbox = new GeoMetadata\Model\Generic\GmBoundingBox();
		$bbox->setWest($west)->setSouth($south)->setEast($east)->setNorth($north);
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

	public function getBeginTime(){
		return $this->start;
	}

	public function setBeginTime(\DateTime $begin = null){
		$this->start = $begin !== null ? Carbon::instance($begin) : null;
	}

	public function getEndTime(){
		return $this->end;
	}

	public function setEndTime(\DateTime $end = null){
		$this->end = $end !== null ? Carbon::instance($end) : null;
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
