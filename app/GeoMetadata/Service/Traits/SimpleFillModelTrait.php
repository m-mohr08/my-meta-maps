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

/**
 * Simple trait that can be used to separate the parsing of the single data in the fillModel method.
 */
trait SimpleFillModelTrait {

	private $called = array();
	private $model;

	/**
	 * The given model will be filled with the parsed data.
	 * 
	 * @param \GeoMetadata\Model\Metadata $model Instance of the model to be filled with the parsed data.
	 * @return boolean true on success, false on failure
	 */
	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$this->model = $model;
		// Get all data we want to parse. 
		// Data is set to the model directly in the get methods.
		$this->getAuthor();
		$this->getCopyright();
		$this->getAbstract();
		$this->getKeywords();
		$this->getLanguage();
		$this->getLicense();
		$this->getBeginTime();
		$this->getEndTime();
		$this->getTitle();
		$this->getBoundingBox();
		$this->getLayers();

		return true;
	}
	
	/**
	 * Some PHP magic happens here. All parseXXX methods have an additional getXXX method which are
	 * implemented here and should be called instead of parseXXX. The getXXX methods cache the result 
	 * of the parseXXX methods and can be called whenever needed. This makes the parsing faster in
	 * case some parseXXX depend on data from other parseXXX methods, e.g. when we need to calculate
	 * the bbox and time extent from the layers. Additionally we don't need to care about the calling
	 * order for the parse/get methods. All arguments given to the getXXX methods will be forwarded
	 * to the parseXXX methods. This method is automatically called when no getXXX method is found 
	 * therefore you could implement your own getXXX method for a parseXXX method that does other things
	 * than this method. This also make the trait easier for extensions, e.g. if you like to parse more
	 * metadata.
	 * 
	 * @see PHP::_call()
	 * @param string $method Method name
	 * @param array $args Parameters
	 * @return mixed
	 * @throws \BadMethodCallException Thrown when no implementation is given for the specified method.
	 */
	public function __call($method, $args) {
		if (strpos($method, 'get') === 0) {
			// Redirect all 'undefined' getXXX requests to this code for parsing and caching of the data.
			$method = substr($method, 3); // Remove the leading 'get'
			if (empty($this->loaded[$method])) {
				$result = call_user_func_array(array($this, "parse{$method}"), $args);
				if (is_array($result)) {
					foreach ($result as $entry) {
						// For addXXX you usually have no plural s at the end which you normally have 
						// with the given getters. But don't remove it with a leading x or s.
						$addMethod = preg_replace('~([^xs])s$~', '$1', "add{$method}");
						call_user_func(array($this->model, $addMethod), $entry);
					}
				}
				else {
					call_user_func(array($this->model, "set{$method}"), $result);
				}
				$this->loaded[$method] = true;
			}
			return call_user_func(array($this->model, "get{$method}"));
		}
		else {
			throw new \BadMethodCallException('Call to undefined method ' . $method);
		}
	}

	/**
	 * Parses and returns the author/service provider.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAuthor()
	 * @see \GeoMetadata\Model\Metadata::setAuthor()
	 */
	protected function parseAuthor() {
		return null;
	}

	/**
	 * Parses and returns the copyright notice.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getCopyright()
	 * @see \GeoMetadata\Model\Metadata::setCopyright()
	 */
	protected function parseCopyright() {
		return null;
	}

	/**
	 * Parses and returns the minimum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getBeginTime()
	 * @see \GeoMetadata\Model\Metadata::setBeginTime()
	 */
	protected function parseBeginTime() {
		return null;
	}

	/**
	 * Parses and returns the maximum timestamp.
	 * 
	 * @return \DateTime|null
	 * @see \GeoMetadata\Model\Metadata::getEndTime()
	 * @see \GeoMetadata\Model\Metadata::setEndTime()
	 */
	protected function parseEndTime() {
		return null;
	}

	/**
	 * Parses and returns the description/abstract.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getAbstract()
	 * @see \GeoMetadata\Model\Metadata::setAbstract()
	 */
	protected function parseAbstract() {
		return null;
	}

	/**
	 * Parses and returns the keywords/tags.
	 * 
	 * @return array
	 * @see \GeoMetadata\Model\Metadata::getKeywords()
	 * @see \GeoMetadata\Model\Metadata::setKeywords()
	 * @see \GeoMetadata\Model\Metadata::addKeyword()
	 */
	protected function parseKeywords() {
		return array();
	}

	/**
	 * Parses and returns the language of the geo dataset.
	 * 
	 * This should be an ISO 639-1 based language code.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getLanguage()
	 * @see \GeoMetadata\Model\Metadata::setLanguage()
	 */
	protected function parseLanguage() {
		return null;
	}

	/**
	 * Parses and returns the licensing information.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getLicense()
	 * @see \GeoMetadata\Model\Metadata::setLicense()
	 */
	protected function parseLicense() {
		return null;
	}

	/**
	 * Parses and returns the title.
	 * 
	 * @return string|null
	 * @see \GeoMetadata\Model\Metadata::getTitle()
	 * @see \GeoMetadata\Model\Metadata::setTitle()
	 */
	protected function parseTitle() {
		return null;
	}

	/**
	 * Parses and returns the service wide bounding boxes with their respective CRS of the geo dataset.
	 * 
	 * @return array An array containing BoundingBox based objects
	 * @see \GeoMetadata\Model\BoundingBox
	 * @see \GeoMetadata\Model\BoundingBoxContainer
	 * @see SimpleFillModelTrait::createEmptyBoundingBox()
	 */
	protected function parseBoundingBox() {
		return array();
	}

	/**
	 * Parses and returns the layers (or similar things) of the geo dataset.
	 * 
	 * @return array An array containing Layer based objects
	 * @see \GeoMetadata\Model\Layer
	 * @see \GeoMetadata\Model\LayerContainer
	 * @see SimpleFillModelTrait::createLayer()
	 */
	protected function parseLayers() {
		return array();
	}

	/**
	 * Creates a new layer using a class implementing the Layer interface.
	 * It sets the id and title of the layer and returns it.
	 * The layer object is delivered by the model which should be filled.
	 * 
	 * @param int|string $id ID/Name of the layer
	 * @param string $title Title of the layer
	 * @return \GeoMetadata\Model\Layer
	 */
	protected function createLayer($id, $title) {
		$layer = $this->model->deliverLayer();
		$layer->setId($id);
		$layer->setTitle($title);
		return $layer;
	}

	/**
	 * Returns a new and empty instance of a class implementing the BoundingBox interface.
	 * The bounding box object is delivered by the model which should be filled.
	 * 
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	protected function createEmptyBoundingBox() {
		return $this->model->deliverBoundingBox();
	}

	/**
	 * Returns a new but filled instance of a class implementing the BoundingBox interface.
	 * The bounding box object is delivered by the model which should be filled.
	 * 
	 * @param double $west Western edge of the bbox
	 * @param double $south Southern edge of the bbox
	 * @param double $east Eastern edge of the bbox
	 * @param double $north Northern edge of the bbox
	 * @param string $crs CRS name (can be an empty string)
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	protected function createBoundingBox($west, $south, $east, $north, $crs = '') {
		$bbox = $this->model->deliverBoundingBox();
		$bbox->set($west, $south, $east, $north);
		$bbox->setCoordinateReferenceSystem($crs);
		return $bbox;
	}

}
