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
 * Implements the search/permalink model.
 */
class SavedSearch extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_saved_search';
	
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
	 * Generates a unique ID for the search.
	 * 
	 * @return string
	 */
	public static function generateId() {
		return str_replace('.', '', uniqid("", true));
	}
	
	/**
	 * Adds a select field to the query that returns the bbox as WKT, not as PostGIS.
	 * 
	 * @param Builder $query Query Builder
	 * @return Builder
	 */
	public function scopeSelectBbox($query) {
		return $query->addSelect('*')->addSelect(DB::raw('ST_AsText(bbox) AS bbox'));
	}

}