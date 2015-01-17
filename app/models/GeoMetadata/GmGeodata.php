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
class GmGeodata extends Geodata implements GeoMetadata\Model\Metadata, \GeoMetadata\Model\ExtraDataContainer {

	use GmGeodataBoundingBoxTrait, \GeoMetadata\Model\LayerContainerTrait, \GeoMetadata\Model\ExtraDataContainerTrait;

	public function createObject() {
		return new static();
	}

	public function deliverLayer() {
		return new GmGeodataLayer();
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

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getAbstract(){
		return $this->abstract;
	}

	public function setAbstract($abstract){
		$this->abstract = $abstract;
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

}
