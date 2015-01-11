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

interface Metadata extends BoundingBoxTrait {
	
	public function createObject();

	public function getUrl();
	public function setUrl($url);

	public function getServiceCode();
	public function setServiceCode($service);

	public function getLayers();
	public function addLayer(Layer $layer);
	public function createLayer($id, $title = null);
	public function removeLayer(Layer $layer);

	public function getTitle();
	public function setTitle($title);

	public function getKeywords();
	public function setKeywords(array $keywords);
	public function addKeyword($keyword);

	public function getDescription();
	public function setDescription($description);

	public function getLanguage();
	public function setLanguage($language);

	public function getAuthor();
	public function setAuthor($author);

	public function getCopyright();
	public function setCopyright($copyright);

	public function getLicense();
	public function setLicense($license);

	public function getBeginTime();
	public function setBeginTime(\DateTime $begin = null);

	public function getEndTime();
	public function setEndTime(\DateTime $end = null);

	public function setData($key, $value);
	public function getData($key);
	
}