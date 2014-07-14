<?php

namespace Coogle\Mvc;

/**
 * The base controller from which all other controllers spawn.
 */
abstract class BaseController
{
	/**
	 * @var \Coogle\Mvc\Request;
	 */
	protected $_request;
	
	/**
	 * @var \Coogle\Mvc\Response;
	 */
	protected $_response;
	
	/**
	 * @return \Coogle\Mvc\Request the $_request
	 */
	public function getRequest() {
		return $this->_request;
	}

	/**
	 * @return \Coogle\Mvc\Response the $_response
	 */
	public function getResponse() {
		return $this->_response;
	}

	/**
	 * @param \Coogle\Mvc\Request; $_request
	 * @return self
	 */
	public function setRequest($_request) {
		$this->_request = $_request;
		return $this;
	}

	/**
	 * @param \Coogle\Mvc\Response; $_response
	 * @return self
	 */
	public function setResponse($_response) {
		$this->_response = $_response;
		return $this;
	}

}