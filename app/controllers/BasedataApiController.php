<?php

class BasedataApiController extends BaseApiController {
	
	public function getBasemaps() {
		
	}
	
	public function getDoc($page) {
		// $page is validated in routes controller?
		// Todo: return as JSON
		return View::make("pages.{$page}");
	}
	
	public function getLanguage($language) {
		// $language is checked in routes file for being 2 letters
		$loader = Lang::getLoader();
		$phrases = $loader->load($language, 'client');
		if (empty($phrases)) {
			return $this->getNotFoundResponse();
		}
		else {
			$json = array(
				'language' => $language,
				'phrases' => $phrases
			);
			return $this->getJsonResponse($json);
		}
	}
	
}
