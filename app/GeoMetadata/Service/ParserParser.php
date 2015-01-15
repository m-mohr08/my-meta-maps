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

abstract class ParserParser implements Parser {
	
	private $parser;
	
	public function createObject() {
		return new static();
	}
	
	public function getParser() {
		return $this->parser;
	}
	
	protected function setParser($parser) {
		$this->parser = $parser;
		return ($this->parser !== null);
	}

	public function verify($source) {
		if ($this->parser == null) {
			$this->setParser($this->createParser($source));
		}
		return ($this->parser !== null);
	}
	
	/**
	 * Parses the data.
	 * 
	 * @param string $source String containing the data to parse.
	 * @param GeoMetadata\Model\Metadata $model An instance of a model class to fill with the data.
	 * @return boolean true on success, false on failure.
	 */
	public function parse($source, \GeoMetadata\Model\Metadata &$model) {
		if ($this->parser === null && !$this->setParser($this->createParser($source))) {
			return false;
		}
		return $this->fillModel($model);
	}
	
	protected abstract function createParser($source);

	protected abstract function fillModel(\GeoMetadata\Model\Metadata &$model);

}
