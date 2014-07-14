<?php

namespace Coogle\Mvc;

/**
 * A helper class used in the Request object to give OO access
 * to the various input data available to us from the request.
 */
class Input
{
	/**
	 * Returns an HTTP GET variable or default if not found
	 * @param string $key
	 * @param string $default
	 * @return unknown|string
	 */
	public function get($key, $default = null) 
	{
		if(isset($_GET[$key])) {
			return $_GET[$key];
		}
		
		return $default;
	}
	
	/**
	 * Returns an HTTP POST variable or default if not found
	 * @param string $key
	 * @param string $default
	 * @return unknown|string
	 */
	public function post($key, $default = null) 
	{
		if(isset($_POST[$key])) {
			return $_POST[$key];
		}
		
		return $default;
	}
	
	/**
	 * Returns an HTTP PUT variable or default if not found
	 * @param string $key
	 * @param string $default
	 * @return Ambigous <unknown, string>
	 */
	public function put($key, $default = null)
	{
		parse_str(file_get_contents('php://input'), $putVars);
		return isset($putVars[$key]) ? $putVars[$key] : $default;
	}
	
	/**
	 * Returns an HTTP DELETE variable or default if not found
	 * @param string $key
	 * @param string $default
	 * @return Ambigous <\Coogle\Mvc\Ambigous, unknown, string>
	 */
	public function delete($key, $default = null)
	{
		return $this->put($key, $default);
	}
}