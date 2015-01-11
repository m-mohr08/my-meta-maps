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

abstract class OgcWebServices extends ParserParser {
	
	private $nsUri = null;
	private $nsPrefix = null;
	const PREFIX = 'ns';
	
	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		// For OGC based services we don't need to store the query parameters.
		// We always append the ? to the OGC base url.
		$index = strpos($url, '?');
		if ($index !== false) {
			return substr($url, 0, $index+1);
		}
		else {
			return $url . '?';
		}
	}
	
	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url) {
		return $this->getServiceUrl($url) . "request=GetCapabilities&service=" . strtoupper($this->getCode());
	}
	
	protected function isWgs84($crs) {
		if (!is_array($crs)) {
			$crs = array($crs);
		}
		foreach($crs as $i) {
			$i = strtolower($i);
			if (($i == 'http://www.opengis.net/def/crs/epsg/0/4326' || $i == 'epsg:4326' || $i == 'crs:84')) {
				return true;
			}
		}
		return false;
	}

	protected function createParser($source) {
		return simplexml_load_string($source);
	}

	public function verify($source) {
		return (parent::verify($source) && $this->getUsedNamespaceUri());
	}
	
	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$model->setAuthor($this->parseAuthor());
		$model->setCopyright($this->parseCopyright());
		$model->setDescription($this->parseAbstract());
		$model->setKeywords($this->parseKeywords());
		$model->setLanguage($this->parseLanguage());
		$model->setLicense($this->parseLicense());
		$model->setBeginTime($this->parseBeginTime());
		$model->setEndTime($this->parseEndTime());
		$model->setTitle($this->parseTitle());
		
		$this->parseBoundingBox($model);
		$this->parseLayer($model);

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
	
	// XML related code

	public abstract function getSupportedNamespaceUri();
	
	public function getUsedNamespaceUri($supportedUri = null) {
		$nsUri = null;
		if ($this->nsUri === null || $supportedUri !== null) {
			if ($supportedUri === null) {
				$supportedUri = $this->getSupportedNamespaceUri();
			}
			$intersect = array_intersect($this->getParser()->getNamespaces(), !is_array($supportedUri) ? array($supportedUri) : $supportedUri);
			$nsUri = reset($intersect);
			// Cache nsUrl only if it is for the default namespace uri
			if ($supportedUri !== null) {
				$this->nsUri = $nsUri;
			}
		}
		return $supportedUri !== null ? $nsUri : $this->nsUri;
	}

	public function getUsedNamespacePrefix($uri = null, $default = '') {
		$nsPrefix = null;
		if ($this->nsPrefix === null || $uri !== null) {
			if ($uri === null) {
				$uri = $this->getUsedNamespaceUri();
			}
			$prefixes = array_keys(array_intersect($this->getParser()->getNamespaces(), !is_array($uri) ? array($uri) : $uri));
			$nsPrefix = reset($prefixes);
			if ($nsPrefix === false) {
				$nsPrefix = $default;
			}
			// Cache $nsPrefix only if it is for the default namespace prefix
			if ($uri !== null) {
				$this->nsPrefix = $nsPrefix;
			}
		}
		return $uri !== null ? $nsPrefix : $this->nsPrefix;
	}
	
	private function buildQuery(array $path, $ns = '') {
		foreach ($path as $key => $value) {
			if ($value != '*' && !empty($ns)) {
				$path[$key] = "{$ns}:{$value}";
			}
		}
		return '//' . implode('/', $path);
	}
	
	protected function xpath($path, \SimpleXMLElement $parent = null, $ns = '', $isNsPrefix = false) {
		if ($parent == null) {
			$parent = $this->getParser();
		}
		// Skip this if a ns prefix has been specified
		if (empty($ns) || !$isNsPrefix) {
			// Take the specified ns URI or the default namespace URI
			$nsUri = empty($ns) ? $this->getUsedNamespaceUri() : $ns;
			$ns = '';
			if (!empty($nsUri)) {
				if ($parent->registerXPathNamespace(self::PREFIX, $nsUri)) {
					$ns = self::PREFIX;
				}
			}
		}
		if (is_array($path)) {
			$path = $this->buildQuery($path, $ns);
		}
		return $parent->xpath($path);
	}
	
	protected function n2s($node) {
		if (is_object($node)) {
			return trim((string) $node);
		}
		else {
			return null;
		}
	}
	
	protected function selectOne($path, \SimpleXMLElement $parent = null, $string = true, $ns = '', $isNsPrefix = false) {
		$nodes = $this->xpath($path, $parent, $ns, $isNsPrefix);
		$node = reset($nodes);
		if ($node !== false) {
			if ($string) {
				$node = $this->n2s($node);
			}
			return $node;
		}
		return null;
	}
	
	protected function selectMany($path, \SimpleXMLElement $parent = null, $string = true, $ns = '', $isNsPrefix = false) {
		$nodes = $this->xpath($path, $parent, $ns, $isNsPrefix);
		$data = array();
		foreach ($nodes as $node) {
			if ($string) {
				$node = $this->n2s($node);
			}
			// Add nodes or non-empty strings
			if (!$string || !empty($node)) {
				$data[] = $node;
			}
		}
		return $data;
	}
	
	protected function getAttrsAsArray(\SimpleXMLElement &$node, $ns = '', $isNsPrefix = false) {
		$data = array();
		if (is_object($node)) {
			// To avoid the "Node no longer exists" error we need to copy the elements to an separate array.
			foreach ($node->attributes($ns, $isNsPrefix) as $key => $value) {
				$data[$key] = strval($value);
			}
		}
		return $data;
	}
	
	protected function selectHierarchyAsOne($path, \SimpleXMLElement $parent = null, $ns = '', $isNsPrefix = false) {
		$node = $this->selectOne($path, $parent,  false, $ns, $isNsPrefix);
		if ($node != null) {
			return $this->nodeToStructuredText($node, $ns, $isNsPrefix);
		}
		else {
			return null;
		}
	}
	
	private function nodeToStructuredText(\SimpleXMLElement $node, $ns, $isNsPrefix = false, $output = "", $level = 0) {
		foreach ($node->children($ns, true) as $key => $value) {
			$children = $value->children($ns, $isNsPrefix);
			$output .= str_repeat("\t", $level);
			if (count($children) == 0) {
				$value = trim((string) $value);
				if (!empty($value)) {
					$output .= "{$key}: {$value}\r\n";
				}
			}
			else {
				$output .= $value->getName() . "\r\n";
				$output = $this->nodeToStructuredText($value, $ns, $isNsPrefix, $output, $level + 1);
			}
		}

		// Remove the trailing newline
		if ($level == 0) {
			$output = rtrim($output);
		}

		return $output;
	}

}