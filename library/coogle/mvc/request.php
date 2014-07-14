<?php

namespace Coogle\Mvc;

use Coogle\Mvc\Input;

/**
 * The request object is used by the router
 * and dispatcher to figure out what controller
 * to execute and is also provided to controllers
 * to get at other variables, etc.
 * 
 * @author john
 *
 */
class Request
{
	/**
	 * The controller's classname
	 * @var string
	 */
	protected $_controller;
	
	/**
	 * The method / action name
	 * @var string
	 */
	protected $_action;
	
	/**
	 * @return the $_controller
	 */
	public function getController() {
		return $this->_controller;
	}

	/**
	 * @return the $_action
	 */
	public function getAction() {
		return $this->_action;
	}

	/**
	 * @param string $_controller
	 */
	public function setController($_controller) {
		$this->_controller = $_controller;
		return $this;
	}

	/**
	 * @param string $_action
	 */
	public function setAction($_action) {
		$this->_action = $_action;
		return $this;
	}

	/**
	 * Returns the unqualified URI (i.e. \foo\bar\baz)
	 */
	public function uuri()
	{
		$path = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
		
		if(strlen($path) == 0) {
			$path = '/';
		}
		
		return $path;
	}
	
	/**
	 * Returns access to the input object for input data
	 * 
	 * @return \Coogle\Mvc\Input
	 */
	public function input()
	{
		return new Input();
	}
}