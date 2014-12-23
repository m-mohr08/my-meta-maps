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
	
	public function __construct() {
		$this->model = null;
	}
	
	public function setURL($url) {
		$this->url = $url;
	}
	
	public function getURL($url) {
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
				return new \GeoMetadata\Model\Generic\Metadata();
			}
			else {
				$class = get_class($this->model);
				return new $class;
			}
		}
		else {
			return $this->model;
		}
	}
	
	public function detect($all = false) {
		if (!$this->init()) {
			return null;
		}
		
		$detected = array();
		foreach (self::getServices() as $service) {
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
		if (!$this->init() || $parser == null) {
			return null;
		}

		$model = $this->getModel();
		$model->setUrl($this->url);
		$model->setService($parser->getType());
		if ($parser->parse($this->data, $model)) {
			return $model;
		}
		else {
			return null;
		}
	}
	
	protected function init() {
		if (empty($this->data) && !empty($this->url)) {
			$this->data = $this->fetch($this->url);
		}
		
		if (empty($this->data)) {
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Downloads the content of a URL and returns it.
	 * 
	 * @param string $url URL to the data.
	 * @param int $timeout Timeout for the connection.
	 * @return Returns the content as string or null on failure.
	 */
	protected function fetch($url, $timeout = 5) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		// TODO: Don't hard wire this proxy here...
		curl_setopt($ch, CURLOPT_PROXY, 'wwwproxy.uni-muenster.de:80');
		curl_setopt($ch, CURLOPT_PROXYPORT, 80);
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return ($httpcode >= 200 && $httpcode < 300) ? $data : null;
	}
	
	// Static part of the class
	
	private static $services = array();
	private static $logger = null;
	
	public static function registerService(Parser $parser) {
		if ($parser != null) {
			self::$services[$parser->getType()] = $parser;
		}
	}

	public static function getServices() {
		return array_values(self::$services);
	}

	public static function getService($type) {
		if (isset(self::$services[$type])) {
			return self::$services[$type];
		}
		else {
			return null;
		}
	}
	
	public static function setLogger($logger) {
		if (is_callable(self::$logger)) {
			self::$logger = $logger;
		}
	}
	
	public static function debug($message) {
		call_user_func(self::$logger, $message);
	}

}
