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

namespace GeoMetadata\Service;

class OgcCatalogueService extends CachedParser {
	
	use Traits\HttpGetTrait;

	// This is an XML based OGC service, but as we only query single datasets and not the
	// GetCapabilities and additionally use an external parser (IMP) we have such a difference in
	// the classes, that we extend CachedParser and not OGcWebServices this time.

	public function getName() {
		return 'OGC Catalogue Service';
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'csw';
	}

	protected function createParser($source) {
		// IMP is not very well written, throws E_NOTICES. Therefore we turn error_reporting off for this parser.
		error_reporting(E_WARNING);
		// We don't use IMP class as we don't need the fancy JSON/PDF/HTML stuff, we just need plain PHP
		// and we get this straight from the parser. THis is nothing different from what IMP does directly.
		$parser = new \Parser();
		try {
			return $parser->parseXML($source);
		} catch (Exception $e) {
			return null;
		}
	}

	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$records = $this->getParser();
		
		if (empty($records)) {
			return false;
		}

		// For now we only parse the first record
		// TODO: Improve that
		$data = reset($records);
		
		// Not supported: Copyright
		
		// Abstract
		if (!empty($data->recordAbstract)) {
			$model->setAbstract($data->recordAbstract);
		}
		
		// Author
		if (!empty($data->pointOfContact['organisationName'])) {
			$model->setAuthor($this->arrayTotext($data->pointOfContact));
		}
		else if (!empty($data->responsibleParty)) {
			$model->setAuthor($this->arrayTotext($data->responsibleParty));
		}
		else if (!empty($data->distributor)) {
			$model->setAuthor($this->arrayTotext($data->distributor));
		}

		// Begin/end time
		if (!empty($data->temporalExtent['begin'])) {
			$model->setBeginTime($data->temporalExtent['begin']);
		}
		if (!empty($data->temporalExtent['end'])) {
			$model->setEndTime($data->temporalExtent['end']);
		}
		
		// Keywords
		if (!empty($data->descriptiveKeywords['keywords'])) {
			$model->setKeywords($data->descriptiveKeywords['keywords']);
		}
		
		// Language
		if (!empty($data->ressourceLang)) {
			$model->setLanguage($data->ressourceLang);
		}

		// License
		if (!empty($data->legalConstraints)) {
			$model->setLicense($this->arrayTotext($data->legalConstraints));
		}
		
		// Title
		if ($data->title) {
			$model->setTitle($data->title);
		}
		
		// BBox
		if (!empty($data->geographicBoundingBox)) {
			$bbox = $data->geographicBoundingBox;
			$model->createBoundingBox($bbox['westBoundLongitude'], $bbox['southBoundLatitude'], $bbox['eastBoundLongitude'], $bbox['northBoundLatitude'], 'EPSG:4326');
		}
		
		return true;
	}
	
	private function arrayTotext($array) {
		$text = '';
		if (!empty($array)) {
			foreach ($array as $key => $value) {
				$value = trim($value);
				if (!empty($value)) {
					$text .= "{$key}: {$value}\r\n";#
				}
			}
			$text = trim($text);
		}
		return (empty($text) ? null : $text);
	}

	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url) {
		return $url;
	}
	
	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		return $url;
	}

}