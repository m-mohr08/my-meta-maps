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

/**
 * Implementation for parsers that need to cache an instance of another parser to avoid multiple 
 * parsing for verification and parsing. Therefore a lazy loading implementation to instanciate the
 * parser has been implemented.
 */
abstract class CachedParser implements Parser {
	
	private $parser;
	
	/**
	 * Creates a new parser object that caches an internally used parser for multiple use (e.g. verify and parse).
	 * 
	 * @return Parser
	 */
	public function createObject() {
		return new static();
	}
	
	/**
	 * Returns the internal parser instance.
	 * 
	 * @return mixed|null
	 */
	public function getParser() {
		return $this->parser;
	}

	/**
	 * Sets the internal parser instance to be used for parsing.
	 * 
	 * @param mixed $parser
	 * @return Returns true on success, false on falure (e.g. if given instance is null).
	 */
	protected function setParser($parser) {
		$this->parser = $parser;
		return ($this->parser !== null);
	}

	/**
	 * Checks whether the given service data is of this type.
	 * 
	 * @param string $source String containing the data to parse.
	 * @return boolean true if content can be parsed, false if not.
	 */
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
	
	/**
	 * Creates the internal parser instance that should be used for parsing. 
	 * 
	 * The object returned here will be cached for further usage.
	 * 
	 * @return mixed $source Internal parser instance
	 */
	protected abstract function createParser($source);

	/**
	 * The given model will be filled with the parsed data.
	 * 
	 * @param \GeoMetadata\Model\Metadata $model Instance of the model to be filled with the parsed data.
	 * @return boolean true on success, false on failure
	 */
	protected abstract function fillModel(\GeoMetadata\Model\Metadata &$model);

}
