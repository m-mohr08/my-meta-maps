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

/**
 * Default layer implementation to be used by GeoMetadata to hold information about the layer (or similar things) of the service.
 */
class GmLayer implements \GeoMetadata\Model\Layer, \GeoMetadata\Model\ExtraDataContainer {

	use \GeoMetadata\Model\BoundingBoxContainerTrait, \GeoMetadata\Model\ExtraDataContainerTrait;
	
	protected $id;
	protected $title;

	/**
	 * Constructs a GmLayer.
	 * 
	 * @param string $id Service-wirde unique identifier
	 * @param strin $title Title
	 */
	public function __construct($id = null, $title = null) {
		$this->id = $id;
		$this->title = $title;
	}
	
	/**
	 * Returns the identifier of the layer. Must be unique across the Service.
	 * 
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets the identifier of the layer. Must be unique across the Service.
	 * 
	 * @param string Identifier
	 */
	public function setId($id) {
		$this->id = $id;
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

	/**
	 * Returns a new instance of a class implementing the BoundingBox interface and 
	 * which is is compatible with this layer implementation.
	 * 
	 * @return \GeoMetadata\Model\Generic\GmBoundingBox
	 */
	public function deliverBoundingBox() {
		return new GmBoundingBox();
	}

}
