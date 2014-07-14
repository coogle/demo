<?php

namespace Coogle\Utils;

/**
 * A helper registry class that lets us keep Global
 * variables and objects without the nasty $GLOBALS
 */
class Registry
{
	static protected $_references = [];
	
	static public function set($key, $value)
	{
		static::$_references[$key] = $value;
	}
	
	static public function get($key)
	{
		return isset(static::$_references[$key]) ? 
					static::$_references[$key] : null;
	}
}