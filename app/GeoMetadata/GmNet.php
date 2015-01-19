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
 * Networking class. Does the HTTP requests for the services.
 */
class GmNet {
	
	const GET = false;
	const POST = true;
	
	protected $timeout;

	protected $proxyHost;
	protected $proxyPort;
	
	/**
	 * Constructs the GmNet object.
	 */
	public function __construct() {
		$this->timeout = 10;
		$this->proxyHost = GmRegistry::get('gm.proxy.host');
		$this->proxyPort = GmRegistry::get('gm.proxy.port');
	}
	
	/**
	 * Sets a proxy host and port to use for the HTTP requests.
	 * 
	 * @param string $host Proxy host (might include the port aswell)
	 * @param int $port Proxy port
	 */
	public function setProxy($host, $port) {
		$this->proxyHost = $host;
		$this->proxyPort = $port;
	}
	
	/**
	 * Sets a timeout in seconds for the HTTP requests.
	 * 
	 * @param int $timeout Timeout in seconds
	 */
	public function setTimeout($timeout) {
		$this->timeout = $timeout;
	}

	/**
	 * Downloads the content of a URL and returns it.
	 * 
	 * @param string $url URL to the data.
	 * @param boolean $post true to use the POST method instead of GET.
	 * @param string $body Additional data to send to the server as body of the request. If specified POST method is used anyway.
	 * @return Returns the content as string or null on failure.
	 */
	public function get($url, $post = false, $body = null) {
		// Check whether URL is given
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			return null;
		}

		// Nothing in the cache, load datan now
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, ($post || $body !== null) ? CURLOPT_POST : CURLOPT_HTTPGET, true);
		if ($body !== null) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		if (!empty($this->proxyHost)) {
			curl_setopt($ch, CURLOPT_PROXY, $this->proxyHost);
			if (intval($this->proxyPort) > 0) {
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxyPort);
			}
		}
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpcode < 200 || $httpcode >= 300) {
			$data = null;
		}
		curl_close($ch);

		return $data;
	}

}
