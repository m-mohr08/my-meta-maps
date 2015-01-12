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
 * Implements the comment model.
 */
class Comment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_comment';
	
	/**
	 * Tell the ORM to use timestamp fields or not. 
	 * 
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function user() {
		return $this->belongsTo('User');
	}

	public function layer() {
		return $this->belongsTo('Layer');
	}
	
    public function geodata() {
        return $this->belongsTo('Geodata');
    }
	
	public function getGeomAttribute($value) {
		return Geodata::convertPostGis($value);
	}

	public function scopeFilter($query, array $filter, $id=0) {
		// Table Names
		$gt = (new Geodata())->getTable();
		$ct = (new Comment())->getTable();
		$ut = (new User())->getTable();
		
		// Select
		$query->select(array(
			"{$gt}.url",
			"{$ct}.*",
			"{$ut}.name AS user_name",
			DB::raw("ST_AsText({$ct}.geom) AS geom")
		));
		
		// Join Geodata
		$query->join($gt, "{$ct}.geodata_id", '=', "{$gt}.id");
		// Join User
		$query->leftJoin($ut, "{$ct}.user_id", '=', "{$ut}.id");

		// Where
		self::applyFilter($query, $filter);
		// Where: Restrict to the requested geodata id
		if ($id > 0){
			$query->where("{$gt}.id", '=', $id);
		}
		// Order By
		$query->orderBy("{$gt}.title");

		return $query;
	}
	
	public static function applyFilter($query, array $filter) {
		// Table Names
		$gt = (new Geodata())->getTable();
		$ct = (new Comment())->getTable();

		// Where
		if (!empty($filter['q'])) {
			if (!empty($filter['metadata'])) {
				$query->whereRaw("({$ct}.searchtext @@ plainto_tsquery('pg_catalog.simple', ?) OR {$gt}.searchtext @@ plainto_tsquery('pg_catalog.simple', ?))", array($filter['q'], $filter['q']));
			}
			else {
				$query->whereRaw("{$ct}.searchtext @@ plainto_tsquery('pg_catalog.simple', ?)", array($filter['q']));
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
	}

}