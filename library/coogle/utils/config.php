<?php

namespace Coogle\Utils;

/**
 * Manages the various configurations for the application.
 * Configurations are recursively merged in the directory so
 * you can split things up nicely.
 */
class Config implements \ArrayAccess {
	
	protected $_configValues = [];
	
	/**
	 * Loads all of the .php files in a given path recursively.
	 * It's expected that each file will return an associative array
	 * which sets various configuration keys.
	 * 
	 * @param string $path path to the configuration directory
	 */
	public function loadConfigs($path)
	{
		$dir = new \RecursiveDirectoryIterator($path);
		$iterator = new \RecursiveIteratorIterator($dir);
		
		$filtered = new \RegexIterator($iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
		
		foreach($filtered as $configFile)
		{
			$configValues = include $configFile[0];
			$this->_configValues = array_merge_recursive($this->_configValues, $configValues);
		}
		
		return $this;
	}
	
	/**
	 * @param offset
	 */
	public function offsetExists ($offset) {
		return isset($this->_configValues[$offset]);
	}
	
	/**
	 * @param offset
	 */
	public function offsetGet ($offset) {
		return $this->_configValues[$offset];
	}
	
	/**
	 * @param offset
	 * @param value
	 */
	public function offsetSet ($offset, $value) {
		$this->_configValues[$offset] = $value;
	}
	
	/**
	 * @param offset
	 */
	public function offsetUnset ($offset) {
		unset($this->_configValues[$offset]);
	}
}