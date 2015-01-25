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

/**
 * Interface that models the metadata of a geo dataset to be used by GeoMetadata to hold information
 * about the service, like title, abstract, keywords, times, bboxes, layers, language, license etc.
 * 
 * @see BoundingBoxContainer
 * @see LayerContainer
 */
interface Metadata extends BoundingBoxContainer, LayerContainer {

	/**
	 * Creates a new object of the implementing class.
	 * 
	 * @return Metadata
	 */
	public function createObject();

	/**
	 * Returns the URL that has been specified.
	 * 
	 * Might not be set if the perser has been called using the metadata source and without any URL.
	 * 
	 * @return string|null
	 */
	public function getUrl();
	/**
	 * Sets the URL.
	 * 
	 * @param string|null $url URL
	 */
	public function setUrl($url);

	/**
	 * Returns the service code that will be or has been used for parsing.
	 * 
	 * @return string|null
	 */
	public function getServiceCode();
	/**
	 * Sets the service code of the parser.
	 * 
	 * Has no impact for parsing, this does not set the parser for parsing.
	 * 
	 * @see \GeoMetadata\Service\Parser::getCode()
	 * @param string|null $service Service Code
	 */
	public function setServiceCode($service);

	/**
	 * Returns the parsed title of the geo dataset.
	 * 
	 * @return string|null
	 */
	public function getTitle();
	/**
	 * Sets the title of the geo dataset.
	 * 
	 * @param string|null $title Title
	 */
	public function setTitle($title);

	/**
	 * Returns the parsed keywords/tags of the geo dataset as array.
	 * 
	 * @return array
	 */
	public function getKeywords();
	/**
	 * Sets the list of keywords/tags for the geo dataset.
	 * 
	 * @param array $keywords List of keywords
	 */
	public function setKeywords(array $keywords);
	/**
	 * Adds a keyword/tag to the list of keywords/tags.
	 * 
	 * @param string $keyword Keyword/Tag
	 */
	public function addKeyword($keyword);

	/**
	 * Returns the parsed description/abstract of the geo dataset.
	 * 
	 * @return string|null
	 */
	public function getAbstract();
	/**
	 * Sets the description/abstract of the geo dataset.
	 * 
	 * @param string|null $abstract Abstract
	 */
	public function setAbstract($abstract);

	/**
	 * Returns the parsed language of the geo dataset.
	 * 
	 * This should be an ISO 639-1 based language code, but some parsers might return other types of data.
	 * 
	 * @return string|null
	 */
	public function getLanguage();
	/**
	 * Sets the language of the geo dataset.
	 * 
	 * This should be an ISO 639-1 based language code, but some parsers might return other types of data.
	 * 
	 * @param string|null $language ISO 639-1 language code
	 */
	public function setLanguage($language);

	/**
	 * Returns the parsed author/service provider of the geo dataset.
	 * 
	 * @return string|null
	 */
	public function getAuthor();
	/**
	 * Sets the author/service provider of the geo dataset.
	 * 
	 * @param string|null $author Author information
	 */
	public function setAuthor($author);

	/**
	 * Returns the parsed copyright notice of the geo dataset.
	 * 
	 * @return string|null
	 */
	public function getCopyright();
	/**
	 * Sets the copyright notice of the geo dataset.
	 * 
	 * @param string|null $copyright Copyright notice
	 */
	public function setCopyright($copyright);

	/**
	 * Returns the parsed licensing information of the geo dataset.
	 * 
	 * @return string|null
	 */
	public function getLicense();
	/**
	 * Sets the licensing information of the geo dataset.
	 * 
	 * @param string|null $license License
	 */
	public function setLicense($license);

	/**
	 * Returns the parsed minimum timestamp of the geo dataset.
	 * 
	 * @return \DateTime|null
	 */
	public function getBeginTime();
	/**
	 * Sets the minimum timestamp of the geo dataset.
	 * 
	 * @param \DateTime|null $begin
	 */
	public function setBeginTime(\DateTime $begin = null);

	/**
	 * Returns the parsed maximum timestamp of the geo dataset.
	 * 
	 * @return \DateTime|null
	 */
	public function getEndTime();
	/**
	 * Sets the maximum timestamp of the geo dataset.
	 * 
	 * @param \DateTime|null $end
	 */
	public function setEndTime(\DateTime $end = null);
	
}