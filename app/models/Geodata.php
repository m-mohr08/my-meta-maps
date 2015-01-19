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

/**
 * Implements the geodata model.
 */
class Geodata extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_geodata';
	
	/**
	 * Tell the ORM to use timestamp fields or not. 
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * Implementation of the relation to the Comment table.
	 * 
	 * @return HasMany
	 */
	public function comments() {
		return $this->hasMany('Comment', 'geodata_id');
	}

	/**
	 * Implementation of the relation to the Layer table.
	 * 
	 * @return HasMany
	 */
	public function layers() {
		return $this->hasMany('Layer', 'geodata_id');
	}
	
	/**
	 * Creates the permalink URI for this comment.
	 * 
	 * @return string|null
	 */	
	public function createPermalink() {
		if ($this->id) {
			return Config::get('app.url') . '/geodata/' . $this->id;
		}
		else {
			return null;
		}
	}
	/**
	 * Implements the search filter for the comments/geodata.
	 * 
	 * @see Comment::applyFilter()
	 * @param Builder $query Query Builder
	 * @param array $filter Filter parameters
	 * @param int $id ID of the geodata set
	 * @return Builder Query Builder
	 */
	public function scopeFilter($query, array $filter) {
		// Table Names
		$gt = (new Geodata())->getTable();
		$ct = (new Comment())->getTable();
		
		// Select
		$query->select(array(
			"{$gt}.*",
			DB::raw("ST_AsText({$gt}.bbox) AS bbox"),
			DB::raw("COUNT(*) AS comments")
		));
		
		// Join Comments
		$query->join($ct, "{$ct}.geodata_id", '=', "{$gt}.id");

		// Where
		Comment::applyFilter($query, $filter);
		
		// Group By
		$query->groupBy("{$gt}.id");
		
		// Order By
		$query->orderBy("{$gt}.title");

		return $query;
	}
	
	/**
	 * Adds a select field to the query that returns the bbox as WKT, not as PostGIS.
	 * 
	 * @param Builder $query Query Builder
	 * @return Builder
	 */
	public function scopeSelectBbox($query) {
		return $query->addSelect(DB::raw('ST_AsText(bbox) AS bbox'));
	}

	/**
	 * Returns the keywords as array.
	 * 
	 * @return array
	 */
	public function getKeywords(){
		if (empty($this->keywords)) {
			return array();
		}
		return explode('|', $this->keywords);
	}

	/**
	 * Returns the bbox attribute of the table and converts it from PostGIS to WKT style.
	 * 
	 * @return string WKT based geometry
	 */
	public function getBboxAttribute($value) {
		return self::convertPostGis($value);
	}

	/**
	 * Replaces the list of keywords with the given list.
	 * 
	 * @param array $keywords Keywords to set
	 */
	public function setKeywords(array $keywords){
		$this->keywords = implode('|', $keywords);
	}

	/**
	 * Adds a keyword to the list of keywords.
	 * 
	 * @param string $keywords Keyword
	 */
	public function addKeyword($keyword){
		$keywords = $this->getKeywords();
		$keywords[] = $keyword;
		$this->setKeywords($keywords);
	}
	
	/**
	 * Converts the PostGIS based bbox to WKT style.
	 * 
	 * @param string $value Value to convert
	 * @return string BBox in WKT
	 */
	public static function convertPostGis($value) {
		if (!empty($value)) {
			try {
				$geom = geoPHP::load($value, 'wkt'); // Detect whether it's already in WKT
			} catch(Exception $e) {
				$geom = null;
			}
			if (empty($geom)) {
				// Due to a bad designed ORM we need to do some extra querys...
				// TODO: Find a better solution. This is a really BAD solution!
				$result = DB::selectOne("SELECT ST_AsText('{$value}') AS bbox");
				return $result->bbox;
			}
			else {
				return $value;
			}
		}
		else {
			return null;
		}
	}
	
	/**
	 * Checks whether the given CRS is a name/alias for WGS84.
	 * 
	 * @param string $crs CRS to check
	 * @return boolean true if its a WGS84 alias, false if not.
	 */
	public static function isWgs84($crs) {
		if (!is_array($crs)) {
			$crs = array($crs);
		}
		foreach($crs as $i) {
			$i = strtolower($i);
			if (\GeoMetadata\GmRegistry::getEpsgCodeNumber($i) == 4326) {
				return true;
			}
			else if ($i == 'crs:84' || $i == 'urn:ogc:def:crs:ogc:2:84' || $i == 'http://www.opengis.net/def/crs/ogc/1.3/crs84') { // crs:84 is mostly an alternative for EPSG:4326
				return true;
			}
		}
		return false;
	}
	
}