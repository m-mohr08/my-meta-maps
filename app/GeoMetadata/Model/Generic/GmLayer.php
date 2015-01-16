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

class GmLayer implements \GeoMetadata\Model\Layer {

	use \GeoMetadata\Model\BoundingBoxTrait, \GeoMetadata\Model\ExtraDataTrait;
	
	protected $id;
	protected $title;
	
	public function __construct($id = null, $title = null) {
		$this->id = $id;
		$this->title = $title;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}

	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}

	protected function createBoundingBoxObject() {
		return new GmBoundingBox();
	}

}
