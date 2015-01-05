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
	
	public function __construct() {
		GmRegistry::registerService(new \GeoMetadata\Service\Microformats2());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapService());

		GmRegistry::setLogger(array('App', 'debug'));
		GmRegistry::setProxy(Config::get('remote.proxy.host'), Config::get('remote.proxy.port'));
	}
	
	protected function buildGeodata(Geodata $geodata) {
		$json = array(
			'geodata' => array(
				'id' => $geodata->id,
				'url' => $geodata->url,
				'metadata' => array(
					'datatype' => $geodata->datatype,
					'title' => $geodata->title,
					'bbox' => $geodata->bbox,
					'keywords' => $geodata->getKeywords(),
					'creation' => self::toDate($geodata->creation),
					'language' => $geodata->language,
					'copyright' => $geodata->copyright,
					'author' => $geodata->author,
					'modified' => self::toDate($geodata->modified),
					'abstract' => $geodata->abstract,
					'license' => $geodata->license
				),
				'layer' => array()
			)
		);

		$layers = empty($geodata->layers) ? array() : (array) $geodata->layers;
		if ($geodata instanceof GmGeodata) {
			$layers = array_merge($layers, $geodata->getLayers());
		}
		foreach($layers as $layer) {
			$json['geodata']['layer'][] = array(
				'id' => $layer->name,
				'title' => $layer->title,
				'bbox' => $layer->bbox
			);
		}
		
		return $json;
	}
	
	protected function parseMetadata($url, $model = null) {
		$geo = new GeoMetadata();
		$geo->setURL($url);
		$geo->setModel($model);
		$parser = $geo->detect();
		if ($parser != null) {
			return $geo->parse($parser);
		}
		return null;
	}
	
	public function postAdd() {
		$data = Input::only('url', 'datatype', 'layer', 'text', 'geometry', 'start', 'end', 'rating', 'title');
		
		$geodata = Geodata::where('url', '=', $data['url'])->first();
		
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
				'rating' => 'digits_between:1,5'
			)
		);
		
		if ($validator->fails()) {
			return $this->getConflictResponse($validator->messages());
		}
		
		if (empty($geodata)) {
			// Add geodata from remote service
			$geodata = $this->parseMetadata($data['url'], new GmGeodata());
			if ($geodata == null) {
				return $this->getConflictResponse();
			}
			// Add geodata from user (overwrites parsed data if needed)
			$geodata->url = $data['url'];
			$geodata->datatype = $data['datatype'];
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
			$comment->user = Auth::user();
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
		
		return $this->getJsonResponse($this->buildGeodata($geodata));
	}
	
	public function postMetadata() {
		$url = Input::get('url');
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			// Try to get existing metadata for the URL
			$geodata = Geodata::where('url', '=', $url)->first();
			if ($geodata != null) {
				$json = $this->buildGeodata($geodata);
				$json['geodata']['id'] = $geodata->id;
				$json['geodata']['isNew'] = false;
				$json['geodata']['metadata']['datatype'] = array($json['geodata']['metadata']['datatype']);
				return $this->getJsonResponse($json);
			}
			else {
				// No metadata found in DB, parse them from the URL
				$metadata = $this->parseMetadata($url, new GmGeodata());
				if ($metadata != null) {
					$json = $this->buildGeodata($metadata);
					$json['geodata']['id'] = 0;
					$json['geodata']['isNew'] = true;
					// TODO: Allow to return all suitable datatypes from the detection process in buildGeodata.
					$json['geodata']['metadata']['datatype'] = array($json['geodata']['metadata']['datatype']);
					return $this->getJsonResponse($json);
				}
			}
		}
		$error = Lang::get('validation.url', array('attribute' => 'URL'));
		return $this->getConflictResponse(array('url' => $error));
	}
	
	public function postList($junk = '') {
		
	}
	
	public function postKeywords() {
		$q = Input::get('q');
		$metadata = Input::get('metadata');
		if (strlen($q) >= 3) {
			// TODO
		}
	}
	
	public function postSearchSave() {
		
	}
	
	public function getSearchLoad($id) {
		
	}
	
	public function getComments($id) {
		
	}
	
}
