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
 * Extends the ORM layer model with the ability to be used as model in GeoMatadata Parser.
 */
class GmGeodataLayer extends Layer implements GeoMetadata\Model\Layer, \GeoMetadata\Model\ExtraDataContainer  {

	use GmGeodataBoundingBoxTrait, \GeoMetadata\Model\ExtraDataContainerTrait;

	/**
	 * Constructs a GmGeodataLayer.
	 * 
	 * @param string $name Service-wirde unique identifier
	 * @param strin $title Title
	 */
	public function __construct($name = null, $title = null) {
		parent::__construct();
		$this->setId($name);
		$this->setTitle($title);
	}
	
	/**
	 * Returns the identifier of the layer. Must be unique across the Service.
	 * 
	 * @return string
	 */
	public function getId() {
		return $this->name;
	}

	/**
	 * Sets the identifier of the layer. Must be unique across the Service.
	 * 
	 * @param string Identifier
	 */
	public function setId($id) {
		$this->name = $id;
	}

	/**
	 * Returns the title for the layer.
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets a title for the layer.
	 * 
	 * @param string Title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

}