<?php

use \GeoMetadata\GeoMetadata;

class GeodataApiController extends BaseApiController {
	
	public function __construct() {
		GeoMetadata::registerService(new \GeoMetadata\Service\Microformats2());
		GeoMetadata::setLogger(array('App', 'debug'));
	}
	
	protected function buildGeodata(\GeoMetadata\Model\Metadata $geodata, $datatype) {
		$json = array(
			'geodata' => array(
				'id' => 0,
				'url' => $geodata->getUrl(),
				'metadata' => array(
					'datatype' => $datatype,
					'title' => $geodata->getTitle(),
					'bbox' => (string) $geodata->getBoundingBox(),
					'keywords' => $geodata->getKeywords(),
					'creation' => $geodata->getCreationTime(), // TODO: Return as proper timestamp
					'language' => $geodata->getLanguage(),
					'copyright' => $geodata->getCopyright(),
					'author' => $geodata->getAuthor(),
					'publisher' => $geodata->getPublisher(),
					'modified' => $geodata->getModifiedTime(), // TODO: Return as proper timestamp
					'abstract' => $geodata->getDescription(),
					'license' => $geodata->getLicense()
				),
				'layer' => array()
			)
		);

		$layers = $geodata->getLayers();
		foreach($layers as $layer) {
			$json['geodata']['layer'] = array(
				'id' => $layer->getId(),
				'title' => $layer->getTitle(),
				'bbox' => (string) $layer->getBoundingBox()
			);
		}
		
		return $json;
	}
	
	public function postAdd() {
		$data = Input::only('url', 'text', 'geometry', 'start', 'end', 'rating', 'title');
		// TODO
	}
	
	public function postMetadata() {
		$url = Input::get('url');
		// Try to get existing metadata for the URL
		$geodata = Geodata::where('url', '=', $url)->first();
		if ($geodata != null) {
			$json = $this->buildGeodata($geodata, $geodata->type);
			$json['geodata']['id'] = $geodata->id;
			$json['geodata']['isNew'] = false;
			return $this->getJsonResponse($json);
		}
		else {
			// No metadata found in DB, parse them from the URL
			$geo = new GeoMetadata();
			$geo->setURL($url);
			$parser = $geo->detect();
			if ($parser != null) {
				$metadata = $geo->parse($parser);
				if ($metadata != null) {
					$json = $this->buildGeodata($metadata, $parser->getType());
					$json['geodata']['id'] = 0;
					$json['geodata']['isNew'] = true;
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
		
	}
	
	public function postSearchSave() {
		
	}
	
	public function getSearchLoad($id) {
		
	}
	
	public function getComments($id) {
		
	}
	
}
