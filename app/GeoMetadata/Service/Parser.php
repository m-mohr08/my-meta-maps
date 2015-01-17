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

namespace GeoMetadata\Service;

interface Parser {
	
	/**
	 * Creates a new parser object.
	 * 
	 * @return Parser
	 */
	public function createObject();
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode();
	
	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName();
	
	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url);
	
	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url);
	
	/**
	 * Returns which request method should be used for get the metadata.
	 * 
	 * Use GmNet::POST for POST method or GmNet::GET for GET method of HTTP 1.1.
	 * 
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataRequestMethod();

	/**
	 * Returns the body data for the HTTP request sent to the server to get the metadata.
	 * 
	 * @return string HTTP request body data or null for no data to be sent.
	 */
	public function getMetadataRequestData();
	
	/**
	 * Checks whether the given service data is of this type.
	 * 
	 * @param string $source String containing the data to parse.
	 * @return boolean true if content can be parsed, false if not.
	 */
	public function verify($source);
	
	/**
	 * Parses the data.
	 * 
	 * @param string $source String containing the data to parse.
	 * @param GeoMetadata\Model\Metadata $model An instance of a model class to fill with the data.
	 * @return boolean true on success, false on failure.
	 */
	public function parse($source, \GeoMetadata\Model\Metadata &$model);
	
}
