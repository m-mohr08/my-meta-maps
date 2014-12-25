<?php
/* 
 * Copyright 2014 Matthias Mohr
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

namespace GeoMetadata;

use GeoMetadata\Service\Parser;

class GeoMetadata {
	
	private $url;
	private $data;
	private $model;
	private $net;
	
	public function __construct() {
		$this->net = new GmNet();
	}
	
	public function setURL($url) {
		$this->url = $url;
	}
	
	public function getURL() {
		return $this->url;
	}
	
	public function setData($data) {
		$this->data = $data;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function setModel(\GeoMetadata\Model\Metadata $model = null) {
		$this->model = $model;
	}
	
	public function getModel($new = true) {
		if ($new) {
			if ($this->model == null) {
				return new \GeoMetadata\Model\Generic\GmMetadata();
			}
			else {
				return $this->model->createObject();
			}
		}
		else {
			return $this->model;
		}
	}

	public function detect($all = false) {
		$services = GmRegistry::getServices();

		// Quick check for URLs, works not for $all = true as not all parsers support it.
		if ($all === false) {
			foreach ($services as $service) {
				if ($service->detectByUrl($this->data)) {
					return $service;
				}
			}
		}
		
		if (!$this->loadData()) {
			return null;
		}
		
		$detected = array();
		foreach ($services as $service) {
			if ($service->detect($this->data)) {
				if ($all) {
					$detected[] = $service;
				}
				else {
					return $service;
				}
			}
		}

		return $detected;
	}
	
	public function parse(Parser $parser) {
		if ($parser == null || !$this->loadData()) {
			return null;
		}

		$model = $this->getModel();
		$model->setUrl($this->url);
		$model->setServiceCode($parser->getCode());
		if ($parser->parse($this->data, $model)) {
			return $model;
		}
		else {
			return null;
		}
	}
	
	protected function loadData() {
		if (empty($this->data) && !empty($this->url)) {
			$net = new GmNet();
			$this->data = $net->get($this->url);
		}
		
		if (empty($this->data)) {
			return false;
		}
		else {
			return true;
		}
	}

}
