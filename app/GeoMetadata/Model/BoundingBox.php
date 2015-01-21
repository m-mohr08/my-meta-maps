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
 * Interface that models a bounding box with 4 edges (all geopgraphic directions) and a CRS.
 * Additionally has some convenience methods for WKT and the union operator.
 */
interface BoundingBox {
	
	/**
	 * Returns the coordinate reference system that belongs to this bounding box.
	 * 
	 * This is optional and might return null, which is normally indicating that we use WGS84.
	 * 
	 * @return string
	 */
	public function getCoordinateReferenceSystem();
	/**
	 * Sets the coordinate reference system that belongs to this bounding box.
	 * 
	 * Might return null, which is normally indicating that WGS84 is used.
	 * 
	 * @param string $crs Coordinate reference system
	 */
	public function setCoordinateReferenceSystem($crs);
	
	/**
	 * Returns the value for the northern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getNorth();
	
	/**
	 * Sets the value for the northern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setNorth($north);

	/**
	 * Returns the value for the eastern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getEast();
	/**
	 * Sets the value for the eastern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setEast($east);

	/**
	 * Returns the value for the southern edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getSouth();
	/**
	 * Sets the value for the southern edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setSouth($south);

	/**
	 * Returns the value for the western edge of the bounding box.
	 * 
	 * @return double
	 */
	public function getWest();
	/**
	 * Sets the value for the western edge of the bounding box.
	 * 
	 * @param double
	 */
	public function setWest($west);

	/**
	 * Convenience method to set all edges of bounding box with one method call.
	 * 
	 * This is the same as calling setWest(), setSouth(), setEast() and setNorth() in a row.
	 * 
	 * @param double $west Western edge of the bbox
	 * @param double $south Southern edge of the bbox
	 * @param double $east Eastern edge of the bbox
	 * @param double $north Northern edge of the bbox
	 */
	public function set($west, $south, $east, $north);

	/**
	 * Returns an array containing two enumerated arrays.  The first array is containing the lower 
	 * (minimum) bounds and the second array is containing the upper (maximum) bounds. Both arrays
	 * contain an x/y pair (in this order). x is the longitude value, y is the latitude value.
	 * 
	 * @return array
	 */
	public function getArray();
	
	/**
	 * Returns the bounding box as WKT Polygon representation.
	 * 
	 * @return string
	 */
	public function toWkt();
	/**
	 * Sets the bounding box by taking the bounding box of the geometry that is parsed based on the
	 * given WKT compatible string.
	 * 
	 * @param string $wkt WKT
	 */
	public function fromWkt($wkt);

	/**
	 * Returns whether the bounding box is fully defined or not.
	 * 
	 * The bbox is fully defined, when there are at least all edges (north, south, west, east) given.
	 * We don't care whether there is a CRS set or not.
	 * 
	 * @return boolean true if all edges are set, false if not.
	 */
	public function defined();

	/**
	 * Merges the given bounding box with this one and calculates the bounding box of this merged
	 * geometry which is then set as the bounding box for this instance.
	 * 
	 * Undefined instances will be ignored. If the CRS of this instance and the other instance are 
	 * different than the other instance is ignored, too. If this instance has no CRS set, the 
	 * CRS of the other object will be used and set.
	 * 
	 * @see BoundingBox::defined()
	 * @param \GeoMetadata\Model\BoundingBox $other Bounding Box
	 */
	public function union(BoundingBox $other);

}