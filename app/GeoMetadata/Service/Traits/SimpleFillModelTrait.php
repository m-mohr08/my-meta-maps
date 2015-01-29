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

trait SimpleFillModelTrait {

	private $called = array();
	private $model;

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

	protected function parseAuthor() {
		return null;
	}

	protected function parseCopyright() {
		return null;
	}

	protected function parseBeginTime() {
		return null;
	}

	protected function parseEndTime() {
		return null;
	}

	protected function parseAbstract() {
		return null;
	}

	protected function parseKeywords() {
		return array();
	}

	protected function parseLanguage() {
		return null;
	}

	protected function parseLicense() {
		return null;
	}

	protected function parseTitle() {
		return null;
	}

	protected function parseBoundingBox() {
		return array();
	}

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
