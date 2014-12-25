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

class GmRegistry {

	private static $config = array();
	private static $services = array();
	
	// General config
	
	public static function get($key) {
		if (isset(self::$config[$key])) {
			return self::$config[$key];
		}
		else {
			return null;
		}
	}
	
	public static function set($key, $value) {
		self::$config[$key] = $value;
	}
	
	// Register parsing services

	public static function registerService(Parser $parser) {
		if ($parser != null) {
			self::$services[$parser->getCode()] = $parser;
		}
	}

	public static function getServices() {
		$services = array();
		foreach (self::$services as $service) {
			$services[] = $service->createObject();
		}
		return $services;
	}

	public static function getService($type) {
		if (isset(self::$services[$type])) {
			return self::$services[$type]->createObject();
		}
		else {
			return null;
		}
	}
	
	// Logging
	
	public static function setLogger($logger) {
		if (is_callable($logger)) {
			self::set('gm.logger', $logger);
		}
	}
	
	public static function log($message) {
		$logger = self::get('gm.logger');
		if (is_callable($logger)) {
			call_user_func($logger, $message);
		}
	}
	
	// Proxy

	public static function setProxy($host, $port = 0) {
		self::set('gm.proxy.host', $host);
		self::set('gm.proxy.port', $port);
	}

}
