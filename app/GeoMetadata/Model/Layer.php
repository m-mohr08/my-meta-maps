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

namespace GeoMetadata\Model;

interface Layer extends BoundingBoxContainer {
	
	/**
	 * Returns the identifier of the layer. Must be unique across the Service.
	 * 
	 * @return string
	 */
	public function getId();
	/**
	 * Sets the identifier of the layer. Must be unique across the Service.
	 * 
	 * @param string Identifier
	 */
	public function setId($id);

	/**
	 * Returns the title for the layer.
	 * 
	 * @return string
	 */
	public function getTitle();
	/**
	 * Sets a title for the layer.
	 * 
	 * @param string Title
	 */
	public function setTitle($title);
	
}