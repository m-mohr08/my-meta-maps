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

use \GeoMetadata\GmRegistry;

/**
 * XML based Parser for GeoMetadata.
 * 
 * Note: When speaking about namespaces we are describing the namespace URI.
 */
abstract class XmlParser extends ParserParser {
	
	private $namespaces = array();
	private $usedNamespace;

	protected function createParser($source) {
		return simplexml_load_string($source);
	}
	
	protected function setParser($parser) {
		$result = parent::setParser($parser);
		if ($result) {
			$this->registerNamespaces();
		}
		return $result;
	}

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * 
	 * This can be also a string conting one single supported namespace.
	 * 
	 * @return array|string
	 */
	protected abstract function getSupportedNamespaces();
	
	/**
	 * Define the namespaces you want to use in XPath.
	 * 
	 * @return void
	 */
	protected abstract function registerNamespaces();

	/**
	 * Registers a namespace to a prefix that can be used in the methods implemented here.
	 * 
	 * Those prefixes are also registered for XPath queries.
	 * 
	 * @param string $prefix Namespace Prefix
	 * @param string $uri Namespace URI
	 */
	protected function registerNamespace($prefix, $uri) {
		$this->namespaces[$prefix] = $uri;
	}

	/**
	 * Returns all namespaces that are used for XPath queries.
	 * 
	 * @return array
	 */
	protected function getNamespaces() {
		return $this->namespaces;
	}
	
	/**
	 * Registers a namespace to a prefix that can be used in the methods implemented here.
	 * 
	 * Those prefixes are also registered for XPath queries.
	 * 
	 * @param string $prefix Namespace Prefix
	 * @param string $uri Namespace URI or empty string when not found.
	 */
	protected function getNamespace($prefix) {
		if (!isset($this->namespaces[$prefix])) {
			GmRegistry::log("Namespace for prefix '{$prefix}' not defined.");
			return '';
		}
		else {
			return $this->namespaces[$prefix];
		}
	}
	
	/**
	 * Get the namespace from list of namespaces that is used in the XML document.
	 * 
	 * @param string|array|null $namespaces string or array containing namespaces. If null, the list from getSupportedNamespaces() is used.
	 * @return string Namespace URI or an empty string if nothing was found.
	 */
	protected function getUsedNamespace($namespaces = null) {
		$isDefault = ($namespaces === null);
		if ($isDefault) {
			if ($this->usedNamespace !== null) {
				return $this->usedNamespace;
			}
			$namespaces = $this->getSupportedNamespaces();
		}
		$namespaces = !is_array($namespaces) ? array($namespaces) : $namespaces;

		$intersect = array_intersect($this->getParser()->getNamespaces(true), $namespaces);
		GmRegistry::log('Multiple namespaces found, falling back randomly.');
		$namespace = reset($intersect);
		$namespace = ($namespace === false ? '' : $namespace);
		if ($isDefault) {
			$this->usedNamespace = $namespace;
		}
		return $namespace;
	}
	
	/**
	 * Executes a XPath query.
	 * 
	 * @param string $path
	 * @param \SimpleXMLElement $parent
	 */
	public function xpath($path, \SimpleXMLElement $parent = null) {
		if ($parent == null) {
			$parent = $this->getParser();
		}
		
		$usedNs = $this->getUsedNamespace();
		$hasNamespace = !empty($usedNs);
		if ($hasNamespace) {
			foreach($this->getNamespaces() as $prefix => $uri) {
				$parent->registerXPathNamespace($prefix, $uri);
			}
		}
		
		return $parent->xpath($this->buildQuery($path, $hasNamespace));
	}
	
	/**
	 * Build the XPath expression from the path array.
	 * 
	 * @param array $path
	 * @param type $hasNamespace
	 * @return type
	 */
	private function buildQuery(array $path, $hasNamespace = true) {
		// Remove namespace prefixes if no namespace is available.
		if (!$hasNamespace) {
			foreach($path as $key => $value) {
				$parts = explode(':', $value, 2); 
				if (count($parts) == 2 && $parts[0] == $this->getCode()) {
					$path[$key] = $parts[1];
				}
			}
		}

		return '//' . implode('/', $path);
	}

	/**
	 * Converts a node to a string.
	 * 
	 * @param \SimpleXMLElement $node Node to convert
	 * @return string Textual content of the node
	 */
	protected function n2s(\SimpleXMLElement &$node = null) {
		if (is_object($node)) {
			return trim(strval($node));
		}
		else {
			return null;
		}
	}
	
	/**
	 * Select one node from the xml document.
	 * 
	 * @param type $path
	 * @param \SimpleXMLElement $parent
	 * @param type $string
	 * @return type
	 */
	protected function selectOne(array $path, \SimpleXMLElement $parent = null, $string = true) {
		$nodes = $this->xpath($path, $parent);
		$node = reset($nodes);
		if ($node === false) {
			$node = null;
		}
		else if ($string) {
			$node = $this->n2s($node);
		}
		return $node;
	}

	/**
	 * Select many nodes as array from the xml document.
	 * 
	 * @param array $path
	 * @param \SimpleXMLElement $parent
	 * @param type $string
	 * @return type
	 */
	protected function selectMany(array $path, \SimpleXMLElement $parent = null, $string = true) {
		$nodes = $this->xpath($path, $parent);
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
	
	/**
	 * Returns one or many attributes from a node.
	 * 
	 * @param \SimpleXMLElement $node
	 * @param type $ns
	 * @return mixed
	 */
	protected function selectAttributes(\SimpleXMLElement $node, $ns = '') {
		$data = array();
		if (is_object($node)) {
			// To avoid the "Node no longer exists" error we need to copy the elements to an separate array.
			foreach ($node->attributes($ns) as $key => $value) {
				$data[$key] = trim((string) $value);
			}
		}
		return $data;
	}
	
	/**
	 * 
	 * @param type $path
	 * @param \SimpleXMLElement $parent
	 * @return type
	 */
	protected function selectNestedText($path, $namespace = '', \SimpleXMLElement $parent = null) {
		$node = $this->selectOne($path, $parent, false);
		if ($node != null) {
			return $this->nodeToNestedText($node, $namespace);
		}
		else {
			return null;
		}
	}
	
	private function nodeToNestedText(\SimpleXMLElement $node, $namespace, $output = "", $level = 0) {
		foreach ($node->children($namespace) as $key => $value) {
			$children = $value->children($namespace);
			$output .= str_repeat("\t", $level);
			if (count($children) == 0) {
				$value = trim((string) $value);
				if (!empty($value)) {
					$output .= "{$key}: {$value}\r\n";
				}
			}
			else {
				$output .= $value->getName() . "\r\n";
				$output = $this->nodeToNestedText($value, $namespace, $output, $level + 1);
			}
		}

		// Remove the trailing newline
		if ($level == 0) {
			$output = rtrim($output);
		}

		return $output;
	}

}