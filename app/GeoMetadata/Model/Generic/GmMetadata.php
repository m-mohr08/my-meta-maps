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

class GmMetadata implements \GeoMetadata\Model\Metadata {
	
	protected $url;
	protected $service;
	protected $layers;
	
	protected $title;
	protected $boundingBox;
	protected $keywords;
	protected $description;
	protected $language;
	protected $author;
	protected $copyright;
	protected $license;

	protected $creationTime;
	protected $modifiedTime;
	
	protected $extra;
	
	public function __construct() {
		$this->layers = array();
		$this->keywords = array();
		$this->extra = array();
	}

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
		return $this->service;
	}

	public function setServiceCode($service){
		$this->service = $service;
	}

	public function getLayers(){
		return $this->layers;
	}

	public function addLayer(\GeoMetadata\Model\Layer $layer){
		$this->layers[] = $layer;
	}

	public function createLayer($id, $title = null){
		$layer = new GmLayer($id, $title, null);
		$this->layers[] = $layer;
		return $layer;
	}

	public function removeLayer(\GeoMetadata\Model\Layer $layer){
		foreach ($this->layers as $key => $value) {
			if ($value === $layer) {
				unset($this->layers[$key]);
				return true;
			}
		}
		return false;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getBoundingBox(){
		return $this->boundingBox;
	}
	
	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox = null) {
		$this->boundingBox = $bbox;
	}
	
	public function createBoundingBox($west, $north, $east, $south) {
		$this->boundingBox = GmBoundingBox::create()->setWest($west)->setNorth($north)->setEast($east)->setSouth($south);
		return $this->boundingBox;
	}

	public function getKeywords(){
		return $this->keywords;
	}

	public function setKeywords(array $keywords){
		$this->keywords = $keywords;
	}

	public function addKeyword($keyword){
		$this->keywords[] = $keyword;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
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
		return $this->creationTime;
	}

	public function setCreationTime(\DateTime $creation = null){
		$this->creationTime = $creation;
	}

	public function getModifiedTime(){
		return $this->modifiedTime;
	}

	public function setModifiedTime(\DateTime $modified = null){
		$this->modifiedTime = $modified;
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