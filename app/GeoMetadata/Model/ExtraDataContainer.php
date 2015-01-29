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

/**
 * Container for extra data that can be added to a class repectively an object.
 */
interface ExtraDataContainer {

	/**
	 * Sets/adds/replaces (depending on the key) data and assigns it to the given key.
	 * 
	 * @param string $key Key
	 * @param mixed $value Data
	 */
	public function setData($key, $value);
	
	/**
	 * Returns data that belongs to the given key if data is set for the key.
	 * 
	 * @param string $key Key
	 * @returns mixed Data or null if nothing has been set for this key
	 */
	public function getData($key);
	
	/**
	 * Checks whether data has been set for the given key.
	 * 
	 * @param string $key Key
	 * @returns boolean true if data is available, false otherwise.
	 */
	public function hasData($key);

}