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

use \Carbon\Carbon;
use \GeoMetadata\GmRegistry;
use \GeoMetadata\GeoMetadata;

/**
 * This controller handles the internal API requests related to geodata/comment tasks, like adding and retrieving comments, parsing metadata, storing permalinks for searches etc.
 * Request is always a GET or POST request with JSON based parameters. Reponse is always JSON based, too.
 */
class GeodataApiController extends BaseApiController {
	
	protected function buildSingleGeodata(Geodata $geodata, $layers = array()) {
		return array('geodata' => $this->buildGeodataEntry($geodata, $layers));
	}
	
	protected function buildMultipleGeodata(array $list) {
		$data = array('geodata' => array());
		foreach ($list as $geodata) {
			$data['geodata'][] = $this->buildGeodataEntry($geodata, null);
		}
		return $data;
	}
	
	protected function buildGeodataEntry(Geodata $geodata, $layers = null) {
		$data =  array(
			'id' => $geodata->id,
			'url' => $geodata->url,
			'metadata' => array(
				'datatype' => $geodata->datatype,
				'title' => $geodata->title,
				'bbox' => $geodata->bbox,
				'keywords' => $geodata->getKeywords(),
				'language' => $geodata->language,
				'copyright' => $geodata->copyright,
				'author' => $geodata->author,
				'time' => $this->buildTime($geodata),
				'abstract' => $geodata->abstract,
				'license' => $geodata->license
			)
		);
		if (isset($geodata->comments)) {
			if (is_array($geodata->comments)) { // Add comment entries
				$data['comments'] = $this->buildCommentList($geodata->comments);
			}
			else if (is_numeric($geodata->comments)) { // Add comment count
				$data['comments'] = $geodata->comments;
			}
		}
		if ($layers !== null) {
			$data['layer'] = array();
			foreach($layers as $layer) {
				$layerJson = array(
					'id' => $layer->name,
					'title' => $layer->title,
					'bbox' => $layer->bbox
				);
				if (isset($layer->comments)) {
					if (is_array($layer->comments)) { // Add comment entries
						$layerJson['comments'] = $this->buildCommentList($layer->comments);
					}
					else if (is_numeric($layer->comments)) { // Add comment count
						$layerJson['comments'] = $layer->comments;
					}
				}
				$data['layer'][] = $layerJson;
			}
		}
		
		return $data;
	}

	protected function buildCommentList(array $comments) {
		$data = array();
		foreach($comments as $comment) {
			$entry = array(
				'id' => $comment->id,
				'text' => $comment->text,
				'rating' => $comment->rating,
				'geometry' => $comment->geom,
				'time' => $this->buildTime($comment),
				'user' => null
			);
			if ($comment->user_id > 0) {
				$entry['user'] = array(
					'id' => $comment->user_id,
					'name' => $comment->user_name
				);
			}
			$data[] = $entry;
		}
		return $data;
	}
	
	protected function buildTime(Eloquent $model) {
		return array(
			'start' => ($model->start !== null) ? $this->toDate($model->start) : null,
			'end' => ($model->end !== null) ? $this->toDate($model->end) : null
		);
	}
	
	protected function parseMetadata($url, $code, $model = null) {
		$geo = GeoMetadata::withUrl($url, $code);
		if ($geo != null) {
			$geo->setModel($model);
			return $geo->parse();
		}
		return null;
	}
	
	public function postAdd() {
		$data = Input::only('url', 'datatype', 'layer', 'text', 'geometry', 'start', 'end', 'rating', 'title');
		
		$geodata = null;
		$service = GmRegistry::getService($data['datatype']);
		if ($service !== null) {
			$serviceUrl = $service->getServiceUrl($data['url']);
			$geodata = Geodata::where('url', '=', $serviceUrl)->first();
		}
		
		$validator = Validator::make($data,
			array(
				'url' => 'required|url',
				'datatype' => empty($geodata) ? 'required|' : '' . 'in:'.implode(',', GmRegistry::getServiceCodes()),
				'layer' => '',
				'title' => empty($geodata) ? 'required|' : '' . 'min:3|max:200',
				'text' => 'required|min:3|max:100000',
				'geometry' => 'geometry',
				'start' => 'date8601',
				'end' => 'date8601',
				'rating' => 'integer|between:1,5'
			)
		);
		
		if ($validator->fails()) {
			return $this->getConflictResponse($validator->messages());
		}
		
		if (empty($geodata)) {
			// Add geodata from remote service
			$geodata = $this->parseMetadata($data['url'], $data['datatype'], new GmGeodata());
			if ($geodata == null) {
				return $this->getConflictResponse();
			}
			// Add geodata from user (user may override the title for new URLs)
			$geodata->title = $data['title'];
			if (!$geodata->save()) {
				return $this->getConflictResponse();
			}
			else {
				// Parser added the layers, but hasn't stored them so far...
				foreach($geodata->getLayers() as $layer) {
					$layer->geodata()->associate($geodata);
					$layer->save();
				}
			}
		}
		
		$foundLayer = null;
		if (!empty($data['layer'])) {
			foreach($geodata->layers as $layer) {
				if ($layer->name == $data['layer']) {
					$foundLayer = $layer;
					break;
				}
			}
		}
		
		$comment = new Comment();
		$comment->geodata()->associate($geodata);
		if (Auth::check()) {
			$comment->user()->associate(Auth::user());
		}
		if ($foundLayer !== null) {
			$comment->layer()->associate($foundLayer);
		}
		$comment->text = $data['text'];
		$comment->rating = empty($data['rating']) ? null : $data['rating'];
		$comment->start = empty($data['start']) ? null : new Carbon($data['start']);
		$comment->end = empty($data['end']) ? null : new Carbon($data['end']);
		$comment->geom = empty($data['geometry']) ? null : $data['geometry'];
		if (!$comment->save()) {
			return $this->getConflictResponse();
		}
		
		return $this->getJsonResponse($this->buildSingleGeodata($geodata, null));
	}
	
	public function postMetadata() {
		$data = Input::only('url', 'datatype');
		
		$validator = Validator::make($data,
			array(
				'url' => 'required|url',
				'datatype' => 'required|in:'.implode(',', GmRegistry::getServiceCodes())
			)
		);
		if ($validator->fails()) {
			return $this->getConflictResponse($validator->messages());
		}

		
		// Try to get existing metadata for the URL
		$serviceUrl = 	GmRegistry::getService($data['datatype'])->getServiceUrl($data['url']);
		$geodata = Geodata::where('url', '=', $serviceUrl)->first();
		if ($geodata != null) {
			$json = $this->buildSingleGeodata($geodata, $geodata->layers->all()); // Get layers from DB
			$json['geodata']['id'] = $geodata->id;
			$json['geodata']['isNew'] = false;
			return $this->getJsonResponse($json);
		}
		else {
			// No metadata found in DB, parse them from the URL
			$geodata = $this->parseMetadata($data['url'], $data['datatype'], new GmGeodata());
			if ($geodata != null) {
				$json = $this->buildSingleGeodata($geodata, $geodata->getLayers()); // Get layers from GeoMetadata
				$json['geodata']['id'] = 0;
				$json['geodata']['isNew'] = true;
				return $this->getJsonResponse($json);
			}
		}

		$error = Lang::get('validation.url', array('attribute' => 'URL'));
		return $this->getConflictResponse(array('url' => $error));
	}
	
	public function postKeywords() {
		$q = Input::get('q');
		$metadata = Input::get('metadata');
		if (strlen($q) >= 3) {
			// TODO: Implement auto suggestion for keywords.
		}
		return $this->getNotFoundResponse();
	}
	
	public function postSearchSave() {
		$data = $this->getFilterInput(array('bbox'));
		$search = new SavedSearch();
		$search->id = SavedSearch::generateId();
		$search->keywords = $data['q'];
		$search->metadata = $data['metadata'];
		$search->rating = $data['minrating'];
		$search->start = $data['start'];
		$search->end = $data['end'];
		$search->bbox = $data['bbox'];
		$search->radius = $data['radius'];
		if ($search->save()) {
			return $this->getJsonResponse(array(
				'permalink' => Config::get('app.url') . '/search/' . $search->id
			));
		}
		else {
			return $this->getConflictResponse();
		}
	}
	
	public function getSearchLoad($id) {
		$search = SavedSearch::selectBbox()->find($id);
		if ($search !== null) {
			$json = array(
				'permalink' => array(
					'q' => $search->keywords,
					'metadata' => $search->metadata,
					'bbox' => $search->bbox,
					'radius' => $search->radius,
					'time' => $this->buildTime($search),
					'minrating' => $search->rating
				)
			);
			return $this->getJsonResponse($json);
		}
		else {
			return $this->getNotFoundResponse();
		}
	}
	
	public function postList() {
		$filter = $this->getFilterInput();
		$geodata = Geodata::filter($filter)->get();
		return $this->getJsonResponse($this->buildMultipleGeodata($geodata->all()));
	}
	
	public function postComments($id) {
		$filter = $this->getFilterInput();
		// Get geodata for the specified id
		$geodata = Geodata::find($id);
		// Get all suitable comments for the filter and group them by layer (no layer = 0)
		$comments = Comment::filter($filter, $id)->get();
		$groupedComments = array(0 => array()); // Make sure the geodata entry is always a valid array
		foreach($comments as $comment) {
			if (empty($comment->layer_id)) {
				$groupedComments[0][] = $comment;
			}
			else {
				$groupedComments[$comment->layer_id][] = $comment;
			}
		}
		// Get all layers
		$layers = $geodata->layers->all();
		// Append the comment data to the layers and the geodata
		$geodata->comments = $groupedComments[0];
		foreach($layers as $layer) {
			if (isset($groupedComments[$layer->id])) {
				$layer->comments = $groupedComments[$layer->id];
			}
			else {
				$layer->comments = array();
			}
		}
		// Build the response array from the collected data
		$json = $this->buildSingleGeodata($geodata, $layers);
		return $this->getJsonResponse($json);
	}
	
	protected function getFilterInput(array $required = array()) {
		$input = Input::only('q', 'bbox', 'radius', 'start', 'end', 'minrating', 'metadata');
		$rules = array(
			'q' => '',
			'bbox' => 'geometry:wkt,Polygon',
			'radius' => 'integer|between:1,500',
			'start' => 'date8601',
			'end' => 'date8601',
			'minrating' => 'integer|between:1,5',
			'metadata' => 'boolean'
		);
		foreach ($required as $field) {
			$rules[$field] = empty($rules[$field]) ? 'required' : 'required|' . $rules[$field];
		}
		$validator = Validator::make($input, $rules);
		$data = $validator->valid(); // TODO: Not all elements might be here, so we have to check that.
		$data['minrating'] = !empty($data['minrating']) ? $data['minrating'] : null;
		$data['start'] = !empty($data['start']) ? new Carbon($data['start']) : null;
		$data['end'] = !empty($data['end']) ? new Carbon($data['end']) : null;
		$data['metadata'] = ($data['metadata'] !== null) ? $data['metadata'] : false;
		return $data;
	}
	
}
