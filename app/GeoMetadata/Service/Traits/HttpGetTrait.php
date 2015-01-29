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

namespace GeoMetadata\Service\Traits;

use GeoMetadata\GmNet;

/**
 * Default implementation for services that use GET requests to get the metadata.
 */
trait HttpGetTrait {

	/**
	 * Returns the body data for the HTTP request sent to the server to get the metadata.
	 * 
	 * @return string HTTP request body data or null for no data to be sent.
	 */
	public function getMetadataRequestData() {
		return null;
	}

	/**
	 * Returns which request method should be used for get the metadata.
	 * 
	 * Use GmNet::POST for POST method or GmNet::GET for GET method of HTTP 1.1.
	 * 
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataRequestMethod() {
		return GmNet::GET;
	}
	
}