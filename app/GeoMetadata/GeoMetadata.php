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

/**
 * Main class for GeoMetadata. 
 */
class GeoMetadata {

	protected $serviceUrl;
	protected $metadataUrl;
	protected $data;
	protected $service;
	protected $model;

	/**
	 * Constructor for the GeoMetadata class.
	 * 
	 * Note: Construction is only possible with static methods withUrl() or withData() from outside of this class.
	 */
	protected function __construct() {
		// Construction only with static methods withUrl() or withData().
	}
	
	/**
	 * Returns a new GeoMetadata object based on an URL input as metadata source.
	 * 
	 * @param string $url URL of the dataset
	 * @param string $code Code of the parser to be used for parsing.
	 * @return \GeoMetadata\GeoMetadata|null
	 */
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
	/**
	 * Returns a new GeoMetadata object based on a string as metadata source.
	 * 
	 * @param string $data Data to be parsed
	 * @return \GeoMetadata\GeoMetadata|null
	 */
	public static function withData($data) {
		$instance = new self();
		$instance->data = $data;
		if ($instance->detect()) {
			return $instance;
		}
		return null;
	}

	/**
	 * Returns the base URL of the service.
	 * 
	 * @return string
	 */
	public function getURL() {
		return $this->serviceUrl;
	}

	/**
	 * Returns the base URL where the metadata of the service can be found.
	 * 
	 * @return string
	 */
	public function getMetadataURL() {
		return $this->metadataUrl;
	}
	
	/**
	 * Returns the string containing the data to be parsed.
	 * 
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Returns the service/parser that will be used.
	 * 
	 * @return \GeoMetadata\Model\Service\Parser
	 */
	public function getService() {
		return $this->service;
	}
	
	/**
	 * Sets the model that should be used to store the data.
	 * 
	 * @param \GeoMetadata\Model\Metadata $model
	 */
	public function setModel(\GeoMetadata\Model\Metadata $model = null) {
		$this->model = $model;
	}
	
	/**
	 * Creates a new model and returns it.
	 * 
	 * @return \GeoMetadata\Model\Generic\GmMetadata
	 */
	protected function createModel() {
		if ($this->model == null) {
			return new \GeoMetadata\Model\Generic\GmMetadata();
		}
		else {
			return $this->model->createObject();
		}
	}

	/**
	 * Tries to detects the dataformat that is given by the data.
	 * 
	 * @return boolean true on success, false on failure
	 */
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

	/**
	 * Parses the data and returns a filled instance of the given model.
	 * 
	 * @return \GeoMetadata\Model\Generic\GmMetadata
	 */
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
