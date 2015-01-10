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

	public function comments() {
		return $this->hasMany('Comment', 'geodata_id');
	}

	public function layers() {
		return $this->hasMany('Layer', 'geodata_id');
	}

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
		if (!empty($filter['q'])) {
			if (!empty($filter['metadata'])) {
				$query->whereRaw("({$ct}.searchtext @@ to_tsquery(?) OR {$gt}.searchtext @@ to_tsquery(?))", array($filter['q'], $filter['q']));
			}
			else {
				$query->whereRaw("{$ct}.searchtext @@ to_tsquery(?)", array($filter['q']));
			}
		}
		
		if (!empty($filter['bbox'])) {
			if (empty($filter['radius'])) {
				// Get all bboxes contained by the bbox of the map
				$query->whereRaw("{$gt}.bbox::geometry @ ST_Envelope(?::geometry)", array($filter['bbox']));
			}
			else {
				// Get all bboxes that are within the chosen radius around the middle of the bbox of the map
				$query->whereRaw("ST_DWithin({$gt}.bbox, ST_Centroid(?::geometry), ?)", array($filter['bbox'], $filter['radius']));
			}
		}
		
		if (!empty($filter['start'])) {
			$query->where("{$ct}.start", '<', $filter['start']);
		}
		if (!empty($filter['end'])) {
			$query->where("{$ct}.end", '>', $filter['end']);
		}
		
		if (!empty($filter['minrating'])) {
			$query->where("{$ct}.rating", '>=', $filter['minrating']);
		}
		
		// Group By
		$query->groupBy("{$gt}.id");
		
		// Order By
		$query->orderBy("{$gt}.title");

		return $query;
	}
	
	public function scopeSelectBbox($query) {
		return $query->addSelect(DB::raw('ST_AsText(bbox) AS bbox'));
	}

	public function getKeywords(){
		return explode('|', $this->keywords);
	}
	
	public function getBboxAttribute($value) {
		return self::convertPostGis($value);
	}

	public function setKeywords(array $keywords){
		$this->keywords = implode('|', $keywords);
	}

	public function addKeyword($keyword){
		$keywords = $this->getKeywords();
		$keywords[] = $keyword;
		$this->setKeywords($keywords);
	}
	
	public static function convertPostGis($value) {
		if (!empty($value)) {
			$geom = geoPHP::load($value, 'wkt'); // Detect whether it's already in WKT
			if (empty($geom)) {
				// Due to a bad designed ORM we need to do some extra querys...
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
	
}
?>