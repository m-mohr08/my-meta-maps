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

namespace GeoMetadata\Service\Traits;

trait SimpleFillModelTrait {

	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$this->parseLayer($model);
		$this->parseBoundingBox($model);

		$model->setAuthor($this->parseAuthor());
		$model->setCopyright($this->parseCopyright());
		$model->setDescription($this->parseAbstract());
		$model->setKeywords($this->parseKeywords());
		$model->setLanguage($this->parseLanguage());
		$model->setLicense($this->parseLicense());
		$model->setBeginTime($this->parseBeginTime());
		$model->setEndTime($this->parseEndTime());
		$model->setTitle($this->parseTitle());

		return true;
	}
	
	protected abstract function parseAuthor();
	protected abstract function parseCopyright();
	protected abstract function parseBeginTime();
	protected abstract function parseEndTime();
	protected abstract function parseAbstract();
	protected abstract function parseKeywords();
	protected abstract function parseLanguage();
	protected abstract function parseLicense();
	protected abstract function parseTitle();
	protected abstract function parseBoundingBox(\GeoMetadata\Model\Metadata &$model);
	protected abstract function parseLayer(\GeoMetadata\Model\Metadata &$model);
	
}