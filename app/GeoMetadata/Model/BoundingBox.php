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

interface BoundingBox {
	
	public function getNorth();
	public function setNorth($north);
	
	public function getEast();
	public function setEast($east);
	
	public function getSouth();
	public function setSouth($south);
	
	public function getWest();
	public function setWest($west);

	public function getArray();
	public function toWkt();

}