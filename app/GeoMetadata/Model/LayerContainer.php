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
 * Interface that allows to store and manage layers.
 */
interface LayerContainer {

	/**
	 * Returns a list of layers.
	 * 
	 * @return array
	 */
	public function getLayers();

	/**
	 * Adds a layer to the list of layers.
	 * 
	 * @param \GeoMetadata\Model\Layer $layer Layer to be added
	 */
	public function addLayer(Layer $layer);

	/**
	 * Creates a new layer, sets the id and title and adds it to the list of layers.
	 * 
	 * The newly created layer is returned.
	 * 
	 * @see \GeoMetadata\Model\LayerContainer::addLayer()
	 * @see \GeoMetadata\Model\LayerContainer::deliverLayer()
	 * @param int|string $id ID/Name of the layer
	 * @param string $title Title of the layer
	 * @return \GeoMetadata\Model\Layer
	 */
	public function createLayer($id, $title = null);

	/**
	 * Returns a new instance of a class implementing the Layer interface and 
	 * which is is compatible with the implementation of metadata based class.
	 * 
	 * @return \GeoMetadata\Model\Layer
	 */
	public function deliverLayer();

	/**
	 * Removes the specified Layer object from the list of layers.
	 * 
	 * It's not enough when the layers have the same content, it must be the same instance.
	 * 
	 * @param \GeoMetadata\Model\Layer $layer Layer to remove
	 * @return boolean true on success, false on failure
	 */
	public function removeLayer(Layer $layer);

	/**
	 * Copies/clones a layer and its attributes to a new object derived from \GeoMetadata\Model\Layer.
	 * 
	 * The newly created object will be added to the list of layers and finally it's returned to be used.
	 * 
	 * You can specify null as parameter which will always return null, but might be more convenient than
	 * aloways checking for null before calling this method.
	 * 
	 * @see \GeoMetadata\Model\LayerContainer::addLayer()
	 * @see \GeoMetadata\Model\LayerContainer::deliverLayer()
	 * @param \GeoMetadata\Model\Layer $layer Layer to copy/clone
	 * @return \GeoMetadata\Model\Layer|null
	 */
	public function copyLayer(Layer $layer = null);

}