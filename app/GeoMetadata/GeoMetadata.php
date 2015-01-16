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

namespace GeoMetadata;

class GeoMetadata {

	protected $serviceUrl;
	protected $metadataUrl;
	protected $data;
	protected $service;
	protected $model;

	protected function __construct() {
		// Construction only with static methods withUrl() or withData().
	}
	
	public static function withUrl($url, $code) {
		$instance = new self();
		$instance->service = GmRegistry::getService($code);
		if ($instance->service != null) {
			$instance->serviceUrl = $instance->service->getServiceUrl($url);
			$instance->metadataUrl = $instance->service->getMetadataUrl($url);
			
			$net = new GmNet();
			$instance->data = $net->get(
				$instance->metadataUrl,
				$instance->service->getMetadataRequestMethod(),
				$instance->service->getMetadataRequestData()
			);
			if ($instance->data != null && $instance->service->verify($instance->data)) {
				return $instance;
			}
		}
		return null;
	}
	
	public static function withData($data) {
		$instance = new self();
		$instance->data = $data;
		if ($instance->detect()) {
			return $instance;
		}
		return null;
	}

	public function getURL() {
		return $this->serviceUrl;
	}

	public function getMetadataURL() {
		return $this->metadataUrl;
	}
	
	public function getData() {
		return $this->data;
	}

	public function getService() {
		return $this->service;
	}
	
	public function setModel(\GeoMetadata\Model\Metadata $model = null) {
		$this->model = $model;
	}
	
	protected function createModel() {
		if ($this->model == null) {
			return new \GeoMetadata\Model\Generic\GmMetadata();
		}
		else {
			return $this->model->createObject();
		}
	}

	protected function detect() {
		if ($this->service == null) {
			$services = GmRegistry::getServices();
			foreach ($services as $service) {
				if ($service->verify($this->data)) {
					$this->service = $service;
					return true;
				}
			}
		}
		return false;
	}

	public function parse() {
		$model = $this->createModel();
		$model->setUrl($this->serviceUrl);
		$model->setServiceCode($this->service->getCode());
		if ($this->service->parse($this->data, $model)) {
			return $model;
		}
		else {
			return null;
		}
	}

}
