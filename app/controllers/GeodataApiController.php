<?php

use \GeoMetadata\GmRegistry;
use \GeoMetadata\GeoMetadata;

class GeodataApiController extends BaseApiController {
	
	public function __construct() {
		GmRegistry::registerService(new \GeoMetadata\Service\Microformats2());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapService());

		GmRegistry::setLogger(array('App', 'debug'));
		GmRegistry::setProxy(Config::get('remote.proxy.host'), Config::get('remote.proxy.port'));
	}
	
	protected function buildGeodata(\GeoMetadata\Model\Metadata $geodata) {
		$json = array(
			'geodata' => array(
				'id' => 0,
				'url' => $geodata->getUrl(),
				'metadata' => array(
					'datatype' => $geodata->getServiceCode(),
					'title' => $geodata->getTitle(),
					'bbox' => (string) $geodata->getBoundingBox(),
					'keywords' => $geodata->getKeywords(),
					'creation' => self::toDate($geodata->getCreationTime()),
					'language' => $geodata->getLanguage(),
					'copyright' => $geodata->getCopyright(),
					'author' => $geodata->getAuthor(),
					'modified' => self::toDate($geodata->getModifiedTime()),
					'abstract' => $geodata->getDescription(),
					'license' => $geodata->getLicense()
				),
				'layer' => array()
			)
		);

		$layers = $geodata->getLayers();
		foreach($layers as $layer) {
			$json['geodata']['layer'][] = array(
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
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			// Try to get existing metadata for the URL
			$geodata = Geodata::where('url', '=', $url)->first();
			if ($geodata != null) {
				$json = $this->buildGeodata($geodata);
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
						$json = $this->buildGeodata($metadata);
						$json['geodata']['id'] = 0;
						$json['geodata']['isNew'] = true;
						return $this->getJsonResponse($json);
					}
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
