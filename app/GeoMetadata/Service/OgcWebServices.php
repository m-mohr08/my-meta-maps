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
		return $this->getServiceUrl($url) . "request=GetCapabilities&service=" . $this->getCode();
	}
	
	protected function parseServiceType($url) {
		$query = parse_url($url, PHP_URL_QUERY);
		$params = array();
		parse_str($query, $params);
		foreach($params as $key => $value) {
			if (strtolower($key) == 'service') {
				return strtolower($value);
			}
		}
		return null;
	}

	protected function createParser($source) {
		return simplexml_load_string($source);
	}
	
	protected function buildQueryWithoutNs($path) {
		foreach ($path as $key => $value) {
			if ($value != '*') {
				$path[$key] = "*[local-name()='{$value}']";
			}
		}
		return '//' . implode('/', $path);
	}
	
	protected function selectOne($path, $parent = null, $string = true) {
		if ($parent == null) {
			$parent = $this->getParser();
		}
		$nodes = $parent->xpath($this->buildQueryWithoutNs($path));
		if (count($nodes) > 0) {
			$node = current($nodes);
			if ($string) {
				$node = trim((string) $node);
			}
			return $node;
		}
		return null;
	}
	
	protected function selectMany($path, $parent = null, $string = true) {
		if ($parent == null) {
			$parent = $this->getParser();
		}
		$nodes = $parent->xpath($this->buildQueryWithoutNs($path));
		$data = array();
		foreach ($nodes as $node) {
			if ($string) {
				$node = trim((string) $node);
			}
			$data[] = $node;
		}
		return $data;
	}
	
	protected function getAttrsAsArray(&$node) {
		// To avoid the "Node no longer exists" error we need to copy the elements to an separate array.
		$data = array();
		foreach ($node->attributes() as $key => $value) {
			$data[$key] = strval($value);
		}
		return $data;
	}
	
	protected function selectHierarchyAsOne($path, $parent = null) {
		$node = $this->selectOne($path, $parent,  false);
		if ($node != null) {
			return $this->nodeToText($node);
		}
		else {
			return null;
		}
	}
	
	private function nodeToText($node, $output = "", $level = 0) {
		foreach ($node->children() as $key => $value) {
			$children = $value->children();
			$output .= str_repeat("\t", $level);
			if (count($children) == 0) {
				$value = trim((string) $value);
				if (!empty($value)) {
					$output .= "{$key}: {$value}\r\n";
				}
			}
			else {
				$output .= $value->getName() . "\r\n";
				$output = $this->nodeToText($value, $output, $level + 1);
			}
		}

		// Remove the trailing newline
		if ($level == 0) {
			$output = rtrim($output);
		}

		return $output;
	}

}